<?php define('MAGIC_QUOTES_OFF',TRUE);
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_WRITE|ACCESS_READ)){
	echo "<script language='javascript'>window.top.location='../../';</script>";
	exit();
}
require '../inc/dbcon.php';
//ham de hien thi danh sach footer cac trang

function getlist($key=NULL){
	global $sql;
	if($key!=NULL){ //co keyword thi tien hanh search
		$sql = 'SELECT `Id`,`Url`,`Text` FROM `'.DB_TABLE_PREFIX.'footer` WHERE `Url` LIKE "%'.$key.'%" OR `Text` LIKE "%'.$key.'%"';	
	}else{ //ko co kewword thi lay tat ca trong du lieu .
		$sql = 'SELECT `Id`,`Url`,`Text` FROM `'.DB_TABLE_PREFIX.'footer`';
	}
	_trace($sql);	
	return mysql_query($sql);	
}
//ham lay thon tin ve 1 trang va chuoi hien thi cua no.
function getitem($id){
	global $sql;
	settype($id,'int');
	$sql = 'SELECT `Url`,`Text` FROM `'.DB_TABLE_PREFIX.'footer` WHERE `Id`='.$id;
	$rs = mysql_query($sql);	
	return mysql_fetch_object($rs);
}
$act = @$_GET['act'];
switch($act){
case ACT_ADD:
case ACT_EDIT:  //khi them moi va sua lai deu ra trang new-item-footer
	$id = @(int)$_GET['id'];
	if($id!=NULL) $o = getitem($id);
	include('../forms/new-item-footer.php');
	exit();
case ACT_SAVE:	//khi quan tri them moi hoac sua lai 1 item.
	$id = @(int)$_GET['id'];
	$url = @(string)($_POST['url']);
	$text = @(string)($_POST['text']);
	if($id){
		$sql = 'UPDATE `'.DB_TABLE_PREFIX.'footer` SET `Url`="'.$url.'",`Text`="'.mysql_real_escape_string(stripslashes($text)).'" WHERE `Id`='.$id;			
	}else{
		$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'footer`(`Url`,`Text`) VALUES("'.$url.'","'.mysql_real_escape_string(stripslashes($text)).'")';	
	} 
	_trace($sql);
	mysql_query($sql);	
	return include('../forms/list-item-footer.php');	
case ACT_DEL: //xoa item
	$id = @(int)$_GET['id'];
	$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'footer` WHERE `Id`='.$id;
	_trace($sql);
	mysql_query($sql);
	return include('../forms/list-item-footer.php');	
case ACT_SEARCH:	//tim kiem voi tu khoa.
	$key = (string)$_POST['key'];	
	return include('../forms/list-item-footer.php');
break;
default:
	return include('../forms/list-item-footer.php');
}
dbclose();
?>
