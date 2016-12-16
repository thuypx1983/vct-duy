<?php require("../config.php"); 
require('./inc/common.php');
require("./inc/session.php");
require './config.php';
require 'inc/dbcon.php';
require PATH_CLASS.'cache.php';
$session->logoff();
$go = URL_GO;
if($go=='') $go=URL_BASE;
if(UPDATE_CTRL) call_user_func(_esnc_check_update,ESNC_VERSION);
showloadscreen($go,3,'&#272;ang tho&aacute;t ra...<script language="javascript" type="text/javascript>" >document.cookie="'.session_name().'=0;expires=" + (new Date()).toGMTString();</script>');
cache::clear();
cache::toggle(TRUE);
dbclose();
?>