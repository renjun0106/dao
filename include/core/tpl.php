<?php

class tpl{
	protected $tpl_path;
	protected $tpl_postfix;
	protected $is_has_cache;
	protected $cache_file;
	protected $default_cache_time;

	function __construct(){
		$tpl = require('include/config/tpl.php');
		$this->tpl_path = $tpl['default_tpl_path'];
		$this->tpl_postfix = $tpl['default_tpl_postfix'];
		$this->default_cache_time = $tpl['default_cache_time'];
		$this->_isHasCache();
	}

	function show($tpl, $data=[], $lang=null, $compress=true){
		if($this->is_has_cache){
			include $this->cache_file;
		}else{
			$content = $this->_getInclude((strstr($tpl, '/')?MODULE:(PATH.'/'.$this->tpl_path)).'/'.$tpl.'.'.$this->tpl_postfix, $data, $lang);

			echo $str = $compress?$this->_compress_html($content):$content;
			if(ENVIRONMENT){
				$this->_writeCache($str);
			}
		}
	}

	private function _isHasCache(){
		if(ENVIRONMENT){
			$this->cache_file = 'cache/'.md5($_SERVER['REQUEST_URI']);

			if(file_exists($this->cache_file)){
				if((time() - filemtime($this->cache_file)) < $this->default_cache_time){
					$this->is_has_cache = 1;
				}else{
					unlink($this->cache_file);
					$this->is_has_cache = 0;
				}
			}else{
				$this->is_has_cache = 0;
			}
		}else{
			$this->is_has_cache = 0;
		}
	}

	private function _getInclude($filename, $data, $lang) {
		foreach ($data as $k => $d) {
			$$k = $d;
		}
		is_file('include/config/lang/'.$lang.'.php') and $lang = include('include/config/lang/'.$lang.'.php');

        ob_start();
        include $filename;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
	}

	private function _writeCache($content){
		$file = fopen($this->cache_file, 'w');
		fwrite($file, $content);
		fclose($file);
	}

	private function _compress_html($string) {
	    return ltrim(rtrim(preg_replace(array("/> *([^ ]*) *</","/<!--[^!]*-->/","'/\*[^*]*\*/'","/\r\n/","/\n/","/\t/",'/>[ ]+</'),array(">\\1<",'','','','','','><'),$string))); 
	}
}