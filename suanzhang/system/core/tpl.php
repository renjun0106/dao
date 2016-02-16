<?php

class tpl{

	function __construct($AllmoduleName){
		$tpl = Loader::loadConf('tpl');
		$this->tpl_floder = $tpl['default_tpl_floder'];
		$this->tpl_postfix = $tpl['default_tpl_postfix'];
		$this->is_open_cache = $tpl['is_open_cache'];
		$this->cache_folder = $tpl['default_cache_folder'];
		$this->cache_postfix = $tpl['default_cache_postfix'];
		$this->cache_rui = $tpl['default_cache_rui'];
		$this->cache_time = $tpl['default_cache_time'];
		$this->lang_language = $tpl['default_lang_language'];
		$this->lang_floder = $tpl['default_lang_floder'];
		$this->lang_postfix = $tpl['default_lang_postfix'];
		$this->lang_var = $tpl['default_lang_var'];
		$this->compress = $tpl['default_compress'];
		$this->resources = APPPATH.'/'.$tpl['default_resource'];
		$this->AllmoduleName = $AllmoduleName;
	}

	static function &getInstance($instance_name) {
		static $self;
		$AllmoduleName = Loader::GetAllmoduleName($instance_name);
		if(!isset($self) || $self->AllmoduleName!==$AllmoduleName) {
			$self = new self($AllmoduleName);
		}
		return $self;
	}

	function cache($tpl, $cache_time=null,$fetch = false){
		$this->tplFile = $this->_getTplfile($tpl);
		!is_null($cache_time) && $this->cache_time = $cache_time;
		$this->fetch = $fetch;
		if($this->_isHasCache()){
	        ob_start();
	        include $this->cache_file;
	        $contents = ob_get_contents();
	        ob_end_clean();
			if($this->fetch){
				return $contents;
			}else{
				echo $contents;
				return true;
			}
		}else{
			return false;
		}
	}

	function show($data=[]){
		if($this->is_open_cache){
			$cache_file = $this->cache_file;
		}
		$lang = $this->_getLang();
		$content = $this->_getInclude($data, $lang);

		$str = $this->compress?$this->_compress_html($content):$content;
		if($this->is_open_cache){
			$this->_writeCache($cache_file,$str);
		}
		if($this->fetch){
			return $str;
		}else{
			echo $str;
		}
	}


	private function _isHasCache(){
		if($this->is_open_cache){
			$this->cache_file = APPPATH.'/'.$this->cache_folder.'/'.md5($this->tplFile.'?'.$_SERVER[$this->cache_rui]).'.'.$this->cache_postfix;

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
	private function _getInclude($data, $lang) {

		foreach ($data as $k => $d) {
			$$k = $d;
		}
		${$this->lang_var} = $lang;

        ob_start();
        include $this->tplFile;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
	}

	private function _getTplfile($tpl){
		if(strstr($tpl,'/')){
			$tplFile = APPPATH.'/'.$this->tpl_floder.'/'.$tpl.'.'.$this->tpl_postfix;
			if(is_file($tplFile)){
				return $tplFile;
			}
		}else{
			foreach ($this->AllmoduleName as $moduleName) {
				$tplFile = APPPATH.'/'.$this->tpl_floder.'/'.$moduleName.'/'.$tpl.'.'.$this->tpl_postfix;
				if(is_file($tplFile)){
					return $tplFile;
				}
			}
		}
		return false;
	}

	private function _getLang(){
		static $lang = [];
		if(!$lang){
			foreach (array_reverse($this->AllmoduleName) as $moduleName) {
				$langFile = APPPATH.'/'.$this->lang_floder.'/'.$this->lang_language.'/'.$moduleName.'.'.$this->lang_postfix;
				if(is_file($langFile)){
					$lang = array_merge($lang,include($langFile));
				}
			}
		}
		return $lang;
	}

	private function _writeCache($cache_file,$content){
		creatFlie($cache_file,$content);
	}

	private function _compress_html($string) {
	    return ltrim(rtrim(preg_replace(array("/> *([^ ]*) *</","/<!--[^!]*-->/","'/\*[^*]*\*/'","/\r\n/","/\n/","/\t/",'/>[ ]+</'),array(">\\1<",'','','','','','><'),$string))); 
	}
}