<?php

define('ENV', 'development');

define('BASE_URL', 'http://localhost/interskymanagement');
define('DB_CONNECTION', 'mysql:host=127.0.0.1;dbname=intersky_storage');
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_CHARSET', 'utf8');
define('DB_TABLE_PREFIX', '');

define('SITE_NAME', 'Intersky Storage Management');
define('LOCALE', 'en');
define('THEME', 'default');

define('ADMIN_THEME', 'admin');
define('LOGIN_THEME', 'login');

define('ADMIN_PAGE_SIZE', 10);

// Value storage config Table
// ============================
// Range Floor
define('RANGE_NUMBER', 1);
define('RANGE_FLOOR_NUMBER', 4);
define('RANGE_FLOOR', 'N,E,W,S');
define('RANGE_COLUMN', 4);

//  Floor floors
define('FLOOR_COLUMN', 5);  //a Floor in container have 5 columns
define('FLOOR_ROW', 3);     //a Floor in container have 3 rows