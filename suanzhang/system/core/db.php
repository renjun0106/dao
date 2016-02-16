<?php

class db{
	protected $mysqli;

	function __construct(){
		$db = Loader::loadConf('db');
		$this->mysqli = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']); 
		$this->mysqli->set_charset("utf8");
		$this->is_open_cache = $db['is_open_cache'];
		$this->cache_folder = $db['default_cache_folder'];
		$this->cache_time = $db['default_cache_time'];
		$this->cache_postfix = $db['cache_postfix'];
	}

	static function &getInstance() {
		static $self;

		if(!isset($self)) {
			$self = new self();
		}
		return $self;
	}

	function pquery($sql, $params=[],$cache_time=null){
		!is_null($cache_time) and $this->cache_time = $cache_time;
		if($this->_isHasCache($sql,$params)){
			return json_decode(file_get_contents($this->cache_file),true);

		}
		$stmt = $this->mysqli->prepare($sql);

		$stmt or $this->_sqlError($this->mysqli->error);
		if($params){
			$ref = new ReflectionClass('mysqli_stmt'); 
			$method = $ref->getMethod('bind_param');
			$method->invokeArgs($stmt,$this->_refValues($params));
		}

		$rs = $stmt->execute();

		$result = $stmt->get_result();

		if($result){
			while ($row = $result->fetch_assoc()) {
				$data[] = $row ;
			}
			$contents = isset($data)?$data:null;
			if($this->is_open_cache){
				$this->_writeCache($contents);
			}
			return $contents;
		}else{
			return $this->mysqli->affected_rows;
		}
	}

	private function _isHasCache($sql,$params){
		if($this->is_open_cache){
			$this->cache_file = APPPATH.'/'.$this->cache_folder.'/'.md5($sql.serialize($params)).'.'.$this->cache_postfix;

			if(file_exists($this->cache_file)){
				if((time() - filemtime($this->cache_file)) < $this->cache_time){
					return true;
				}else{
					unlink($this->cache_file);
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	private function _writeCache($content){
		creatFlie($this->cache_file,json_encode($content));
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