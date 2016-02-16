<?php

class Router{

	static function getAppInfo($uri){
		$router = Loader::loadConf('router');
		$uri = trim($uri,'/');
		$uri = $uri?$uri:$router['default_url'];
		$uritmp = strstr($uri,'?',true);
		$uri = $uritmp?$uritmp:$uri;
		$uritmp = isset($router['url_rules'][$uri])?$router['url_rules'][$uri]:$uri;
		$pathList = explode('/',$uritmp);
		
		$AppAction = array_pop($pathList);
		$AppClass = implode('_',$pathList);

		return [$AppClass,$AppAction];
	}
	
}