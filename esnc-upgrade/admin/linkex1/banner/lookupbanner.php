<?php require('../../config.php');
header('Cache-control:no-cache');
require('../inc/common.php');
require('../inc/dbcon.php');
require '../config.php';
require(PATH_CLASS.'banner.php');
$b = new bannerlink();	
$b->id = (int)$_GET['BNid'];
$page = $b->lookup();
$leading = URL_BASE.'link-exchange.php?CBid='.$b->a_cat.'&CBname='.urlencode($b->a_catname);
if($page == 1)		echo $leading;
elseif($page > 1) echo $leading.'&BNpage='.$page;
//$page <1: unspecified link
mysql_close();?>
