<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_READ|ACCESS_WRITE)){
	exit("<script language='javascript'>window.top.location='../../';</script>");
}
require '../config.php';
define('COL0_WIDTH','3%');
define('COL1_WIDTH','3%');

define('COL2_NAME','T&ecirc;n t&#7853;p tin');
define('COL3_WIDTH','45%');
define('COL3_NAME','Ghi ch&uacute;');

define('COL4_NAME','H&agrave;nh &#273;&#7897;ng');

define('CATALIAS','FL');
define('ALIAS','FF');
class sysfilelist {
	function loaddescription(){
		if(is_file(PATH_APPLICATION.'desktop_esnc.ini')) $this->description = parse_ini_file(PATH_APPLICATION.'desktop_esnc.ini',TRUE); else $this->description=array();
	}
	function savedescription($filename,$name){
		include PATH_ADMIN.'inc/function.php';
		$this->loaddescription();
		$this->description[$filename]['name']=$name;
		save_ini_file(PATH_APPLICATION.'desktop_esnc.ini',$this->description);
	}
	function redescription($filename,$newname){
		include PATH_ADMIN.'inc/function.php';
		$this->loaddescription();
		$this->description[$newname]=$this->description[$filename];
		unset($this->description[$filename]);
		save_ini_file(PATH_APPLICATION.'desktop_esnc.ini',$this->description);
	}
	function open(){
		$curdir = getcwd();
		chdir($this->cat);
		$this->rs = glob("*.{{$this->ext}}",GLOB_NOESCAPE|GLOB_BRACE|GLOB_NOSORT);
		chdir($curdir);
		$this->rowcount = sizeof($this->rs);
 		if($this->pagesize < 15) $this->pagesize=15;
		$this->pagecount = (int)ceil($this->rowcount/$this->pagesize);if($this->pagecount < 1) $this->pagecount=1;
		if($this->page < 1) $this->page=1;
		if($this->page > $this->pagecount) $this->page = $this->pagecount;
		$this->startrow = ($this->page -1)* $this->pagesize;
	}
	function show(){
		global $FILE_ALLOW_EDIT_TYPE;
		$this->pagesize = (int)$_GET[ALIAS.'pagesize'];
		$this->page = (int)$_GET[ALIAS.'page'];
		$this->loaddescription();
		$this->open();
		include PATH_ADMIN_FORM.'item-list-sysfile.php';
	}
}
$o = new sysfilelist;
$o->type=TABLE_FILE;
if(!isset($_GET['FFextid'])) $_GET['FFextid'] = 1;
$o->extid = (int)$_GET['FFextid'];
$o->ext = $FILE_ALLOW_EDIT_TYPE[$o->extid];
$o->catid = 1;
$o->cat = PATH_APPLICATION;
switch($act){
case ACT_SAVE:
	$o->savedescription($_GET['filename'],$_GET['name']);
	redirect(URL_GO);
	break;
case ACT_RENAME:
	$filename=$_GET['filename'];
	if(strpos($filename,'..') === FALSE){
		$newname=preg_replace('/\..*$/','',preg_replace(REGEX_NORMAL_FILENAME,'_',$_GET['newname'])).'.'.strtolower(pathinfo($filename,PATHINFO_EXTENSION));
		if(rename(PATH_APPLICATION.$filename,PATH_APPLICATION.$newname)){
			$o->redescription($filename,$newname);
		}
	}
	redirect(URL_GO);
break;
case ACT_REMOVE:
	$filename=$_GET['filename'];
	if(strpos($filename,'..') === FALSE){
		chmod(PATH_APPLICATION.$filename,0700);
		if(unlink(PATH_APPLICATION.$filename))
			$o->redescription($filename,'');
	}
	redirect(URL_GO);
break;
default:		$o->show();break;
}
?>