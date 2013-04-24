<?php

class Engine_links extends Engine {
	
	public function run($middles = array()){
		$links = array();
		$xpath = new DOMXPath($this->b->getResponseDom());


		foreach( $xpath->query('//a') as $node ) {
			if($node->hasAttribute('href') && $this->isLocalLink($node->getAttribute('href'))){
				$links[] = $node->getAttribute('href');
			}
		}

		$this->b->links = $links;		
	}
	

	protected function isLocalLink($url){
		$url = trim($url);
		if(preg_match('@^javascript@usi', $url) || preg_match('@^#@usi', $url))
			return false;

		//clean up the url
		$url = preg_match('@^http@usi', $url) ? $url : $this->cleanHost($this->b->getUrlInfo()) . $url;
		
		
		$base_url = $this->cleanHost($this->b->getUrlInfo());
		$url = $this->cleanHost(parse_url($url));
		
		return $url == $base_url;
	}

	protected function cleanHost($url){				
		$url = $url['scheme'] . '://' . preg_replace('@www\.@usi', '', $url['host']);
		return trim($url);		
	}	
}
