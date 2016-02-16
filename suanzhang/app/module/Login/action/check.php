<?php

class Login_action_check extends Core{
	protected $salt = '1qazxsw2';
	protected $timeout = 604800;

	function __construct(){
		parent::__construct();
		$this->lib(['db']);
	}

	function isLogin(){
		if(isset($_COOKIE['auth'])){
			list($identifier, $token) = explode(':', $_COOKIE['auth']);
			list($rs) = $this->db->pquery('SELECT * FROM user WHERE identifier = ? limit 1',[$identifier]);
			
			if($rs && $rs['token'] == $token){
				return $rs['id'];
			}
		}
		return false;
	}

	function login(){
		if(isset($_POST['username'])){

			list($rs) = $this->db->pquery('SELECT * FROM user WHERE username = ? limit 1',[$_POST['username']]);
//var_dump($_POST,$rs);
			if($rs && $rs['password'] == md5($_POST['password']))
			{
				$this->_recordLogin($rs['username'], $rs['id']);
				return $rs['id'];
			}
			
		}
		
		return false;
	}

	function logout(){
		if(isset($_COOKIE['auth'])){
			list($identifier, $token) = explode(':', $_COOKIE['auth']);

			setcookie('auth', $identifier.':'.$token, time()-1,'/');
		}
	}

	private function _recordLogin($username, $id){
		$identifier = md5($username.$this->salt);
		$token = md5(uniqid(rand(), TRUE));
		$timeout = time() + $this->timeout;

		setcookie('auth', $identifier.':'.$token, $timeout,'/');
		
		$this->db->pquery('UPDATE user SET token = ?, timeout = ? WHERE id = ?',[$token, $timeout, $id]);
	}

	//?module=Login/action/check/getuserinfo&username=renjun&password=renjun
	function getuserinfo(){
		echo $_GET['username'].'|'.$_GET['password'].'|'.md5($_GET['username'].$this->salt).'|'.md5($_GET['password']);
	}
}