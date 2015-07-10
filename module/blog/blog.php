<?php

class blog extends core{

	function __construct(){
		$this->lib(['tpl','db']);
		$this->load(['admin/common/page'=>'page','common/field']);
	}

	function show(){
		$this->tpl->show('blog',[
			'title'=>$this->getTitle(),
			'data'=>$this->getBlog()
			],'blog');
	}

	function getTitle(){
		return 'Title';
	}

	function getBlog(){
		$data = $this->db->query('SELECT * FROM blog WHERE id = ?',[$_GET['id']]);
		return $data[0];
	}

	
}