<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_POLL)){
	exit();
}
require '../config.php';
require('../inc/dbcon.php');
require(PATH_CLASS.'poll.php');
class item extends poll{
	function save(){
		$this->fetch();
		$this->a_vote=$_POST['PO'];
		if($this->id > 0) $this->updaterow(); else $this->addrow();
		$this->updatevote();
	}
	function show(){
		if($this->id > 0){
			$this->loadonerow();
			$this->loadvote();
			if($this->num > 0)
				include '../forms/item-poll-show.php';
			else 
				include('../forms/item-poll.php');
		}else{
			$this->a_vote=array();
			include('../forms/item-poll.php');
		}
		exit();
	}
}
$o = new item();
$o->doctitle='&#272;i&#7873;u tra th&#7883; tr&#432;&#7901;ng';
$o->a_ctrl = &$POLL_CTRL;
$o->a_type = &$POLL_TYPE;
switch($act = $_REQUEST['act']){
case ACT_SAVE:
	$o->save();
	redirect(URL_GO);
	break;
default:
	$o->id = (int)$_REQUEST['PLid'];
	$o->show();
}
?>
