<?php

require_once(MODULE.'/admin/common/common.php');

class index extends common{

	function __construct(){
		parent::__construct();
		$this->lib(['tpl']);
	}

	function show(){
		$this->tpl->show('index',[],null,false);
	}
}