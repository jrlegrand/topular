<?php

/**
 * This is the model class for table "Bundle".
 *
 * The followings are the available columns in table 'Bundle':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $user_id
 * @property string $date_created
 * @property string $date_updated
 *
 * The followings are the available model relations:
 * @property BundleHasCategory[] $bundleHasCategories
 * @property UserHasBundle[] $userHasBundles
 */
class Bundle extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bundle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>150),
			array('description', 'length', 'max'=>500),
			array('user_id', 'length', 'max'=>10),
			array('date_updated, categories, cities, city_id, keywords', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, user_id, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'categories' => array(self::HAS_MANY, 'BundleHasCategory', 'bundle_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'userHasBundles' => array(self::HAS_MANY, 'UserHasBundle', 'bundle_id'),
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
			'description' => 'Description',
			'user_id' => 'User',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Bundle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
