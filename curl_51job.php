<?php

error_reporting(E_ALL);
ini_set('display_errors','on');
date_default_timezone_set('PRC');
set_time_limit(0);
header("Content-Type: text/html;charset=utf-8");

$url = 'http://search.51job.com/jobsearch/search_result.php?fromJs=1&jobarea=180200%2C00&district=000000&funtype=0000&industrytype=00&issuedate=9&providesalary=07%2C08%2C09%2C10%2C06&keyword=java&keywordtype=0&lang=c&stype=2&postchannel=0000&workyear=99&cotype=99&degreefrom=99&jobterm=99&companysize=99&lonlat=0%2C0&radius=-1&ord_field=0&list_type=0&fromType=14&dibiaoid=0&confirmdate=9&curr_page=';


$content =  grap($url.'1');
//creatFlie('java.html',$content);
preg_match('/onclick="jumpPage\(\'(\d+)\'\);/s', $content, $num);


$file = fopen('java_10000.html', 'a');
setData($content);
for ($i=2; $i <= $num[1]; $i++) { 
	$content =  grap($url.$i);
	setData($content);
}
fclose($file);

function setData($content){
	global $file;
	preg_match_all('/(<div class="el">.+)(?=<div class="el">|<div class="dw_tlc">)/Us', $content, $arr);
	foreach ($arr[0] as $key => $value) {
		fwrite($file, $value);
	}
	
}

function creatFlie($filename,$content){
	
	$file = fopen($filename, 'w');
	fwrite($file, $content);
	fclose($file);
}

function grap($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    	"Accept-Encoding:{gzip, deflate}",
"Accept: {text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8}",
"Accept-Language: {zh-CN,zh;q=0.8}",
"Cache-Control: {no-cache}",
"Connection: {keep-alive}",
"Content-Length: {3050}",
"Content-Type: {application/x-www-form-urlencoded}",
"Cookie:{guid=14578452655545100018; guide=1; __gads=ID=26f725a90b692383:T=1458648602:S=ALNI_MZhZ0gO7fHRDcdL4Ojc8uxJ-UqENA; adv=adsnew%3D1%26%7C%26adsresume%3D1%26%7C%26adsfrom%3Dhttp%253A%252F%252Fbzclk.baidu.com%252Fadrc.php%253Ft%253D0fKL00c00fAjOKR0gXdf00uiAs0KUOuy00000r4NOWY00000rBAtgK.THYdnyGEm6K85yF9pywd0ZnquHDLuHTdmhRsnjDznWR1mfKd5RckPbnzwHuDf1bvnjmvfYfdPDm3nWPAfHDYnHDLPW7a0ADqI1YhUyPGujYzPW6kn1msPH61FMKzUvwGujYkPBuEThbqniu1IyFEThbqFMKzpHYz0ARqpZwYTjCEQLwzmyP-QWRkphqBQhPEUiqYTh7Wui4spZ0Omyw1UMNV5HT3rHc1nzu9pM0qmR9inAPDULunnvf1uZbYnRdgTZuupHNJmWcsI-0zyM-BnW04yydAT7GcNMI-u1YqFh_qnARkPHcYPjFbrAFWrHRsuHR4PhFWPjmkryPhrHKhuhc0mLFW5Hf4PHc1%2526tpl%253Dtpl_10085_12986_1%2526l%253D1040078318%2526ie%253Dutf-8%2526f%253D3%2526tn%253Dbaidu%2526wd%253D51job%2526oq%253D51%2526prefixsug%253D51%2526rsp%253D0%26%7C%26adsnum%3D789233; 51job=cenglish%3D0; collapse_expansion=1; search=jobarea%7E%60020000%7C%21ord_field%7E%600%7C%21list_type%7E%600%7C%21recentSearch0%7E%602%A1%FB%A1%FA020000%2C00%A1%FB%A1%FA000000%A1%FB%A1%FA0000%A1%FB%A1%FA00%A1%FB%A1%FA9%A1%FB%A1%FA99%A1%FB%A1%FA07%2C08%2C09%2C10%A1%FB%A1%FA99%A1%FB%A1%FA99%A1%FB%A1%FA99%A1%FB%A1%FA99%A1%FB%A1%FAjava%A1%FB%A1%FA0%A1%FB%A1%FA%A1%FB%A1%FA-1%A1%FB%A1%FA1458991034%A1%FB%A1%FA0%A1%FB%A1%FA%7C%21recentSearch1%7E%602%A1%FB%A1%FA020000%2C00%A1%FB%A1%FA000000%A1%FB%A1%FA0000%A1%FB%A1%FA00%A1%FB%A1%FA9%A1%FB%A1%FA99%A1%FB%A1%FA07%A1%FB%A1%FA99%A1%FB%A1%FA99%A1%FB%A1%FA99%A1%FB%A1%FA99%A1%FB%A1%FAjava%A1%FB%A1%FA0%A1%FB%A1%FA%A1%FB%A1%FA-1%A1%FB%A1%FA1458990896%A1%FB%A1%FA0%A1%FB%A1%FA%7C%21recentSearch2%7E%602%A1%FB%A1%FA020000%2C00%A1%FB%A1%FA000000%A1%FB%A1%FA0000%A1%FB%A1%FA00%A1%FB%A1%FA9%A1%FB%A1%FA99%A1%FB%A1%FA99%A1%FB%A1%FA99%A1%FB%A1%FA99%A1%FB%A1%FA99%A1%FB%A1%FA99%A1%FB%A1%FAjava%A1%FB%A1%FA0%A1%FB%A1%FA%A1%FB%A1%FA-1%A1%FB%A1%FA1458990865%A1%FB%A1%FA0%A1%FB%A1%FA%7C%21}",
"Host: {search.51job.com}",
"Origin: {http://search.51job.com}",
"Pragma: {no-cache}",
"Referer: {http://search.51job.com/jobsearch/search_result.php?fromJs=1&jobarea=020000%2C00&district=000000&funtype=0000&industrytype=00&issuedate=9&providesalary=07%2C08%2C09%2C10&keyword=java&keywordtype=0&curr_page=1&lang=c&stype=2&postchannel=0000&workyear=99&cotype=99&degreefrom=99&jobterm=99&companysize=99&lonlat=0%2C0&radius=-1&ord_field=0&list_type=0&dibiaoid=0&confirmdate=9}",
"Upgrade-Insecure-Requests: {1}",
"User-Agent: {Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36}"
));
    
    $out = curl_exec($ch);
    curl_close($ch);
    return $out;
}


