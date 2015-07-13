<?php

class index extends core{

	public $listWhere;

	function __construct(){
		$this->lib(['tpl','db']);
		$this->load(['admin/common/page'=>'page','common/field']);
	}

	function show(){
		$this->getListWhere();
		list($data,$page) = $this->getListData();

		$this->tpl->show('index',[
			'title'=>$this->getTitle(),
			'data'=>$data,
			'page'=>$page,
			],'blog');
	}

	function search(){
		$this->listWhere = 'and (title like "%'.$_GET['word'].'%" or description like "%'.$_GET['word'].'%")';
		list($data,$page) = $this->getListData();
		
		$this->tpl->show('index',[
			'title'=>$this->getTitle(),
			'data'=>$data,
			'page'=>$page,
			],'blog');
	}

	function getTitle(){
		return '<a href="/">Home</a>';
	}

	function getListData(){
		$where = 'status=1 '.$this->listWhere;
		$field = 'id,user_id,title,description,creat_time,modify_time,type,tags';
		list($data,$page) = $this->page->getPage('blog',$where,$field);

		return [$this->field->changeField($data),$page];
	}

	function getListWhere(){
		$where = '';
		if(isset($_GET['user'])){
			$where .= 'and user_id='.$_GET['user']; 
		}
		if(isset($_GET['type'])){
			$where .= 'and type='.$_GET['type']; 
		}
		if(isset($_GET['tags'])){
			$tags_arr = explode(',',$_GET['tags']);
			foreach($tags_arr as $t){
				$where_arr[] = 'tags like "'.$t.'" ';
				$where_arr[] = 'tags like "'.$t.',%" ';
				$where_arr[] = 'tags like "%,'.$t.',%" ';
				$where_arr[] = 'tags like "%,'.$t.'" ';
			}
			$where .= 'and ('.implode(' or ', $where_arr).')';
		}

		$this->listWhere = $where;
	}
	
}