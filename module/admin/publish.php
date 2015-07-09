<?php

require_once(MODULE.'/admin/common/common.php');

class publish extends common{
	public $id;
	public $data;

	function __construct(){
		parent::__construct();
		$this->lib(['db']);

	}

	function show(){
		$this->id = isset($_GET['id'])?$_GET['id']:null;
		$this->data = $this->getData();

		$this->lib(['tpl']);
		$this->tpl->show('publish',[
			'data'=>$this->data,
			'base_data'=>$this->getBaseData()
			],null,false);
	}

	function save(){
		if(isset($_POST['id'])){
			$_POST['creat_time'] = date('Y-m-d');
			$_POST['tags'] = implode(',', $_POST['tags']);
		}

		$this->load(['admin/common/save'=>'save']);
		$id = $this->save->savePost();
		
		header('Location: /admin/detail?id='.$id);
	}

	function getData(){
		$id = $this->id;
		if($id){
			$data = $this->db->query('SELECT * FROM blog WHERE id = ?',[$id]);
			return $data[0];
		}else{
			return ['id'=>null,'user_id'=>$this->user_id,'title'=>null,'title'=>null,'content'=>null,'description'=>null,'type'=>null];
		}
	}

	function getBaseData(){
		$tags = include('data/blogTags.php');
		$type = include('data/blogType.php');
		return ['tags'=>$tags,'type'=>$type];
	}
}