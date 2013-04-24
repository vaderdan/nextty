<?php

class Engine{
	protected $b;

	public function __construct($input){
		if(is_string($input)){
			$this->b = new Browser();
			$this->get($input);
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
