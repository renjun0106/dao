<?php

class index extends core{

	function __construct(){
		$this->lib(['tpl','db']);
	}

	function show(){
		$this->tpl->show('index',[
			'title'=>$this->getTitle()
			],'blog');
	}

	function getTitle(){
		return 'Title';
	}
}