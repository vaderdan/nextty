<?php 


include(dirname(__FILE__).'/../config.php');

//initalization
$b = new Browser(array(), 'sfCurlAdapter');

//start tests
$t = new limetest(1, new lime_output_color());
$t->diag('Server');
//login in app
$b->get($_host."/roommates", array('token' => $_token));
$response_codee = $b->getResponseCode();

$t->ok($response_codee = 200, 'server is up');

