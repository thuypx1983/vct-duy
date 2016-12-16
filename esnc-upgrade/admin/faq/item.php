<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_FAQ)){
	exit();
}
require '../config.php';
require('../inc/dbcon.php');
require(PATH_CLASS.'faq.php');
require PATH_CLASS.'rte.php';
class item extends faq{
	function save(){
		if($this->id >0) return $this->updaterow();
		else return $this->addrow();
	}
	function show(){
		$rte = new RTE('oRte','images/rteimages/',0x7FFFFFFF & ~ 0x00000020);	
		$this->loadonerow();
		include('../forms/item-faq.php');
		exit();
	}
}
$o = new item();
$o->id = (int)$_GET['id'];
$o->doctitle='H&#7886;I &#272;&Aacute;P';
$o->a_ctrl = &$FAQ_CTRL;
switch($act){
case ACT_SAVE:
	$o->fetch();
	$o->save();
	redirect(URL_GO);
	break;
default:
	$o->id = (int)$_GET['FAid'];
	$o->show();
}
?>
