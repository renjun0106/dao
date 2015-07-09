<?php

class field extends core{

	function __construct(){
		$this->lib(['db']);
		$this->types = include('data/blogType.php');
		$this->tags = include('data/blogTags.php');
	}

	function changeField($fields){
		if (count($fields) == count($fields, 1)){
			$this->_changeFieldByList($fields);
		}else{
			foreach ($fields as &$field) {
				$this->_changeFieldByList($field);
			}
		}
		//var_dump($fields);die;
		return $fields;
	}

	private function _changeFieldByList(&$field){
		foreach ($field as $k => &$f) {
			$f = $this->_changeFieldByOne($k,$f);
		}
	}

	private function _changeFieldByOne($field,$value){
		switch ($field) {
			case 'user_id':
				$name = $this->db->query('SELECT username FROM user WHERE id = ?',[$value]);
				return '<a target="_blank" href="/?user='.$value.'">'.$name[0]['username'].'</a>';
			case 'type':
				foreach ($this->types as $type) {
					foreach ($type as $k => $v) {
						if($k == $value){
							return '<a target="_blank" href="/?type='.$value.'">'.$v.'</a>';
						}
					}
				}
			case 'tags':
				$tagsarr=explode(',', $value);
				foreach ($this->tags as $type) {
					foreach ($type as $k => $v) {
						if(in_array($k,$tagsarr)){
							$tagsstr[] = '<a target="_blank" href="/?tags='.$k.'">'.$v.'</a>';
						}
					}
				}
				return implode(' ', $tagsstr);
			default:
				return $value;
		}
	}
}