<?php 

include(dirname(__FILE__).'/../config.php');

//initalization
$b = new Browser();
//start tests

$t = new limetest(5, new lime_output_color());
$t->diag('Friends');

//login in app
$b->get($_host."/friends", array('token' => $_token));
$out = $b->getResponseJson();


$t->ok(is_array($out['data']), 'data property');
$t->ok($out['error'] == false, 'has error');



$has_name = $has_id = $has_facebook_id = true;
foreach ($out['data'] as $key => $friend) {
	if(empty($friend['id']))
		$has_id = false;

	if(empty($friend['name']))
		$has_name = false;

	if(empty($friend['facebook_id']))
		$has_facebook_id = false;
}

$t->ok($has_id, 'all friends have id property');
$t->ok($has_name, 'all friends have name property');
$t->ok($has_facebook_id, 'all friends have facebook_id property');



