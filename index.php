<?php

// include Yii bootstrap file
$yii = dirname(__FILE__) . '/../www/yii/yii-1.1.8.r3324/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

// turns debug on
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);
date_default_timezone_set("Asia/Ho_Chi_Minh");
// create a Web application instance and run
Yii::createWebApplication($config)->run();