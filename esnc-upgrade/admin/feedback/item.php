<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_FEEDBACK)){
        echo "<script language='javascript'>window.top.location='../../';</script>";
        exit();
}
require '../config.php';
require("../inc/dbcon.php");
require('../../class/feedback.php');
class item extends feedback{
	var $act,$q,$alias='FB',$type=TABLE_FEEDBACK,$catalias='CF',$catid,$a_ctrl;
	function process(){
		global $session;
		switch ($this->act){
		case ACT_SAVE:
			$this->email = $session->email;
			$this->body = $_POST['body'];
			$this->subject = $_POST['subject'];
			if((int)$_POST['flag']){//also save
				$this->ctrl = FEEDBACK_CTRL_SHOW;
				$this->name = $session->name;
				if(!$this->addrow()) return false;
			}
			if(preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]+$/',$_POST['email'])){//if email is valid then sendmail
				include('../../class/mailer.php');
				$mr = new mailer;
				$mr->sender = $this->email;
				$mr->recipient = $_POST['email'];
				$mr->cc = $this->email;
				$mr->subject = $this->subject;
				$mr->body = $this->body;
				$mr->send();
			}
			return true;
		default:
			$this->id = (int)$_GET[$this->alias.'id'];
			$this->catid = (int)$_GET[$this->catalias.'id'];
			$this->show();
		}
	}
	function show(){
		$this->loadonerow();
		include('../forms/item-feedback.php');
		exit();
	}
}
$o = new item();
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->catid = $_GET[$o->catalias.'id'];
$o->type = TABLE_FEEDBACK;
$o->catalias = 'CF';
$o->a_ctrl = &$FEEDBACK_CTRL;
if($o->process()){ header("Location:item-list.php?".urlformat($o->q,'act',ACT_COPY,'id',$o->id,'catid',$o->catid,'CFid',$o->catid)); exit();}//redirect to copy product to list
$o->msg = "L&#7895;i khi c&#7853;p nh&#7853;t";
$o->show();
?>