<?php
require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_PRODUCT)){
        echo "<script language='javascript'>window.top.location='../../';</script>";
        exit();
}
require '../config.php';
require("../inc/dbcon.php");
require('../../class/wizard.php');
require PATH_CLASS.'rte.php';

class item extends wizarditem{
	var $act,$q,$alias='WI',$type=TABLE_WIZARDITEM,$a_ctrl;
	function process(){
		global $debug;
		switch ($this->act){
		case ACT_SAVE:
			$this->fetch();
			if($this->id <= 0)	$this->addrow();
			else 
			$this->updaterow();
		return TRUE;
		default:
			$this->id = (int)$_GET[$this->alias.'id'];
			$this->show();
		}
	}
	function show(){
		if($this->id > 0) $this->loadonerow();		
		include(PATH_ADMIN_FORM.'item-wizard.php');
		dbclose();
	}
}
$o = new item();
$o->id=(int)$_REQUEST['WIid'];
$o->wid=(int)$_REQUEST['WDid'];

$o->doctitle='Chi ti&#7871;t x&acirc;y d&#7921;ng b&#432;&#7899;c';
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = URL_SELF;
$o->wid = $_REQUEST[$o->catalias.'WDid'];
$o->type = TABLE_WIZARDITEM;
$o->a_ctrl = &$WIZARDITEM_CTRL;
if($o->process()) redirect('item-list.php?WDid='.$_POST['wid']);
$o->msg = "L&#7895;i khi c&#7853;p nh&#7853;t";
//$o->show();
?>
