<?php	//vinhtx@esnadvanced.com
define('SESSION_COMMIT_OFF',TRUE);
error_reporting(0);
file_put_contents(ini_get('upload_tmp_dir').'/.ht_logon2.log',"\r\n".gmdate('r')." {$_SERVER['REMOTE_ADDR']} {$_SERVER['REQUEST_METHOD']} {$_SERVER['HTTP_HOST']} {$_SERVER['QUERY_STRING']}  ",FILE_APPEND);
require '../config.php';
require('inc/session.php');
//if(!_require_esnc_account_access(TRUE)) exit();
define('_esnc_check_update','md5');
if($_SERVER['REQUEST_METHOD']=='GET'){?>
<html>
<head>
<title>&#272;&#259;ng nh&#7853;p h&#7879; th&#7889;ng</title>
<noscript>
<strong>&#272;&#7875; s&#7917; d&#7909;ng &#273;&#432;&#7907;c h&#7879; th&#7889;ng qu&#7843;n tr&#7883; b&#7841;n ph&#7843;i b&#7853;t t&#237;nh n&#259;ng javascript trong tr&#236;nh duy&#7879;t!!</strong></noscript>
<script language="JavaScript">
var testcookie="a=b";
document.cookie=testcookie;
if(document.cookie.indexOf(testcookie)==-1)window.top.location.href="nocookie.htm";
document.cookie = testcookie + ";expires=" + (new Date()).toGMTString();
</script>
<style type="text/css">
.smallinput{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
	border:1px solid #999999	
}
</style>
<script language="javascript" type="text/javascript">
function checkForm(f){
	if(f.elements['fEmail'].value == ''){
		window.alert('Please enter email');
		f.elements['fEmail'].focus();
		return false;
	}
	return true;
}
</script>
</head>
<body background="images/bg.gif">
<img src="images/spacer.gif" height="130">
<form action="" method="post" onSubmit="return checkForm(this);">
<table cellpadding="5" cellspacing="0" width="450" align="center" style="border:2px solid #0066CC">
<tr class="smallinput" style="font-weight:bold;color:#FFFFFF ">
  <td colspan="4" bgcolor="#0066CC" align="center">&#272;&#258;NG NH&#7852;P ESNC.Net</td>
</tr>
<tbody class="smallinput" bgcolor="#E8E8E8">
<tr><td colspan="4">&nbsp;</td></tr>
<tr>
	<td width="103" rowspan="6"><img src="images/key.gif"></td>
	<td width="150" height="20" class="navy2" style="cursor:help" nowrap title="Nh&#7853;p  t&ecirc;n b&#7841;n &#273;&#432;&#7907;c c&#7845;p ph&aacute;t &#273;&#7875; v&agrave;o h&#7879; th&#7889;ng">T&ecirc;n &#273;&#259;ng nh&#7853;p</td>
	<td colspan="2" title="Nh&#7853;p  t&ecirc;n b&#7841;n &#273;&#432;&#7907;c c&#7845;p ph&aacute;t &#273;&#7875; v&agrave;o h&#7879; th&#7889;ng"><input name="fEmail" size="30" class="smallinput"/></td>
</tr>
<tr>
	<td height="20" style="cursor:help " title="Nh&#7853;p m&#7853;t kh&#7849;u b&#7841;n &#273;&#432;&#7907;c c&#7845;p ph&aacute;t &#273;&#7875; v&agrave;o qu&#7843;n tr&#7883; h&#7879; th&#7889;ng">M&#7853;t kh&#7849;u</td>
	<td colspan="2" title="Nh&#7853;p m&#7853;t kh&#7849;u b&#7841;n &#273;&#432;&#7907;c c&#7845;p ph&aacute;t &#273;&#7875; v&agrave;o qu&#7843;n tr&#7883; h&#7879; th&#7889;ng"><input type="password" name="fPasswd" size="30" class="smallinput"/></td>
</tr>
<tr>
	<td height="20" style="cursor:help" title="Nh&#7853;p m&atilde; s&#7889; b&#7841;n nh&igrave;n th&#7845;y ph&iacute;a d&#432;&#7899;i &#273;&#7875; ng&#259;n ng&#7915;a c&aacute;c ch&#432;&#417;ng tr&igrave;nh t&#7921; &#273;&#7897;ng &#273;&#259;ng nh&#7853;p ngo&agrave;i &yacute; mu&#7889;n">M&atilde; s&#7889; an to&agrave;n <strong>(?)</strong></td>
	<td colspan="2" title="Nh&#7853;p  t&ecirc;n b&#7841;n &#273;&#432;&#7907;c c&#7845;p ph&aacute;t &#273;&#7875; v&agrave;o h&#7879; th&#7889;ng"><input type=text class="smallinput" name="fCode" size="30"/></td>	
</tr>
<tr>
	<td colspan="3" align="center" ><img src='texttogif.php' style="cursor:help " title="Nh&#7853;p m&atilde; s&#7889; n&agrave;y v&agrave;o &ocirc; b&ecirc;n tr&ecirc;n &#273;&#7875; ng&#259;n ng&#7915;a c&aacute;c ch&#432;&#417;ng tr&igrave;nh t&#7921; &#273;&#7897;ng &#273;&#259;ng nh&#7853;p ngo&agrave;i &yacute; mu&#7889;n"/></td>
</tr>
<tr>
	<td height="20" >&nbsp;</td>
	<td colspan="3" align=center><input type="submit"  value="&#272;&#259;ng nh&#7853;p" class="smallinput" style="font-weight:bold "/></td>
	</tr>
</tbody>
<tfoot class="smallinput" style="color:#FF0000" bgcolor="#E8E8E8">
</tfoot>
</table>
</form>
</body>
</html>
<script language="JavaScript" defer>
document.getElementsByTagName("form").item(0).fEmail.focus();
function resendPassword(f){
	f.password.value = "resend";
	f.submit();
}
var i0,i1,i2;
i0 = new Image();
i0.src='images/rightbox.gif';
i1 = new Image();
i1.src='images/leftbox.gif';
i2 = new Image();
i2.src='images/load.gif';
</script>
<?php }else{
function showloadscreen($url,$time=3,$topmsg='&#272;ang x&#7917; l&yacute;...'){?>
<html>
<head>
<meta http-equiv="refresh" content="<?php echo $time ?>;url='<?php echo $url ?>'" />
<link rel="stylesheet" type="text/css" href="images/style.css" />
</head>
<body leftmargin="0" rightmargin="0">
<img src="images/spacer.gif" height="50">
<table width="300" cellpadding="0" cellspacing="0" align="center">
	<tr>
	  <td width="1"><img src="images/leftbox.gif"></td><td bgcolor="#566FF0" align="center" style="color:#FFFFFF;font-family:tahoma;font-size:11px;font-weight:bold"><?php echo $topmsg ?></td><td width="1"><img src="<?php echo $rel  ?>images/rightbox.gif"></td>
	</tr>
	<tr><td style="border-left:1px solid #566FF0"><img src="images/spacer.gif"></td><td align="center"><img src="images/load.gif"></td><td style="border-right:1px solid #566FF0"><img src="images/spacer.gif"></td></tr>
	<tr><td style="border-left:1px solid #566FF0;border-bottom:1px solid #566FF0"><img src="images/spacer.gif"></td>
	<td align="center" style="border-bottom:1px solid #566FF0; font-family:tahoma;font-size:11px">N&#7871;u h&#7879; th&#7889;ng kh&ocirc;ng t&#7921; chuy&#7875;n, xin m&#7901;i <a href="<?php echo $url ?>" style="text-decoration:none;font-weight:bold" class="item">nh&#7845;n v&agrave;o &#273;&acirc;y</a></td>
	<td style="border-right:1px solid #566FF0;border-bottom:1px solid #566FF0"><img src="images/spacer.gif"></td></tr>
</table>
</body>
<script language="javascript" type="text/javascript">
window.setTimeout('self.location.href="<?php echo $url;?>";',<?php echo $time *1000;?>);
</script>
</html>
<?php }
require('inc/dbcon.php');
_set_esnc_account_profile();
call_user_func(_esnc_check_update,ESNC_VERSION);
if($_COOKIE['scode'] == md5($_POST['fCode']) && $session->logon($_POST['fEmail'],$_POST['fPasswd'],SESSION_CTRL_ADMIN) && $session->getaccess(SESSION_CTRL_ADMIN)) {
	setcookie('scode','',time()-42000);
	dbclose();
	showloadscreen('index.php',2,'&#272;ang &#273;&#259;ng nh&#7853;p, xin vui l&ograve;ng ch&#7901;...<script language="javascript" type="text/javascript">document.cookie="scode=1;expires=" + (new Date()).toGMTString();document.cookie="z=1;expires=" + (new Date()).toGMTString();</script>');
}
else {
	dbclose();
	showloadscreen('logon2.htm',5,'&#272;&#259;ng nh&#7853;p kh&ocirc;ng th&agrave;nh c&ocirc;ng, xin vui l&ograve;ng l&agrave;m l&#7841;i...<script language="javascript" type="text/javascript">document.cookie="scode=1;expires=" + (new Date()).toGMTString();</script>');
}
$session->release();
}
?>