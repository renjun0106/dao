<?php

class index extends core{

	function __construct(){
		$this->lib(['tpl','db']);
	}

	function show(){
		$this->tpl->show('index',['test'=>1],'blog');
	}
}