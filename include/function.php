<?php

function loadClass($file){
	$class = trim(strrchr($file,'/'),'/');

	require_once($file.'.php');

	return new $class;
}