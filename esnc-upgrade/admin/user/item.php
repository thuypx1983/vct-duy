<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_USER,ACCESS_READ|ACCESS_WRITE|ACCESS_NEW)){
	header('HTTP/1.0 404 Not Found');
	exit();
}
require '../config.php';
require('../inc/dbcon.php');
if($DB_R_NAME){
	dbclose();
	r_open($DB_R_HOST,$DB_R_USER_ADMIN,$DB_R_PWD_ADMIN,$DB_R_NAME);//open remote
}
require(PATH_CLASS.'user.php');
class item extends user{
	function save(){
		if($this->id > 0) return $this->updaterow();
		else return $this->addrow();
	}
	function show(){
		$this->loadonerow();
		include PATH_ADMIN_FORM.'item-user.php';
	}
}
$o = new item();
$o->id = (int)$_GET['id'];
$o->doctitle='T&Agrave;I KHO&#7842;N QU&#7842;N TR&#7882;';
$o->a_ctrl = $USER_CTRL;
$o->a_gender = &$USER_GENDER;
$o->a_alert = &$USER_ALERT;
switch($act){
case ACT_SAVE:
	$o->fetch();
	$o->save();
//	redirect(URL_GO);
	break;
default:
	$o->id = (int)$_GET['USid'];
	$o->show();
}
dbclose();
?>