<?php

class checkUser extends core{
	protected $salt = '1qazxsw2';
	protected $timeout = 604800;

	function __construct(){
		$this->lib(['db']);
	}

	function isLogin(){
		if(isset($_COOKIE['auth'])){
			list($identifier, $token) = explode(':', $_COOKIE['auth']);
			list($rs) = $this->db->query('SELECT * FROM user WHERE identifier = ? limit 1',[$identifier]);
			
			if($rs && $rs['token'] == $token){
				return $rs['id'];
			}
		}
		header('Location: /admin/login');
	}

	function login(){
		$resp = ['accessGranted' => false, 'errors' => ''];

		if(isset($_POST['do_login'])){
			list($rs) = $this->db->query('SELECT * FROM user WHERE username = ? limit 1',[$_POST['username']]);

			if($rs && $rs['password'] == md5($_POST['passwd']))
			{
				$resp['accessGranted'] = true;
				$this->_recordLogin($rs['username'], $rs['id']);
			}
		}
		
		echo json_encode($resp);
	}

	function logout(){
		setcookie('auth', $identifier.':'.$token, time()-1,'/');
		header('Location: /admin/login');
	}

	private function _recordLogin($username, $id){
		$identifier = md5($username.$this->salt);
		$token = md5(uniqid(rand(), TRUE));
		$timeout = time() + $this->timeout;

		setcookie('auth', $identifier.':'.$token, $timeout,'/');
		
		$this->db->query('UPDATE user SET token = ?, timeout = ? WHERE id = ?',[$token, $timeout, $id]);
	}
}