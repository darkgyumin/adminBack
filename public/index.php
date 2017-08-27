<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

@session_start();
header('Content-type: text/plain; charset=utf-8');

require_once './../vendor/autoload.php';
require_once './../class/CommonUtil.php';
require_once './../class/PagingUtil.php';

use Firebase\JWT\JWT;
use Zend\Config\Factory;
use Slim\PDO\Database;
use Slim\App;

$app = new App([
    "settings"  => [
        "displayErrorDetails" => true,
        "determineRouteBeforeAppMiddleware" => true,
		"debug" => true,
    ]
]);

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->withHeader('Content-Type', 'application/json');
});

$container = $app->getContainer();

$container['config'] = function($container) {
    $config = Factory::fromFile('./../config/config.php', true);

    return $config;
};

//https://github.com/FaaPz/Slim-PDO/tree/master/docs
$container['pdo'] = function($container) {
    $config = $container->config->get('database');

    $dsn = 'mysql:host='.$config->get('host').';dbname='.$config->get('name').';charset=utf8';
    $pdo = new Database($dsn, $config->get('user'), $config->get('password'));

    return $pdo;
};

$container['paging'] = function($container) {
    $pagingUtil = PagingUtil::getInstance();

    return $pagingUtil;
};

$container['common'] = function($container) {
    $commonUtil = CommonUtil::getInstance();

    return $commonUtil;
};

//error Handler
$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {

		$json['status'] = (string)$exception->getCode();
        
		if($exception->getCode() == 500) $json['message'] = 'internal server error';
		if($exception->getCode() == 401) $json['message'] = 'unauthorized';
		if($exception->getCode() == 400) $json['message'] = 'bad request';
		if($exception->getCode() == 200) $json['message'] = 'success';

        return $response->withJson($json, $exception->getCode());
    };
};

require_once './../routes/popup.php';

$app->run();