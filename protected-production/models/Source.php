<?php

/**
 * This is the model class for table "source".
 *
 * The followings are the available columns in table 'source':
 * @property string $id
 * @property string $title
 * @property string $feed_url
 * @property integer $category_id
 * @property string $city_id
 * @property string $score
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property Article[] $articles
 * @property City $city
 * @property Category $category
 */
class Source extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Source the static model class
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
		return 'source';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_submitted, user_id', 'safe'),
			array('title, feed_url, url, category_id, city_id', 'required'),
			array('category_id, city_id', 'numerical', 'integerOnly'=>true),
			array('feed_url, url', 'url'),
			array('title', 'length', 'max'=>150),
			array('twitter_handle', 'length', 'max'=>25),
			array('facebook_handle', 'length', 'max'=>50),
			array('city_id, score', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('title', 'safe', 'on'=>'search'),
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
			'articles' => array(self::HAS_MANY, 'Article', 'source_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'feed_url' => 'Feed URL',
			'url' => 'Website',
			'category_id' => 'Category',
			'city_id' => 'City',
			'score' => 'Score',
			'facebook_handle' => 'Facebook',
			'twitter_handle' => 'Twitter',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('feed_url',$this->feed_url,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('score',$this->score,true);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function defaultScope()
	{
		return array (
			'condition' => 'user_submitted = 0',
		);
	}

	public function scopes()
	{
		return array(
			'userSubmitted' => array(
				'condition' => 'user_submitted = 1',
			),
		);
	}
	
	public function getArticles($sort='score',$limit=5) {
		$criteria = new CDbCriteria();
		
		switch ($sort)
		{
			case 'score':
				$criteria->order = 't.score DESC';
				break;
			case 'age':
				$criteria->order = 't.date_published DESC';
				break;
			default:
				$criteria->order = 't.score DESC';
		}
		
		$criteria->condition = 'source_id=:source_id';
		$criteria->params = array(':source_id'=>$this->id);
		$criteria->limit = $limit;
		
		$articles = Article::model()->findAll($criteria);
		
		return $articles;		
	}
	
	public function getArticleCount($age='')
	{
		$criteria = new CDbCriteria();

		$criteria->condition = 'source_id=:source_id';
		$criteria->params = array(':source_id'=>$this->id);
		
		switch ($age)
		{
			case 'day':
				$criteria->addCondition('DATE(date_published)=CURDATE()');
				break;
			case 'week':
				$criteria->addCondition('DATE(date_published) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()');
				break;
			case 'month':
				$criteria->addCondition('DATE(date_published) BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()');
				break;
			default:
		}
		$count = Article::model()->count($criteria);
		
		return $count;
	}
	
}