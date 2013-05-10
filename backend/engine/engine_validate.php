<?php

class Engine_validate extends Engine {
	
	public function run($middles = array()){
		$this->validateMainPage();
	}

	protected function validateMainPage(){
		// var_dump($this->b->getUrl());

		if($this->b && $this->b->deep_search <= 0){
			$this->b = null;
			return;
		}

		foreach ($this->b->links as $url) {
			// var_dump($url);

			if($this->b){
				// if($this->cleanUrl($url) == $this->cleanUrl($this->b->getUrl())){
				// 	// var_dump('here', $this->cleanUrl($url),  $this->cleanUrl($this->b->getUrl()));

				// 	exit;
				// }

				if($this->cleanUrl($url) == $this->cleanUrl($this->b->getUrl())  ){
					$this->b = null;
					return;
				}
			}
		}
	}

	protected function cleanUrl($url){
		$url_info = $this->b->getUrlInfo();

		$params = array();
		$params['host'] = isset($url_info['host']) ? $url_info['host'] : false;
		$params['scheme'] = isset($url_info['scheme']) ? $url_info['scheme'] : false;


		$url = http_build_url(parse_url($url), $params);
		return trim($url);
	}
}
