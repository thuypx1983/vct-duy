<?php
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
require('../inc/config.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_WIZARD)){
	exit('<script language="javascript">window.top.location="../../";</script>');
}
require('../inc/dbcon.php');
require(PATH_CLASS.'wizard.php');
$w = new wizarditem();
if (isset($_POST['view1'])){
	$id1 = $_POST['id1'];
	$view1 = $_POST['view1'];
	$id2 = $_POST['id2'];
	$view2 = $_POST['view2'];
	if ($w->goUpDown($id1,$id2,$view1,$view2)) {		
		echo "TRUE";
	}
	else echo "FALSE";
	return;
}
if (isset($_GET['ids'])){
	$w->catid = $_GET['ids'];
	$w->id    = (int)$_GET['WIid'];
	if ($w->setCat()) echo 'TRUE';
	else echo 'FALSE';
	return;
}
if (isset($_GET['WIid'])){
	$id = (int)$_GET['WIid'];	
	$w->id = $id;
	$act = (int)$_GET['act'];
	switch ($act){
		case ACT_REMOVE:
			if ($w->remove()) echo 'TRUE';
			else echo 'FALSE';
			break;
		case ACT_EDIT:
			$w->name  = $_POST['name'];
			$w->view  = $_POST['view'];
			$w->wid   = (int)$_GET['WDid'];
			$rs = $w->loadonerow();
			$row = mysql_fetch_assoc($rs);
			$w->catid = $row['catid'];
			if ($w->updaterow()) {
				//echo $w->msg;
				echo 'TRUE';
			}
			else echo 'FALSE';
			break;
		default: return;	
	}
	return;
}
if (isset($_GET['WDid'])){	
	$w->name = $_POST['name'];
	$w->view = $_POST['view'];
	$w->wid = (int)$_GET['WDid'];
	if ($w->addrow()) {
		echo "$w->id|$w->name|$w->view";
	}
	else{
		print_r($_POST);
		print_r($_GET);
	}
}
?>