<?php

require_once(MODULE.'/admin/common/common.php');

class lists extends common{

	function __construct(){
		parent::__construct();
	}

	function show(){
		$this->lib(['tpl','db']);
		$this->tpl->show('lists',[
			],null,false);
	}
}