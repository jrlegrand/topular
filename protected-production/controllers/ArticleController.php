<?php

class ArticleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @var string the page title of the current article view the user is viewing
	 * used as a sub-header in the navigation menu
	 */
	public $page_title = null;

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
			array('allow', // allow all user to perform 'menu'
				'actions'=>array('index','menu','ajax','view','share','search','save','unsave'),
				'users'=>array('*'),
			),
			array('allow', // allow public user to perform 'index' and 'view' actions
				'actions'=>array(),
				'roles'=>array('public'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','update','delete','more','ajaxanalytics'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($city=null, $category=null, $timespan=null, $priority=null)
	{
		if (!Yii::app()->user->isGuest) {
			$user = User::model()->findByPk(Yii::app()->user->getId());
		} else {
			$user = User::model()->loadGuest();
		}
		
		// If we didn't arrive here from a browse link,
		// check for a preferred city or bundle
		if (!$city && !$category)
		{
			switch ($user->last_viewed)
			{
				case 1: // User last viewed/updated their city
					$city = City::model()->findByPk($user->city->id)->id;
				break;
				case 2: // User last viewed/updated their bundle
					$bundle = Bundle::model()->findByPk($user->bundle->id);
					$city = $bundle->cities;
					$category = $bundle->categories;
					$keyword = $bundle->keywords;
				break;
			}
		} else {
			$bundle = null;
		}
		
		if ($bundle)
			$this->page_title=$bundle->title;
		elseif ($city && $category)
			$this->page_title=ucwords(City::model()->findByPk($city)->title) . ' ' . ucwords(Category::model()->findByPk($category)->title);
		elseif ($city)
			$this->page_title=ucwords(City::model()->findByPk($city)->title);
		elseif ($category)
			$this->page_title=ucwords(Category::model()->findByPk($category)->title);
		else
			$this->page_title='All Cities';
		
		$timespan = $user->timespan;
		$priority = $user->priority;
		
		$criteria = new CDbCriteria();
		$criteria->scopes = array(
			'city'=>array($city),
			'category'=>array($category),
			'timespan'=>array($timespan),
			'priority'=>array($priority),
			'keyword'=>array($keyword),
			);
		
		$count = Article::model()->count($criteria);
		$pages = new CPagination($count);
		
		$pages->pageSize = 20;
		$pages->applyLimit($criteria);

		$articles = Article::model()->findAll($criteria);
		
		$this->render('index',array(
			'articles'=>$articles,
			'pages'=>$pages,
			'timespan'=>$timespan,
		));
	}
	
	public function actionSearch($q, $timespan=null, $city=null) {
		$criteria = new CDbCriteria();

		if(isset($_GET['q']))
		{
			$q = $_GET['q'];
			$keyword = $q;
			$this->page_title='Search: ' . ucwords($q);
		}
		
		if(isset($_GET['t']))
		{
			$timespan = $_GET['t'];
		} else {
			$timespan = 'month';
		}
		
		if(isset($_GET['c']))
		{
			$city = $_GET['c'];
		} else {
			$city = null;
		}
		
		$priority = 'score';
		
		$criteria->limit = 100;

		$criteria->scopes = array(
			'city'=>array($city),
			'timespan'=>array($timespan),
			'priority'=>array($priority),
			'keyword'=>array($keyword),
			);
		
		$count = Article::model()->count($criteria);
		$pages = new CPagination($count);
		
		$pages->pageSize = 20;
		$pages->applyLimit($criteria);

		$articles = Article::model()->findAll($criteria);

		$this->render('index',array(
			'articles'=>$articles,
			'pages'=>$pages,
			'timespan'=>$timespan,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		
		$city = Article::model()->city($model->source->city->id)->timespan('week')->priority('random')->limit(2)->findAll();
		$category = Article::model()->category($model->source->category->id)->timespan('week')->priority('random')->limit(2)->findAll();

		$this->render('view',array(
			'model'=>$model,
			'city'=>$city,
			'category'=>$category,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionAnalytics($id)
	{
		$q = "SELECT timestamp, retweets, fb_likes, fb_shares FROM data WHERE article_id='$id'";
		$cmd = Yii::app()->db->createCommand($q);
		$r = $cmd->queryAll();
		
		$retweet_data = array();
		$fb_likes_data = array();
		$fb_shares_data = array();
		foreach ($r as $row)
		{
			$retweet_data[] = array(strtotime($row['timestamp']) * 1000, intval($row['retweets']));
			$fb_likes_data[] = array(strtotime($row['timestamp']) * 1000, intval($row['fb_likes']));
			$fb_shares_data[] = array(strtotime($row['timestamp']) * 1000, intval($row['fb_shares']));
		}
		
		$retweet_data = json_encode($retweet_data);
		$fb_likes_data = json_encode($fb_likes_data);
		$fb_shares_data = json_encode($fb_shares_data);
		
		$this->render('analytics',array(
			'article'=>$this->loadModel($id),
			'retweet_data'=>$retweet_data,
			'fb_likes_data'=>$fb_likes_data,
			'fb_shares_data'=>$fb_shares_data,
		));
	}
	
	public function actionAjaxAnalytics($id,$type)
	{
		$q = "SELECT timestamp, retweets, fb_likes, fb_shares FROM data WHERE article_id='$id'";
		$cmd = Yii::app()->db->createCommand($q);
		$r = $cmd->queryAll();
		
		$retweet_data = array();
		$fb_likes_data = array();
		$fb_shares_data = array();
		foreach ($r as $row)
		{
			$retweet_data[] = array(strtotime($row['timestamp']) * 1000, intval($row['retweets']));
			$fb_likes_data[] = array(strtotime($row['timestamp']) * 1000, intval($row['fb_likes']));
			$fb_shares_data[] = array(strtotime($row['timestamp']) * 1000, intval($row['fb_shares']));
		}
		
		switch ($type)
		{
			case 'retweets':
				echo json_encode($retweet_data);
				break;
			case 'fb_likes':
				echo json_encode($fb_likes_data);
				break;
			case 'fb_shares':
				echo json_encode($fb_shares_data);
				break;
		}
	}

	public function actionShare($id)
	{
		$model=$this->loadModel($id);
		
		$this->renderPartial('share',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

		/**
	 * Saves an article to user_has_article table.
	 * If save is successful, the browser will print success message.
	 */
	public function actionMenu()
	{
		$menu = Article::getMenuList();
		$this->renderPartial('menu', array(
			'menu'=>$menu,
		));
	}
	
	/**
	 * Saves an article to user_has_article table.
	 * If save is successful, the browser will print success message.
	 */
	public function actionSave($id)
	{
		if (!Yii::app()->user->isGuest) {
			$user_id=Yii::app()->user->getId();
			$article_id=$id;
			
			$q = "SELECT * FROM user_has_article WHERE user_id='$user_id' AND article_id='$article_id'";
			$cmd = Yii::app()->db->createCommand($q);
			$r = $cmd->queryRow();

			// If article has not been saved, save article
			if (!$r) {
				try
				{
					$q = "INSERT INTO user_has_article (user_id, article_id) VALUES (:user_id, :article_id)";
					$cmd = Yii::app()->db->createCommand($q);
					$cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
					$cmd->bindParam(':article_id', $article_id, PDO::PARAM_INT);
					echo ($cmd->execute() ? 'SAVED' : 'NOT_SAVED');
				}
				catch (Exception $e)
				{
					// Article doesn't exist or something else went wrong
					echo 'ERROR';
				}
			} else {
				echo 'ALREADY_SAVED';
			}
		} else {
			echo 'LOGGED_OUT';
		}
	}
	
	/**
	 * Loses an article from user_has_article table.
	 * If loss is successful, the browser will print success message.
	 */
	public function actionUnsave($id)
	{
		$user_id=Yii::app()->user->getId();
		$article_id=$id;
		
		$q = "SELECT * FROM user_has_article WHERE user_id='$user_id' AND article_id='$article_id'";
		$cmd = Yii::app()->db->createCommand($q);
		$r = $cmd->queryRow();

		// If article has already been saved, drop article
		if ($r) {
			try
			{
				$q = "DELETE FROM user_has_article WHERE user_id='$user_id' AND article_id='$article_id' LIMIT 1";
				$cmd = Yii::app()->db->createCommand($q);
				echo ($cmd->execute() ? 'UNSAVED' : 'NOT_UNSAVED');
			}
			catch (Exception $e)
			{
				// Article doesn't exist or something else went wrong
				echo 'ERROR';
			}
		} else {
			echo 'ALREADY_UNSAVED';
		}
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * AJAX articles.
	 */
	public function actionAjax()
	{
		$articles = Article::model()->getArticles();
	
		$this->renderPartial('articles', array('articles'=>$articles));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Article('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Article']))
			$model->attributes=$_GET['Article'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Article the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Article::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Article $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='article-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
