<?php 


include(dirname(__FILE__).'/../config.php');

//initalization
$b = new Browser();

//start tests
$t = new limetest(12, new lime_output_color());
$t->diag('Roomates');

//get roommates
$b->get($_host."/roommates", array('token' => $_token));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'data property');
$t->ok($out['error'] == false, 'has error');



$has_name = $has_id = $has_facebook_id = $has_color = true;
foreach ($out['data'] as $key => $friend) {
	if(empty($friend['id']))
		$has_id = false;

	if(empty($friend['name']))
		$has_name = false;

	if(empty($friend['facebook_id']))
		$has_facebook_id = false;

	if(!preg_match('@^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})@', $friend['color']))
		$has_color = false;
}



$t->ok($has_id, 'all roommates have id property');
$t->ok($has_name, 'all roommates have name property');
$t->ok($has_facebook_id, 'all roommates have facebook_id property');
$t->ok($has_color, 'all roommates have color property');


// ROOMMATE ID
$roommate_test_id = '100005176595662';




//add roommate
$b->get($_host."/roommates/add", array('token' => $_token, 'id' => $roommate_test_id));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'add roommate - property data');
$t->ok($out['error'] == false, 'add roommate - has error');





//check roommate is added
$b->get($_host."/roommates", array('token' => $_token));
$out = $b->getResponseJson();

$has_roommate = false;
foreach ($out['data'] as $roommate) {
	if($roommate['facebook_id'] == $roommate_test_id)
		$has_roommate = true;
}

$t->ok($has_roommate == true, 'add roommate - added to roommate list');




//remove roommate
$b->get($_host."/roommates/remove", array('token' => $_token, 'id' => $roommate_test_id));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'remove roommate - property data');
$t->ok($out['error'] == false, 'remove roommate - has error');




//check roommate is removed
$b->get($_host."/roommates", array('token' => $_token));
$out = $b->getResponseJson();

$has_roommate = false;
foreach ($out['data'] as $roommate) {
	if($roommate['facebook_id'] == $roommate_test_id)
		$has_roommate = true;
}

$t->ok($has_roommate == false, 'remove roommate - removed roommate from list');
