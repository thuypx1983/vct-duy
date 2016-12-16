<?php
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_PRODUCT)){
	echo "<script language='javascript'>window.top.location='../../';</script>";
	exit();
}
require('../config.php');
require('../inc/dbcon.php');
require(PATH_CLASS.'product.php');
require PATH_CLASS.'rte.php';
require(PATH_CLASS.'price.php');
require(PATH_COMPLS.'product.php');
if (isset($_GET['PDid'])) $pdid= $_GET['PDid'];
$rows = productread((int)$pdid);
//print_r($rows);
$type= $rows->type;
//$type= 18;
include(PATH_ADMIN_PRICEFORM.'item-price-'.$type.'.php');
?>