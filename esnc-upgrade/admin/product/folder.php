<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_PRODUCT)){
        echo "<script language='javascript'>window.top.location='../../';</script>";
        exit();
}
require '../config.php';
require("../inc/dbcon.php");
require PATH_CLASS.'catproduct.php';
require PATH_CLASS.'rte.php';

class catitem extends catproduct{
	var $act,$q,$alias='CP',$type=TABLE_CATPRODUCT;
	function process(){

		switch ($this->act){
		case ACT_SAVE:
		$this->id = (int)$_GET['id'];
		$this->parentid = (int)$_POST['parentid'];
		$this->name=(string)$_POST['name'];
		$this->desc=(string)$_POST['desc'];
		$this->view=(int)$_POST['view'];
		$this->ctrl=(int)$_POST['ctrl'];
		$this->img1 = $_POST['img1'];
		$this->alt1 = $_POST['alt1'];
		$this->urlrewrite = $_POST['urlrewrite'];
		$size1=(int)trim(@$_POST['size_img1']);
		if(is_file(PATH_TEMP.$this->img1)) @rename(PATH_TEMP.$this->img1,PATH_CATPRODUCT_IMG1.$this->img1);
		resize_image(PATH_CATNEWS_IMG1,$this->img1,$size1);
		if($this->id == 0){//save with id=0 -> create
			return $this->addrow();
		}else if($this->id > 0){ return $this->updaterow();}
		return false;
		default:
			$this->id = (int)$_GET[$this->alias.'id'];
			$this->show();
		}
	}
	function show(){
		$this->loadonerow();
		include PATH_ADMIN_FORM.'folder.php';
		dbclose();
		exit();
	}
}
$o = new catitem();
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->type = TABLE_CATPRODUCT;
$o->url = URL_SELF;
$o->alias = 'CP';
$o->a_ctrl = &$CATPRODUCT_CTRL;
$o->url_img1 = URL_CATPRODUCT_IMG1;
if($o->process()){ redirect('index.php?'.urlmodify('act',NULL,'id',NULL,'parentid',NULL,$o->alias.'parentid',$o->parentid)); exit();}//redirect to copy product to list
$o->msg = "L&#7895;i khi c&#7853;p nh&#7853;t";
$o->show();
?>