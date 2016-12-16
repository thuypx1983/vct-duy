<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_ORDER)){
        echo '<script language="javascript">window.top.location="../../";</script>';
        exit();
}
require '../config.php';
require('../inc/dbcon.php');
require('../admincompls/itemlist.php');

include_once PATH_GLOBAL.'order.php';
include_once PATH_GLOBAL.'currency.php';

define('COL0_WIDTH','3%');
define('COL1_WIDTH','8%');
define('COL1_NAME','ID');

define('COL2_WIDTH','8%');
define('COL2_NAME','M&#227;');

define('COL3_WIDTH','12%');
define('COL3_NAME','Kh&#225;ch h&#224;ng');

define('COL4_WIDTH','18%');
define('COL4_NAME','Ng&#224;y nh&#7853;n');

define('COL5_WIDTH','18%');
define('COL5_NAME','Th&#7901;i h&#7841;n');

define('COL6_NAME','Gi&#225; tr&#7883; ('.CURRENCY_UNIT.')');
define('COL7_NAME','Tr&#7841;ng th&#225;i');


define('CATALIAS','');
define('ALIAS','OR');

class mylist extends itemflatlist{	
	function process(){

		switch($this->act){
		case ACT_LIST:
		case ACT_OPEN:
		case ACT_SEARCH:
			$this->show();break;
		case ACT_DEL:
		case ACT_REMOVE:
			_trace('ACT_DEL');
			$this->id = (string)$_GET['id'];
			$this->q = urlchop($this->q,'id');
			$this->del();
			$this->show();break;
		default:
			$this->show();break;
		}
	}
	function show(){
		global $ORDER_STATUS;
		$this->catid=0;
		$this->keyword = ($_GET[ALIAS.'keyword'])?'*'.$_GET[ALIAS.'keyword'].'*':'';
		$this->pagesize = (int)$_GET[ALIAS.'pagesize'];
		$this->page = (int)$_GET[ALIAS.'page'];
		$this->sortby = (int)$_GET[ALIAS.'sortby'];
		if($this->sortby == 0) $this->sortby = SORTBY_ID_DESC;
		$this->ctrl = (int)$_GET[ALIAS.'ctrl'];
		$this->ctrl_ = (int)$_GET[ALIAS.'ctrl_'];
		$this->open('`tb`.`id`,`tb`.`code`,`custfirstname`,`custlastname`,`status`,`custemail`,DATE_FORMAT(`tb`.`created`,\''.FORMAT_DB_DATETIME.'\') as `created`,DATE_FORMAT(`tb`.`expireddate`,\''.FORMAT_DB_DATETIME.'\') as `expireddate`,`tb`.`value`,`tb`.`ctrl`');
		include('../forms/item-list-order.php');		
		exit();
	}
}
$o = new mylist();
$o->doctitle='&#272;&#417;n h&#224;ng';
$o->table='order';
$o->type = TABLE_ORDER;
$o->alias = 'OR';
$o->a_ctrl = &$ORDER_CTRL;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = (string)URL_SELF;
$o->process();
?>
