<?php

class PreferenceController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('city','collection','timespan'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionCity()
	{
		$cities = City::model()->findAll();
		
		$this->render('city',array(
			'cities'=>$cities,
		));
	}
	
	public function actionCollection()
	{
		$user_id=Yii::app()->user->getId();
		
		$collections = Collection::model()->findAll();
		
		$this->render('collection',array(
			'collections'=>$collections,
		));
	}
	
	public function actionTimespan()
	{
		echo 'CHANGE TIMESPAN PREFERENCE';
	}

}
