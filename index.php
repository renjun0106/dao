<?php

/*
*	0=>开发，1=>线上
*/
define('ENVIRONMENT',0);

if(ENVIRONMENT){
	error_reporting(0);
}else{
	error_reporting(E_ALL);
}


require('include/main.php');