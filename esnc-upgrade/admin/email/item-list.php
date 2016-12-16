<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_MARKETING)){
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
define('COL2_NAME','email');

define('COL3_WIDTH','12%');
define('COL3_NAME','created');

define('COL4_WIDTH','12%');
define('COL4_NAME','HTML');

define('COL5_WIDTH','18%');
define('COL5_NAME','Plaintext');

define('COL6_WIDTH','18%');
define('COL6_NAME','attributes');

define('COL7_NAME','&#272;&#7863;c t&#237;nh');

define('ALIAS','CS');
class mylist extends itemflatlist{
	function process(){

		switch($this->act){
		case ACT_ADD:
			include PATH_COMPLS.'email.php';
			subscribe($_GET['email']);
			redirect(URL_SELF.'?'.urlmodify('act',NULL,'email',NULL));
		break;
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
		if($this->sortby==0) $this->sortby = SORTBY_ID_ASC;
		$this->ctrl = (int)$_GET[ALIAS.'ctrl'];
		$this->ctrl_ = (int)$_GET[ALIAS.'ctrl_'];
		$this->open('`tb`.`id`,`tb`.`email` ,`tb`.`ctrl`,`tb`.`created`');
		include PATH_ADMIN_FORM.'item-list-email(newsletter).php';
		exit();
	}
}
$o = new mylist;
$o->doctitle='Danh s&#225;ch email';
$o->table='email';
$o->type = TABLE_EMAIL;
$o->alias = 'EM';
$o->a_ctrl = &$EMAIL_CTRL;
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = (string)URL_SELF;
$o->process();
?>