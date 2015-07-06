<?php

require_once(MODULE.'/admin/common/common.php');

class publish extends common{

	function __construct(){
		parent::__construct();
	}

	function show(){
		$id = isset($_GET['id'])?isset($_GET['id']):null;
		
		$this->lib(['tpl']);
		$this->tpl->show('publish',[
			'user_id'=>$this->user_id,
			'id'=>$id,
			],null,false);
	}

	function save(){
		$this->load(['admin/common/save'=>'save']);
		$this->save->savePost('/admin/publish');
	}
}