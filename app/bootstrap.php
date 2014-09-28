<?php

use \App\Lib\Session;
use \App\Lib\Auth;
use \Slim\Views\Twig;
use \Slim\Logger\DateTimeFileWriter;
use \Slim\Views\TwigExtension;
use \Rgsone\Slim\LazyControllerConnector;

/**
 * Procedural Functions
 */
include_once 'function.php';

/**
 * Setting Application
 */
$_ENV['SLIM_MODE'] = APP_STAGE;

$WebApp->config([
    'debug'           => false,
    'cookies.encrypt' => true,
    'log.enabled'     => true,
    'view'            => new Twig(),
    'templates.path'  => TPL_PATH,
    'log.writer'      => new DateTimeFileWriter([
        'path'        => LOGS_PATH
    ]),
]);

// Setting View Extensions
$WebApp->view()->parserExtensions = [
    new TwigExtension()
];

// IoC
$WebApp->container->singleton('auth', function () {
    return new Auth();
});
$WebApp->container->singleton('session', function () {
    return new Session();
});

// Start session
$WebApp->session->start();

/**
 * Setting Database
 */
ORM::configure('mysql:host='.DB_HOST.';dbname='.DB_NAME);
ORM::configure('username', DB_USER);
ORM::configure('password', DB_PASSWORD);
ORM::configure('logging', true);

/**
 * Setting Controller
 */
$connector = new LazyControllerConnector($WebApp);

$connector->connectRoutes(
    'App\Controller\SiteController', [
        '/'       => ['action'=>'checkLogin'],
        '/login'  => ['action'=>'formLogin','method'=>'GET|POST'],
        '/logout' => ['action'=>'logout'],
    ]
);
$connector->connectRoutes(
    'App\Controller\EventController', [
        '/timeline(/page/:page)' => ['action'=>'timeline'],
        '/jadwal(/page/:page)'   => ['action'=>'listEvent'],
        '/jadwal/tambah'         => ['action'=>'addEvent','method'=>'GET|POST'],
        '/jadwal/edit/:id'       => ['action'=>'editEvent','method'=>'GET|POST'],
        '/jadwal/hapus/:id'      => ['action'=>'deleteEvent','method'=>'GET|POST'],
        '/jadwal/ajax_disposisi' => ['action'=>'ajaxDisposisi','method'=>'POST'],
    ],
    'App\Lib\Middleware:checkLogin'
);