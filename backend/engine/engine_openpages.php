<?php


class Engine_openpages extends Engine{
	public function run($middles = array()){
		
		

		foreach ($this->b->links as $url) {
			$e = new Engine($url);
			$e->run(array('links', 'validate', 'content', 'openpages'));
			
			
		}

	}
}
