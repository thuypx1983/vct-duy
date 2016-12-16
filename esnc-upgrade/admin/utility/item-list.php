<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_UTILITY)){
        echo "<script language='javascript'>window.top.location='../../'</script>";
        exit();
}
require '../config.php';
require("../inc/dbcon.php");
require('../admincompls/itemlist.php');
define('COL0_WIDTH','3%');
define('COL1_WIDTH','3%');

define('COL2_WIDTH','30%');
define('COL2_NAME','T&ecirc;n');

define('COL3_WIDTH','12%');
define('COL3_NAME','????');

define('COL4_WIDTH','60%');
define('COL4_NAME','Ngu&#7891;n');

define('COL5_WIDTH','7%');
define('COL5_NAME','Th&#7913; t&#7921;');

define('COL6_NAME','&#272;&#7863;c t&iacute;nh');
define('COL7_NAME','H&agrave;nh &#273;&#7897;ng');

define('CATALIAS','CU');
define('ALIAS','UT');

class bannerlist extends itemlist{
	function process(){
		switch($this->act){
		case ACT_LIST:
		case ACT_OPEN:
		case ACT_SEARCH:
			$this->catid=(int)$_GET[CATALIAS.'id'];
			$this->show();break;
		case ACT_DEL:
		case ACT_REMOVE:
			$this->id = (string)$_GET['id'];
			$this->catid = (int)$_GET['catid'];
			$this->del();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_MOVE:
			$this->id = (string)$_GET['id'];
			$this->catid = (int)$_GET['catid'];
			$this->moveto();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_COPY:
			$this->id = (string)$_GET['id'];
			$this->catid = (int)$_GET['catid'];
			$this->copyto();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_SETCTRL:
			$this->id = (string)$_GET['id'];
			$this->ctrl = (int)$_GET['ctrl'];
			$this->nctrl = (int)$_GET['nctrl'];
			$this->setctrl();
			$this->q = urlchop($this->q,'id');
			$this->catid = (int)$_GET[CATALIAS.'id'];
			$this->show();break;
		case ACT_UNSETCTRL:
			$this->id = (string)$_GET['id'];
			$this->ctrl = (int)$_GET['ctrl'];
			$this->unsetctrl();
			$this->q = urlchop($this->q,'id');
			$this->catid = (int)$_GET[CATALIAS.'id'];
			$this->show();break;
		case ACT_RENAME:
			$this->name = (string)$_GET['name'];
			$this->id = (int)$_GET['id'];
			echo ($this->ren() ? "parent.banner.setStatus('&#272;&#7893;i t&ecirc;n th&agrave;nh c&ocirc;ng');" : "parent.banner.setStatus('L&#7895;i khi &#273;&#7893;i t&ecirc;n');input.value=exvalue;");
			exit();
		case ACT_REORDER:
			$this->idvalue = (string)$_GET['idvalue'];
			echo $this->reorder() ? "parent.banner.setStatus('Thay &#273;&#7893;i th&agrave;nh c&ocirc;ng');":"parent.banner.setStatus('L&#7895;i khi thay &#273;&#7893;i');self.document.reload();";
			exit();//not open
		}
	}
	function show(){
		$this->keyword = $_GET[ALIAS.'keyword'];
		$this->pagesize = (int)$_GET[ALIAS.'pagesize'];
		$this->page = (int)$_GET[ALIAS.'page'];
		$this->sortby = (int)$_GET[ALIAS.'sortby'];
		$this->ctrl = (int)$_GET[ALIAS.'ctrl'];
		$this->ctrl_ = (int)$_GET[ALIAS.'ctrl_'];
		$this->open('`tb`.`id`,`tb`.`name`,`tb`.`filename`,`tb`.`path`,`tb`.`view`,`tb`.`ctrl`');
		include('../forms/item-list.php');
		exit();
	}
}
$o = new bannerlist;
$o->table='utility';
$o->type = TABLE_UTILITY;
$o->alias = 'UT';
$o->catalias = 'CU';
$o->a_ctrl = &$UTILITY_CTRL;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = (string)URL_SELF;
$o->process();
?>