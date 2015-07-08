<?php

require_once(MODULE.'/admin/common/common.php');

class detail extends common{

	function __construct(){
		parent::__construct();
		$this->lib(['db','tpl']);

	}

	function show(){
		$data = $this->db->query('SELECT * FROM blog WHERE id = ?',[$_GET['id']]);

		$this->tpl->show('detail',['data'=>$data[0]],null,false);
	}
}