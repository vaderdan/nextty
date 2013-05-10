<?php

include_once(dirname(__FILE__).'/mode.php');
include_once(dirname(__FILE__).'/overrides.php');
include_once(dirname(__FILE__).'/lib/autloload/autoload.php');




$autoloadManager = new Autoload();
$autoloadManager->setSaveFile(dirname(__FILE__).'/data/_autoload.php');
$autoloadManager->addFolder(dirname(__FILE__).'/lib');
$autoloadManager->addFolder(dirname(__FILE__).'/engine');
$autoloadManager->addFolder(dirname(__FILE__).'/config');
$autoloadManager->register();

Config::register($_mode, 'local');

R::setup(Config::get('db_dns'), Config::get('db_user'), Config::get('db_password'));


