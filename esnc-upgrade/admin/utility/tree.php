<?php require('../../config.php');
require '../inc/common.php';
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_UTILITY)){
	echo "<script language='javascript'>window.top.location='../../';</script>";
	exit();
}
require '../inc/dbcon.php';
require '../config.php';
require PATH_ADMINCOMPLS.'tree.php';
class MyTree extends Tree{
	function show(){
		loadtree($this->a);
		include PATH_ADMIN_FORM.'tree.php';	
	}
}
$tree = new MyTree;
$tree->target='content';
$tree->folder=URL_CWD.'index.php?CUparentid=';
$tree->catalias='CU';
$tree->item=URL_CWD.'item-list.php?CUid=';
$tree->empty=$tree->folder;
$tree->table='utility';
$tree->rootname=MENU_UTILITY;
$tree->show();
dbclose();
?>