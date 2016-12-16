<?php 
require('../config.php');
require("./inc/common.php");
require('./inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_DEFAULT,ACCESS_UPLOAD_FILE)){
        echo '<script language="javascript">window.top.location="../";</script>';
        exit();
}
require './config.php';
require PATH_CLASS.'document.php';
class documentitem extends document{
	var $fn;
	function show(){
		global $act,$FILE_ALLOW_EDIT_TYPE;
		include PATH_ADMIN_FORM.'item-document-one.php';
		exit();
	}
}
$o = new documentitem();
$o->FLid = (int)$_GET['FLid'];
$o->fn = $_GET['fn'];
$o->FLsubFolder = $_GET['FLsubFolder'];
switch($act){
case ACT_SAVE:
	$o->save();	
default:
	$o->show();	
}
?>
