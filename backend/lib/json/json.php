<?php

class Json{
	
	public static function show($data, $app = false){
		$array['data'] = (is_array($data) || is_object($data)) ? self::toArray($data) : array();
		$array['error_msg'] = is_string($data) ? $data : '';
		$array['error'] = is_string($data) ? true : false;

		// For JsonP cross domain shits
		$callback = is_object($app) ? $app->request()->get('callback') : false;
		$template = ($callback == true ? $callback.'(%s);' : '%s');
		

		header('Content-type: application/json');
		$out = sprintf($template, self::encode($array));

		Log::out($out);

		echo $out;
		exit;
	}

	//conver redbean object to array
	private static function toArray($array){				
		if(is_object($array))
			return R::exportAll($array);

		if(is_object(reset($array)))
			return R::exportAll($array);
		else
			return $array;
	}

	public static function encode($array){
		return json_encode($array);
	}

	public static function decode($string){
		return json_decode($string, true);
	}

}
