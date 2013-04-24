<?php 


include(dirname(__FILE__).'/../config.php');

//initalization
$b = new Browser();

//start tests
$t = new limetest(9, new lime_output_color());
$t->diag('Roommates login');
$t->ok(!empty($_token), 'facebook missing test user token');

//login in app
$b->get($_host."/login", array('token' => $_token));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'property data');
$t->ok($out['error'] == false, 'has error');

$t->ok(isset($out['data'][0]['first_login']) , 'first_login property');
$t->ok($out['data'][0]['first_login'] == 1, 'on first login update first_login property to 1');
$t->ok(isset($out['data'][0]['facebook_id']), 'facebook_id property');
$t->like($out['data'][0]['color'], '@^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})@', 'user has color');


//login second time
$b->get($_host."/login", array('token' => $_token));
$out = $b->getResponseJson();

$t->ok($out['data'][0]['first_login'] == 0, 'on second login update first_login property to 0');

//login third time
$b->get($_host."/login", array('token' => $_token));
$out = $b->getResponseJson();

$t->ok($out['data'][0]['first_login'] == 0, 'on third login update first_login property to 0');
