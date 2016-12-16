<?php define('MAGIC_QUOTES_OFF',TRUE);
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_READ)){
	exit("<script language='javascript'>window.top.location='../../';</script>");
}
require '../config.php';
require PATH_ADMIN.'inc/dbcon.php';
$msg = '';
if(!is_file(PATH_ROOT.'js/IEhover.htc')){
	file_put_contents(PATH_TEMP.'IEhover.htc',
'<PUBLIC:COMPONENT lightweight="true">
<PUBLIC:ATTACH EVENT="onmouseover" ONEVENT="hoverClass()" />
<PUBLIC:ATTACH EVENT="onmouseout"  ONEVENT="restoreClass()" />
<SCRIPT LANGUAGE="JavaScript">
   function hoverClass(){  if(element.className.indexOf("-hover") < 0) element.className += "-hover";}
   function restoreClass(){element.className = String(element.className).replace(/\-hover$/,"");}
</SCRIPT>
</PUBLIC:COMPONENT>'
	);
	if(!rename(PATH_TEMP.'IEhover.htc',PATH_ROOT.'js/IEhover.htc')) $msg .='<li>Thi&#7871;u t&#7853;p tin IEhover.htc trong th&#432; m&#7909;c js. B&#7841;n ph&#7843;i chuy&#7875;n t&#7853;p tin IEhover.htc trong th&#432; m&#7909;c temp v&agrave;o th&#432; m&#7909;c js</li>';
}

if(!is_file(PATH_ROOT.'js/IEmaxsize.htc')){
	file_put_contents(PATH_TEMP.'IEmaxsize.htc',
'<PUBLIC:COMPONENT lightweight="true">
<PUBLIC:ATTACH EVENT="oncontentready" FOR="element" ONEVENT="resize()" />
<SCRIPT LANGUAGE="JavaScript">
   function resize(){
   		mW = parseInt(element._max_width);if(isNaN(mW)) mW=0;
   		mH = parseInt(element._max_height);if(isNaN(mH)) mH=0;
   		if(element.tagName == "IMG"){
    		if(mW > 0 && parseInt(element.width) > mW) element.width=mW;
    		if(mH > 0 && parseInt(element.height) > mH) element.height=mH;
		}else{
    		if(mW > 0 && parseInt(element.offsetWidth) > mW) element.style.width=mW + "px";
    		if(mH > 0 && parseInt(element.offsetHeight) > mH) element.style.height=mH + "px";
		}
   }
</SCRIPT>
</PUBLIC:COMPONENT>'
	);
	if(!rename(PATH_TEMP.'IEmaxsize.htc',PATH_ROOT.'js/IEmaxsize.htc')) $msg .='<li>Thi&#7871;u t&#7853;p tin IEmaxsize.htc trong th&#432; m&#7909;c js. B&#7841;n ph&#7843;i chuy&#7875;n t&#7853;p tin IEmaxsize.htc trong th&#432; m&#7909;c temp v&agrave;o th&#432; m&#7909;c js</li>';
}

if(!is_file(PATH_ROOT.'js/job.php')){
	file_put_contents(PATH_TEMP.'job.php',
'<?php
header(\'Cache-Control:private\');
require(\'../config.php\');
require(PATH_INC.\'commonguest.php\');
require(PATH_INC.\'dbconguest.php\');
require(PATH_COMPLS.\'job.php\');
require(PATH_CLASS.\'session.php\');
require(PATH_INC.\'function.php\');
@define(\'JOB_INTERVAL\',3600);
if(jobqueueready()){

}
dbclose();
?>');
	if(!rename(PATH_TEMP.'job.php',PATH_ROOT.'js/job.php')) $msg .='<li>Thi&#7871;u t&#7853;p tin job.php trong th&#432; m&#7909;c js. B&#7841;n ph&#7843;i chuy&#7875;n t&#7853;p tin stat.php trong th&#432; m&#7909;c temp v&agrave;o th&#432; m&#7909;c js</li>';
}

if(!is_file(PATH_ROOT.'js/esnc_aform.php')){
	file_put_contents(PATH_TEMP.'esnc_aform.php',
'<?php require(\'../config.php\');
require(PATH_COMPLS.\'esnc_aform.php\');
initcheck();
?>');
	if(!rename(PATH_TEMP.'esnc_aform.php',PATH_ROOT.'js/esnc_aform.php')) $msg .='<li>Thi&#7871;u t&#7853;p tin esnc_aform.php trong th&#432; m&#7909;c js. B&#7841;n ph&#7843;i chuy&#7875;n t&#7853;p tin esnc_aform.php trong th&#432; m&#7909;c temp v&agrave;o th&#432; m&#7909;c js</li>';
}

if(!is_file(PATH_ROOT.'js/init.js')){
	file_put_contents(PATH_TEMP.'init.js',
'if(_visit = document.getElementById(\'app_visit\')) _visit.innerHTML = app.visit;
if(_online = document.getElementById(\'app_online\')) _online.innerHTML = app.online;');
	if(!rename(PATH_TEMP.'init.js',PATH_ROOT.'js/init.js')) $msg .='<li>Thi&#7871;u t&#7853;p tin init.js trong th&#432; m&#7909;c js. B&#7841;n ph&#7843;i chuy&#7875;n t&#7853;p tin init.js trong th&#432; m&#7909;c temp v&agrave;o th&#432; m&#7909;c js</li>';
}

if(!is_file(PATH_ROOT.'js/stat.php')){
	file_put_contents(PATH_TEMP.'stat.php',
'<?php require(\'../config.php\');
require(PATH_INC.\'commonguest.php\');
require(PATH_INC.\'dbconguest.php\');
$act = $_GET[\'act\'];
switch($act){
case \'bannerclick\':
	$BNid=(int)$_GET[\'BNid\'];
	$sql=\'UPDATE `\'.DB_TABLE_PREFIX.\'banner` SET `Click`=`Click` + 1 WHERE `ID`=\'.$BNid;
	mysql_query($sql);
	break;
    break;
case \'prdhit\':
	$PDid=(int)$_GET[\'PDid\'];
	$sql=\'UPDATE `\'.DB_TABLE_PREFIX.\'product` SET `Hit`=`Hit` + 1,`LastRead`=\'.SQL_NOW.\' WHERE `ID`=\'.$PDid;
	mysql_query($sql);
	break;
case \'newshit\':
	$NWid=(int)$_GET[\'NWid\'];
	$sql=\'UPDATE `\'.DB_TABLE_PREFIX.\'news` SET `Hit`=`Hit` + 1,`LastRead`=\'.SQL_NOW.\' WHERE `ID`=\'.$NWid;
	mysql_query($sql);
	break;
}
dbclose();
?>');
	if(!rename(PATH_TEMP.'stat.php',PATH_ROOT.'js/stat.php')) $msg .='<li>Thi&#7871;u t&#7853;p tin stat.php trong th&#432; m&#7909;c js. B&#7841;n ph&#7843;i chuy&#7875;n t&#7853;p tin stat.php trong th&#432; m&#7909;c temp v&agrave;o th&#432; m&#7909;c js</li>';
}
if(!is_file(PATH_ROOT.'js/js.php')){
	file_put_contents(PATH_TEMP.'js.php',
'<?php 
require(\'../config.php\'); 
require(PATH_INC.\'commonguest.php\'); 
require(PATH_INC.\'session.php\');
header(\'Cache-Control:no-cache\',TRUE);
?>var session = new Object, app=new Object;
session.name=\'<?php echo (string)$session->name; ?>\';
session.email=\'<?php echo (string)$session->email; ?>\';
session.lastlogin=\'<?php echo (string)$session->lastlogin; ?>\';
session.rnd=\'<?php echo session_id();?>\';
app.visit = \'<?php echo session::visit(); ?>\';
app.online=\'<?php echo session::online(); ?>\';
app.now=new Date(<?php echo gmdate("U * 1000");?>);
');
	if(!rename(PATH_TEMP.'js.php',PATH_ROOT.'js/js.php')) $msg .='<li>Thi&#7871;u t&#7853;p tin js.php trong th&#432; m&#7909;c js. B&#7841;n ph&#7843;i chuy&#7875;n t&#7853;p tin js.php trong th&#432; m&#7909;c temp v&agrave;o th&#432; m&#7909;c js</li>';
}
if(!is_file(PATH_APPLICATION.'lang.js')) touch(PATH_APPLICATION.'lang.js');
if(!is_file(PATH_APPLICATION.'config_desc.ini') && defined('BANNER_PAGESIZE_LINKEXCHANGE')){
	file_put_contents(PATH_APPLICATION.'config_desc.ini',';created by system checker
[BANNER_PAGESIZE_LINKEXCHANGE]
name="K&iacute;ch th&#432;&#7899;c trang link exchange"
type=int
default=40
[URL_LINKEXCHANGE]
name="URL c&#7847;n ki&#7875;m tra khi link exchange"
type=string
default=URL_BASE
'	);
}
call_user_func(_esnc_check_update,ESNC_VERSION);
chmod(PATH_ROOT.'config.php',0500);//lock configuration file
dbclose();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Ki&#7875;m tra h&#7879; th&#7889;ng</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="images/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<fieldset><legend>Th&ocirc;ng b&aacute;o</legend>
&#272;&atilde; ho&agrave;n th&agrave;nh ki&#7875;m tra<br/>
<?php if($msg){?>
C&aacute;c v&#7845;n &#273;&#7873;:
<ul>
<?php echo $msg ?>
</ul>
<?php }?>
</fieldset>
</body>
<script language="javascript" defer>
window.top.document.title = self.document.title;
</script>
</html>