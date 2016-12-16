<?php 
require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
include_once ('../resize-images.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_PRODUCT,ACCESS_UPLOAD_FILE)){
	echo "<script language='javascript'>window.top.location='../../';</script>";
	exit();
}
require '../config.php';
require('../inc/dbcon.php');
require(PATH_CLASS.'document.php');
require(PATH_CLASS.'productphoto.php');
$o = new document();
$o->FLid = (int)$_GET['FLid'];
$o->fn = $_GET['fn'];
switch($act){
case ACT_SAVE:
	if($o->save()){
		$v = new productphoto();
		if(strpos($FILE_ALLOW_EDIT_URL[$o->FLid],URL_MYIMAGES) === 0)
			$v->img=str_replace(URL_MYIMAGES,'',$FILE_ALLOW_EDIT_URL[$o->FLid]).$o->name;
		else $v->img=$FILE_ALLOW_EDIT_URL[$o->FLid].$o->name;
		$v->name = nl2br($_POST['title']);
		$v->alt = nl2br($_POST['desc']);
		$v->productid = (int)$_GET['productid'];
		$v->view = (int)$_POST['view'];
		$v->url = (string)$_POST['url'];
		$v->ctrl = @(int)array_sum($_POST['ctrl']);
		$v->addrow();
		//dangtx@esnadvanced.com
		$size1=(int)trim(@$_POST['size1']);
		resize_image(PATH_PRODUCTPHOTO_IMG,$o->name,$size1);
		
		
	}
default:
	if($o->fn){
		echo '<script language="javascript" type="text/javascript">';
		echo $o->fn;
		echo '("';
		echo $o->name;
		echo '","';
		echo  $o->extension;
		echo '",';
		echo (int)array_search($o->extension,$FILE_ALLOW_EDIT_TYPE);
		echo ',0';
		echo ')</script>';
	}
}?>