<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_NEWS)){
        echo "<script language='javascript'>window.top.location='".URL_ROOT."'</script>";
        exit();
}
require '../config.php';
require("../inc/dbcon.php");
require('../admincompls/itemlist.php');
define('COL0_WIDTH','3%');
define('COL1_WIDTH','3%');

define('COL2_WIDTH','45%');
define('COL2_NAME','T&ecirc;n');

define('COL3_WIDTH','auto');
define('COL3_NAME','Ng&agrave;y th&aacute;ng');

define('COL4_WIDTH','8%');
define('COL4_NAME','Ngu&#7891;n');

define('COL5_WIDTH','3%');
define('COL5_NAME','Th&#7913; t&#7921;');

define('COL6_NAME','&#272;&#7863;c t&iacute;nh');
define('COL7_NAME','H&agrave;nh &#273;&#7897;ng');

define('CATALIAS','CN');
define('ALIAS','NW');

class newslist extends itemlist{
	function process(){
		switch($this->act){
		case ACT_LIST:
		case ACT_OPEN:
		case ACT_SEARCH:
			$this->catid=(int)$_GET[CATALIAS.'id'];
			$this->show();break;
		case ACT_DEL:
		case ACT_REMOVE:
			$this->id = (string)$_GET['id'];
			$this->catid = (int)$_GET['catid'];
			$this->del();
			$this->q = urlchop($this->q,'id','catid');
			$this->show();break;
		case ACT_MOVE:
			$this->id = (string)$_GET['id'];
			$this->catid = (int)$_GET['catid'];
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
			$this->show(); break;
		case ACT_UNSETCTRL:
			$this->id = (string)$_GET['id'];
			$this->ctrl = (int)$_GET['ctrl'];
			$this->unsetctrl();
			$this->q = urlchop($this->q,'id');
			$this->catid = (int)$_GET[CATALIAS.'id'];
			$this->show();break;
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
		if(!isset($_GET[ALIAS.'sortby'])) 
			$this->sortby= SORTBY_CREATED_DESC;
		else 
			$this->sortby = (int)$_GET[ALIAS.'sortby'];
		if(is_array($_GET[ALIAS.'ctrl'])) $this->ctrl = $_GET[ALIAS.'ctrl']=(int)@array_sum($_GET[ALIAS.'ctrl']);
		else $this->ctrl = (int)$_GET[ALIAS.'ctrl'];
		$this->ctrl_ = (int)$_GET[ALIAS.'ctrl_'];
		$search='';
		if($q = mysql_real_escape_string($_GET['q'])){
			$search = " AND (`name` LIKE '%{$q}%' OR `keyword` LIKE '%{$q}%')";
		}elseif($id = (int)$_GET[ALIAS.'id']){
			$search = " AND (`id` = {$id})";
		}
		$date1 = mysql_format_date($_GET[ALIAS.'created1']);
		$date2 = mysql_format_date($_GET[ALIAS.'created2']);
		if(strpos($date1,'0000') === FALSE && strpos($date2,'0000') === FALSE){
			$search .=' AND (`tb`.`created` BETWEEN \''.$date1.' 00:00:00\' AND \''.$date2.' 23:59:59\')';
		}elseif(strpos($date1,'0000') === FALSE){
			$search .= ' AND (`tb`.`created` >= \''.$date1.' 00:00:00\')';
		}elseif(strpos($date2,'0000') === FALSE){
			$search .= ' AND (`tb`.`created` <= \''.$date2.' 23:59:59\')';
		}
		$this->open('`tb`.`id`,`tb`.`name`,DATE_FORMAT(`tb`.`created`,\''.FORMAT_DB_DATETIME.'\'),`tb`.`creator`,`tb`.`view`,`tb`.`ctrl`',substr($search,4));
		include PATH_ADMIN_FORM.'item-list.php';
		exit();
	}
}
$o = new newslist;
$o->doctitle='Danh s&aacute;ch c&aacute;c m&#7909;c n&#7897;i dung';
$o->table='news';
$o->type = TABLE_NEWS;
$o->alias = 'NW';
$o->catalias = 'CN';
$o->a_ctrl = &$NEWS_CTRL;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = (string)URL_SELF;
$o->process();
?>
