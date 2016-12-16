<?php 
require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_PRODUCT)){
        exit('<script language="javascript">window.top.location="../../";</script>');
}
require '../config.php';
require('../inc/dbcon.php');
require(PATH_CLASS.'productphoto.php');
$v   = array();
$lim = count($_POST['img']);
for ($i=0; $i<$lim ;$i++){
	if (empty($_POST['img'][$i])) continue;
	$v[$i] = new productphoto();	
	$v[$i]->name        = $_POST['title'][$i];
	$v[$i]->img         = $_POST['img'][$i];
	$v[$i]->alt  		= $_POST['alt'][$i];
	$v[$i]->url			= $_POST['url'][$i];
	$v[$i]->productid   = (int)$_GET['productid'];	
	$v[$i]->addrow();
}
header("Location:photo-list.php?PPproductid=".(int)$_GET['productid']);
?>