<?php
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
require('../config.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_WIZARD)){
	exit('<script language="javascript">window.top.location="../../";</script>');
}
require('../inc/dbcon.php');
require('../admincompls/itemlist.php');
define('COL0_WIDTH','3%');
define('COL1_WIDTH','3%');

define('COL2_WIDTH','45%');
define('COL2_NAME','T&ecirc;n');

define('COL3_WIDTH','22%');
define('COL3_NAME','Th&#7921;c hi&#7879;n');

define('COL4_WIDTH','30%');
define('COL4_NAME',TEXT_PRICE);

define('COL5_WIDTH','7%');
define('COL5_NAME','Th&#7913; t&#7921;');

define('COL6_NAME','&#272;&#7863;c t&iacute;nh');
define('COL7_WIDTH','14%');
define('COL7_NAME','M&#227;');
class mylist extends itemlist{
	function copyto(){
		global $sql;
		$a_id = explode(',',$this->id);
		$a = &$a_id;
		foreach($a as $id){
			settype($id,"int");
			settype($this->wid,"int");
			//$sql = "INSERT INTO `".DB_TABLE_PREFIX."cat{$this->table}{$this->table}`(`cat{$this->table}id`,`{$this->table}id`) SELECT {$this->catid},{$id}";
			$sql = "INSERT INTO `".DB_TABLE_PREFIX."wizard`(`wid`,`id`) SELECT wizarditem,{$id}";
			mysql_query($sql);
		}
		return TRUE;
	}
	function moveto(){
		global $debug,$sql;
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id)&& is_int($this->catid)){
			$this->copyto();//copy to new category
			$sql = "DELETE FROM `".DB_TABLE_PREFIX."cat{$this->table}{$this->table}` WHERE `{$this->table}id` IN ({$this->id}) AND `cat{$this->table}id` <> {$this->catid}";
			$debug->save($sql);
			return mysql_query($sql);			
		}
		return FALSE;
	}

	function stepdel(){
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id)){
			global $sql,$debug;
			$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.$this->table.'` WHERE `id` IN ('.$this->id.')';
			return mysql_query($sql);
		}
	}
	function open($fields,$search=''){
		global $debug,$sql;
		switch($this->sortby){
			case SORTBY_NAME_ASC:       $sr = ' ORDER BY `tb`.`name` ASC'; break;
			case SORTBY_NAME_DESC:      $sr = ' ORDER BY `tb`.`name` DESC'; break;
			case SORTBY_VIEW_DESC:      $sr = ' ORDER BY `tb`.`view` DESC, `tb`.`id` DESC'; break;
			case SORTBY_ID_DESC: 	    $sr = 'ORDER BY `tb`.`id` DESC';break;
			case SORTBY_ID_ASC: 	    $sr = 'ORDER BY `tb`.`id` ASC';break;
			default:
				$this->sortby=SORTBY_VIEW_ASC;//default to sort by view ascending
				$sr = ' ORDER BY `tb`.`view` ASC,`tb`.`id` DESC';
		}
		$wh = 'WHERE '. $search;
		$l='';//filter by catid
		if($this->ctrl){
			if($this->ctrl_){
				$wh .= " AND `tb`.`ctrl` & {$this->ctrl} = 0";
			}else{
				$wh .= " AND `tb`.`ctrl` & {$this->ctrl} = {$this->ctrl}";
			}
		}
		if($this->wid >0){
			$wh .= " AND `tb`.`wid` =".$this->wid;
		}

		if(preg_match(REGEX_CHECK_ID_SERIES,$this->status)) $wh .= ' AND `tb`.`status` IN ('.$this->status.')';
		if($wh == 'WHERE ') $wh = '';
		else $wh = str_replace('WHERE  AND',' WHERE ',$wh);
		if($this->pagesize > 200 || $this->pagesize < 5) $this->pagesize=18;
		if($this->page <1) $this->page=1;
		if($this->page == 1) 
			$this->startrow = 0;
		else
 			$this->startrow=$this->pagesize * ($this->page - 1);
		$sql = "SELECT SQL_CALC_FOUND_ROWS DISTINCT {$fields} FROM `".DB_TABLE_PREFIX."{$this->table}` as `tb` {$l} {$wh} {$sr} LIMIT {$this->startrow},{$this->pagesize}";
		$this->rs= mysql_query($sql);
		$t_rs = mysql_query('SELECT FOUND_ROWS()');
		$row = mysql_fetch_row($t_rs);
		mysql_free_result($t_rs);
		$this->rowcount = (int)$row[0];
		$this->pagecount = ceil($this->rowcount/$this->pagesize);
		$this->endrow = (++$this->startrow) + $this->pagesize;
		if($this->endrow > $this->rowcount) $this->endrow = $this->rowcount;
		return true; //open
	}
	
	function process(){
		switch($this->act){
		case ACT_LIST:
		case ACT_OPEN:
		case ACT_SEARCH:
			$this->catid=(int)$_GET[CATALIAS.'id'];
			$this->show();break;
		case ACT_DEL:
			$this->id=(string)$_GET['id'];
			$this->stepdel();
			dbclose();
			redirect(URL_SELF);
			break;
		case ACT_REMOVE:
			$this->id = (string)$_GET['id'];
			$this->catid = (int)$_GET['catid'];
			if ($this->catid >0)	$this->stepdel();
			else	$this->delall();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_MOVE:
			$this->id = (string)$_GET['id'];
			$this->catid = (int)$_GET['WDid'];
			$this->moveto();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_COPY:
			$this->id = (string)$_GET['id'];
			$this->catid = (int)$_GET['catid'];
			$this->copyto();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_SETCTRL:
			$this->id = (string)$_GET['id'];
			$this->ctrl = (int)$_GET['ctrl'];
			$this->nctrl = (int)$_GET['nctrl'];
			$this->setctrl();
			$this->q = urlchop($this->q,'id');
			$this->catid = (int)$_GET[CATALIAS.'id'];
			$this->show();break;
		case ACT_UNSETCTRL:
			$this->id = (string)$_GET['id'];
			$this->ctrl = (int)$_GET['ctrl'];
			$this->unsetctrl();
			$this->q = urlchop($this->q,'id');
			$this->catid = (int)$_GET[CATALIAS.'id'];
			$this->show();break;
		case ACT_SETCATID:
			$this->id=(string)$_GET['id'];
			$this->catid=$_GET['catid'];
			$this->q = urlchop($this->q,'id');
			$this->nocatid=(int)$_GET['nocatid'];
			$this->setcatid();
			$this->q=urlchop($this->q,'id');
			$this->show();
			break;
		case ACT_RENAME:
			$this->name = (string)$_GET['name'];
			$this->id = (int)$_GET['id'];
			echo ($this->ren() ? "parent.banner.setStatus('&#272;&#7893;i t&ecirc;n th&agrave;nh c&ocirc;ng');" : "parent.banner.setStatus('L&#7895;i khi &#273;&#7893;i t&ecirc;n');input.value=exvalue;");
			exit();
		case ACT_REORDER:
			$this->idvalue = (string)$_GET['idvalue'];
			echo $this->reorder() ? "parent.banner.setStatus('Thay &#273;&#7893;i th&agrave;nh c&ocirc;ng');":"parent.banner.setStatus('L&#7895;i khi thay &#273;&#7893;i');self.document.reload();";
			exit();//not open
		
		}
	}
	function show(){
		$this->pagesize = (int)$_GET[ALIAS.'pagesize'];
		$this->page = (int)$_GET[ALIAS.'page'];
		$this->sortby = (int)$_GET[ALIAS.'sortby'];
		if(is_array($_GET[ALIAS.'ctrl'])) $this->ctrl = $_GET[ALIAS.'ctrl']=(int)@array_sum($_GET[ALIAS.'ctrl']);
		else $this->ctrl = (int)$_GET[ALIAS.'ctrl'];
		$search='';
		if($q = mysql_real_escape_string($_GET['q'])){
			$search = " (`name` LIKE '%{$q}%')";
		}
		if($id = (int)$_GET[ALIAS.'id']){
			$search = " (`id` = {$id})";
		}
		$this->ctrl_ = (int)$_GET[ALIAS.'ctrl_'];		
		$this->open("`tb`.`id`,`tb`.`name`,`tb`.`view`,`tb`.`ctrl`",$search);//global $sql;	echo $sql;	
		include('../forms/item-list-wizard.php');
		dbclose();
		exit();
	}
}
$o = new mylist;
$o->table='wizarditem';
$o->type = TABLE_WIZARDITEM;
$o->alias = 'WI';
$o->a_ctrl = $WIZARDITEM_CTRL;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->a_catid=$_REQUEST['catid'];
$o->url = (string)URL_SELF;
$o->wid=(int)$_GET['WDid'];
$o->doctitle='C&aacute;c b&#432;&#7899;c x&acirc;y d&#7921;ng';
$o->process();
?>
