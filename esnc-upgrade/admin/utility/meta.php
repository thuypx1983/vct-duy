<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_UTILITY)){
        exit("<script language='javascript'>window.top.location='../../';</script>");
}
require '../config.php';
require('../inc/dbcon.php');
require(PATH_CLASS.'meta.php');
class item extends meta{
	var $id,$catid;
	function show(){
		$this->path = PATH_UTILITY_META.'utility-'.$this->id.'.html';
		$this->read();
		include(PATH_ADMIN_FORM.'meta-item.php');
		dbclose();
		exit();
	}
}
$o = new item;
define('CATALIAS','CU');
define('ALIAS','UT');
$o->id = (int)$_REQUEST['id'];
switch($act){
case ACT_SAVE:
	if($o->id <=0) break;
	$o->title=$_POST['title'];
	$o->m['keywords'] = $_POST['keywords'];
	$o->m['description'] = $_POST['description'];
	if($_POST['default']){
		fileremove(PATH_UTILITY_META.'utility-'.$o->id.'.html');
		$o->path = PATH_UTILITY_META.'default.html';
	}else{
		$o->path=PATH_UTILITY_META.'utility-'.$o->id.'.html';
	}
	$o->save();
	break;
case ACT_DEL:
	fileremove(PATH_UTILITY_META.'utility-'.$o->id.'.html');
	break;
default:
	$o->id = (int)$_GET[ALIAS.'id'];
	$rs = mysql_select('`a`.`name`,`b`.`catutilityid`','`#utility` as `a` INNER JOIN `#catutilityutility` as `b` ON `a`.`id`=`b`.`utilityid`','`a`.`id`='.$o->id);
	$row = mysql_fetch_row($rs);
	$o->name=$row[0];
	$o->catid=(int)$row[1];
	mysql_free_result($rs);
	$o->show();
}
redirect($_GET['go']);
?>