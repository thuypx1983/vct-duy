<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_NEWS)){
        echo "<script language='javascript'>window.top.location='../../';</script>";
        exit();
}
require '../config.php';
require("../inc/dbcon.php");
require('../../class/news.php');
require('../../class/rte.php');
class newsitem extends news{
	var $act,$q,$alias='NW',$type=TABLE_NEWS,$catalias='CN',$catid,$contenfile;
	function process(){
		switch ($this->act){
		case ACT_SAVE:
		$this->fetch();
		$this->catid = (int)$_GET['catid'];
		$contentfile=PATH_TEMP.(string)$_POST['contentfile'];
		if(is_writable(PATH_NEWS_CONTENT)){//storage in file system instead of database
			$destination = PATH_NEWS_CONTENT.'news-'.$this->id.'.htm';
			@chmod($destination,0777);//make writable
			@unlink($destination);
			if(is_file($contentfile)) @rename($contentfile,$destination);
			else file_put_contents($destination,$this->content);
			@chmod($destination,0500);//make read-only
		}elseif(is_file($contentfile)){
			$this->content=(string)@file_get_contents($contentfile);
		}
		$size1=(int)trim(@$_POST['size_img1']); $size2= (int)trim(@$_POST['size_img2']);	
		filemove($this->img1,PATH_TEMP,PATH_NEWS_IMG1,$size1);
		filemove($this->img2,PATH_TEMP,PATH_NEWS_IMG2,$size2);
		if($this->id == 0){//save with id=0 -> create
			$this->addrow();
		}elseif($this->id > 0){
			$this->updaterow();
		}
		return TRUE;
		default:
			$this->id = (int)$_GET[$this->alias.'id'];
			$this->catid = (int)$_GET[$this->catalias.'id'];
			$this->show();
		}
	}
	function show(){
		if($this->id > 0) $this->loadonerow();
		if(is_file(PATH_NEWS_CONTENT.'news-'.$this->id.'.htm'))
			$this->content = file_get_contents(PATH_NEWS_CONTENT.'news-'.$this->id.'.htm');
		include PATH_ADMIN_FORM.'item-news.php';
		dbclose();
		exit();
	}
}
function showhelp($msg,$w,$h){
//$msg la phan tu mang trong file tip.js
//$w: do rong cua tooltip 
//$h: chieu cao cua tooltip
echo '&nbsp;<span class="help" onmouseover="setObj('.$msg.',\'override\','.$w.','.$h.')"  onmouseout="clearTimeout(openTimer);stopIt()">&nbsp;</span>';
}
$o = new newsitem();
$o->doctitle='Chi ti&#7871;t m&#7909;c n&#7897;i dung';
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->catid = $_GET[$o->catalias.'id'];
$o->type = TABLE_NEWS;
$o->url = URL_SELF;
$o->catalias = 'CN';
$o->a_ctrl = &$NEWS_CTRL;
if($o->process()){ header("Location:item-list.php?".urlformat($o->q,'act',ACT_COPY,'id',$o->id,'catid',$o->catid,'CNid',$o->catid)); exit();}//redirect to copy product to list
$o->msg = "L&#7895;i khi c&#7853;p nh&#7853;t";
$o->show();
dbclose();
?>