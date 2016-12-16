<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_MEMBER)){
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
define('COL2_NAME','M&#227;');

define('COL3_WIDTH','12%');
define('COL3_NAME','T&#234;n');

define('COL4_WIDTH','12%');
define('COL4_NAME','&#272;i&#7879;n tho&#7841;i&nbsp;<strong style="color:red">:</strong>&nbsp;Di &#273;&#7897;ng&nbsp;<strong style="color:red">:</strong>&nbsp;Fax');

define('COL5_WIDTH','18%');
define('COL5_NAME','&#272;&#259;ng nh&#7853;p');

define('COL6_WIDTH','18%');
define('COL6_NAME','V&#224;o');
define('COL7_NAME','&#272;&#7863;c t&#237;nh');

define('ALIAS','CS');

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
		$this->open('`tb`.`id`,`tb`.`code`,`firstname`,`lastname`,`email`,`phone`,`mobile`,`fax`,DATE_FORMAT(`tb`.`lastlogon`,\''.FORMAT_DB_DATETIME.'\') as `lastlogon`,`tb`.`visited`,`tb`.`ctrl`');
		include('../forms/item-list-customer.php');
		exit();
	}
}
$o = new mylist;
$o->doctitle='Danh s&#225;ch th&#224;nh vi&#234;n';
$o->table='customer';
$o->type = TABLE_CUSTOMER;
$o->alias = 'CS';
$o->a_ctrl = &$CUSTOMER_CTRL;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = (string)URL_SELF;
$o->process();
?>