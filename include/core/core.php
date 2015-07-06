<?php

class core{

	function load($load){
		foreach($load as $k => $l){
			if(is_numeric($k)){
				$file = $l;
				$class = strstr($l, '/')?trim(strrchr($l,'/'),'/'):$l;
			}else{
				$file = $k;
				$class = $l;
			}

			$this->$class = file_exists(PATH.'/'.$file.'.php')?loadClass(PATH.'/'.$file):loadClass(MODULE.'/'.$file);
		}
	}

	function lib($lib){
		foreach ($lib as $l) {
			$this->$l = loadClass('include/core/'.$l);
		}
	}
}