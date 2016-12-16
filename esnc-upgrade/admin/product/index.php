<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_PRODUCT)){
        echo "<script language='javascript'>window.top.location='../../';</script>";
        exit();
}
require '../config.php';
require("../inc/dbcon.php");
require("../admincompls/folderlist.php"); 
class catlist extends folderlist{
	var $a_ctrl,$q,$flag,$alias,$url,$allowpaste,$type,$doctitle;
	function process(){

		switch($this->act){
			case ACT_OPEN:
			case ACT_LIST:
			case ACT_SEARCH:
				$this->parentid = (int)$_GET["{$this->alias}parentid"];
				$this->pagesize = (int)$_GET["{$this->alias}pagesize"];
				$this->page = (int)$_GET["{$this->alias}page"];
				$this->keyword = (string)$_GET["{$this->alias}keyword"];
				$this->ctrl = (int)$_GET["{$this->alias}ctrl"];
				$this->ctrl_ = (int)$_GET["{$this->alias}ctrl_"];
				$this->sortby = (int)$_GET["{$this->alias}sortby"];
				$this->show();
				exit();
			case ACT_ADD:
				include_once('../../class/catproduct.php');
				$item = new catproduct();
				$item->parentid = $this->parentid = (int)$_GET["parentid"];
				$item->name = (string)$_GET["name"];
				$item->desc= (string)$_GET["desc"];
				$item->view = (int)$_GET["view"];
				$item->ctrl = (int)$_GET["ctrl"];
				$item->addrow();
				$this->pagesize = (int)$_GET["{$this->alias}pagesize"];
				$this->page = (int)$_GET["{$this->alias}page"];
				$this->show();
				exit();
			case ACT_SET:
				$this->ctrl = (int)$_GET["ctrl"];
				$this->nctrl = (int)$_GET["nctrl"];
				$this->id=(string)$_GET["id"];
				$this->setctrl();
				$this->q = urlchop($this->q,"id","ctrl");
				$this->parentid = (int)$_GET["{$this->alias}parentid"];
				$this->pagesize = (int)$_GET["{$this->alias}pagesize"];
				$this->page = (int)$_GET["{$this->alias}page"];
				$this->keyword = (string)$_GET["{$this->alias}keyword"];
				$this->sortby = (int)$_GET["{$this->alias}sortby"];
				$this->ctrl = (int)$_GET["{$this->alias}ctrl"];
				$this->show();
				exit();
			case ACT_UNSETCTRL:
				$this->ctrl = (int)$_GET["ctrl"];
				$this->id=(string)$_GET["id"];
				$this->unsetctrl();
				$this->q = urlchop($this->q,"id","ctrl");
				$this->parentid = (int)$_GET["{$this->alias}parentid"];
				$this->pagesize = (int)$_GET["{$this->alias}pagesize"];
				$this->page = (int)$_GET["{$this->alias}page"];
				$this->keyword = (string)$_GET["{$this->alias}keyword"];
				$this->sortby = (int)$_GET["{$this->alias}sortby"];
				$this->ctrl = (int)$_GET["{$this->alias}ctrl"];
				$this->show();
				exit();
			case ACT_RENAME:
				$this->name = (string)$_GET["name"];
				$this->id = (int)$_GET["id"];
				echo ($this->ren() ? "parent.banner.setStatus('&#272;&#7893;i t&ecirc;n th&agrave;nh c&ocirc;ng');" : "parent.banner.setStatus('L&#7895;i khi &#273;&#7893;i t&ecirc;n');input.value=exvalue;");
				dbclose();
				exit();
			case ACT_REORDER:
				$this->idvalue = (string)$_GET['idvalue'];
				echo $this->reorder() ? "parent.banner.setStatus('Thay &#273;&#7893;i th&agrave;nh c&ocirc;ng');":"parent.banner.setStatus('L&#7895;i khi thay &#273;&#7893;i');self.document.reload();";
				dbclose();
				exit();//not open
			case ACT_REMOVE:
				$this->id = (string)$_GET['id'];
				$this->del();
				$this->q = urlchop($this->q,'id');
				$this->parentid = (int)$_GET["{$this->alias}parentid"];
				$this->pagesize = (int)$_GET["{$this->alias}pagesize"];
				$this->page = (int)$_GET["{$this->alias}page"];
				$this->keyword = (string)$_GET["{$this->alias}keyword"];
				$this->sortby = (int)$_GET["{$this->alias}sortby"];
				$this->ctrl = (int)$_GET["{$this->alias}ctrl"];
				$this->show();
				exit();
			case ACT_MOVE:
				$this->id = (string)$_GET['id'];
				$this->parentid = (int)$_GET["{$this->alias}parentid"];
				$this->moveto();
				$this->q = urlchop($this->q,"id");
				$this->pagesize = (int)$_GET["{$this->alias}pagesize"];
				$this->page = (int)$_GET["{$this->alias}page"];
				$this->keyword = (string)$_GET["{$this->alias}keyword"];
				$this->sortby = (int)$_GET["{$this->alias}sortby"];
				$this->ctrl = (int)$_GET["{$this->alias}ctrl"];
				$this->show();
				exit();
		}
	}
	function show(){
		$this->open();
		include('../forms/folder-list.php');
	}
}//class
$o = new catlist;
$o->type=$o->allowpaste=TABLE_PRODUCT;
$o->a_ctrl = &$CATPRODUCT_CTRL;//array of constants definition
$o->table='catproduct';
$o->tbitem='product';
$o->flag=&$FOLDER_FLAG;
$o->alias='CP';
$o->url=URL_SELF;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->doctitle = "Qu&#7843;n l&yacute; s&#7843;n ph&#7849;m";
$o->process();
/*$o->act = (int)$_GET['_act'];//if break, process with next action, SEARCH|OPEN
$o->process();*/
?>