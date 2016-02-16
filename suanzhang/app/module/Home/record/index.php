<?php

class Home_record_index extends Core
{
	function __construct(){
		parent::__construct();
		$this->lib(['db']);
		$this->load(['Login_action_check'=>'check']);
	}

	function getData($userid){
		$this->db->pquery("UPDATE `user` SET `jiesuan` = '0' WHERE `id` = ?",[$userid]);
		$sql = "select * from `user` where id = ?";
		$userInfo = $this->db->pquery($sql,[$userid]);
		$sql = "select sum(money) sum from `book` ";
		$allBook1 = $this->db->pquery($sql);
		$sql = "select sum(money) sum from `book` where isdone = 1";
		$allBook2 = $this->db->pquery($sql);
		$sql = "select sum(money) sum from `book` where userid = ?";
		$userBook1 = $this->db->pquery($sql,[$userid]);
		$sql = "select sum(money) sum from `book` where userid = ? and isdone = 1";
		$userBook2 = $this->db->pquery($sql,[$userid]);
		return [
			'userInfo'=>$userInfo[0],
			'allBook1'=>number_format($allBook1[0]['sum'], 2,'.',''),
			'allBook2'=>number_format($allBook2[0]['sum'], 2,'.',''),
			'allBook3'=>number_format($allBook1[0]['sum'] - $allBook2[0]['sum'], 2,'.',''),
			'userBook1'=>number_format($userBook1[0]['sum'], 2,'.',''),
			'userBook2'=>number_format($userBook2[0]['sum'], 2,'.',''),
			'userBook3'=>number_format($userBook1[0]['sum'] - $userBook2[0]['sum'], 2,'.','')
		];
	}

	function saveBook(){
		$userid = $this->check->isLogin();
		if($userid){
	      	$params = [$userid,$_POST['money'],$_POST['description'],$_POST['date']];
			$this->db->pquery("insert book (userid,money,description,date,isdone) value(?,?,?,?,0) ",$params);
		}
	}

	function getBook(){
		$userid = $this->check->isLogin();
		if(!$userid)
			return false;

		$page = $_POST['page'];
		$type = $_POST['type'];
		if($page>0){
			$where = '';
			if($type==2){
				$where = 'where userid='.$userid;
			}
			$sql = "select userid,money,date,isdone,head,description,name from `book` b 
					inner join `user` u on u.id = b.userid ".$where."  ORDER BY b.`id` DESC limit ".(($page-1)*5).",5";
			$bookInfo = $this->db->pquery($sql);
			if($bookInfo){
				return $bookInfo;
			}
		}
		return false;
	}

	function getBookPage(){
		$userid = $this->check->isLogin();
		if(!$userid)
			return false;

		$type = $_POST['type'];
		$where = '';
		if($type==2){
			$where = 'where userid='.$userid;
		}
		$sql = "select count(*) sum from `book` b 
				inner join `user` u on u.id = b.userid ".$where;
		$bookInfo = $this->db->pquery($sql);
		if($bookInfo){
			echo ceil($bookInfo[0]['sum']/5);exit;
		}
		echo false;exit;
	}

	function suanzhangKaishi(){
		$userid = $this->check->isLogin();
		if(!$userid)
			return false;
		$this->db->pquery("UPDATE `user` SET `jiesuan` = '1' WHERE `id` = ?",[$userid]);
	}

	function getjiesuan(){
		$sql = "select count(1) count from `user` where jiesuan = 1";
		$count = $this->db->pquery($sql);
		if($count[0]['count']==5){
			$sql = "SELECT name,head,id FROM `user`";
			$userInfo = $this->db->pquery($sql);
			foreach ($userInfo as $key => $value) {
				$sql = "SELECT sum(money) sum FROM `book` where userid=? and isdone=0 ";
				$sum = $this->db->pquery($sql,[$value['id']]);
				$userInfo[$key]['sum'] = number_format($sum[0]['sum'], 2,'.','');
			}
			return $this->suanqian($userInfo);
		}else{
			return false;
		}
	}
	function suanqian($data){
		$gei = [];
		$shou = [];
		$sum_money = 0;
		foreach ($data as $d) {
			$sum_money += $d['sum'];
		}
		$avg_moeny = number_format($sum_money/5, 2,'.','');
		foreach ($data as $k=>$d) {
			$data[$k]['the_money'] = number_format($d['sum'] - $avg_moeny, 2,'.','');
		}
		usort($data, function($a, $b) {
            $al = abs($a['the_money']);
            $bl = abs($b['the_money']);
            if ($al == $bl)
                return 0;
            return ($al < $bl) ? -1 : 1;
        });
        $data2 = array_reverse($data);
        $i=0;
		foreach ($data as $k=>$d) {
			if($data[$k]['the_money']<0){
				$gei[$i]=$data[$k];
				foreach ($data as $key => $value) {
					if($value['the_money']>0 && $value['the_money']>=-$data[$k]['the_money']){
						$gei[$i]['gei_money'] = number_format(-$data[$k]['the_money'], 2,'.','');
						$gei[$i]['gei_name'] = $value['name'];
						$gei[$i]['gei_head'] = $value['head'];
						$data[$key]['the_money'] = number_format($value['the_money']+$data[$k]['the_money'], 2,'.','');
						$data[$k]['the_money'] = 0;
					}
				}
				$i++;
			}
			if($data[$k]['the_money']>0){
				$gei[$i]=[];
				foreach ($data as $key => $value) {
					if($data[$key]['the_money']<0 && -$data[$key]['the_money']>=$d['the_money']){
						$gei[$i]['gei_money'] = number_format($d['the_money'], 2,'.','');
						$gei[$i]['gei_name'] = $d['name'];
						$gei[$i]['gei_head'] = $d['head'];
						$gei[$i]['name'] = $data[$key]['name'];
						$gei[$i]['head'] = $data[$key]['head'];
						$data[$key]['the_money'] = number_format($data[$key]['the_money']+$d['the_money'], 2,'.','');
						$data[$k]['the_money'] = 0;
					}
				}
				$i++;
			}
		}dump($gei);die;
        return $gei;
	}
	function jiesuanKaishi(){
		$userid = $this->check->isLogin();
		if(!$userid)
			return false;
		$this->db->pquery("UPDATE `user` SET `jiesuan` = '2' WHERE `id` = ?",[$userid]);
	}


	function jiesuanOver(){
		$sql = "select count(1) count from `user` where jiesuan = 2";
		$count = $this->db->pquery($sql);
		if($count[0]['count']==5){
			$sql = "UPDATE book SET isdone = 1";
			$this->db->pquery($sql);
			echo true;
		}else{
			echo false;
		}
	}
	

}