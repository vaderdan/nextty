<?php

class Log{
	public static function out($out){
		if(!Config::get('log_file'))
			return;

		$sp  = "\n\n\n\n";
		$spl = "\n\n----------------------------------------------------------------------------\n\n";
		


		$headers = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$data = $headers.$sp.$out.$spl;

		
		file_put_contents(Config::get('log_file'), $data, FILE_APPEND);
	}
}