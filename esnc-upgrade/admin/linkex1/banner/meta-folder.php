<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_BANNER)){
        exit("<script language='javascript'>window.top.location='../../';</script>");
}
require '../config.php';
require('../inc/dbcon.php');
require(PATH_CLASS.'meta.php');
class item extends meta{
	var $id,$catalias='CP',$parentid;
	function show(){
		$this->path = PATH_CATBANNER_META.'catbanner-'.$this->id.'.html';
		$this->read();
		include(PATH_ADMIN_FORM.'meta-folder.php');
		dbclose();
		exit();
	}
}
define('CATALIAS','CB');
$o = new item;
$o->id = (int)$_REQUEST['id'];
switch($act){
case ACT_SAVE:
	$o->title=$_POST['title'];
	$o->m['keywords'] = $_POST['keywords'];
	$o->m['description'] = $_POST['description'];
	if($_POST['default']){
		fileremove(PATH_CATBANNER_META.'catbanner-'.$o->id.'.html');
		$o->path = PATH_CATBANNER_META.'default.html';
	}else{
		$o->path=PATH_CATBANNER_META.'catbanner-'.$o->id.'.html';
	}
	if($o->id > 0)	$o->save();
	break;
case ACT_DEL:
	fileremove(PATH_CATBANNER_META.'catbanner-'.$o->id.'.html');
	break;
default:
	$o->id = (int)$_GET['MTcatid'];
	$rs = mysql_select('`a`.`name`,`a`.`parentid`','`#catbanner` as `a`','`a`.`id`='.$o->id);
	$row = mysql_fetch_row($rs);
	$o->name=$row[0];
	$o->parentid=(int)$row[1];
	mysql_free_result($rs);
	$o->show();
}
redirect(URL_GO);
?>