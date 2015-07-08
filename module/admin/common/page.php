<?php

class page extends core{

	function __construct(){
		$this->lib(['db','tpl']);
	}

	function getPage($table, $where='1=1', $column='*', $limit=5){
		$p = isset($_GET['p'])?$_GET['p']:1;
		$page = ($p-1)*$limit;
		$count = $this->db->query("SELECT count(*) count FROM `$table` WHERE $where");
		$data = $this->db->query("SELECT $column FROM `$table` WHERE $where LIMIT $page,$limit");
		
		$page = $this->tpl->show('admin/common/page/page',[
			'url'=>'?'.$this->getUrl().'&p=',
			'p'=>$p,
			'last_p'=>ceil($count[0]['count']/$limit)
			],null,false,false);
		return [$data?$data:[],$page];
	}

	function getUrl(){
		unset($_GET['p']);
		$getarr = array();

		foreach ($_GET as $key => $value) {
			$getarr[] = $key.'='.$value;
		}

		return empty($getarr)?'':implode('&', $getarr);
	}
}