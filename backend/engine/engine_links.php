<?php

class Engine_links extends Engine {
	
	public function run($middles = array()){
		$links = array();
		$xpath = new DOMXPath($this->b->getResponseDom());


		foreach( $xpath->query('//a') as $node ) {
			if($node->hasAttribute('href') && $this->isLocalLink($node->getAttribute('href'))){
				$links[] = $this->cleanUrl($node->getAttribute('href'));
			}
		}

		$this->b->links = $links;
	}
	
	protected function isLocalLink($url){
		$url = trim($url);
		if(preg_match('@^javascript@usi', $url) || preg_match('@^#@usi', $url))
			return false;

		
		$base_url = $this->cleanHost($this->b->getUrlInfo());
		$url = $this->cleanHost(parse_url($url));
		
		return $url == $base_url;
	}

	protected function cleanHost($url){				
		if(empty($url))
			return false;

		$params = array();
		$base_url_info = $this->b->getUrlInfo();
		
		
		if(!isset($url['host'])){
			$params['scheme'] = $base_url_info['scheme'];
			$params['host'] = $base_url_info['host'];			
		}
		else{
			$params['host'] =$url['host'];				
		}

		$params['host'] = preg_replace('@www\.@usi', '', $params['host']);				


		$url = http_build_url($url, $params, HTTP_URL_STRIP_ALL);
		return trim($url);
	}	

	protected function cleanUrl($url){
		$base_url_info = $this->b->getUrlInfo();

		$params = array();
		$params['host'] = isset($base_url_info['host']) ? $base_url_info['host'] : false;
		$params['scheme'] = isset($base_url_info['scheme']) ? $base_url_info['scheme'] : false;


		$url = http_build_url(parse_url($url), $params);
		return trim($url);
	}
}
