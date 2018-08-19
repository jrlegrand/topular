<?php

class UserController extends Controller
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
			array('allow',  // allow all users to perform 'register' actions
				'actions'=>array('register','menu','set'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'edit' and 'view' actions
				'actions'=>array('edit','view','articles'),
				'roles'=>array('public'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionSet($timespan)
	{
		if (!Yii::app()->user->isGuest)
		{
			$user=User::model()->findByPk(Yii::app()->user->getId());
			
			$user->timespan=$timespan;
			
			if ($user->save()) $this->redirect(array('article/index'));
		} else {
			Yii::app()->session['timespan']=$timespan;
			$this->redirect(array('article/index'));
		}
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id=null)
	{
		if ($id == null) $id=Yii::app()->user->getId();
		
		$model = $this->loadModel($id);
		
		// Only allow users to view their own profiles
		if (!Yii::app()->user->checkAccess('viewUser', array('id' => $id))) {
			throw new CHttpException(403, 'You are not authorized to view this user.');
		}
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRegister()
	{
		// If already logged in, redirect to home URL
		if(!Yii::app()->user->isGuest) $this->redirect(Yii::app()->homeUrl);

		Yii::app()->params['current_title'] = 'Register';

		$model=new User('register');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success','<strong>You successfully registered!</strong> Please log in below.');
				$this->redirect(array('site/login'));
			}
		}

		$this->render('register',array(
			'model'=>$model,
		));
	}

	public function actionArticles()
	{
		if ($id == null) $id=Yii::app()->user->getId();
		
		$model = $this->loadModel($id);
		
		$this->render('articles',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id=null)
	{
		if ($id == null) $id=Yii::app()->user->getId();
		
		$model=$this->loadModel($id);
		
		// Only allow users to update their own profiles
		if (!Yii::app()->user->checkAccess('updateUser', array('id' => $id))) {
			throw new CHttpException(403, 'You are not authorized to edit this user.');
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		Yii::app()->params['current_title'] = 'Edit Profile';

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$upload = CUploadedFile::getInstance($model, 'image');
			if ($upload != null) $model->image=$model->id . '.' . strtolower($upload->extensionName);
			if($model->save())
			{
				if ($upload !== null)
				{
					//$path = Yii::getPathOfAlias('application.views.user.images');
					$path = Yii::app()->request->baseUrl . 'images/user';
					//$image =  $model->id . '.' . $model->image->extensionName;
					$upload->saveAs($path . '/' . $model->image);
				}

				Yii::app()->user->setFlash('success','<strong>Profile successfully edited!</strong>');
				$this->redirect(array('user/edit', 'id'=>$id));
			} else {
				Yii::app()->user->setFlash('error','<strong>Profile not edited...</strong> Something went wrong.');
			}
		}
		
		Yii::log("errors saving model: " . var_export($model->getErrors(), true), CLogger::LEVEL_WARNING, __METHOD__);
		
		$this->render('edit',array(
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAjaxpreferences($categories=null,$city=null,$sort=null,$age=null)
	{	
		User::setSession($categories,$sort,$age,$city);
		User::setPreferences();
	}
	
	public function actionClearpreferences()
	{
		$categories = '';
		
		User::setSession($categories);
		User::setPreferences();		
	}
}
