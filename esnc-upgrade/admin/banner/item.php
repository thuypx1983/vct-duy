<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_BANNER)){
        echo "<script language='javascript'>window.top.location='".URL_ROOT."'</script>";
        exit();
}
require '../config.php';
require("../inc/dbcon.php");
require('../../class/banner.php');
class banneritem extends bannerlink{
	var $act,$q,$alias='BN',$type=TABLE_BANNER,$catalias='CB',$catid,$a_ctrl;
	function process(){

		switch ($this->act){
		case ACT_SAVE:
			$this->fetch();
			$this->catid=(int)$_GET['catid'];
			$this->a_cat=array($this->catid);
			$this->ctrl=(int)@array_sum($_POST['ctrl']);
			if(($_POST['flag'] & 1) && $this->isduplicated()) return FASLE;
			$size1=(int)trim(@$_POST['size_img1']);	
			filemove($this->img,PATH_TEMP,PATH_BANNER_IMG,$size1);
			if((int)$this->id <= 0){			
				if($_POST['flag2'])  $this->addoverwrite();
				else $this->addrow();
				
			}
			else  $this->updaterow();
			include PATH_ADMINCOMPLS.'itemlist.php';
			$mylist = new itemlist();
			$mylist->table='banner';
			$mylist->id=$this->id;
			$mylist->catid=$this->catid;
			$mylist->copyto();//copy to category
			return TRUE;
		default:
			$this->id = (int)$_GET[$this->alias.'id'];
			$this->catid = (int)$_GET[$this->catalias.'id'];
			$this->show();
		}
	}
	function show(){
		$this->loadonerow();
		if($this->id <= 0){
			$this->target='_blank';//default to open new window
			$rs = mysql_select('`a`.`ctrl` ','`#catbanner` as `a`','`a`.`id`='.$this->catid);
			if($row=mysql_fetch_row($rs)){
				if($row[0] & 0x00000040) $this->ctrl = BANNER_CTRL_SHOW | 0x02000000;//auto link-exchange fo new item if category is link-exchange
			}
			mysql_free_result($rs);
		}
		include('../forms/item-banner.php');
		exit();
	}
}
$o = new banneritem();
$o->doctitle='T&#7841;o ho&#7863;c s&#7917;a li&ecirc;n k&#7871;t, banner';
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->catid = (int)$_GET['catid'];
$o->type = TABLE_BANNER;
$o->catalias = 'CB';
$o->a_ctrl = &$BANNER_CTRL;
$o->a_status = &$BANNER_STATUS;
if($o->process()){ 
	$pagesize = (int)$_GET[$o->alias.'pagesize'];
	if($pagesize > 200 || $pagesize < 20) $pagesize=20;
	$page = $o->lookup($pagesize);
	redirect('item-list.php?'.$o->catalias.'id='.$o->a_cat.'&'.$o->alias.'page='.$page);//redirect to page which containt item
}
$o->msg = "L&#7895;i khi c&#7853;p nh&#7853;t";
$o->show();
?>
