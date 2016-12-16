<?php	//vinhtx@esnadvanced.com
require('../config.php');
require('inc/common.php');
require('config.php');
require('inc/session.php');
require('inc/dbcon.php');
if($DB_R_NAME != ''){
	dbclose();
	r_open($DB_R_HOST,$DB_R_USER_ADMIN,$DB_R_PWD_ADMIN,$DB_R_NAME);//open remote
}
$email=$_POST['fEmail'];
$pass=$_POST['fPasswd'];
if($_POST['password'] != ''){
	if($pwd=appsession::getpassword($email)){
		include PATH_CLASS.'mailer.php';
		$mr=new mailer;
		$mr->sender=EMAIL_WEBMASTER;
		$mr->recipient = $email;
		$mr->bcc = 'webmaster@esnc.net';
		$mr->subject='Gui lai mat khau';
		$mr->body = 'Mat khau cua ban la:'.$pwd;
		$mr->send();
		showloadscreen('logon.htm',10,'Mat khau da gui lai.Xin kiem tra email');
		exit();
	}else{
		showloadscreen('logon.htm',15,'Khong tim thay mat khau.Email khong dung hoac tai khoan bi khoa.');
		exit();
	}
}
$t=$_COOKIE['scode'];
$t1=md5($_POST['fCode']);
if($t == $t1){
	if($session->logon($email,$pass,SESSION_CTRL_ADMIN) && $session->getaccess(SESSION_CTRL_ADMIN)) {
		include PATH_CLASS.'cache.php';
		cache::toggle(FALSE);
		setcookie('scode','',time()-42000);//clear scode
/**CHECK FOR UPDATE, COMPABILITY HERE**/
if(UPDATE_CTRL){
	call_user_func(_esnc_check_update,ESNC_VERSION);
}
/**END CHECK FOR UPDATE AND COMPABILITY**/
		if($session->pwdexpires){
			redirect(URL_ADMIN.'passwd.php');
			exit();
		}
		showloadscreen(URL_ADMIN,3,'&#272;ang &#273;&#259;ng nh&#7853;p...<script language="javascript">document.cookie="scode=0; expires=" + (new Date()).toGMTString();</script>');
		dbclose();
		exit();
	}
}else{
}
dbclose();
echo '<html><head><meta http-equiv="Refresh" content="0;url=\''.URL_ADMIN.'logon.htm\'" /><script type="text/javascript" language="javascript">window.location.href="'.URL_ADMIN.'logon.htm";</script></head></html>';
//we do not use header: as it will ignore cookie
?>
