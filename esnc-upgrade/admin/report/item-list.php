<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_REPORT)){
	header('HTTP/1.0 404 Not Found');
	exit();
}
require '../config.php';
require("../inc/dbcon.php");
require(PATH_CLASS.'report.php');
require(PATH_ADMINCOMPLS.'itemlist.php');
define('COL0_WIDTH','3%');
define('COL1_WIDTH','3%');

define('COL2_WIDTH','45%');
define('COL2_NAME','T&ecirc;n');

define('COL3_WIDTH','22%');
define('COL3_NAME','L&#7847;n ch&#7841;y g&#7847;n &#273;&acirc;y');

define('COL4_WIDTH','35%');
define('COL4_NAME','H&agrave;nh &#273;&#7897;ng');

define('COL5_WIDTH','0%');
define('COL5_NAME','Th&#7913; t&#7921;');

define('COL6_NAME','&#272;&#7863;c t&iacute;nh');

define('CATALIAS','');
define('ALIAS','RP');

class mylist extends itemflatlist{
	function show(){
		global $session;
		$this->pagesize = (int)$_GET[ALIAS.'pagesize'];
		$this->page = (int)$_GET[ALIAS.'page'];
		$this->sortby = (int)$_GET[ALIAS.'sortby'];
		if($this->sortby == '') $this->sortby = SORTBY_ID_DESC;
		$this->ctrl = (int)$_GET[ALIAS.'ctrl'];
		$this->ctrl_ = (int)$_GET[ALIAS.'ctrl_'];
		$this->open('`tb`.`id`,`tb`.`name`,DATE_FORMAT(`tb`.`lastrun`,\''.FORMAT_DB_DATETIME.'\') as `lastrun`,`tb`.`type`,`tb`.`ctrl`');
		include PATH_ADMIN_FORM.'item-list-report.php';
	}
	function del(){	
		global $session;
		if ($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){
			$sql = "DELETE FROM `".DB_TABLE_PREFIX."{$this->table}` WHERE `id` IN ({$this->id})";
			return mysql_query($sql);
		}
		return FALSE;
	}
}

$o = new mylist;
$o->doctitle='B&aacute;o c&aacute;o';
$o->table='report';
$o->type = TABLE_REPORT;
$o->alias = 'RP';
$o->catalias = '';
$o->a_ctrl = &$REPORT_CTRL;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = URL_SELF;
switch($act){
	case ACT_REMOVE:				
		$o->id = (string)$_GET['id'];
		$o->del();				
		$o->q = urlchop($o->q,'id');
		redirect(URL_SELF);
		break;
	case ACT_SET:
		$o->id=$_GET['id'];
		$o->ctrl=$_GET['ctrl'];
		$o->nctrl=$_GET['nctrl'];
		$o->setCtrl();
		$o->q=urlchop($o->q,'id');
		redirect(URL_SELF);
	default: $o->show();	
}
dbclose();
?>