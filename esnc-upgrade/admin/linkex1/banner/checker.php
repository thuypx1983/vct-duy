<?php require('../../config.php');
header('Cache-control:no-cache');
require('../inc/common.php');
require '../config.php';
require('../inc/dbcon.php');
require (PATH_CLASS.'banner.php');
require '../inc/function.php';
$b = new bannerlink();	
$b->id = (int)$_GET['BNid'];
$b->loadonerow();
if ($b->checker()===TRUE){
	echo '<font style="color:#0066FF;">&#272;&#7889;i t&#225;c &#273;&#227; link t&#7899;i ch&#250;ng ta</font>';	
}
else echo '<font style="color:#FF0000;">R&#7845;t ti&#7871;c &#273;&#7889;i t&#225;c ch&#432;a link t&#7899;i ch&#250;ng ta</font>';
dbclose();
?>
