<?php
require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_PRODUCT)){
        echo "<script language='javascript'>window.top.location='../../';</script>";
        exit();
}
require '../config.php';
require("../inc/dbcon.php");
require('../../class/product.php');
require PATH_CLASS.'rte.php';
$type=(int)$_REQUEST['type'];
if(!$type) $type=(int)$_REQUEST['PDtype'];

if(is_file(PATH_CLASS.'product-'.$type.'.php')){
	include PATH_CLASS.'product-'.$type.'.php';//contain ProductEx class definition
}else{
	class ProductEx extends Product{
		function __construct(){
			parent::__construct();
			$this->type = $GLOBALS['type'];
		}
	}
}
class item extends ProductEx{
	var $act,$q,$alias='PD',$type=TABLE_PRODUCT,$catalias='CP',$catid,$a_ctrl;
	function process(){
		switch ($this->act){
		case ACT_SAVE:
			$this->fetch();			
			$this->catid=(int)$_GET['catid'];
			$this->contentfile=$_POST['contentfile'];
			if(is_file(PATH_TEMP.$this->contentfile)) $this->detail = @file_get_contents(PATH_TEMP.$this->contentfile);
			$size1=(int)trim(@$_POST['size_img1']); $size2= (int)trim(@$_POST['size_img2']);	
			filemove($this->img1,PATH_TEMP,PATH_PRODUCT_IMG1,$size1);
			filemove($this->img2,PATH_TEMP,PATH_PRODUCT_IMG2,$size2);	
			if($this->id <= 0) $this->addrow();
			else $this->updaterow();
			if(is_writable(PATH_PRODUCT_DETAIL) && is_file(PATH_TEMP.$this->contentfile)){
				define('PRODUCT_DETAIL',PATH_PRODUCT_DETAIL.'product-'.$this->id.'.htm');
				@chmod(PRODUCT_DETAIL,0777);//make writable
				@unlink(PRODUCT_DETAIL);
				@rename(PATH_TEMP.$this->contentfile,PRODUCT_DETAIL);
				@chmod(PRODUCT_DETAIL,0555);//make read-only
			}
			include PATH_ADMINCOMPLS.'itemlist.php';
			$mylist = new itemlist();
			$mylist->table='product';
			$mylist->id=$this->id;
			$mylist->catid=$this->catid;
			$mylist->copyto();//copy to category
		return TRUE;
		default:
			$this->id = (int)$_GET[$this->alias.'id'];
			$this->catid = (int)$_GET[$this->catalias.'id'];
			$this->type = (int)$_GET['type'];
			$this->show();
		}
	}
	function show(){
		$rte = new RTE('oRte','images/rteimages/',0x7FFFFFFF);
		if($this->id > 0) $this->loadonerow();
		if($this->type == 0) $this->type = (int)$_GET['type'];//allow to overwrite type for unspecified type
		$this->contentfile=getuniquename().'.txt';
		if(!@copy(PATH_PRODUCT_DETAIL.'product-'.$this->id.'.htm',PATH_TEMP.$this->contentfile))
			@file_put_contents(PATH_TEMP.$this->contentfile,$this->detail);
		if($this->type){
			include(PATH_ADMIN_FORM.'item-product-'.$this->type.'.php');			
		}
		else 
			include(PATH_ADMIN_FORM.'item-product.php');
		dbclose();
	}
}
$o = new item();
$o->doctitle='Chi ti&#7871;t s&#7843;n ph&#7849;m';
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = URL_SELF;
$o->catid = $_GET[$o->catalias.'id'];
$o->type = TABLE_PRODUCT;
$o->catalias = 'CP';
$o->a_ctrl = &$PRODUCT_CTRL;
$o->a_type = &$PRODUCT_TYPE;
if($o->process()) redirect('item-list.php?'.urlformat($o->q,'act','','id',$o->id,'catid',$o->catid,'CPid',$o->catid));
$o->msg = "L&#7895;i khi c&#7853;p nh&#7853;t";
//$o->show();
?>
