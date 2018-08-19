<?php

class BundleController extends Controller
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
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','set','delete'),
				'roles'=>array('public'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionSet($id)
	{
		$user=User::model()->findByPk(Yii::app()->user->getId());
		
		$user->bundle_id=$id;
		$user->last_viewed=2; // Set bundle as last viewed
		
		if ($user->save()) $this->redirect(array('article/index'));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Bundle;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bundle']))
		{
			$model->attributes=$_POST['Bundle'];

			$model->user_id = Yii::app()->user->getId();

			if($model->categories !== '')
				$model->categories = implode(',',$model->categories);

			if($model->cities !== '')
				$model->cities = implode(',',$model->cities);

			if($model->save())
				$this->redirect(array('index'));
		}
		
		$model->categories = explode(',',$model->categories);

		$this->render('create',array(
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

		if(isset($_POST['Bundle']))
		{
			$model->attributes=$_POST['Bundle'];

			if($model->categories !== '')
				$model->categories = implode(',',$model->categories);

			if($model->cities !== '')
				$model->cities = implode(',',$model->cities);

			if($model->save())
				$this->redirect(array('index'));
		}

		$model->categories = explode(',',$model->categories);

		$this->render('update',array(
			'model'=>$model,
		));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$user_id=(!Yii::app()->user->isGuest ? Yii::app()->user->getId() : 0);
		
		$criteria = new CDbCriteria();
		$criteria->condition = "user_id=$user_id";
		$count = Bundle::model()->count($criteria);
		$pages = new CPagination($count);
		
		$pages->pageSize = 3;
		$pages->applyLimit($criteria);
		$bundles = Bundle::model()->findAll($criteria);

		$this->render('index',array(
			'bundles'=>$bundles,
			'pages'=>$pages,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Bundle('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bundle']))
			$model->attributes=$_GET['Bundle'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Bundle the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bundle::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bundle $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bundle-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
