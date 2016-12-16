<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_USER)){
        echo '<script language="javascript">window.top.location="../../";</script>';
        exit();
}
require '../config.php';
require('../inc/dbcon.php');

if($DB_R_NAME){
	dbclose();
	r_open($DB_R_HOST,$DB_R_USER_ADMIN,$DB_R_PWD_ADMIN,$DB_R_NAME);//open remote database, use to login multi account
}
require('../admincompls/itemlist.php');
define('COL0_WIDTH','3%');
define('COL1_WIDTH','8%');
define('COL1_NAME','ID');

define('COL2_WIDTH','8%');
define('COL2_NAME','T&ecirc;n vi&#7871;t t&#7855;t');

define('COL3_WIDTH','12%');
define('COL3_NAME','T&ecirc;n &#273;&#7847;y &#273;&#7911;');

define('COL4_WIDTH','12%');
define('COL4_NAME','Email &#273;&#259;ng nh&#7853;p');

define('COL5_WIDTH','18%');
define('COL5_NAME','&#272;&#259;ng nh&#7853;p');

define('COL6_WIDTH','18%');
define('COL6_NAME','S&#7889; l&#7847;n');
define('COL7_NAME','&#272;&#7863;c t&#237;nh');

define('ALIAS','US');

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
		$this->open('`tb`.`id`,`tb`.`user`,`name`,`email`,DATE_FORMAT(`tb`.`lastlogin`,\''.FORMAT_DB_DATETIME.'\') as `lastlogin`,`tb`.`visited`,`tb`.`ctrl`');
		include('../forms/item-list-user.php');
		exit();
	}
}
$o = new mylist;
$o->doctitle='C&Aacute;C T&Agrave;I KHO&#7842;N QU&#7842;N TR&#7882;';
$o->table='user';
$o->type = TABLE_USER;
$o->alias = 'US';
$o->a_ctrl = &$USER_CTRL;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = (string)URL_SELF;
$o->process();
?>