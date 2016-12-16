<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_AGENT)){
        echo "<script language='javascript'>window.top.location='../../';</script>";
        exit();
}
require '../config.php';
require("../inc/dbcon.php");
require PATH_CLASS.'agent.php';
require PATH_CLASS.'rte.php';

class item extends agent{
	var $act,$q,$alias='AG',$type=TABLE_AGENT,$a_ctrl,$a_type;
	function process(){
		switch ($this->act){
		case ACT_SAVE:
			$this->id=(int)$_GET['id'];
			$this->catid=(int)$_GET['catid'];
			$this->name=(string)$_POST['name'];
			$this->address=(string)$_POST['address'];
			$this->cityid=(string)$_POST['cityid'];
			$this->city=(string)$_POST['city'];
			$this->detail=(string)$_POST['detail'];
			$this->phone=(string)$_POST['phone'];
			$this->img=(string)$_POST['img'];
			filemove($this->img,PATH_TEMP,PATH_AGENT_IMG);
			$this->alt=(string)$_POST['alt'];
			$this->contact=(string)$_POST['contact'];
			$this->email=(string)$_POST['email'];
			$this->contactphone=(string)$_POST['contactphone'];
			$this->ctrl=@array_sum($_POST['ctrl']);
			$this->website=(string)$_POST['website'];
			$this->fax=(string)$_POST['fax'];
			$this->countryid=(string)$_POST['countryid'];
			$this->country=(string)$_POST['country'];
			$this->view=(int)$_POST['view'];
			$this->type = (int)$_POST['type'];
			if($this->id <= 0) return $this->addrow();
			else return $this->updaterow();
		default:
			$this->id = (int)$_GET[$this->alias.'id'];
			$this->show();
		}
	}
	function show(){
		$this->loadonerow();
		include('../forms/item-agent.php');
		dbclose();
		exit();
	}
}
$o = new item();
$o->doctitle='C&#417; s&#7903;';
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->catid = $_GET[$o->catalias.'id'];
$o->a_ctrl = &$AGENT_CTRL;
$o->a_type = &$AGENT_TYPE;
if($o->process()) redirect(URL_GO);
$o->msg = "L&#7895;i khi c&#7853;p nh&#7853;t";
$o->show();
?>
