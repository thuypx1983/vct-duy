<?php 
class CacheFull{
   static $cachefile;
	function start($ext='.htm'){
		$s=basename(URL_SELF,'.php').'_'.@http_build_query(@$_GET).$ext;
		if(strlen($s) < 256){
			self::$cachefile=PATH_CACHE.$s;//cache to this file
			if(@readfile(self::$cachefile)) { 
				@mysql_close();
				if($ext=='.htm') exit('<!--cache hit '.date('r',filemtime(self::$cachefile)).'-->');
				else exit();
			}
			ob_start();//begin bufferring
		}else
			self::$cachefile=NULL;
	}
	function finish(){
		if(self::$cachefile){
			file_put_contents(self::$cachefile,ob_get_flush());//save cache
		}
	}
	function commit($name,$id='',$ext='.htm'){
		static $cachefile='';
		if($cachefile == ''){//begin buffering
			$s=strtr($name,':\\/','___').$id.$ext;
			if(@readfile(PATH_CACHE.$s)) { return TRUE;}
			$cachefile=$s;
			ob_start();//begin bufferring for this file
		}else{//finish			
			file_put_contents(PATH_CACHE.$cachefile,ob_get_flush());
			$cachefile='';
		}
		return FALSE;
	}
	function put(&$o,$name,$id='',$ext='.bin'){
		$s=strtr($name,':\\/','___').$id.$ext;
		if(strlen($s) < 256)	file_put_contents(PATH_CACHE.$s,serialize($o));
	}
	function get(&$o,$name,$id='',$ext='.bin'){
		$s=strtr($name,':\\/','___').$id.$ext;
		 return (bool)(@$o = unserialize(@file_get_contents(PATH_CACHE.$s)));
	}
	function clear(){
		chmod(PATH_CACHE,0755);//change to re-write mode
		passthru('rm -f '.PATH_CACHE.'*.*');//clean up cache direcotory
		$fl = glob(PATH_CACHE.'*.*',GLOB_NOESCAPE|GLOB_NOSORT);
		foreach($fl as $ff){ chmod($ff,700); unlink($ff);}
		passthru('rm -f '.PATH_DEBUG.'*.*');//clean up debug directory
		$fl = glob(PATH_DEBUG.'*.*',GLOB_NOESCAPE|GLOB_NOSORT);
		foreach($fl as $ff) { chmod($ff,700); unlink($ff);}
		passthru('find '.PATH_TEMP.' -ctime +1 -exec rm -f \\{\\} \\;');//clean up temp dir
		$fl = glob(PATH_TEMP.'*.*',GLOB_NOESCAPE|GLOB_NOSORT);
		$ctime = time();
		foreach($fl as $ff)
			if($ctime - filemtime($ff) > 86400) { chmod($ff,700); unlink($ff);};//only delete file 1 day old 
	}
	function toggle($onoff){
		@touch(PATH_CACHE);//update last modification
		return chmod(PATH_CACHE,$onoff ? 0700:0500);
	}
}//end class
if(defined('CACHE_OFF')){	class Cache0x00000001 extends CacheFull{function start(){ return FALSE;}	function finish(){return FALSE;}}
}else{	class Cache0x00000001 extends CacheFull{}	define('CACHE_OFF',0x00000000);}
if(CACHE_OFF & 0x00000002){	class Cache0x00000002 extends Cache0x00000001{ function commit(){return FALSE;}}
}else{	class Cache0x00000002 extends Cache0x00000001{}}
if(CACHE_OFF & 0x00000004){	class Cache0x00000004 extends Cache0x00000002{ function get(){return FALSE;} function put(){return FALSE;}}
}else{	class Cache0x00000004 extends Cache0x00000002{}}
if(CACHE_OFF & 0x00000008){	class Cache0x00000008 extends Cache0x00000004{ /*disable SQL cache functions here*/}
}else{	class Cache0x00000008 extends Cache0x00000004{}}
if(is_writable(PATH_CACHE)){ class Cache extends Cache0x00000008{}}
else{ 	class Cache {function toggle($onoff) { return CacheFull::toggle($onoff);} function get(){return FALSE;} function commit(){return FALSE;}function start(){return FALSE;} function put(){return FALSE;} function finish(){return FALSE;} function clear(){return CacheFull::clear();}}}
?>