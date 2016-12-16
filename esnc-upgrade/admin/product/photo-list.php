<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_PRODUCT)){
        exit("<script language='javascript'>window.top.location='../../';</script>");
}
require '../config.php';
require('../inc/dbcon.php');
require(PATH_CLASS.'productphoto.php'); 
require(PATH_ADMINCOMPLS.'productphotoitem.php'); 
class itemlist extends productphotoitem{
	var $flag;
	function show(){
		$this->search();
		switch($this->flag){
			case 0x00010000:			
				include(PATH_ADMIN_FORM.'item-list-productphoto.php');
				break;
			default:			
				include(PATH_ADMIN_FORM.'item-thumb-productphoto.php');
		}
	}
}

$o = new itemlist();
$o->productid = (int)$_GET['productid'];
switch($act){
case ACT_ADD:
	$o->fetch();
	$o->addrow();
	break;
case ACT_SAVE:
	$o->fetch();
	$o->updaterow();
	break;
case ACT_DEL:
	foreach($_POST['img'] as $img){
		$o->remove($img);
	}
	if((int)$_GET['FFflag'] & 2){
		foreach($_POST['img'] as $img){//remove file also
			@unlink(PATH_MYIMAGES.$img);
		}	
	}
	break;
case ACT_REORDER:
	$o->reorder($_POST['idview']);
	break;
default:
	$PPhint = $_GET['PPhint'];
	$PPpage = (int)$_GET['PPpage'];
	$PPpagesize = (int)$_GET['PPpagesize'];
	$o->productid=(int)$_GET['PPproductid'];
	$o->flag = ((int)$_GET['FFflag'] & 0x00030000) >> 16;
	$o->show();
	exit();
}
redirect(URL_SELF.'?'.urlmodify('act',NULL,'PPproductid',$o->productid,'productid',NULL));?>