<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Insectram CRM v.1.3',
	'theme'=>'crm',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		/*authmodulelist*/
				'deneme2',
			/*authmodulelistend*/
		'authsystem',
		'email',
		'leftmenu',
		'qrcode',
		'pdf',
		'translate'=>array(
			'components'=>array(
				'language'=>array(
					'class'=>'Language',
				),
			),
					'parametre'=>20,
					'dirpath'=>'languages',
		),
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'@datahan2018',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array($_SERVER['REMOTE_ADDR'],'::1'),
		),

	),

	// application components
	'components'=>array(
		'SetFlashes'=>array(
            'class'=>'application.components.SetFlashes'),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
            'showScriptName' => false,
			'urlFormat'=>'path',
            'baseUrl' => 'http://localhost/insectram',
			'rules'=>array(
			'app'=>'/mobile/index1',
			/*authmodulelist*/
				'deneme',
			/*authmodulelistend*/
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),


		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
        ),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

		'phpSettings'=>array(
			'memory_limit'=>'512M',
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'fcurukcu@gmail.com',
	),
);
