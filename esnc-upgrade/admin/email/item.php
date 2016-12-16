<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_EMAIL)){
	exit();
}
require '../config.php';
require('../inc/dbcon.php');
require(PATH_CLASS.'mailer.php');
require PATH_CLASS.'rte.php';
require PATH_ADMINCOMPLS.'itemlist.php';
class item extends mailer{	
	function show(){
		$this->sender=EMAIL_CONTACT;
		$rept = new itemflatlist;
		$rept->table='email';
		$rept->sortby=SORTBY_ID_ASC;
		$rept->ctrl = 1;
		$rept->open('`email`','`id` IN ('.$_GET['id'].')');
		$this->recipient='';	
		while($row=mysql_fetch_row($rept->rs)) $this->recipient .= ','.$row[0];
		$this->recipient{0}=' ';
		mysql_free_result($rept->rs);
		include PATH_ADMIN_FORM.'item-email.php';
		exit();
	}		
}
$o = new item();
$o->email = (string)$_GET['email'];
$o->doctitle='G&#7917;i Email';
$o->a_ctrl = &$EMAIL_CTRL;
switch($act){
case ACT_SEND:
	$o->sender = $_POST['from'];
	$o->recipient = $_POST['to'];
	$o->cc = $_POST['cc'];
	$o->subject = $_POST['subject'];
	if($_POST['rte_tag_content']) RTE::normalizeHTML($_POST['content']);
	$o->body = $_POST['content'];
	$o->mime = "text/html;charset=utf-8";			
	$o->send();
	redirect(URL_ADMIN.'/email/item-list.php');;
	break;
default:
	$o->email = (string)$_GET['EMemail'];
	$o->show();
}
?>
