<?php
class CommonUtil {
	private static $instance = null;
	private function __construct() {}
	private function __clone() {}

	public static function getInstance() {
		
		if(!is_object(self::$instance)) {
			self::$instance = new CommonUtil();		
		}
		
		return self::$instance;
	}

	
	public function nvl($param, $paramValue, $defaultValue) {
		if(!array_key_exists($paramValue, $param) || !$param[$paramValue])			
			$param[$paramValue] = $defaultValue;

		return $param;
	}	
}