<?php 
session_cache_limiter('nocache');
session_name('ESNC_LINKEXID');
session_set_cookie_params(0,URL_ADMIN);
session_cache_expire(SESSION_TIMEOUT);
session_save_path(PATH_ADMIN_SESSION);
session_start();

if($_SESSION['linkex_userid']!=NULL){
	$linkex_userid = (int)$_SESSION['linkex_userid'];
	if($linkex_userid===-1){
		echo '<html><head><meta http-equiv="Refresh" content="0;url=\''.URL_ADMIN.'logon-linkex.htm\'" /><script type="text/javascript" language="javascript">window.location.href="'.URL_ADMIN.'logon-linkex.htm";</script></head></html>';
	}else{
		$linkex_user = new linkexchangeuser();
		$linkex_user->id = $linkex_userid;
		$linkex_user->loadonerow();
	}
}else{
	echo '<html><head><meta http-equiv="Refresh" content="0;url=\''.URL_ADMIN.'logon-linkex.htm\'" /><script type="text/javascript" language="javascript">window.location.href="'.URL_ADMIN.'logon-linkex.htm";</script></head></html>';
}
?>