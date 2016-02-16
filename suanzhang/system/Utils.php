<?php

function creatFlie($filename,$content){
	
	$file = fopen($filename, 'w');
	fwrite($file, $content);
	fclose($file);
}

function getMouleNameByClass($className){
	$thisClassArr = explode('_',$className);
	return implode('/',array_splice($thisClassArr,0,-2));
}

function error($message){
	throw new Exception($message);
}

function dump($var){
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}

/*------------------------------------------------------
参数：
$str_cut    需要截断的字符串
$length     允许字符串显示的最大长度
程序功能：截取全角和半角（汉字和英文）混合的字符串以避免乱码
------------------------------------------------------
*/
function substr_cut($str_cut,$length)
{
    if (strlen($str_cut) > $length)
    {
        for($i=0; $i < $length; $i++)
        if (ord($str_cut[$i]) > 128)    $i++;
        $str_cut = substr($str_cut,0,$i)."..";
    }
    return $str_cut;
}