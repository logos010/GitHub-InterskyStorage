<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
require_once 'environment.php';

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'INTERSKY Storage System',
    'defaultController' => 'site',
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.helpers.*',
        'application.components.behaviors.*',
        'application.components.widgets.*',
        'application.extensions.*',
        'application.models.base.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.storage.models.*',
        'application.modules.customer.models.*',
        'application.modules.translate.TranslateModule',    
        'application.extensions.Util.Util',
    ),
    'preload' => array(
        'log',
        'translate'
    ),
    'modules' => array(
        'textedit',
        'email' => array(
            'delivery' => 'debug',
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'gii',
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'application.gii'  //Ajax Crud template path
            ),
        ),
        'admin',
        'storage',
        'customer',
        'translate',
        'user' => array(
            # encrypting method (php hash function)
            'hash' => 'md5',
            # send activation email
            'sendActivationMail' => false,
            # allow access for non-activated users
            'loginNotActiv' => true,
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => true,
            # automatically login from registration
            'autoLogin' => true,
            # registration path
            'registrationUrl' => array('/user/registration'),
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
            # login form path
            'loginUrl' => array('/user/login'),
            # page after login
            'returnUrl' => array('/user/profile'),
            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),
    ),
    // application components
    'components' => array(
//		'session' => array(
//			'class' => 'system.web.CDbHttpSession',
//			'connectionID' => 'db',
//		),        
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=intersky_storage',
            'username' => 'root',
            'password' => '',
        ),
        'user' => array(
            'class' => 'application.components.WebUser',
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array('user/login'),
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                'web' => array(
                    'class' => 'CWebLogRoute',
                    'levels' => 'trace, info, error, warning, application',
                    'categories' => 'system.db.*',
                    'showInFireBug' => true //firebug only - turn off otherwise
                ),
                'file' => array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, watch',
                    'categories' => 'system.*',
                ),
            ),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            //'caseSensitive'=>false,
            'rules' => array(
                'user/register/*' => 'user/create',
                'user/settings/*' => 'user/update',
            ),
        ),
        'CLinkPager' => array(
            'class' => 'CLinkPager',
            'cssFile' => false,
        ),
        'messages' => array(
            'class' => 'CDbMessageSource',
            'onMissingTranslation' => array('TranslateModule', 'missingTranslation'),
        ),
        'translate' => array(//if you name your component something else change TranslateModule
            'class' => 'translate.components.MPTranslate',
            //any avaliable options here
            'acceptedLanguages' => array(
                'en' => 'English',
                'pt' => 'Portugues',
                'es' => 'Español'
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'logos010@gmail.com',
    ),
);