<?php

require SYSPATH.'/Utils.php';
require SYSPATH.'/Loader.php';

try{
	spl_autoload_register('Loader::autoLoad');
	$uri = isset($_GET['module'])?$_GET['module']:'';
	list($AppClass,$AppAction) = Router::getAppInfo($uri);

	$App = new $AppClass();
	$App->$AppAction();
}catch(Exception $e){
	echo '<pre>'.$e->getMessage();
}
