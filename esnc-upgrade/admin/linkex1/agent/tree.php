<?php require('../../config.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	echo "<script language='javascript'>window.top.location='".ROOT."'</script>";
	exit();
}
?>
<html>
<head>
<title>News menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="../../images/computerstyle.css">
<script language="javascript" src="../js/tree.js"></script>
<!--<script language="javascript" src="images/tree_items.php"></script>-->
<script language="javascript" src="../admincompls/tree-items.php?rootname=C%26%23417%3B+s%26%237903%3B&folderpage=index.php%3FCAparentid%3D&itempage=item-list.php%3FCAid%3D&emptypage=index.php%3FCAparentid%3D&module=agent"></script>
<script language="javascript" src="../js/tree_tpl.js"></script>
<script language="javascript">
function closemenu(){
	parent.left.location.href="../search.php";
}
</script>
<style>
	a, A:link, a:visited, a:active
		{color: #000000; text-decoration: none; font-family: Tahoma, Verdana; font-size: 11px}
	A:hover
		{color: #000000; text-decoration: underline; font-family: Tahoma, Verdana; font-size: 11px}
	p, tr, td, ul, li
		{color: #000000; font-family: Tahoma, Verdana; font-size: 11px}
	.header1, h1
		{color: #ffffff; background: #4682B4; font-weight: bold; font-family: Tahoma, Verdana; font-size: 13px; margin: 0px; padding: 2px;}
	.header2, h2
		{color: #000000; background: #DBEAF5; font-weight: bold; font-family: Tahoma, Verdana; font-size: 12px;}
	.intd
		{color: #000000; font-family: Tahoma, Verdana; font-size: 11px; padding-left: 15px; padding-right: 15px;}
	.ctrl
		{font-family: Tahoma, Verdana, sans-serif; font-size: 12px; width: 100%; }
	form
		{ margin: 2px;}
</style>
</head>
<body>
<script language="javascript">
	new tree (TREE_ITEMS,TREE_TPL);
</script>
</body>
</html>
