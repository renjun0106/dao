<?php

class index extends core{

	function __construct(){
		$this->lib(['tpl','db']);
		$this->load(['admin/common/page'=>'page','common/field']);
	}

	function show(){
		list($data,$page) = $this->getListData();
		$this->tpl->show('index',[
			'title'=>$this->getTitle(),
			'data'=>$data,
			'page'=>$page,
			],'blog');
	}

	function getTitle(){
		return 'Title';
	}

	function getListData(){
		$where = 'status=1';
		$field = 'id,user_id,title,description,creat_time,modify_time,type,tags';
		list($data,$page) = $this->page->getPage('blog',$where,$field);

		return [$this->field->changeField($data),$page];
	}

	
}