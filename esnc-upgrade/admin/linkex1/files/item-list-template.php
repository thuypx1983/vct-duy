<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){
	exit("<script language='javascript'>window.top.location='../../';</script>");
}
require '../config.php';
define('COL0_WIDTH','3%');
define('COL1_WIDTH','3%');

define('COL2_WIDTH','45%');
define('COL2_NAME','Template');

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
		chdir(PATH_TEMPLATES);
		$this->rs = glob("*.htm",GLOB_NOESCAPE);
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
		$this->open();
		include PATH_ADMIN_FORM.'item-list-template.php';
		exit();
	}
}
$o = new filelist;
$o->show();
?>