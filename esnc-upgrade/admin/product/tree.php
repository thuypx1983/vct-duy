<?php require('../../config.php');
require '../inc/common.php';
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_PRODUCT)){
	echo "<script language='javascript'>window.top.location='../../';</script>";
	exit();
}
require '../inc/dbcon.php';
require '../config.php';
require PATH_ADMINCOMPLS.'tree.php';
class MyTree extends Tree{
	function show(){
		loadtree($this->a);
		if(MODULE_WIZARD){
			$sql='SELECT `id`,`name`,`ctrl` FROM `'.DB_TABLE_PREFIX.'wizard';
			$rs_w=mysql_query($sql);
			$a_wz = array();
			while($a_wz[]=mysql_fetch_assoc($rs_w));
			array_pop($a_wz);
			mysql_free_result($rs_w);
		}
		include PATH_ADMIN_FORM.'tree-product.php'; 
	}
}
$tree = new MyTree;
$tree->target='content';
$tree->folder=URL_CWD.'index.php?CPparentid=';
$tree->catalias='CP';
$tree->item=URL_CWD.'item-list.php?CPid=';
$tree->empty=URL_CWD.'index.php?CPparentid=';
$tree->table='product';
$tree->rootname=MENU_PRODUCT;
$tree->show();
dbclose();
?>