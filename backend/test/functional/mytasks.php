<?php 


include(dirname(__FILE__).'/../config.php');

//initalization
$b = new Browser();

//start tests
$t = new limetest(20, new lime_output_color());


$t->diag('mytasks list');
///////////////////////////
$b->get($_host."/mytasks", array('token' => $_token));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'mytasks - property data');
$t->ok($out['error'] == false, 'mytasks - has error');





$t->diag('mytasks - add');
///////////////////////////
$roommate_ids = array('100005176595662', $_userid);
$data = array('title' => 'testcalendar', 'location' => 'testlocation', 'start' => '2013-2-2 13:30', 'end'  => '2013-2-3 13:30', 'repeat' => 'no', 'notes' => 'testnotes', 'roommates' => $roommate_ids);
$save_data = json_encode($data);
$b->get($_host."/mytasks/save", array('token' => $_token, 'data' => $save_data));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'add calendar - property data');
$t->ok($out['error'] == false, 'add calendar - has error');




//////mytasks ID
$_calendar_id = $out['data'][0]['id'];



//check that all users are added
$has_all_roommates = true;
foreach ($out['data'][0]['sharedUsers'] as $roommate) {
	if(!in_array($roommate['facebook_id'], $roommate_ids)){
		$has_all_roommates = false;
	}
}
unset($out['data'][0]['id'], $out['data'][0]['created_at'],  $out['data'][0]['sharedUsers'], $data['roommates']);

$t->ok($has_all_roommates == true, 'add mytasks - added all users, including the creator');
$t->is_deeply($data, $out['data'][0], 'add mytasks - save same data');





$t->diag('Mytasks - mytasks is in list');
//////////////////////////////////////////
$b->get($_host."/mytasks", array('token' => $_token));
$out = $b->getResponseJson();

$has_mytask = false;
foreach ($out['data'] as $mytask) {
	if($mytask['title'] == $data['title'])
		$has_mytasks = true;
}

$t->ok($has_mytask == true, 'add mytasks - added');


//check mytasks has all users added
$has_mytask_users = false;
foreach ($out['data'] as $mytask) {

	if($mytask['title'] == $data['title']){
		$has_mytask_users = true;

		foreach ($mytask['sharedUsers'] as $roommate) {
			if(!in_array($roommate['facebook_id'], $roommate_ids)){
				$has_mytask_users = false;
			}
		}
	}
}

$t->ok($has_mytask_users == true, 'add mytasks - added roommates');



$t->diag('Mytasks - update one user');
///////////////////////////
$roommate_ids = array();
$data = array('id' => (string)$_mytask_id, 'title' => 'testmytasks2', 'location' => 'testlocation2', 'start' => '2013-2-2 14:30', 'end'  => '2013-2-3 14:30', 'repeat' => 'yes', 'notes' => 'testnotes2', 'roommates' => $roommate_ids);
$save_data = json_encode($data);
$b->get($_host."/mytasks/save", array('token' => $_token, 'data' => $save_data));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'update one user mytasks - property data');
$t->ok($out['error'] == false, 'update one user mytasks - has error');
$t->ok(empty($out['data'][0]['sharedUsers']), 'update one user mytasks - remove users');





$t->diag('Mytasks - update');
///////////////////////////
$roommate_ids = array($_userid);
$data = array('id' => (string)$_mytask_id, 'title' => 'testmytasks2', 'location' => 'testlocation2', 'start' => '2013-2-2 14:30', 'end'  => '2013-2-3 14:30', 'repeat' => 'yes', 'notes' => 'testnotes2', 'roommates' => $roommate_ids);
$save_data = json_encode($data);
$b->get($_host."/mytasks/save", array('token' => $_token, 'data' => $save_data));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'update mytasks - property data');
$t->ok($out['error'] == false, 'update mytasks - has error');




//check that all users are added
$has_all_roommates = true;
foreach ($out['data'][0]['sharedUsers'] as $roommate) {
	if(!in_array($roommate['facebook_id'], $roommate_ids)){
		$has_all_roommates = false;
	}
}
unset($out['data'][0]['id'], $out['data'][0]['created_at'],  $out['data'][0]['sharedUsers'], $data['roommates'], $data['id']);

$t->ok($has_all_roommates == true, 'update mytasks - added all users, including the creator');
$t->is_deeply($data, $out['data'][0], 'update mytasks - save same data');




$t->diag('Mytasks - updated mytasks is in list');
///////////////////////////
//check mytasks is updated
$b->get($_host."/mytasks", array('token' => $_token));
$out = $b->getResponseJson();
$has_mytask = false;
foreach ($out['data'] as $mytask) {
	if($mytask['title'] == $data['title'])
		$has_mytask = true;
}

$t->ok($has_mytask == true, 'update mytasks - mytasks is updated');




//check updated mytasks has all users added
$has_mytask_users = false;
foreach ($out['data'] as $mytask) {

	if($mytask['title'] == $data['title']){
		$has_mytask_users = true;

		foreach ($mytask['sharedUsers'] as $roommate) {
			if(!in_array($roommate['facebook_id'], $roommate_ids)){
				$has_mytask_users = false;
			}
		}
	}
}

$t->ok($has_mytask_users == true, 'update mytasks - removed all roommates except me');






$t->diag('Mytasks - remove mytasks');
///////////////////////////
//remove mytasks
$b->get($_host."/mytasks/remove", array('token' => $_token, 'id' => $_mytask_id));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'remove mytasks - property data');
$t->ok($out['error'] == false, 'remove mytasks - has error');




//check mytasks is removed
$b->get($_host."/mytasks", array('token' => $_token));
$out = $b->getResponseJson();
$has_mytask = false;
foreach ($out['data'] as $mytask) {
	if($mytask['title'] == $data['title'])
		$has_mytask = true;
}

$t->ok($has_mytask == false, 'remove mytasks - mytasks is removed');
