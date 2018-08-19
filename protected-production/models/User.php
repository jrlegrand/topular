<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $pass
 * @property string $type
 * @property string $date_entered
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property File[] $files
 * @property Page[] $pages
 */
class User extends CActiveRecord
{
	public $passCompare; // Needed for registration!
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image', 'file', 'allowEmpty'=>true,'maxSize'=>512000,'types'=>'jpg, jpeg, png','tooLarge'=>'The profile image cannot be larger than 512kb.','wrongType'=>'The profile image must be a JPG or PNG.'),
			array('categories, sort, age, email, provider_uid, first_name, last_name, date_entered, date_updated, city_id, image, last_viewed', 'safe'),
			// Required fields when registering:
			array('email, pass, passCompare', 'required', 'on'=>'register'),
			// Username must be unique and less than 45 characters:
			array('email', 'unique'),
			// Email address must also be unique (see above), an email address,
			// and less than 60 characters:
			array('email', 'email'),
			array('email, first_name, last_name', 'length', 'max'=>60),
			// Password must match a regular expression:
			array('pass', 'match', 'pattern'=>'/^[a-z0-9_-]{6,20}$/i', 'on'=>'register'),
			// Password must match the comparison:
			array('passCompare', 'compare', 'compareAttribute'=>'pass', 'on'=>'register'),
			// Set the type to "public" by default:
			array('type', 'default', 'value'=>'public'),
			// Type must also be one of three values:
			array('type', 'in', 'range'=>array('public','author','admin')),
			// Set the date_entered to NOW():
			array('date_entered', 'default', 'value'=>new CDbExpression('NOW()'), 'on'=>'register'),
			array('date_updated', 'default', 'value'=>new CDbExpression('NOW()'), 'on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, pass, type, date_entered', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'bundle' => array(self::BELONGS_TO, 'Bundle', 'bundle_id'),
			'bundles' => array(self::HAS_MANY, 'Bundle', 'user_id'),
			'articles' => array(self::MANY_MANY, 'Article', 
				'user_has_article(user_id, article_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'pass' => 'Password',
			'type' => 'Type',
			'city_id' => 'Favorite City',
			'image' => 'Profile Image',
			'date_entered' => 'Date Entered',
			'passCompare' => 'Repeat Password',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('date_entered',$this->date_entered,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Function before saving new user.
	 * Sets encrypted password.
	 */	
	public function beforeSave() {
		if ($this->isNewRecord) {
			$this->pass = hash_hmac('sha256', $this->pass, Yii::app()->params['encryptionKey']);
		}
		return parent::beforeSave();
	}
	
	public function afterSave() {
		if (!Yii::app()->authManager->isAssigned($this->type, $this->id)) {
			Yii::app()->authManager->assign($this->type, $this->id);
		}
		return parent::afterSave();
	}
	
	public function loadGuest()
	{
		$user = new User();
		
		$user->timespan = Yii::app()->session['timespan'];
		$user->city_id = Yii::app()->session['city_id'];
		$user->last_viewed = Yii::app()->session['last_viewed'];
		
		return $user;
	}

	public function getRecentSavedArticles($limit=100) {
		$user_id = Yii::app()->user->getId();
		
		$q = "SELECT article_id FROM user_has_article WHERE user_id='$user_id' ORDER BY timestamp DESC LIMIT $limit";
		$cmd = Yii::app()->db->createCommand($q);
		$r = $cmd->query();

		$article_ids = array();
		
		foreach ($r as $row)
			$article_ids[] = $row['article_id'];
		
		$articles = Article::model()->findAllByPk($article_ids);
		
		return $articles;		
	}
	
	public function actionPassword($id)
	{
		$this->render('password');
	}
}