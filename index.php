<?php

/*
*	0=>开发，1=>线上
*/
define('ENVIRONMENT',0);

if(ENVIRONMENT){
	error_reporting(0);
}else{
	error_reporting(E_ALL);
	$HeaderTime = microtime(true);
	$HeaderMemory = memory_get_usage();
}






require('include/main.php');








if(!$_POST){
	if(!ENVIRONMENT){
		printf("<script>console.log({
			'total run': '%.10f s',
			'memory before usage': '%.10f K',
			'memory after usage': '%.10f K'
		})</script>",
		microtime(true)-$HeaderTime, $HeaderMemory / 1024, memory_get_usage() / 1024 );
	}
}