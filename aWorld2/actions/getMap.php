<?php
error_reporting(E_STRICT);

$z = $_REQUEST['z'];
$x = $_REQUEST['x'];
$y = $_REQUEST['y'];
$w = $_REQUEST['w'];
$h = $_REQUEST['h'];
$mapkeystr = $_REQUEST['mapkeystr'];



$mepointarr = array(
	array('x'=>$x+$w,'y'=>$y+$h),
	array('x'=>$x-$w,'y'=>$y+$h),
	array('x'=>$x+$w,'y'=>$y-$h),
	array('x'=>$x-$w,'y'=>$y-$h)
	);

$mapkeyarr = explode('|', trim($mapkeystr,'|'));

$dir = "../map/$z/";
$file = scandir($dir);
foreach ($file as $f) {
	$arr = explode('.',$f);
	$points = $arr[0];
	$type = $arr[1];
	switch ($type) {
		case 'map':
			$isput = 0;
			$polygon = array();
			$pointarr = explode(',', $points);
			foreach ($pointarr as $point) {
				list($px,$py) = explode('_', $point);
				$polygon[] = array('x'=>(int) $px,'y'=>(int) $py);
			}

			if(pnpoly_pnpoly($mepointarr,$polygon)){
				if(in_array($points,$mapkeyarr)){
					$map = new stdClass();
				}else{
					$map = json_decode(file_get_contents($dir.$f));
				}
				$map->isdraw = true;
				$put['map'][$points] = $map;
			}
			break;
		
		case 'block':
			$isput = 0;
			$polygon = array();
			$pointarr = explode(',', $points);
			foreach ($pointarr as $point) {
				list($px,$py) = explode('_', $point);
				$polygon[] = array('x'=>(int) $px,'y'=>(int) $py);
			}

			if(pnpoly_pnpoly($mepointarr,$polygon)){
				if(in_array($points,$mapkeyarr)){
					$block = new stdClass();
				}else{
					$block = json_decode(file_get_contents($dir.$f));
				}
				$block->isdraw = true;
				
				$put['block'][$points] = $block;
			}
			break;
		
		default:
			# code...
			break;
	}
}
//var_dump($put);
if(isset($put)){
	echo json_encode($put);
}else{
	echo false;
}



//多边形与多边形是否有交集
function pnpoly_pnpoly($polygon,$polygon2){
	array_push($polygon,$polygon[0]);

    for ($i=0; $i < count($polygon)-1; $i++) {
	    if(pnpoly_line($polygon2,$polygon[$i],$polygon[$i+1])){
	    	return true;
	    }
	    if(pnpoly_point($polygon2,$polygon[$i])){
	    	return true;
	    }
    }
    array_pop($polygon);
    for ($i=0; $i < count($polygon2); $i++) {
	    if(pnpoly_point($polygon,$polygon2[$i])){
	    	return true;
	    }
    }
    return false;
}

////多边形与线段是否有交集
function pnpoly_line($polygon, $pointstar, $pointend){
	array_push($polygon,$polygon[0]);
	for ($i=0; $i < count($polygon)-1; $i++) {
        if(line_line($pointstar,$pointend,$polygon[$i],$polygon[$i+1])){
            return true;
        }
    }
	return false;
}

////线段与线段是否有交集
function line_line($s1,$e1,$s2,$e2){
	return( (max($s1['x'],$e1['x'])>=min($s2['x'],$e2['x']))&&
	(max($s2['x'],$e2['x'])>=min($s1['x'],$e1['x']))&& 
	(max($s1['y'],$e1['y'])>=min($s2['y'],$e2['y']))&& 
	(max($s2['y'],$e2['y'])>=min($s1['y'],$e1['y']))&& 
	(multiply($s2,$e1,$s1)*multiply($e1,$e2,$s1)>=0)&&
	(multiply($s1,$e2,$s2)*multiply($e2,$e1,$s2)>=0)); 
}

//得到(sp-op)*(ep-op)的叉积
function multiply($sp, $ep, $op) { 
	return (($sp['x']-$op['x'])*($ep['y']-$op['y'])-($ep['x']-$op['x'])*($sp['y']-$op['y']));
}

////多边形与点是否有交集
function pnpoly_point($polygon, $point){
	$i=$j=$c=0;
	$nvert = count($polygon);
	for ($i = 0, $j = $nvert-1; $i < $nvert; $j = $i++) {
		if ( (($polygon[$i]['y']>=$point['y']) != ($polygon[$j]['y']>=$point['y'])) && ($point['x'] <= ($polygon[$j]['x']-$polygon[$i]['x']) * ($point['y']-$polygon[$i]['y']) / ($polygon[$j]['y']-$polygon[$i]['y']) + $polygon[$i]['x']) ){
	   		$c = !$c;
	   	}
	}
	return $c;
}
