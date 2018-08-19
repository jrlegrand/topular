<?php

/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property string $id
 * @property string $url
 * @property string $bitly_url
 * @property string $title
 * @property string $image_url
 * @property integer $image_width
 * @property integer $image_height
 * @property string $date_published
 * @property string $source_id
 * @property string $fb_likes
 * @property string $fb_shares
 * @property string $retweets
 * @property string $linkedin_shares
 * @property string $score
 * @property string $rank
 * @property integer $movement_day
 * @property integer $movement_week
 * @property integer $movement_month
 * @property integer $trend
 * @property integer $age
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property Source $source
 */
class Article extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Article the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image_width, image_height, movement_day, movement_week, movement_month, trend, age, hidden', 'numerical', 'integerOnly'=>true),
			array('url, image_url', 'length', 'max'=>2083),
			array('bitly_url', 'length', 'max'=>100),
			array('title', 'length', 'max'=>150),
			array('source_id, fb_likes, fb_shares, retweets, linkedin_shares, score, rank', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url, bitly_url, title, image_url, date_published, source_id, fb_likes, fb_shares, retweets, linkedin_shares, score, rank, movement_day, movement_week, movement_month, trend, age, timestamp', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'source' => array(self::BELONGS_TO, 'Source', 'source_id'),
			'users' => array(self::MANY_MANY, 'User', 
				'user_has_article(article_id, user_id)'),
		);
	}
	
	public function defaultScope()
	{
		return array (
			'with' => array('source', 'source.category', 'source.city'),
			'condition' => 'hidden = 0 AND city.under_construction = 0',
		);
	}
	
	public function scopes()
	{
		return array();
	}
	
	public function city($id)
	{
		if ($id)
		{
			$this->getDbCriteria()->mergeWith(array(
				'condition'=>"`city`.`id` IN (".$id.")"
			));
		}
		
		return $this;
	}
	
	public function keyword($q) {
		if ($q)
		{
			$keywords = explode(',', $q);
			$condition = '';
			$i = 0;
			foreach ($keywords as $k)
			{
				if ($i > 0) $condition .= " OR ";
				$condition .= "content LIKE '%".$k."%' OR t.title LIKE '%".$k."%'";
				$i++;
			}
			$this->getDbCriteria()->mergeWith(array(
				'condition'=>$condition
				//'condition'=>"`article`.`title` LIKE '%".$q."%'"
			));
		}
		
		return $this;
	}
	
	public function category($id)
	{
		if ($id)
		{
			$this->getDbCriteria()->mergeWith(array(
				'condition'=>"`category`.`id` IN (".$id.")"
			));
		}
		
		return $this;
	}
	
	public function timespan($timespan='day')
	{
		switch ($timespan)
		{
			case 'day':
				$condition = 'DATE(date_published)=CURDATE()';
				break;
			case 'week':
				$condition = 'DATE(date_published) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()';
				break;
			case 'month':
				$condition = 'DATE(date_published) BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()';
				break;
			default:
				$condition = 'DATE(date_published)=CURDATE()';
				break;
		}
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>$condition
		));
		return $this;
	}
	
	public function priority($order='score')
	{
		switch ($order)
		{
			case 'score':
				$order = 't.score DESC';
				break;
			case 'age':
				$order = 't.date_published DESC';
				break;
			case 'random':
				$order = 'rand()';
				break;
			default:
				$order = 't.score DESC';
				break;
		}
		$this->getDbCriteria()->mergeWith(array(
			'order'=>$order
		));
		return $this;
	}

	public function limit($limit=20)
	{
		$this->getDbCriteria()->mergeWith(array(
			'limit'=>$limit
		));
		return $this;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'url' => 'Url',
			'bitly_url' => 'Bitly Url',
			'title' => 'Title',
			'image_url' => 'Image Url',
			'image_width' => 'Image Width',
			'image_height' => 'Image Height',
			'date_published' => 'Date Published',
			'source_id' => 'Source',
			'fb_likes' => 'Fb Likes',
			'fb_shares' => 'Fb Shares',
			'retweets' => 'Retweets',
			'linkedin_shares' => 'Linkedin Shares',
			'score' => 'Score',
			'rank' => 'Rank',
			'movement_day' => 'Movement Day',
			'movement_week' => 'Movement Week',
			'movement_month' => 'Movement Month',
			'trend' => 'Trend',
			'age' => 'Age',
			'hidden' => 'Hidden',
			'timestamp' => 'Timestamp',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('title',$this->title,true);
		$criteria->compare('source_id',$this->source_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function isSaved()
	{
		if(!Yii::app()->user->isGuest)
		{
			
			$q = "SELECT * FROM user_has_article WHERE article_id=:article_id AND user_id=:user_id";
			$cmd = Yii::app()->db->createCommand($q);
			$cmd->bindParam(':article_id', $this->id, PDO::PARAM_INT);
			$cmd->bindParam(':user_id', Yii::app()->user->getId(), PDO::PARAM_INT);
			return $cmd->execute();
		} else {
			// Redirect to login
		}
	}
	
	/**
	 * Returns the time since an article was posted
	 * @return string time since in hours or days or actual date
	 */
	public function timeSince($time)
	{
		// Calculate the difference in days between now and the date published
		$time_since = floor( abs(time() - strtotime($time)) / (60*60*24));
		
		// If article is less than 1 day old, calculate how many hours old it is
		if ($time_since < 1) {
			$time_since = floor( abs(time() - strtotime($time)) / (60*60));
			
			// If article is less than 1 hour old, calculate how many minutes old it is
			if ($time_since < 1) {
				$time_since = floor( abs(time() - strtotime($time)) / (60));
				$time_since .= ' minutes ago';
			} else {
				$time_since .= ' hours ago';
			}
		
		// If article is older than 7 days, return the actual date
		} elseif ($time_since > 7) {
			$time_since = date('F jS', strtotime($time));
		
		// If article is 7 days old or less, add the word days
		} else {
			$time_since .= ' days ago';
		}
			
		return $time_since;
	}
	
	/**
	 * Returns the list of all categories and sources
	 * @return multidimensional array
	 */
	public function getMenuList()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 'title ASC';
		
		$cities = City::model()->findAll($criteria);
		$city_menu = array();
		foreach ($cities as $c)
		{
			$city_menu[] = array(
						'id'=>$c->id,
						'title'=>$c->title,
						'url'=>$this->createUrl('article/index', array('city'=>strtolower($c->title))),
						);
		}
		
		$categories = Category::model()->findAll($criteria);
		$category_menu = array();
		foreach ($categories as $c)
		{
	
			$category_menu[] = array(
				'id'=>$c->id,
				'title'=>$c->title,
			);
		}
		
		$menu['city'] = $city_menu;
		$menu['category'] = $category_menu;
		
		return $menu;
	}
	
	/**
	 * Returns the bitly url if one exists - otherwise regular url
	 * @return string url
	 */
	public function getUrl()
	{
		return (!empty($this->bitly_url) ? $this->bitly_url : $this->url);
	}
	
	/**
	 * Returns the long content if one exists - otherwise summary if one exists
	 * @return string
	 */
	public function getSummary()
	{
		if (!empty($this->content)) {
			$summary = substr(strip_tags($this->content), 0, 500);
		} elseif (!empty($this->summary)) {
			$summary = substr(strip_tags($this->summary), 0, 500);
		} else {
			$summary = null;
		}

		if (strlen($summary) > 500) $summary .= '...';

		return $summary;
	}

	/**
	 * Returns the source twitter handle if on exists - otherwise regular source title
	 * @return string
	 */
	public function getTwitterHandle()
	{
		return (!empty($this->source->twitter_handle) ? $this->source->twitter_handle : $this->source->title);
	}
	
	/**
	 * Returns the source twitter handle if on exists - otherwise regular source title
	 * @return string
	 */
	public function getHashtag()
	{
		return $this->source->city->hashtag;
	}
	
	/**
	 * Returns the score of the article - rounds to thousandth
	 * @return string
	 */
	public function getScore($score)
	{
		if ($score >= 1000)
			$score = round($score/1000, 1) . 'k';
		
		return $score;
	}

	/**
	 * Returns the trend of the article AKA what the rank was x minutes ago versus now
	 * @return string
	 */
	public function getTrend($time=15)
	{
		$q = "SELECT * FROM data WHERE article_id=:article_id AND TIME(timestamp) < TIME(DATE_SUB(NOW(), INTERVAL 15 MINUTE)) ORDER BY timestamp DESC LIMIT 1";
		$cmd = Yii::app()->db->createCommand($q);
		$cmd->bindParam(':article_id', $this->id, PDO::PARAM_INT);
		$r = $cmd->execute();

		return $r->rank;
	}

}