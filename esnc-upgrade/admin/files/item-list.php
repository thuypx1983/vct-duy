<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	exit("<script language='javascript'>window.top.location='../../';</script>");
}
require '../config.php';
define('COL0_WIDTH','3%');
define('COL1_WIDTH','3%');

define('COL2_WIDTH','45%');
define('COL2_NAME',$FILE_ALLOW_EDIT_URL[(int)$_GET['FLid']]);

define('COL3_WIDTH','0%');
define('COL3_NAME','');

define('COL4_WIDTH','0%');
define('COL4_NAME','');

define('COL5_WIDTH','0%');
define('COL5_NAME','');

define('COL6_NAME','');

define('CATALIAS','FL');
define('ALIAS','FF');
class filelist {
	function open(){
		$curdir = getcwd();
		chdir($this->cat);
		$this->rs = glob("*.{$this->ext}",GLOB_NOESCAPE);
		chdir($curdir);
		$this->rowcount = sizeof($this->rs);
		if($this->pagesize < 15) $this->pagesize=15;
		$this->pagecount = (int)ceil(@($this->rowcount/$this->pagesize));if($this->pagecount < 1) $this->pagecount=1;
		if($this->page < 1) $this->page=1;
		if($this->page > $this->pagecount) $this->page = $this->pagecount;
		$this->startrow = ($this->page -1)* $this->pagesize;
	}
	function ren(){

		if(!preg_match(REGEX_CHECK_FILENAME,$this->id)){
			_trace('filename not valid'.$this->id);
			return FALSE;
		}
		return rename($this->cat.$this->id,$this->cat.$this->name.'.'.$this->ext);
	}
	function moveto(){
		if(!preg_match(REGEX_CHECK_STRING_SERIES,$this->id)) return FALSE;
		if($this->excatid != $this->catid){
			$t=explode(',',$this->id);
			foreach($t as $id){
				@rename($this->excat.$id,$this->cat.$id);
			}
			return TRUE;
		}
		return FALSE;
	}
	function copyto(){
		if(!preg_match(REGEX_CHECK_STRING_SERIES,$this->id)) return FALSE;
		if($this->excatid == $this->catid){
			$t=explode(',',$this->id);
			foreach($t as $id){
				@copy($this->excat.$id,$this->cat.'copy_of_'.$id);
			}
		}
		else{
			$t=explode(',',$this->id);
			foreach($t as $id){
				@copy($this->excat.$id,$this->cat.$id);
			}
		}
		return TRUE;
	}
	function del(){
		if(!preg_match(REGEX_CHECK_STRING_SERIES,$this->id)) return FALSE;
		$t=explode(',',$this->id);
		foreach($t as $id){
			chmod($this->cat.$id,0777);
			unlink($this->cat.$id);
		}
		return TRUE;
	}
	function process(){

		switch($this->act){
		case ACT_LIST:
		case ACT_OPEN:
		case ACT_SEARCH:
			$this->show();break;
		case ACT_DEL:
		case ACT_REMOVE:
			$this->id = (string)$_GET['id'];
			$this->del();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_MOVE:
			$this->id = (string)$_GET['id'];
			$this->moveto();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_COPY:
			$this->id = (string)$_GET['id'];
			$this->copyto();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_RENAME:
			$this->name = (string)preg_replace(REGEX_NORMAL_FILENAME,'_',$_GET['name']);
			$this->name = preg_replace('/\.[^\.]+$/','',$this->name);
			_trace($this->name);
			$this->id = (string)$_GET['id'];
			ob_start();
			echo ($this->ren() ? "parent.banner.setStatus('&#272;&#7893;i t&ecirc;n th&agrave;nh c&ocirc;ng');input.value='{$this->name}.{$this->ext}';" : "parent.banner.setStatus('L&#7895;i khi &#273;&#7893;i t&ecirc;n');input.value=exvalue;");
			_trace(ob_get_flush());
			exit();
		}
	}
	function show(){
		$this->pagesize = (int)$_GET[ALIAS.'pagesize'];
		$this->page = (int)$_GET[ALIAS.'page'];
		$this->open();
		include('../forms/item-list-files.php');
		exit();
	}
}
$o = new filelist;
$o->type=TABLE_FILE;
$o->alias = ALIAS;
$o->catalias = CATALIAS;
$o->act=$act;
$o->extid = (int)$_GET[ALIAS.'ext'];
$o->ext = $FILE_ALLOW_EDIT_TYPE[$o->extid];
$o->catid = (int)$_GET[CATALIAS.'id'];
$o->cat = $FILE_ALLOW_EDIT_PATH[$o->catid];
$o->caturl = $FILE_ALLOW_EDIT_URL[$o->catid];
$o->excatid = (int)$_GET[CATALIAS.'exid'];
$o->excat = $FILE_ALLOW_EDIT_PATH[$o->excatid];
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = (string)URL_SELF;
$o->a_type = &$FILE_ALLOW_EDIT_TYPE;
$o->process();
?>