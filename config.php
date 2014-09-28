<?php

/* App Config */
define('VERSION', '0.1.0');

/* Perhatian: Backup / Jangan diubah sama sekali!! */
define('APP_CRYPTO_KEY',  'cRyPt0@k3y');
define('APP_STAGE',       'development');
define('AUTH_TIMEOUT',    3600*6);

/* 
 * Path Config 
 */

// default
define('APP_PATH',    __DIR__);
define('LIB_PATH',    __DIR__.'/app/lib');
define('MODULE_PATH', __DIR__.'/app/module');
define('LOGS_PATH',   __DIR__.'/logs');
define('TPL_PATH',    __DIR__.'/tpl');
define('VENDOR_PATH', __DIR__.'/vendor');

// default: '/' or '/jendelakarir'
define('BASE_URL',    dirname($_SERVER['SCRIPT_NAME']));
define('ASSETS_URL',  BASE_URL.'/assets');

// website url
define('WEBSITE', 'http://localhost/webapp/');

/* 
 * Database Config 
 */

// MySQL hostname
define('DB_HOST', 'localhost');

// MySQL database name
define('DB_NAME', 'jetplanedb');

// MySQL database username
define('DB_USER', 'root');

// MySQL database password
define('DB_PASSWORD', '');

/* 
 * Email Config 
 */

// Security
define('MAIL_SECURITY', 'tls');
// Server Host
define('MAIL_HOST', 'smtp.gmail.com');
// Server Port
define('MAIL_PORT', 587);
// Sender
define('MAIL_FROM', 'zeinmiftah@gmail.com');
// Gmail Username
define('MAIL_USERNAME', '');
// Gmail Password
define('MAIL_PASSWORD', '');