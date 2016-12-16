<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_FAQ)){
        echo '<script language="javascript">window.top.location="../../";</script>';
        exit();
}
require '../config.php';
require('../inc/dbcon.php');
require('../admincompls/itemlist.php');
define('COL0_WIDTH','3%');
define('COL1_WIDTH','8%');
define('COL1_NAME','ID');

define('COL2_WIDTH','75%');
define('COL2_NAME','C&acirc;u h&#7887;i');

define('COL3_WIDTH','12%');
define('COL3_NAME','Ng&#432;&#7901;i h&#7887;i');

define('COL4_NAME','Th&#7913; t&#7921;');
define('COL5_NAME','&#272;&#7863;c t&iacute;nh');

define('ALIAS','FA');

class mylist extends itemflatlist{
	function process(){

		switch($this->act){
		case ACT_LIST:
		case ACT_OPEN:
		case ACT_SEARCH:
			$this->show();break;
		case ACT_DEL:
		case ACT_REMOVE:
			$this->id = (string)$_GET['id'];
			$this->q = urlchop($this->q,'id');
			$this->del();
			$this->show();break;
		case ACT_SETCTRL:
			$this->id = (string)$_GET['id'];
			$this->ctrl = (int)$_GET['ctrl'];
			$this->nctrl = (int)$_GET['nctrl'];			
			$this->setctrl();
			$this->q = urlchop($this->q,'id');
			$this->show();break;
		case ACT_REORDER:
			$this->idvalue = (string)$_GET['idvalue'];
			echo $this->reorder() ? "parent.banner.setStatus('Thay &#273;&#7893;i th&agrave;nh c&ocirc;ng');":"parent.banner.setStatus('L&#7895;i khi thay &#273;&#7893;i');self.document.reload();";
			exit();//not open
		default:
			$this->show();break;
		}
	}
	function show(){
		$this->catid=0;
		$this->keyword = $_GET[ALIAS.'keyword'];
		$this->pagesize = (int)$_GET[ALIAS.'pagesize'];
		$this->page = (int)$_GET[ALIAS.'page'];
		$this->sortby = (int)$_GET[ALIAS.'sortby'];
		if($this->sortby==0) $this->sortby = SORTBY_ID_DESC;
		$this->ctrl = (int)$_GET[ALIAS.'ctrl'];
		$this->ctrl_ = (int)$_GET[ALIAS.'ctrl_'];
		$this->open('`tb`.`id`,`tb`.`question`,`tb`.`customername`,`tb`.`view`,`tb`.`ctrl`');
		include('../forms/item-list-faq.php');
		dbclose();
		exit();
	}
}
$o = new mylist;
$o->doctitle='C&acirc;u h&#7887;i th&#432;&#7901;ng g&#7863;p';
$o->table='faq';
$o->type = TABLE_FAQ;
$o->alias = 'FA';
$o->a_ctrl = &$FAQ_CTRL;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = (string)URL_SELF;
$o->process();
dbclose();
?>