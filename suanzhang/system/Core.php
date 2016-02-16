<?php

class Core{

	function __construct(){
		$this->instance_name = get_class($this);
	}

	function load($load){
		foreach($load as $k => $l){
			$class = is_numeric($k)?$l:$k;
			$this->$l = new $class;
		}
	}

	function lib($lib){
		foreach ($lib as $l) {
			include_once SYSPATH.'/core/'.$l.'.php';
			$this->$l = $l::getInstance($this->instance_name);
		}
	}
}