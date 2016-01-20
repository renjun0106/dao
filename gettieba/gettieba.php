<?php


set_time_limit(0);
$id = isset($_GET['id'])?$_GET['id']:'';

if(!$id){
	echo '<form>id:<input name="id" value="'.$id.'"></form>';exit;
}

$html_1 = '';

$url_1 = 'http://tieba.baidu.com/mo/q----,sz@320_240-1-3---1/';
$url_2 = $url_1.'m?kz='.$id.'&pn=';

$file_1 = file_get_contents($url_2);

//1
	preg_match('/^(.+)<body>.+(<div class="bc p">.+<br\/>).+(<div class="d">.+)<form action=".+name="pnum".+value="(.+)"/U', $file_1, $data_1);

	$cssjs = '<style>.t{display:none;background-color: papayawhip;}.r{cursor: pointer;}.r:hover{background-color: antiquewhite;}</style>';
	$cssjs .= '<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>';
	$cssjs .= '<script>$(function(){$(".r").click(function(event){event.preventDefault();$(this).closest(".i").next(".t").toggle();});});</script>';

	$head = $data_1[1].$cssjs.'<body>'.$data_1[2].'</div>';

	$html_1 .= $head.$data_1[3].'</div>';

	for ($i=1; $i <$data_1[4] ; $i++) { 
	   $file_2 = file_get_contents($url_2.($i*30));
	   preg_match('/<div class="d">(.+)<form action="/sU', $file_2, $data_2);
	   $html_1 .= $data_2[1];
	}

	//echo $html_1;die;


//2

	$html_2 = $head.'<div class="d">';

	preg_match_all('/<div class="i">.+<\/div>/U', $html_1, $data_3);

	foreach ($data_3[0] as $tmp) {
		if(strstr($tmp,'<br/>(1/')){
			preg_match('/<a href="(\/m.+)"/U', $tmp, $url_3);
		    $url = str_replace('spn=2',"spn=1",$url_3[1]);
		    $url = str_replace('&amp;',"&",$url);
		    $url = 'http://tieba.baidu.com'.$url.'&global=1';

			$data_4 = file_get_contents($url);  
			preg_match('/<div class="i">.+<\/div>/U', $data_4, $tmp2);
			
			$html_2 .= $tmp2[0];
		}else{
			$html_2 .= $tmp;
		}
	}
	//echo $html_2;die;


//3

	$html_3 = $head.'<div class="d">';
	  
	preg_match_all('/<div class="i">.+<\/div>/U', $html_2, $data_4);

	$i=0;
	foreach ($data_4[0] as $tmp) {

		if(strstr($tmp,'回复(')){
			preg_match('/<td class="r".+<a href=".*(flr?.+)" class="reply_to/U', $tmp, $moreurl);
		    $url = str_replace('&amp;',"&",$moreurl[1]);
		    $url = $url_1.$url;

			$moredata = file_get_contents($url);  
			preg_match('/(<div class="m t">.+)(<form action="|<\/div><div><a)/U', $moredata, $tmp2);
			$reply_html = $tmp2[1];

			preg_match('/<br\/>第.+\/(.+)页<input/U', $moredata, $page);
			if($page){
				for ($k=2; $k <= $page[1] ; $k++) { 
					$u = $url."&fpn=".$k;
					$repalymore = file_get_contents($u);
					preg_match('/<div class="m t">(.+)<form action="/U', $repalymore, $tmp3);
					$reply_html .= $tmp3[1];
				}
			}
			$reply_html .= '</div>';

			$html_3 .= $tmp.$reply_html;
		}else{
			$html_3 .= $tmp;
		}
	}

	$html_3 .= '</div></body></html>';
	//echo $html_3;die;


//4

$html_4 = preg_replace("/<a[^>]*>(.*)<\/a>/U",'${1}',$html_3);
$html_4 = preg_replace("/&#160;回复[^(]/U",'<',$html_4);
$html_4 = preg_replace("/<td class=\"r\"><\/td>/U",'',$html_4);


$file = fopen($id.'.html','w');
fwrite($file,$html_4);
fclose($file);

echo $html_4;