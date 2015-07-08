<?php

class save extends common{

	function __construct(){
		$this->lib(['db']);
	}

	function savePost(){
		$table = $_POST['table'];
		$id = $_POST['id'];
		unset($_POST['table']);
		unset($_POST['id']);

		if($id){
			$this->updateData($table,$_POST,$id);
			return $id;
		}else{
			return $this->insertData($table,$_POST);
		}
	}

	function insertData($table,$data){
		foreach ($data as $k => $d) {
			$field[] = '`'.$k.'`';
			$mark[] = '?';
			$params[] = $d;
		}

		return $this->db->query('INSERT INTO `'.$table.'` ('.implode(',', $field).') VALUES ('.implode(',', $mark).')', $params);
	}

	function updateData($table,$data,$id){
		foreach ($data as $k => $d) {
			$field[] = '`'.$k.'` = ? ';
			$params[] = $d;
		}
		array_push($params,$id);

		$this->db->query('UPDATE `'.$table.'` SET '.implode(',', $field).' WHERE id = ?', $params);
	}

}