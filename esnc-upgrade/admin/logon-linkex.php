<?php //tienpd@esnadvanced.com
require('../config.php');
require('inc/common.php');
require('config.php');
require('inc/dbcon.php');
require('../class/linkexchangeuser.php');
require('inc/session-linkex.php');

$t=$_COOKIE['scode'];
$t1=md5($_POST['fCode']);
if($t == $t1){
	$linkex_user = new linkexchangeuser();
	$linkex_user->email = @$_POST['fEmail'];
	$linkex_user->password = @$_POST['fPasswd'];
	if($linkex_user->checkaccess(1)){
		$linkex_userid = (int)$linkex_user->id;
		$_SESSION['linkex_userid'] = $linkex_userid;
		redirect('linkex.php');
	}else{
		$linkex_userid = -1;
		$_SESSION['linkex_userid'] = $linkex_userid;
		echo '<html><head><meta http-equiv="Refresh" content="0;url=\''.URL_ADMIN.'logon-linkex.htm\'" /><script type="text/javascript" language="javascript">window.location.href="'.URL_ADMIN.'logon-linkex.htm";</script></head></html>';
	}
}else{
	echo '<html><head><meta http-equiv="Refresh" content="0;url=\''.URL_ADMIN.'logon-linkex.htm\'" /><script type="text/javascript" language="javascript">window.location.href="'.URL_ADMIN.'logon-linkex.htm";</script></head></html>';
}
dbclose();
?>
