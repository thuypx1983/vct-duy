<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
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
class metafilelist {
	function loaddescription(){
		if(is_file(PATH_APPLICATION.'meta_desc.ini')) $this->description = parse_ini_file(PATH_APPLICATION.'meta_desc.ini',TRUE); else $this->description=array();
	}
	function savedescription($filename,$name){
		include PATH_ADMIN.'inc/function.php';
		$this->loaddescription();
		$this->description[$filename]['name']=$name;
		save_ini_file(PATH_APPLICATION.'meta_desc.ini',$this->description);
	}
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
	function show(){
		$this->pagesize = (int)$_GET[ALIAS.'pagesize'];
		$this->page = (int)$_GET[ALIAS.'page'];
		$this->loaddescription();
		$this->open();
		include PATH_ADMIN_FORM.'item-list-metafile.php';
	}
}
$o = new metafilelist;
$o->type=TABLE_FILE;
$o->extid = 2;
$o->ext = 'html';
$o->catid = 2;
$o->cat = PATH_META;
switch($act){
case ACT_SAVE:
	$o->savedescription($_GET['filename'],$_GET['name']);
	redirect(URL_GO);
	break;
default:		$o->show();break;
}
?>