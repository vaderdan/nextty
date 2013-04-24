<?php



class Controller{
	
	public static function load($app = false, $load_dir = '', $save_file = ''){
		$app = empty($app) ? new Slim\Slim() : $app;
		$load_dir = empty($load_dir) ? dirname(__FILE__) : $load_dir;
		$save_file = empty($save_file) ? $load_dir.'/_autoload.php' : $save_file;


		$autoloadManager = new AutoloadAll();
		$autoloadManager->setSaveFile($save_file);
		$autoloadManager->addFolder($load_dir);
		
		$autoloadManager->register();
		
		foreach ($autoloadManager->getRegisteredClasses() as $class) {
            require($class);
        }

		return $app;
	}

}