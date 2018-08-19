<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Topular',
	'defaultController'=>'article',
	'theme'=>'bootstrap-development',
	
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.vendors.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Sword.Base.1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('98.206.151.121'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'identityCookie' => array(
				'domain'=>'topular.in',
				'secure'=>true,
			),
		),
		'authManager'=>array(
			'class'=>'CDbAuthManager',
			'connectionID'=>'db',
		),
		'urlManager'=>array(
			'showScriptName'=>true,
			'urlFormat'=>'path',
			'caseSensitive'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				array(
					'class' => 'application.components.ArticleUrlRule',
					'connectionID' => 'db',
				),
				'<action:(register)>'=>'user/<action>',
				'<action:(login|logout|about)>'=>'site/<action>',
				'login/<provider_name:\w+>'=>'site/login',
				'<controller:\w+>'=>'<controller>/index',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=mysql.dashboard.topular.in;dbname=topular',
			'emulatePrepare' => true,
			'enableParamLogging' => true,
			'username' => 'topular',
			'password' => 'Sword.Base.1',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
					'enabled'=>YII_DEBUG,
				),
				array(
					'class'=>'CWebLogRoute',
					'enabled'=>YII_DEBUG,
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'yourfriends@topular.in',
		'encryptionKey'=>'lxkj25mo2j29GJE7r',
	),
);