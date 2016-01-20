<?php 
/*  
 *  http://localhost/search.php?w=php
 *  by 2015-3-25
 */
error_reporting(E_ALL & ~E_NOTICE);
header('Content-Type: text/html; charset=UTF-8');
class Search{

    public function index()
    {
        if($_GET['ajax']){
            $this->ajax();exit;
        }
        $q = is_null($_GET['w'])?'php':$_GET['w'];
        $url = array();
        $show_baidu=$show_bing=$show_sgou=0;
        $p=0;
        $baidu = $this->baidu('http://m.baidu.com/s?word='.$q);
        $bing = $this->bing('http://cn.bing.com/search?q='.$q);
        $sogou = $this->sogou('http://wap.sogou.com/web/searchList.jsp?keyword='.$q);


        $i=0;
        echo $baidu[1];echo $bing[1];echo $sogou[1];
        echo '<script src="http://wap.sogou.com/js/zepto.min.js" type="text/javascript"></script>';     
        echo '<link href="http://wap.sogou.com/resource/web/css/base.min.css?ver=150129" rel="stylesheet" type="text/css"/> <link href="http://wap.sogou.com/resource/web/css/vr_overwrite.min.css?v=140520" rel="stylesheet" type="text/css"/>';
        echo '<style>body{background: #E0E0E0;} .comefrom{text-align: left;padding: 5px 10px 9px;margin: 6px 0;background: #fff;border-top: 1px solid #e0e0e0;} .b_algo ,.result,.vrResult{text-align: left;border: 0px;}.b_algo{padding-bottom: 0px;margin-left: 10;margin-bottom: 11px;}';
        echo '.results{padding: 5px 10px 9px;margin: 6px 0;background: #fff;border: 0px;}.comelogo{height:30px;  margin-bottom: -5px;}</style>';
        foreach ($baidu['list'][1] as $b) {
            if(!empty($b)){
                if(preg_match('/(<p class="[A-Z] .+<\/p>)<\/div>$/U',$b,$tmps)){
                    $tmp = strstr(strip_tags($tmps[1]),' ',true);
                    $tmp2 = $tmp?$tmp:strip_tags($tmps[1]);
                    if(!in_array($tmp2, $url)){
                        $show_baidu = 1;
                        $url[] = $tmp2;
                    }
                }else if(preg_match('/<span class="site">(.+)<\/span>/U', $b, $tmps)){
                    if(!in_array($tmps[1], $url)){
                        $show_baidu = 1;
                        $url[] = $tmps[1];
                    }
                }else{
                    $show_baidu = 1;
                }

                if($show_baidu==1){
                    echo '<div id="results" class="results">';echo $b;
                    echo '<p class="comefrom">来自<img class="comelogo" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAABzklEQVRIx2P4//8/w0BgFI5FzGN8uAmI/wPxVSBmwaGGA4iZqWlxA9RSZIyuZgWSXBy1LP6PBWsRcJgmpRbL4LC4Gil4scl/ptRiTRwGT4LK++OQ/0+pxQI4DI6DyhfgkH9GqsWmQOwKxIwE4pgDKueFQ96eFIsfoWkWhBquiCY+FclRLFgsfU10qgYqNsbhcpgFIEeUArEllugQA+IHUPVTkMwUBmJrIJbEZ/EBHBYbEChY4Bgt9DrRzHmEy+L/OHA4qRYD2Ww4zEomxWI3LJZIAXEENCuxYbHYkFAWQ1bcg0OxGJKFTKCCAYuaYjSL3UmxGFvqvIPm0994QiYJySw7oi2GagDlzXlAfAKII4moKNCxCNQccRzyW0itJByJsBSGmaBmPcMiJ0yKxd548jYuy2Hm6QBxLhDHgEKTlLK6gkChgs/njORWEsexFJ3E1NPImJtUix8gabYg0EBAcQSWckGNWIvTiAhWUiwGYT5iLP5PA4sPErKYnUYW/ydkMRMWi82JjGN0s0iyGFdKFaDQ4gfEWOxOQilFLHYiNjstoqKlL0ktQOSgTR1Q+6oP2o72BWJZaCKEqWMFYm0g7gDij0gW3gMVt0QVIPTEALhQR0GmUQAMAAAAAElFTkSuQmCC">百度</p>';echo '</div>';
                    $show_baidu = 0;
                }
            }
            if(!empty($bing['list'][1][$i])){
                if(preg_match('/<cite>(.+)<\/cite>/', $bing['list'][1][$i], $tmps)){
                    if(!in_array(strip_tags($tmps[1]), $url)){
                        $url[] = strip_tags($tmps[1]);
                        $show_bing = 1;
                    }
                }else{
                    $show_bing = 1;
                }

                if($show_bing==1){
                    echo '<div id="b_content" style="margin-top:0px;"><ol id="b_results">';echo $bing['list'][1][$i];
                    echo '<p class="comefrom" style="margin-top:0px;padding-top:0px;">来自<img class="comelogo" src="http://cn.bing.com/rms/rms%20serp%20Homepage$bgLogoBingBrand/ic/572aec3d/35a3e645.png?y">bing</p>';echo '</ol></div>';
                    $show_bing = 0;
                }
            }
            if(!empty($sogou['list'][1][$i])){
                if(preg_match('/<div class="citeurl">(.+)<\/div>/', $sogou['list'][1][$i], $tmps)){
                    $tmpnum = strpos(strip_tags($tmps[1]),'- ');
                    if($tmpnum){
                        $tmp = trim(substr(strip_tags($tmps[1]),$tmpnum+2));
                    }else
                        $tmp = trim(strip_tags($tmps[1]));
                    if(!in_array($tmp, $url)){
                        $url[] = $tmp;
                        $show_sgou = 1;
                    }
                }else{
                    $show_sgou = 1;
                }

                if($show_sgou==1){
                    echo '<div id="mainBody" class="mainBody" style="padding: 0;"><div class="results">';echo $sogou['list'][1][$i];
                    echo '<p class="comefrom">来自<img class="comelogo" src="http://wap.sogou.com/images/app_tuiguang/tg_logo.png">搜狗</p>';echo '</div></div>';
                    $show_sgou = 0;
                }else{
                    echo preg_replace('/<div.*<\/div>/',"",$sogou['list'][1][$i]);
                }
            }
            $i++;
        }
        echo '<div id="loading_next_page" class="loading" style="display: none;"><span>加载中</span></div>';
        echo '<div id="page-controller" style="cursor:pointer;"><div id="pagenav" class="pagenav"><div class="pagebar">下一页<span class="ico"></span></div></div></div>';
        echo '<script src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js" type="text/javascript"></script>';
        echo '<script>var page=1;$("#page-controller").click(function(){$("#page-controller").hide();$("#loading_next_page").show();$.get("/search.php?ajax=1&w='.$q.'&p="+page,function(d){$("#loading_next_page").hide();$("#page-controller").show();$("#loading_next_page").before(d);page++;});});</script>';
        echo $baidu[3];echo $bing[3];echo $sogou[3];
        //var_dump($url);
    }

    function baidu($url){
        do {
           $file = $this->grap($url);
        } while (empty($file));
        
        //echo $file;die;
        preg_match('/(^.+)<div id="page".+(<div id="page-bd".+)(<style id="search_ls_css_btm".+$)/sU', $file, $data);
        $data[2] = preg_replace('/href="\//','href="http://m.baidu.com/',$data[2]);

        preg_match_all('/(<div class="result(?: |").+<\/div>)(?=<div class="(?:result |[a-zA-Z]{6}"))/U', $data[2], $data['list']);
        return $data;
    }

    function bing($url){
        do {
           $file = $this->grap($url);
        } while (empty($file));

        //echo $file;die;
        preg_match('/(^.+)<header id="b_header">.+(<div id="b_content">.+)<footer class="b_footer">.+<\/footer>(.+$)/sU', $file, $data);
        preg_match_all('/(<li class="b_algo.+<\/li>)(?=<li class="(?:b_algo|b_ans))/U', $data[2], $data['list']);
        return $data;
    }

    function sogou($url){
        do {
           $file = $this->grap($url);
        } while (empty($file));

        //echo $file;die;
        preg_match('/(^.+)<div class="header.+(<div id="mainBody.+)(<!--pageHideShow begin-->.+$)/sU', $file, $data);
        if(preg_match('/<!--顶部广告 end-->.+<\/style>/U', $data[2],$data_top)){
            $data[1] .= $tmp = preg_replace('/<div.*<\/div>/',"",$data_top[0]);
        }
        $data[2] = preg_replace('/href="(?:@!|\$\$)\//','href="http://wap.sogou.com/web/',$data[2]);
        $data[2] = preg_replace('/(this\.qourl = ")(.+getJSON)/sU','$1http://wap.sogou.com$2',$data[2]);
        preg_match_all('/(<div class="(?:r|vrR)esult".+)(?=<div class="(?:r|vrR)esult"|<!--底部广告-->)/sU', $data[2], $data['list']);
        
        return $data;
    }

    function grap($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('CLIENT-IP:116.226.224.1','X-FORWARDED-FOR:116.226.224.1',));
        //curl_setopt ($ch, CURLOPT_REFERER, pathinfo($url,PATHINFO_DIRNAME).'/');
        
        $out = curl_exec($ch);
        curl_close($ch);
        return $out;
    }

    public function ajax()
    {
        $q = is_null($_GET['w'])?'php':$_GET['w'];
        $p = $_GET['p'];
        $baidu = $this->baidu('http://m.baidu.com/s?word='.$q.'&pn='.($p*10));
        $bing = $this->bing('http://cn.bing.com/search?q='.$q.'&first='.($p*10));
        $sogou = $this->sogou('http://wap.sogou.com/web/searchList.jsp?keyword='.$q.'&p='.$p);

        $url = array();
        $show_baidu=$show_bing=$show_sgou=0;
        $i=0;
        foreach ($baidu['list'][1] as $b) {
            if(!empty($b)){
                if(preg_match('/(<p class="[A-Z] .+<\/p>)<\/div>$/U',$b,$tmps)){
                    $tmp = strstr(strip_tags($tmps[1]),' ',true);
                    $tmp2 = $tmp?$tmp:strip_tags($tmps[1]);
                    if(!in_array($tmp2, $url)){
                        $show_baidu = 1;
                        $url[] = $tmp2;
                    }
                }else if(preg_match('/<span class="site">(.+)<\/span>/U', $b, $tmps)){
                    if(!in_array($tmps[1], $url)){
                        $show_baidu = 1;
                        $url[] = $tmps[1];
                    }
                }else{
                    $show_baidu = 1;
                }

                if($show_baidu==1){
                    echo '<div id="results" class="results">';echo $b;
                    echo '<p class="comefrom">来自<img class="comelogo" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAABzklEQVRIx2P4//8/w0BgFI5FzGN8uAmI/wPxVSBmwaGGA4iZqWlxA9RSZIyuZgWSXBy1LP6PBWsRcJgmpRbL4LC4Gil4scl/ptRiTRwGT4LK++OQ/0+pxQI4DI6DyhfgkH9GqsWmQOwKxIwE4pgDKueFQ96eFIsfoWkWhBquiCY+FclRLFgsfU10qgYqNsbhcpgFIEeUArEllugQA+IHUPVTkMwUBmJrIJbEZ/EBHBYbEChY4Bgt9DrRzHmEy+L/OHA4qRYD2Ww4zEomxWI3LJZIAXEENCuxYbHYkFAWQ1bcg0OxGJKFTKCCAYuaYjSL3UmxGFvqvIPm0994QiYJySw7oi2GagDlzXlAfAKII4moKNCxCNQccRzyW0itJByJsBSGmaBmPcMiJ0yKxd548jYuy2Hm6QBxLhDHgEKTlLK6gkChgs/njORWEsexFJ3E1NPImJtUix8gabYg0EBAcQSWckGNWIvTiAhWUiwGYT5iLP5PA4sPErKYnUYW/ydkMRMWi82JjGN0s0iyGFdKFaDQ4gfEWOxOQilFLHYiNjstoqKlL0ktQOSgTR1Q+6oP2o72BWJZaCKEqWMFYm0g7gDij0gW3gMVt0QVIPTEALhQR0GmUQAMAAAAAElFTkSuQmCC">百度</p>';echo '</div>';
                    $show_baidu = 0;
                }
            }
            if(!empty($bing['list'][1][$i])){
                if(preg_match('/<cite>(.+)<\/cite>/', $bing['list'][1][$i], $tmps)){
                    if(!in_array(strip_tags($tmps[1]), $url)){
                        $url[] = strip_tags($tmps[1]);
                        $show_bing = 1;
                    }
                }else{
                    $show_bing = 1;
                }

                if($show_bing==1){
                    echo '<div id="b_content" style="margin-top:0px;"><ol id="b_results">';echo $bing['list'][1][$i];
                    echo '<p class="comefrom" style="margin-top:0px;padding-top:0px;">来自<img class="comelogo" src="http://cn.bing.com/rms/rms%20serp%20Homepage$bgLogoBingBrand/ic/572aec3d/35a3e645.png?y">bing</p>';echo '</ol></div>';
                    $show_bing = 0;
                }
            }
            if(!empty($sogou['list'][1][$i])){
                if(preg_match('/<div class="citeurl">(.+)<\/div>/', $sogou['list'][1][$i], $tmps)){
                    $tmpnum = strpos(strip_tags($tmps[1]),'- ');
                    if($tmpnum){
                        $tmp = trim(substr(strip_tags($tmps[1]),$tmpnum+2));
                    }else
                        $tmp = trim(strip_tags($tmps[1]));
                    if(!in_array($tmp, $url)){
                        $url[] = $tmp;
                        $show_sgou = 1;
                    }
                }else{
                    $show_sgou = 1;
                }

                if($show_sgou==1){
                    echo '<div id="mainBody" class="mainBody" style="padding: 0;"><div class="results">';echo $sogou['list'][1][$i];
                    echo '<p class="comefrom">来自<img class="comelogo" src="http://wap.sogou.com/images/app_tuiguang/tg_logo.png">搜狗</p>';echo '</div></div>';
                    $show_sgou = 0;
                }
            }
            $i++;
        }
    }

    function writelog($str,$name)
    {
        $open=fopen($name,"a" );
        fwrite($open,$str);
        fclose($open);
    } 

}
$s = new search();
$s->index();

