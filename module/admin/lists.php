<?php

require_once(MODULE.'/admin/common/common.php');

class lists extends common{

	function __construct(){
		parent::__construct();
	}

	function show(){
		$this->lib(['tpl']);
		$this->load(['admin/common/page'=>'page']);

		list($data,$page) = $this->page->getPage('blog');

		$this->tpl->show('lists',[
			'data'=>$data,
			'page'=>$page
			],null,false);
	}
}