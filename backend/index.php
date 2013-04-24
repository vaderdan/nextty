<?php

session_start();

ini_set('display_errors', 1);
header('Content-Type: text/html; charset=cp1251');
echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";


include dirname(__FILE__).'/projectConfig.php';


$app = new Slim\Slim();


$app = Controller::load($app, dirname(__FILE__).'/controller', dirname(__FILE__).'/data/_autoload_controler.php');

$app->run();

