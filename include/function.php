<?php

function loadClass($file){
	$class = trim(strrchr($file,'/'),'/');

	require_once($file.'.php');

	return new $class;
}

function l($data,$add=1){
    ob_start();
    print_r($data);
    $contents = ob_get_contents();
    ob_end_clean();

	$file = fopen('log.txt',$add?'a':'w');
	fwrite($file,$contents);
	fclose($file);
}