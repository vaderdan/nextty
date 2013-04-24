<?php

// ini_set('display_errors', 0);

include(dirname(__FILE__).'/lib/lime/lime.php');
include(dirname(__FILE__).'/lib/lime/lime2.php');
include(dirname(__FILE__).'/lib/browser/browser.php');

$_host = 'http://localhost/happy_flatsharing/backend';
$_fb_key = '155270524625799';
$_fb_secret = 'ff58ba1bee5f2fdbfc286f2508c666c1';


//make request to facebook
$b = new Browser(array(), 'sfCurlAdapter', array('cookies' => true));
$b->get("https://graph.facebook.com/oauth/access_token?client_id={$_fb_key}&client_secret={$_fb_secret}&grant_type=client_credentials");
$app_token = preg_replace('@access_token=@usi', '', $b->getResponseText());


//get fb user
$b->get("https://graph.facebook.com/{$_fb_key}/accounts/test-users?access_token={$app_token}");
$user = $b->getResponseJson();
$user = $user['data'][0];
$_token = $user['access_token'];

$_userid = $user['id'];


