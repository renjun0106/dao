<?php

class db{
	protected $mysqli;

	function __construct(){
		$con = require('include/config/db.php');
		$this->mysqli = new mysqli($con['hostname'], $con['username'], $con['password'], $con['database']); 
		$this->mysqli->set_charset("utf8");
	}


	function query($sql, $params=[]){
		if(!$params){
			return $this->pquery($sql);
		}
		$stmt = $this->mysqli->prepare($sql);

		$stmt or $this->_sqlError($this->mysqli->error);

		$ref = new ReflectionClass('mysqli_stmt'); 
		$method = $ref->getMethod('bind_param');
		$method->invokeArgs($stmt,$this->_refValues($params));

		$rs = $stmt->execute();

		$result = $stmt->get_result();

		if($result){
			while ($row = $result->fetch_assoc()) {
				$data[] = $row ;
			}
			return isset($data)?$data:null;
		}else{
			if($this->mysqli->insert_id)
				return $this->mysqli->insert_id;
			if($this->mysqli->affected_rows)
				return $this->mysqli->affected_rows;
		}
	}

    function pquery($sql){
		$rs = $this->mysqli->query($sql);

		$rs or $this->_sqlError($this->mysqli->error);

		while($row  = $rs->fetch_assoc()){
			$data[] = $row ;
		}
		return isset($data)?$data:null;
	}

    private function _refValues($params){
	    $types = '';
	    foreach ($params as $p) {
	        if (is_numeric($p)) {
	            $types.='i';
	        }else{
	            $types.='s';
	        }
	    }
	   	$refArr = array_merge([$types],$params);
	    $refs = array();
	    foreach($refArr as $key => $value)
	        $refs[$key] = &$refArr[$key];
	    return $refs;
	}

	private function _sqlError($error){
		die($error);
	}
}