<?php
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
//require('../inc/config.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_WIZARD)){
	exit('<script language="javascript">window.top.location="../../";</script>');
}
require('../inc/dbcon.php');
require(PATH_CLASS.'wizard.php');
$w = new wizard();
if ($_GET['act']){	
	$act     = (int)$_GET['act'];
	$ids     = $_GET['ids'];
	$w->ctrl = (int)$_GET['ctrl'];
	switch ($act){
		case ACT_SETCTRL   : $w->setCtrl($ids);break;
		case ACT_UNSETCTRL : $w->unsetCtrl($ids);break;
		case ACT_RENAME    : 
			$w->id   = (int)$_GET['WDid'];
			$w->name = $_POST['name'];
			if ($w->setName()) echo 'TRUE';
			else echo $w->msg;
			return;
			break;
		case ACT_REMOVE    : 
			$w->id = (int)$_GET['WDid'];
			if ($w->remove()) echo 'TRUE';
			else echo 'FALSE';
			return;
			break;
		default:return;
	}
	header("Location:wizard-list.php");exit();
}
$w->name = $_POST['WDname'];
$w->desc = $_POST['WDdesc'];
$v = NULL;
if ($_POST['WDctrl']){
	foreach ($_POST['WDctrl'] as $ctrl=>$value){		
		$v |= $value;
	}
}
$w->ctrl = $v;
if ($_GET['WDid']){
	$w->id   = (int)$_GET['WDid'];
	$w->updaterow();
	header("Location:wizard-list.php");exit();
}
$w->addrow();
header("Location:wizard.php?WDid=".$w->id);exit();
?>