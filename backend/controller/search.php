<?php

$app->get('/search', function () use ($app) {
	if($app->request()->get('url') == '' || parse_url($app->request()->get('url'), PHP_URL_HOST) == null){
		die(json_encode(array( 'error' => 'invalid_url' )));
	}


	if($app->request()->get('q') == ''){
		die(json_encode(array( 'error' => 'invalid_query' )));	
	}
	

	$e = new Engine($app->request()->get('url'));
	// $e->getB()->deep_search = 1;
	// $e->run(array('links', 'validate', 'content', 'openpages'));
});






















// $b  = new Browser();	
	// $b->get(Config::get('rss_url').'makefulltextfeed.php', array(
	// 		'url' => 'http://stackoverflow.com/questions/4980610/implementing-a-splash-screen-in-ios',
	// 		'max' => '50',
	// 		'links' => 'preserve',
	// 		'exc' => '',
	// 		'format' => 'json'
	// 	));

	// $rss = json_decode($b->getResponseText(), true);
	// $rss = !empty($rss['rss']['channel']) ? $rss['rss']['channel'] : array();
	
	// $content = !empty($rss['item']) ? $rss['item'] : array();
	
	// var_dump($content);
	
	// http://localhost/nextty/rss/makefulltextfeed.php?url=www.capital.bg%2Fbiznes%2Ftehnologii_i_nauka%2F2013%2F03%2F08%2F2018387_misli_purvo_za_malkiia%2F&max=5&links=preserve&exc=&format=json&submit=Create+Feed	