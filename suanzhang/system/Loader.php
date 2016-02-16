<?php

class Loader{


	static function autoLoad($className) {
		$loader = self::loadConf('loader');
		$parts = explode('_', $className);
		$file = APPPATH.'/'.$loader['module_path'].'/'.implode('/',$parts).'.php';
		if(is_file($file)) {
			include_once $file;
		}else{
			$file = SYSPATH.'/'.$className.'.php';
			if(is_file($file)) {
				include_once $file;
			}else{
				return false;
			}
		}
	}

	static function loadConf($name){
		static $loader;
		if(!isset($loader[$name])) {
			$systemConfig = SYSPATH.'/default/'.$name.'.php';
			$appConfigFile = COFPATH.'/'.$name.'.php';
			$loader[$name] = array_merge(include($systemConfig),(is_file($appConfigFile)?include($appConfigFile):[]));
		}
		return $loader[$name];
	}

	static function GetAllmoduleName($class){
		$AllmoduleName[] = getMouleNameByClass($class);
		$parentClass = get_parent_class($class);
		while(1){
			if($parentClass && $parentClass!=='Core'){
				$AllmoduleName[] = getMouleNameByClass($parentClass);
				$parentClass = get_parent_class($parentClass);
			}else{
				break;
			}
		}
		
		return $AllmoduleName;
	}
}