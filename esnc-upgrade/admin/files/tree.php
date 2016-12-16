<?php require('../../config.php');
require '../inc/common.php';
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_FILE)){
	echo "<script language='javascript'>window.top.location='../../';</script>";
	exit();
}
require '../inc/dbcon.php';
require '../config.php';
require PATH_ADMINCOMPLS.'tree.php';
unset($FILE_ALLOW_EDIT_FOLDER_NAME[1],$FILE_ALLOW_EDIT_FOLDER_NAME[2]);
class MyTree extends Tree{
	function show(){
		global $FILE_ALLOW_EDIT_FOLDER_NAME;
		$this->a=array();
		foreach($FILE_ALLOW_EDIT_FOLDER_NAME as $k=>$v){
			$this->a[]=array($k,$v,1,-1,NULL);
		}
		include PATH_ADMIN_FORM.'tree.php';	
	}
}
$tree = new MyTree;
$tree->target='content';
$tree->folder=URL_CWD.'index.php?FLparentid=';
$tree->catalias='FL';
$tree->item=URL_CWD.'item-list.php?FFext=0&FLid=';
$tree->empty=$tree->folder;
$tree->table='file';
$tree->rootname='So&#7841;n th&#7843;o';
$tree->show();
dbclose();
?>