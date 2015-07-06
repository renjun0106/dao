<?php

class common extends core{
	public $user_id;

	function __construct(){
		$this->load(['admin/common/user/checkUser'=>'checkUser']);
		$this->checkUser();
	}

	function checkUser(){
		$this->user_id = $this->checkUser->isLogin();
	}
}