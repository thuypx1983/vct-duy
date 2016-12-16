<?php define('MAGIC_QUOTES_OFF',TRUE);
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_WRITE|ACCESS_READ)){
	echo "<script language='javascript'>window.top.location='../../';</script>";
	exit();
}
require '../config.php';

require '../inc/function.php';

define('DATE_FORMAT','%d-%m-%Y');
define('DATE_SEPERATOR','-');
define('FILE_DEFAULT','');

require(PATH_CLASS.'session.php');

if(is_file(PATH_APPLICATION.'config_desc.ini')) $CFG=parse_ini_file(PATH_APPLICATION.'config_desc.ini',TRUE); else $CFG=array();
if(is_file(PATH_COMPONENT.'scedit.php')){
	include PATH_COMPONENT.'scedit.php';
//	header('X-ESNC-scedit:ok');//test if code valid, no redundant code outside function
}else include PATH_ADMINCOMPLS.'app_config.php';
if($act == ACT_SAVE){
	app_config_write();
	redirect(URL_SELF);
	exit();
}
require PATH_ADMIN.'inc/dbcon.php';
$sql = 'SELECT `content` FROM `'.DB_TABLE_PREFIX.'fs` WHERE `name`=\'application/stat\'';
$rs = mysql_query($sql);
if($row=mysql_fetch_row($rs)){
	$stat = unserialize($row[0]);
}
if(!$stat) $stat=array();
mysql_free_result($rs);
$sql = 'SELECT DATE_FORMAT('.SQL_NOW.',\''.FORMAT_DB_DATETIME.'\'), DATE_FORMAT(NOW(),\''.FORMAT_DB_DATETIME.'\')';
$rs  = mysql_query($sql);
list($sql_now,$now)=mysql_fetch_row($rs);
mysql_free_result($rs);
dbclose();
if($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)) define('MAX_ADD_CONSTANT',1); else	define('MAX_ADD_CONSTANT',-1);
include PATH_ADMIN_FORM.'scedit.php';	
?>