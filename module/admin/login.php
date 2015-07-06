<?php

class login extends core{

	function __construct(){
		$this->lib(['tpl']);
	}

	function show(){
		$this->tpl->show('login',[],null,false);
	}
}