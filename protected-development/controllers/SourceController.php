<?php

class SourceController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'submit' and 'update' actions
				'actions'=>array('submit'),
				'roles'=>array('public'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'roles'=>array('editor'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','update','delete','submit','approve','mail'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
	public function actionSubmit()
	{
		$model=new Source;

		$admin = (Yii::app()->user->checkAccess('createSource'));		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Source']))
		{
			$model->attributes=$_POST['Source'];
			
			$model->user_id = Yii::app()->user->getId();
			
			if (!$admin)
				$model->user_submitted=1;
			
			if($model->save())
				Yii::app()->user->setFlash('success','<strong>Success!</strong> You have successfully submitted a source!');

				if (!$admin)
				Yii::app()->user->setFlash('info','The Topular Team will approve your submission within 24 hours.');
				
				$to = 'support@topular.in';
				$subject = 'New Source Submitted';
				$message = $this->renderPartial('view', array('model'=>$model),true);
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: Topular New Source <support@topular.in>' . "\r\n";

				mail($to,$subject,$message,$headers);
			
				$this->redirect(array('submit'));
		}

		$this->render('submit',array(
			'model'=>$model,
		));
	}
	
	public function actionMail()
	{
				$source = Source::model()->findByPk(511);
				//$message = '<html><body><h1>TEST</h1><p>Test test test test.</p></body></html>';
				$message = $this->renderPartial('view', array('model'=>$source),true);
				$message .= '<a href="http://topular.in/source/approve">GO TO SOURCE APPROVE PAGE</a>';
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: New Source <support@topular.in>' . "\r\n";

				mail('jrlegrand@gmail.com','New Source Submitted',$message,$headers);
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if (!Yii::app()->user->checkAccess('updateSource', array('ownerId' => $model->user_id))) {
			throw new CHttpException(403, 'You are not allowed to update this source.');
		}		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Source']))
		{
			$model->attributes=$_POST['Source'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Source');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
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
	 * Approve user submitted sources.
	 */
	public function actionApprove($id=null)
	{
		if ($id)
		{
			$model=Source::model()->resetScope()->findByPk($id);
			$model->user_submitted = 0;
			if($model->save())
			{
				Yii::app()->user->setFlash('success','<strong>Success!</strong> You have approved this source!');
			} else {
				Yii::app()->user->setFlash('error','<strong>Uh oh!</strong> Something went wrong with approving this source.');
			}
		}
		
		$model=Source::model()->resetScope()->userSubmitted()->findAll();
		
		$this->render('approve',array(
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
