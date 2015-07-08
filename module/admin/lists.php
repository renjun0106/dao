<?php

require_once(MODULE.'/admin/common/common.php');

class lists extends common{

	function __construct(){
		parent::__construct();
	}

	function show(){
		$this->lib(['tpl']);
		$this->load(['admin/common/page'=>'page']);

		$where = 'user_id='.$this->user_id;
		$field = 'id,user_id,title,description,creat_time,modify_time';
		list($data,$page) = $this->page->getPage('blog',$where,$field);

		$this->tpl->show('lists',[
			'data'=>$data,
			'page'=>$page
			],null,false);
	}
}