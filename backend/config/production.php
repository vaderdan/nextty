<?php

class ProductionConfig extends Config{
	protected $db_dns = 'mysql:host=127.0.0.1;dbname=nextty';
	protected $db_user = 'root';
	protected $db_password = '';
	
	protected $rss_url = 'http://localhost/nextty/rss/';

	protected $log_file = './log/out.txt';
}

