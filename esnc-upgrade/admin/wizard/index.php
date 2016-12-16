<?php
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
require('../config.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_WIZARD)){
	exit('<script language="javascript">window.top.location="../../";</script>');
}
require('../inc/dbcon.php');
require("../admincompls/folderlist.php"); 
class catlist extends folderlist{
	var $a_ctrl,$q,$flag,$alias,$url,$allowpaste,$type,$doctitle;
	function process(){
		global $debug;
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
				include_once('../../class/wizard.php');
				$item = new wizard();
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
				exit();
			case ACT_REORDER:
				$this->idvalue = (string)$_GET['idvalue'];
				echo $this->reorder() ? "parent.banner.setStatus('Thay &#273;&#7893;i th&agrave;nh c&ocirc;ng');":"parent.banner.setStatus('L&#7895;i khi thay &#273;&#7893;i');self.document.reload();";
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
	function check(){
		return CAT_FLAG_ROOT;
	}
	function open(){
		global $debug,$sql;
		switch($this->sortby){
			case SORTBY_NAME_ASC: $sr = ' ORDER BY `tb`.`name` ASC'; break;
			case SORTBY_NAME_DESC: $sr = ' ORDER BY `tb`.`name` DESC'; break;
			case SORTBY_VIEW_DESC: $sr = ' ORDER BY `tb`.`view` DESC'; break;
			default:
				$this->sortby=SORTBY_VIEW_ASC;//default to sort by view ascending
				$sr = ' ORDER BY `tb`.`view` ASC,`tb`.`id` ASC';
		}
		$hint = str_replace('*','%',mysql_escape_string($this->keyword));
		if($hint != ''){
			if($wh != '') $wh .= " AND `tb`.`name` LIKE '{$hint}'";
			else $wh = "WHERE `tb`.`name` LIKE '{$hint}'";
		}
		if($this->ctrl){
			if($this->ctrl_){
				if($wh != '') $wh .= " AND `tb`.`ctrl` & {$this->ctrl} = 0";
				else $wh = " WHERE `tb`.`ctrl` & {$this->ctrl} = 0";
			}else{
				if($wh != '') $wh .= " AND `tb`.`ctrl` & {$this->ctrl} = {$this->ctrl}";
				else $wh = " WHERE `tb`.`ctrl` & {$this->ctrl} = {$this->ctrl}";
			}
		}
		if($this->pagesize < 200 && $this->pagesize > 19){ //only count if valid request
			$sql = "SELECT COUNT(*) FROM `".DB_TABLE_PREFIX."{$this->table}` as `tb` {$wh}";
			if($row = mysql_fetch_row($this->rs=mysql_query($sql))) $this->pagecount = ceil((int)$row[0] / $this->pagesize);
			else	$this->pagecount =1;
			mysql_free_result($this->rs);
			if($this->page > $this->pagecount) $this->page = $this->pagecount;
			elseif($this->page < 1) $this->page = 1;
			if($this->page > 1){
				$pagestart = $this->page > 1 ? ($this->page - 1) * $this->pagesize : 0;
				$limit = "LIMIT {$pagestart}, {$this->pagesize}";
			}
			else $limit = "LIMIT {$this->pagesize}";
		}else $limit='';
		$this->grandparentid = NULL;
		$sql = "SELECT DISTINCT `tb`.`id`,`tb`.`name`,`tb`.`view`,`tb`.`ctrl` FROM `".DB_TABLE_PREFIX."{$this->table}` as `tb` {$wh} {$sr} {$limit}";
		$this->rs= mysql_query($sql);
		return true; //open
	}
	function show(){
		$this->open();
		include('../forms/folder-list-wizard.php');
		dbclose();
	}
}//class
$o = new catlist;
$o->type=$o->allowpaste=TABLE_WIZARD;
$o->a_ctrl = &$WIZARD_CTRL;//array of constants definition

$o->table='wizard';
$o->alias='WD';
$o->url=URL_SELF;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->doctitle = "X&acirc;y d&#7921;ng s&#7843;n ph&#7849;m";
$o->process();
dbclose();