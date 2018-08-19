<?php

class CronController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform all actions
				'actions'=>array('index','admin','article','score','facebook','twitter','linkedin'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionArticle()
	{
		// Make larger memory limit and execution time
		ini_set('memory_limit', '2056M');
		ini_set('max_execution_time', 1000); // 1000 seconds = 17 minutes
		
		// Include SimplePie
		spl_autoload_unregister(array('YiiBase','autoload'));
		Yii::import('application.vendors.*');
		require_once('autoloader.php');
		require_once('idn/idna_convert.class.php');
		spl_autoload_register(array('YiiBase', 'autoload'));

		// Query database for all sources and return source ID and URL
		$criteria = new CDbCriteria;
		$criteria->select = 'id, feed_url';
		$criteria->order = 'id ASC';
		$source = Source::model()->findAll($criteria);

		// Make an array of all source feed URLs and use source ID's as keys
		foreach ($source as $s)
		{
			$feed_list[$s->id] = $s->feed_url;
		}
		
		$criteria = new CDbCriteria;
		$criteria->select = 'id, url';
		$article = Article::model()->findAll($criteria);

		$article_list=array();
		// Make an array of all article URLs and use article ID's as keys
		foreach ($article as $a)
		{
			$article_list[$a->id] = $a->url;
		}

		// Create a new instance of the SimplePie object
		$feed = new SimplePie();

		// Set an array of feed URLs
		$feed->set_feed_url($feed_list);

		// Set path to cache
		$path = Yii::getPathOfAlias('application.vendors.cache');
		$feed->set_cache_location($path);
		
		// Turn off caching (re-enable later)
		$feed->enable_cache(true);
		
		// Set timeout in seconds
		$feed->set_timeout(15);
		
		// Choose to not re-order the items by date (optional)
		$feed->enable_order_by_date(false);

		// Initialize the whole SimplePie object
		// Read the feed, process it, parse it, cache it, and all that other good stuff
		// The feed's information will not be available to SimplePie before this is called
		$success = $feed->init();

		// We'll make sure that the right content type and character encoding gets set automatically
		// This function will grab the proper character encoding, as well as set the content type to text/html
		$feed->handle_content_type();
		
		// Show any errors and count the total number of errors
		if ($feed->error())
		{
			$error = $feed->error();
			$errors = count($feed->error());
			echo '<pre>';
			print_r($error);
			echo '</pre>';
	
		}

		if ($success)
		{
			foreach($feed->get_items() as $item) {
				
				$article_url = $item->get_permalink();
				$article_title = mysql_escape_string($item->get_title());
				$article_date = $item->get_date('Y-m-d H:i:s');
				
				// Check to see if article already exists by matching URL
				// If article doesn't exist, add article to database
				if (!in_array($article_url, $article_list))
				{
					// Get the feed url from the post and attach a blog id to it
					$source_feed = $item->get_feed()->subscribe_url();
					$source_id = array_search($source_feed, $feed_list);
					
					echo $source_feed . ' (' . $source_id . ') - ' . $article_title . '<br>';
					
					/*
					// Get the bitly link
					$url = urlencode($article_url);
					$api_key = '7cd7cdba2f15ca80bdf942c5165eae566ea0928c';
					$request_url = 'https://api-ssl.bitly.com/v3/shorten?access_token=' . $api_key . '&longUrl=' . $url;
					$json = file_get_contents($request_url);
					$result = json_decode($json);
					
					$bitly_url = $result->data->url;
					*/
					$bitly_url = '';
					
					try {
					// Create a new article entry in the database
					$article = new Article();
					$article->title = $article_title;
					$article->url = $article_url;
					$article->date_published = $article_date;
					$article->source_id = $source_id;
					$article->bitly_url = $bitly_url;
					$article->save();
					} catch (Exception $e) {}
				}	
			}
		}
		$this->render('index');

	}
	
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionFacebook()
	{
		// Make larger memory limit and execution time
		ini_set('memory_limit', '2056M');
		ini_set('max_execution_time', 1000); // 1000 seconds = 17 minutes

		$criteria = new CDbCriteria;
		$criteria->select = 'url';
		$article = Article::model()->week()->findAll();
		
		foreach ($article as $a)
		{
			// Get API JSON data
			$request = 'http://api.ak.facebook.com/restserver.php?v=1.0&method=links.getStats&urls=' . $a->url . '&format=json';
			$json = file_get_contents($request);
			$result = json_decode($json);
			
			// Assign data to variables
			$a->fb_likes = $result[0]->like_count;
			$a->fb_shares = $result[0]->share_count;
			
			echo $a->fb_likes + $a->fb_shares . '<br>';
			
			$a->save();
		}

		$this->render('index');

	}

	public function actionTwitter()
	{
		// Make larger memory limit and execution time
		ini_set('memory_limit', '2056M');
		ini_set('max_execution_time', 1000); // 1000 seconds = 17 minutes

		$criteria = new CDbCriteria;
		$criteria->select = 'url';
		$article = Article::model()->week()->findAll();

		foreach ($article as $a)
		{
			// Get API JSON data
			$request = 'http://urls.api.twitter.com/1/urls/count.json?url=' . $a->url;
			$json = file_get_contents($request);
			$result = json_decode($json);
			
			// Assign data to a variable
			$a->retweets = $result->count;
			$a->save();
		}

		$this->render('index');

	}

	public function actionScore()
	{
		// Make larger memory limit and execution time
		ini_set('memory_limit', '2056M');
		ini_set('max_execution_time', 1000); // 1000 seconds = 17 minutes

		$criteria = new CDbCriteria;
		$criteria->select = 'fb_likes, fb_shares, retweets, linkedin_shares, timestamp';
		$article = Article::model()->findAll();
		
		foreach ($article as $a)
		{
			/*
			// Set age as the difference in days between now and the timestamp
			$age = floor( abs(time() - strtotime($a->timestamp)) / (60*60*24) );
			
			// If article is less than 1 day old, calculate how many hours old it is
			$data = false;
			if ($age < 1) {
				// Calculate number of hours since last timestamp if article is less than 1 day old
				// If article is one hour older than last timestamp, make a new data entry
				$hours = abs(time() - strtotime($a->timestamp) / (60*60));
				if ($hours > 1) $data = true;
			
			// If article is one day older than last timestamp, make a new data entry
			} else if ($age > $a->age) {
				$data = true;
			}
			
			// If article is older than one week, don't make a data entry
			if ($age > 7) $data = false;	
			
			// If it is appropriate, make a new data entry in data table
			if ($data) {
				//$a = "INSERT INTO data (article_id, fb_likes, fb_shares, retweets, linkedin_shares, score, age, timestamp) ";
				//$a .= "VALUES ('{$row['article_id']}', '{$row['fb_likes']}', '{$row['fb_shares']}', '{$row['retweets']}', '{$row['linkedin_shares']}', '{$row['score']}', '$age', NOW())";
				//$b = mysqli_query($dbc, $a);
			}			
			*/
			
			$score = $a->fb_likes + $a->fb_shares + $a->retweets + $a->linkedin_shares;
			$trend = $score - $a->score;	
			
			// Update the article's score and trend in the database
			$a->score = $score;
			$a->trend = $trend;
			$a->save();
		}
/*
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		// ###############################
		// Rank and movement logging
		// ###############################

		// Assign rank based on score
		$q = "SELECT id, rank FROM article ORDER BY score DESC";
		$r = mysqli_query($dbc, $q);
		$rank = 0;

		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			$rank++;
			
			if ($row['rank'] != 0) {
				$movement = $rank - $row['rank'];
			}
			
			// Update the article's rank and movement in the database
			$a = "UPDATE article SET rank='$rank' WHERE id='$article_id' LIMIT 1";
			$b = mysqli_query($dbc, $a);
		}

		// ###############################
		// End rank and movement logging
		// ###############################
		// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
*/
		// Get top 10 articles for the day for each city
		$city = City::model()->findAll();
		foreach ($city as $c)
		{
			$criteria = new CDbCriteria();
			$criteria->condition = "`city`.`title`='".$c->title."'";
			$article = Article::model()->top()->ten()->day()->findAll($criteria);
			foreach ($article as $a)
			{

				if (empty($a->image_url)) {
					// Get image from article webpage with embedly
					$url = urlencode($a->url);
					$api_key = '4449e1af1e9649b2996245496aeb35ac';
					$request = 'http://api.embed.ly/1/oembed?key=' . $api_key . '&url=' . $url;
					$json = file_get_contents($request);
					$result = json_decode($json);

					$a->image_url = $result->thumbnail_url;
					$a->image_width = $result->thumbnail_width;
					$a->image_height = $result->thumbnail_height;
					$a->save();
				}

			}
		}

		$this->render('index');
		
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Source('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Source']))
			$model->attributes=$_GET['Source'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Source the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Source::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Source $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='source-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
