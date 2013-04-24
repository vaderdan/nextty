<?php

class Engine_validate extends Engine {
	
	public function run($middles = array()){
		
		$this->validateMainPage();
	}

	protected function validateMainPage(){
		// foreach ($this->b->links as $url) {
		// 	if($this->cleanUrl($url) == $this->cleanUrl($this->b->getUrl())){
				$this->b = null;
		// 	}
		// }		
	}

	protected function cleanUrl($url){				
		$url = $url['scheme'] . '://' . preg_replace('@www\.@usi', '', $url['host']);
		return trim($url);		
	}	
}
