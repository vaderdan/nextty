<?php

class Config extends ArrayObject{
	private static $instance;

	public function __construct() {
	    $this->setFlags(ArrayObject::ARRAY_AS_PROPS);
	}

	public static function register($mode, $default_mode = ''){
		$mode = !empty($mode) ? $mode : $default_mode; 
		$configClass = ucfirst($mode).'Config';

		if (!class_exists($configClass)) {
			throw new Exception("Cannot load config file");
		}

		$instance = new $configClass();
		self::$instance = $instance;
	}
	
	public static function get($key){
		$config = self::getInstance();

		return $config->$key;
	}

	public static function set($key, $value){
		$config = self::getInstance();

		$config->$key = $value;

		self::$instance = $config;
	}

	public static function getInstance(){
		if (!isset(self::$instance)) {
	      self::$instance = new self();
	    }
	    return self::$instance;	
	}

	public function __get($key){
		if(!empty($this->$key))
			return $this->$key;
		else
			return;
	}

	public function __set($key, $value){
		$this->$key = $value;
	}
}

