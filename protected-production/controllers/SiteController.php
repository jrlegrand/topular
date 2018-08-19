<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * Sets up the RBAC rules for authorization.
	 * Only needs to be run once - should be limited to admin only.
	 */
	public function actionSetup()
	{
		$auth = Yii::app()->authManager;
		$auth->createOperation('viewUser');
		$auth->createOperation('updateUser');
		$auth->createOperation('deleteUser');
		
		$auth->createOperation('createSource');
		$auth->createOperation('updateSource');
		$auth->createOperation('deleteSource');
		
		$auth->createOperation('updateArticle');
		$auth->createOperation('deleteArticle');
		
		$task = $auth->createTask('viewOwnUser',
			'Allows a user to view their profile',
			'return $params["id"] == Yii::app()->user->id;');
		$task->addChild('viewUser');
		
		$task = $auth->createTask('updateOwnUser',
			'Allows a user to update their profile',
			'return $params["id"] == Yii::app()->user->id;');
		$task->addChild('updateUser');
		
		$task = $auth->createTask('updateOwnSource',
			'Allows an editor to update their source',
			'return $params["ownerId"] == $params["userId"]');
		$task->addChild('updateSource');
		
		$role = $auth->createRole('public');
		$role->addChild('viewOwnUser');
		$role->addChild('updateOwnUser');
		
		$role = $auth->createRole('editor');
		$role->addChild('public');
		$role->addChild('updateOwnSource');
		
		$role = $auth->createRole('admin');
		$role->addChild('editor');
		$role->addChild('createSource');
		$role->addChild('updateSource');
		$role->addChild('deleteSource');
		$role->addChild('viewUser');
		$role->addChild('updateUser');
		$role->addChild('deleteUser');
		$role->addChild('updateArticle');
		$role->addChild('deleteArticle');
		
	}
	
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the about page
	 */
	public function actionAbout()
	{
		$this->render('about');
	}
	
	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	public function actionDashboard()
	{
		if (!Yii::app()->user->isGuest && Yii::app()->user->type === 'admin')
			$this->render('dashboard');
		else
			$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin($provider_name=null)
	{
		// If already logged in, redirect to home URL
		if(!Yii::app()->user->isGuest) $this->redirect(Yii::app()->homeUrl);
		
		if($provider_name)
		{
			$config = Yii::app()->request->baseUrl . 'hybridauth/config.php';
			require_once( Yii::app()->request->baseUrl . 'hybridauth/Hybrid/Auth.php' );
			
			try
			{
				// create an instance for Hybridauth with the configuration file path as parameter
				$hybridauth = new Hybrid_Auth( $config );
			  
				// try to authenticate the user with twitter, 
				// user will be redirected to Twitter for authentication, 
				// if he already did, then Hybridauth will ignore this step and return an instance of the adapter
				$provider = $hybridauth->authenticate( $provider_name );  
			 
				// get the user profile 
				$provider_user_profile = $provider->getUserProfile();
			  
			}
			catch( Exception $e ){  
				// Display the recived error, 
				// to know more please refer to Exceptions handling section on the userguide
				switch( $e->getCode() ){ 
				  case 0 : echo "Unspecified error."; break;
				  case 1 : echo "Hybriauth configuration error."; break;
				  case 2 : echo "Provider not properly configured."; break;
				  case 3 : echo "Unknown or disabled provider."; break;
				  case 4 : echo "Missing provider application credentials."; break;
				  case 5 : echo "Authentification failed. " 
							  . "The user has canceled the authentication or the provider refused the connection."; 
						   break;
				  case 6 : echo "User profile request failed. Most likely the user is not connected "
							  . "to the provider and he should authenticate again."; 
						   $provider->logout(); 
						   break;
				  case 7 : echo "User not connected to the provider."; 
						   $provider->logout(); 
						   break;
				  case 8 : echo "Provider does not support this feature."; break;
				} 
			 
				// well, basically your should not display this to the end user, just give him a hint and move on..
				//echo "<br /><br /><b>Original error message:</b> " . $e->getMessage(); 
			}
			
			// Try to find user in database matching $provider_user_profile->identifier
			$user = User::model()->findByAttributes(array('provider_uid'=>$provider_user_profile->identifier));
			// If user exists, log that user in
			if ($user) {
				$model=new LoginForm;
				
				// Set $model->attributes to the attributes from the database
				$model->email = $user->email;
				$model->password = $user->provider_uid;
				// FUTURE NOTE: Don't require password if provider_uid is part of the model (see the login or validate functions)
				// This might cause problems later when we implement password changing
				
				// Validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
					$this->redirect(Yii::app()->user->returnUrl);
			}
			
			// If user doesn't exist in database, see if we can register them
			if ($provider_user_profile->email) {
				$model=new User('register');

				$model->email = $provider_user_profile->email;
				$model->pass = $model->passCompare = $provider_user_profile->identifier;
				$model->provider_uid = $provider_user_profile->identifier;
				if($model->save())
				{
					Yii::app()->user->setFlash('success','<strong>Success!</strong> Now Topular should log you in. But it won\'t. Cuz I haven\'t built it.');
				} else {
					Yii::app()->user->setFlash('error','<strong>The email associated with your ' . $provider_name . ' account already exists.</strong> Please try logging in with this email.');
				}
			} else {
					Yii::app()->user->setFlash('warning','<strong>You are so close!</strong> Your ' . $provider_name . ' account did not have an email associated with it. Please enter your email to finish logging in.');
			}
		}

		$model=new LoginForm;
			
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model, 'provider'=>$provider));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}