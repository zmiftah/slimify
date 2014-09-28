<?php

/*
 * @project : WebApp Skeleton
 * @author  : Zein Miftah
 * @copyright : 2014
 * @last-update : 2014-09-17
 */

// Default App Setting
error_reporting(~E_NOTICE); //E_ALL | E_STRICT);
date_default_timezone_set('Asia/Jakarta');

// Includes
include_once __DIR__.'/config.php';
include_once VENDOR_PATH.'/autoload.php';

// Init Application
$WebApp = new \App\Lib\Application();

// Bootstraping Application
include_once __DIR__.'/app/bootstrap.php';

// Run Application
$WebApp->run();