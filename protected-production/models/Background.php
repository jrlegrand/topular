<?php

/**
 * This is the model class for table "background".
 *
 * The followings are the available columns in table 'background':
 * @property string $id
 * @property string $url
 * @property string $source_url
 * @property string $author
 * @property string $city_id
 * @property integer $category_id
 * @property string $timestamp
 */
class Background extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'background';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url, source_url, author, city_id', 'required'),
			array('category_id', 'numerical', 'integerOnly'=>true),
			array('url, source_url', 'length', 'max'=>2083),
			array('author', 'length', 'max'=>100),
			array('city_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, url, source_url, author, city_id, category_id, timestamp', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'url' => 'Url',
			'source_url' => 'Source Url',
			'author' => 'Author',
			'city_id' => 'City',
			'category_id' => 'Category',
			'timestamp' => 'Timestamp',
		);
	}
	
	public function getUrl()
	{
		if (!Yii::app()->user->isGuest) {
			$user = User::model()->findByPk(Yii::app()->user->getId());
		} else {
			$user = User::model()->loadGuest();
		}
		
		if ($user->city_id) {
			$background = "'" . $this->findByAttributes(array('city_id'=>$user->city_id))->url . "'";
		} else {
			$backgrounds = $this->findAll(array(
				'select'=>'*, rand() as rand',
				'order'=>'rand',
				)
			);
			$ua = array();
			foreach ($backgrounds as $b) {
				$ua[] = $b->url;
			}
			$background = json_encode($ua) . ", {duration: 8000, fade: 1000}";
		}

		return $background;
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('source_url',$this->source_url,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Background the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
