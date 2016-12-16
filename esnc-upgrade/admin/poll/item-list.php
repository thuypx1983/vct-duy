<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_POLL)){
        echo '<script language="javascript">window.top.location="../../";</script>';
        exit();
}
require '../config.php';
require('../inc/dbcon.php');

require('../admincompls/itemlist.php');
define('COL0_WIDTH','3%');
define('COL1_WIDTH','8%');
define('COL1_NAME','ID');

define('COL2_WIDTH','8%');
define('COL2_NAME','T&ecirc;n cu&#7897;c &#273;i&#7873;u tra ');

define('COL3_WIDTH','12%');
define('COL3_NAME','Ki&#7875;u tr&#7843; l&#7901;i');

define('COL4_WIDTH','12%');
define('COL4_NAME','Ng&agrave;y b&#7855;t &#273;&#7847;u');

define('COL5_WIDTH','18%');
define('COL5_NAME','Ng&agrave;y k&#7871;t th&uacute;c');

define('COL6_WIDTH','18%');
define('COL6_NAME','S&#7889; ng&#432;&#7901;i');
define('COL7_NAME','Tr&#7841;ng th&aacute;i');

define('ALIAS','PL');

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
		$this->open('`tb`.`id`,`tb`.`name`,`tb`.`type`,DATE_FORMAT(`tb`.`thisdate`,\''.FORMAT_DB_DATE.'\') as `thisdate`,DATE_FORMAT(`tb`.`enddate`,\''.FORMAT_DB_DATE.'\') as `enddate`,`tb`.`ctrl`');
		include('../forms/item-list-poll.php');
		exit();
	}
}
$o = new mylist;
$o->doctitle='&#272;i&#7873;u tra th&#7883; tr&#432;&#7901;ng';
$o->table='poll';
$o->type = TABLE_POLL;
$o->alias = 'PL';
$o->a_ctrl = &$POLL_CTRL;
$o->a_type = &$POLL_TYPE;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = (string)URL_SELF;
$o->process();
?>