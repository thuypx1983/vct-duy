<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_UTILITY)){
        echo "<script language='javascript'>window.top.location='../../'</script>";
        exit();
}
require '../config.php';
require("../inc/dbcon.php");
require PATH_CLASS.'utility.php';
require PATH_CLASS.'rte.php';
class utilityitem extends utility{
	var $act,$q,$alias='UT',$type=TABLE_UTILITY,$catalias='CU',$catid,$a_ctrl;
	function process(){

		switch ($this->act){
		case ACT_SAVE:
			$this->id=(int)$_GET['id'];
			$this->catid=(int)$_GET['catid'];
			$this->name=(string)$_POST['name'];
			$this->summary=(string)$_POST['summary'];
			$this->path=(string)$_POST['path'];
			is_file(PATH_TEMP.$this->path) and @rename(PATH_TEMP.$this->path,PATH_UTILITY_PATH.$this->path);
			$this->filename=(string)$_POST['filename'];
			$this->img=(string)$_POST['img'];
			is_file(PATH_TEMP.$this->img) and @rename(PATH_TEMP.$this->img,PATH_UTILITY_IMG.$this->img);
			$this->alt=(string)$_POST['alt'];
			$this->view=(int)$_POST['view'];
			$this->ctrl=(int)@array_sum($_POST['ctrl']);
			$this->keyword=(string)$_POST['keyword'];
			if($this->id <= 0) return $this->addrow();
			else return $this->updaterow();
		default:
			$this->id = (int)$_GET[$this->alias.'id'];
			$this->catid = (int)$_GET[$this->catalias.'id'];
			$this->show();
		}
	}
	function show(){
		$this->loadonerow();
		include PATH_ADMIN_FORM.'item-utility.php';
		dbclose();
		exit();
	}
}
$o = new utilityitem();
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->catid = $_GET[$o->catalias.'id'];
$o->type = TABLE_UTILITY;
$o->catalias = 'CU';
$o->a_ctrl = &$UTILITY_CTRL;
if($o->process()){ header("Location:item-list.php?".urlformat($o->q,'act',ACT_COPY,'id',$o->id,'catid',$o->catid,'CUid',$o->catid)); exit();}//redirect to copy product to list
$o->msg = "L&#7895;i khi c&#7853;p nh&#7853;t";
$o->show();
dbclose();
?>