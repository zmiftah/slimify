<?php

/*
 * @project : WebApp Console
 * @author  : Zein Miftah
 * @copyright : 2014
 * @last-update : 2014-09-17
 */

// Default App Setting
error_reporting(~E_NOTICE);
date_default_timezone_set('Asia/Jakarta');

// Includes
include_once __DIR__.'/config.php';
include_once VENDOR_PATH.'/autoload.php';

// Init Application
$App = new \App\Lib\Application();
$App->config([
    'log.enabled' => true,
    'log.writer'  => new Slim\Logger\DateTimeFileWriter([
        'path'    => LOGS_PATH
    ]),
]);

ORM::configure('mysql:host=localhost;dbname='.DB_NAME);
ORM::configure('username', DB_USER);
ORM::configure('password', DB_PASSWORD);
ORM::configure('logging', true);

$command = new Commando\Command();
$console = new App\Lib\Console($command);
$console->run();