<?php 


include(dirname(__FILE__).'/../config.php');

//initalization
$b = new Browser();

//start tests
$t = new limetest(20, new lime_output_color());


$t->diag('Calendar list');
///////////////////////////
$b->get($_host."/calendar", array('token' => $_token));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'calendars - property data');
$t->ok($out['error'] == false, 'calendars - has error');





$t->diag('Calendar - add');
///////////////////////////
$roommate_ids = array('100005176595662', $_userid);
$data = array('title' => 'testcalendar', 'location' => 'testlocation', 'start' => '2013-2-2 13:30', 'end'  => '2013-2-3 13:30', 'repeat' => 'no', 'notes' => 'testnotes', 'roommates' => $roommate_ids);
$save_data = json_encode($data);
$b->get($_host."/calendar/save", array('token' => $_token, 'data' => $save_data));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'add calendar - property data');
$t->ok($out['error'] == false, 'add calendar - has error');




//////Calendar ID
$_calendar_id = $out['data'][0]['id'];



//check that all users are added
$has_all_roommates = true;
foreach ($out['data'][0]['sharedUsers'] as $roommate) {
	if(!in_array($roommate['facebook_id'], $roommate_ids)){
		$has_all_roommates = false;
	}
}
unset($out['data'][0]['id'], $out['data'][0]['created_at'],  $out['data'][0]['sharedUsers'], $data['roommates']);

$t->ok($has_all_roommates == true, 'add calendar - added all users, including the creator');
$t->is_deeply($data, $out['data'][0], 'add calendar - save same data');





$t->diag('Calendar - calendar is in list');
//////////////////////////////////////////
$b->get($_host."/calendar", array('token' => $_token));
$out = $b->getResponseJson();

$has_calendar = false;
foreach ($out['data'] as $calendar) {
	if($calendar['title'] == $data['title'])
		$has_calendar = true;
}

$t->ok($has_calendar == true, 'add calendar - added');


//check calendar has all users added
$has_calendar_users = false;
foreach ($out['data'] as $calendar) {

	if($calendar['title'] == $data['title']){
		$has_calendar_users = true;

		foreach ($calendar['sharedUsers'] as $roommate) {
			if(!in_array($roommate['facebook_id'], $roommate_ids)){
				$has_calendar_users = false;
			}
		}
	}
}

$t->ok($has_calendar_users == true, 'add calendar - added roommates');



$t->diag('Calendar - update one user');
///////////////////////////
$roommate_ids = array();
$data = array('id' => (string)$_calendar_id, 'title' => 'testcalendar2', 'location' => 'testlocation2', 'start' => '2013-2-2 14:30', 'end'  => '2013-2-3 14:30', 'repeat' => 'yes', 'notes' => 'testnotes2', 'roommates' => $roommate_ids);
$save_data = json_encode($data);
$b->get($_host."/calendar/save", array('token' => $_token, 'data' => $save_data));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'update one user calendar - property data');
$t->ok($out['error'] == false, 'update one user calendar - has error');
$t->ok(empty($out['data'][0]['sharedUsers']), 'update one user calendar - remove users');





$t->diag('Calendar - update');
///////////////////////////
$roommate_ids = array($_userid);
$data = array('id' => (string)$_calendar_id, 'title' => 'testcalendar2', 'location' => 'testlocation2', 'start' => '2013-2-2 14:30', 'end'  => '2013-2-3 14:30', 'repeat' => 'yes', 'notes' => 'testnotes2', 'roommates' => $roommate_ids);
$save_data = json_encode($data);
$b->get($_host."/calendar/save", array('token' => $_token, 'data' => $save_data));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'update calendar - property data');
$t->ok($out['error'] == false, 'update calendar - has error');




//check that all users are added
$has_all_roommates = true;
foreach ($out['data'][0]['sharedUsers'] as $roommate) {
	if(!in_array($roommate['facebook_id'], $roommate_ids)){
		$has_all_roommates = false;
	}
}
unset($out['data'][0]['id'], $out['data'][0]['created_at'],  $out['data'][0]['sharedUsers'], $data['roommates'], $data['id']);

$t->ok($has_all_roommates == true, 'update calendar - added all users, including the creator');
$t->is_deeply($data, $out['data'][0], 'update calendar - save same data');




$t->diag('Calendar - updated calendar is in list');
///////////////////////////
//check calendar is updated
$b->get($_host."/calendar", array('token' => $_token));
$out = $b->getResponseJson();
$has_calendar = false;
foreach ($out['data'] as $calendar) {
	if($calendar['title'] == $data['title'])
		$has_calendar = true;
}

$t->ok($has_calendar == true, 'update calendar - calendar is updated');




//check updated calendar has all users added
$has_calendar_users = false;
foreach ($out['data'] as $calendar) {

	if($calendar['title'] == $data['title']){
		$has_calendar_users = true;

		foreach ($calendar['sharedUsers'] as $roommate) {
			if(!in_array($roommate['facebook_id'], $roommate_ids)){
				$has_calendar_users = false;
			}
		}
	}
}

$t->ok($has_calendar_users == true, 'update calendar - removed all roommates except me');






$t->diag('Calendar - remove calendar');
///////////////////////////
//remove calendar
$b->get($_host."/calendar/remove", array('token' => $_token, 'id' => $_calendar_id));
$out = $b->getResponseJson();

$t->ok(is_array($out['data']), 'remove calendar - property data');
$t->ok($out['error'] == false, 'remove calendar - has error');




//check calendar is removed
$b->get($_host."/calendar", array('token' => $_token));
$out = $b->getResponseJson();
$has_calendar = false;
foreach ($out['data'] as $calendar) {
	if($calendar['title'] == $data['title'])
		$has_calendar = true;
}

$t->ok($has_calendar == false, 'remove calendar - calendar is removed');
