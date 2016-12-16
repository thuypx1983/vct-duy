<?php require('../config.php');
require_once('./inc/common.php');
require_once('./inc/session.php');
if (!$session->getAccess(SESSION_CTRL_ADMIN)){
	exit("<script language='javascript'>window.top.location='../';</script>");
}
require './config.php';
require('./inc/dbcon.php');
if($DB_R_NAME){
	dbclose();
	r_open($DB_R_HOST,$DB_R_USER_ADMIN,$DB_R_PWD_ADMIN,$DB_R_NAME);//open remote
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Qu&#7843;n l&yacute; m&#7853;t kh&#7849;u</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css">
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
<style>tr.notice{display:none;}
<?php if($session->pwdexpires) echo "tr#pwdexpires{display:block;} tr#pwdexpires{display:table-row;}";
if($session->USctrl & USER_CTRL_PASSWD_EXPIRES) echo "tr#pwdprompt{display:block;} tr#pwdprompt{display:table-row;}";
?>
</style>
</head>
<body style="margin:0px 0px 0px 0px">
<form action="passwd.php?act=save" method="post" onSubmit="return checkForm(this);">
<table width="100%" cellpadding="0" cellspacing="0">
<tr id="pwdexpires" class="notice"><td colspan="2" class="text" align="center" style="color:red;font-weight:bold;padding:15px;" >M&#7853;t kh&#7849;u c&#7911;a b&#7841;n &#273;&atilde; h&#7871;t h&#7841;n, xin vui l&ograve;ng &#273;&#7893;i m&#7853;t kh&#7849;u &#273;&#7875; &#273;&#7843;m b&#7843;o an to&agrave;n.N&#7871;u b&#7841;n kh&ocirc;ng &#273;&#7893;i m&#7853;t kh&#7849;u, b&#7841;n s&#7869; kh&ocirc;ng th&#7875; qu&#7843;n tr&#7883; &#273;&#432;&#7907;c n&#7919;a</td></tr>
<tr id="pwdprompt" class="notice"><td colspan="2" class="text" align="center" style="color:red;font-weight:bold;padding:15px;"  width="100%">H&#7879; th&#7889;ng y&ecirc;u c&#7847;u b&#7841;n ph&#7843;i &#273;&#7893;i m&#7853;t kh&#7849;u &#273;&#7875; &#273;&#7843;m b&#7843;o an to&agrave;n.N&#7871;u b&#7841;n kh&ocirc;ng &#273;&#7893;i m&#7853;t kh&#7849;u b&#7841;n s&#7869; kh&ocirc;ng th&#7875; qu&#7843;n tr&#7883; &#273;&#432;&#7907;c n&#7919;a.</td></tr>
<tr><td class="text" width="30%">&nbsp;</td><td class="text" align="left" style="font-weight:bold;padding-top:10px;padding-bottom:5px; ">&#272;&#7893;i m&#7853;t kh&#7849;u</td></tr>
<tr><td class="text" width="30%">&nbsp;&nbsp;&nbsp;M&#7853;t kh&#7849;u &#273;ang d&ugrave;ng</td><td><input type="password" size="20" class="input" name="ADpassword" /></td></tr>
<tr><td class="text">&nbsp;&nbsp;&nbsp;M&#7853;t kh&#7849;u m&#7899;i</td><td><input type="password" size="20" class="input" name="ADnewpassword" /></td></tr>
<tr><td class="text">&nbsp;&nbsp;&nbsp;Nh&#7853;p l&#7841;i m&#7853;t kh&#7849;u m&#7899;i</td><td><input type="password" size="20" class="input" name="ADnewpassword2" /></td><tr>
<tr><td>&nbsp;</td><td style="padding-top:5px"><input type="submit" value="&#272;&#7893;i m&#7853;t kh&#7849;u" class="button" /></td></tr>
</table>
</form>
</body>
</html>
<script language="javascript" defer>
<?php 
if($act == 'save'){
	$ADpassword = (string)$_POST['ADpassword'];
	$ADnewpassword = (string)$_POST['ADnewpassword'];
	if($session->passwd($ADpassword,$ADnewpassword)){;?>
		window.alert('Da thay doi xong mat khau\n. Moi ban Thoat ra va dang nhap lai');
		window.top.location.href = '<?php echo URL_ADMIN?>logoff.php?go=<?php echo URL_ROOT?>logon.htm';
<?php	}
	else{ ?>
		window.alert('Khong thay doi duoc mat khau. Xin vui long lam lai');
		document.getElementsByName('ADpassword').item(0).focus();
	<?php } ?>
<?php }
?>
function checkForm(f){
	if(f.ADnewpassword.value != f.ADnewpassword2.value || !/^[a-zA-Z0-9]{6,50}$/.test(String(f.ADnewpassword.value))){
		window.alert('Mat khau khong  trung nhau hoac khong hop le.\n(Phai co 6-50 ky tu, chu cai hoac chu so)');
		return false;
	}else if(f.ADnewpassword.value == f.ADpassword.value){
		window.alert('Khong duoc su dung mat khau cu va mat khau moi trung nhau');
		return false;
	}
	return true;
}
</script>
<?php dbclose();?>