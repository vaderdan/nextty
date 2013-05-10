<?php

class Engine{
	protected $b;

	public function __construct($input){
		if(is_string($input)){
			$pages = R::find('pages',' url = ? ', array(trim($input)));
			
			// $this->b = new Browser();
			
			// if($page){
			// 	$this->b->setUrlInfo(parse_url($input));
			// 	$this->b->setResponseHeaders(array('Content-Type: text/html'));
			// 	$this->b->setResponseCode(200);
			// 	$this->b->setResponseText($page->html);
			// }
			// else{
			// 	$this->b->get($input);
			
			// 	$page = R::dispense('pages');
			// 	$page->url = trim($input);
			// 	$page->html = $this->b->getResponseText();
			// 	R::store($page);
			// }
		}
		else if(is_object($input) && get_class($input) == 'browser'){
			$this->b = $input;
		}
		else{
			die(json_encode(array( 'error' => 'invalid_engine_input' )));
		}

		if($this->b->responseIsError()){
			die(json_encode(array( 'error' => 'invalid_engine_page_code' )));
		}
	}

	public function run($middles = array()){
		$b = $this->b;

		foreach ($middles as $class) {
			$className = 'Engine_'.$class;
			$e = new $className($b);
			$e->run();

			if($e->getB()){
				$b = clone $e->getB();
			}
			else{
				break;
			}
		}

		return $b;
	}

	public function getB() {
	    return $this->b;
	}
}
