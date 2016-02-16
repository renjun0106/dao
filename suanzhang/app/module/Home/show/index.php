<?php


class Home_show_index extends Core{
	
	function __construct(){
		parent::__construct();
		$this->lib(['tpl']);
		$this->load(['Login_action_check'=>'check']);
	}

	function go(){
		$this->tpl->cache('index') or $this->tpl->show();
	}

	function getApp(){
		$this->load(['Home_record_index'=>'record']);
		$userid = $this->check->isLogin();
		if(!$userid){
			$userid = $this->check->login();
		}
		if($userid){
			$this->tpl->cache('app') or $this->tpl->show(['data'=>$this->record->getData($userid)]);
			exit;
		}else{
			echo false;
			exit;
		}
	}

	function getBook(){
		$this->load(['Home_record_index'=>'record']);
		if(!$this->tpl->cache('books')){
			$books = $this->record->getBook();
			if($books){
				$this->tpl->show(['data'=>$books]);
				exit;
			}else{
				echo false;
				exit;
			}
		}

	}

	function getjiesuan(){
		$this->load(['Home_record_index'=>'record']);
		$data = $this->record->getjiesuan();
		if($data!==false){
			if(!$this->tpl->cache('jiesuan')){
				$this->tpl->show(['data'=>$data]);
				exit;
			}else{
				echo false;
				exit;
			}
		}
	}

}