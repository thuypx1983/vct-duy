<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_PRODUCT)){
	echo "<script language='javascript'>window.top.location='../../';</script>";
	exit();
}
require '../config.php';
require "../inc/dbcon.php";
require PATH_ADMINCOMPLS.'itemlist.php';
define('COL0_WIDTH','3%');
define('COL1_WIDTH','3%');

define('COL2_WIDTH','60%');
define('COL2_NAME','L&#7901;i b&igrave;nh sp:');

define('COL3_WIDTH','15%');
define('COL3_NAME','Ng&agrave;y th&aacute;ng');

define('COL4_WIDTH','20%');
define('COL4_NAME','Ng&#432;&#7901;i g&#7917;i');

define('COL5_WIDTH','7%');
define('COL5_NAME','Th&#7913; t&#7921;');

define('COL6_NAME','&#272;&#7863;c t&iacute;nh');
define('COL7_WIDTH','14%');
define('COL7_NAME','M&#227;');

define('ALIAS','RV');

class mylist extends itemflatlist{
	function process(){
		switch($this->act){
		case ACT_EDIT:  //khi them moi va sua lai deu ra trang new-item-footer
			$id = @(int)$_GET['id'];
			$PDid = (int)$_GET['PDid'];
			$CPid = (int)$_GET['CPid'];
			if($id!=NULL) {
				$sql = "SELECT * FROM `".DB_TABLE_PREFIX."review` WHERE `id`=$id";
				$query = mysql_query($sql);
				$row = mysql_fetch_object($query);
			}
			include('../forms/item-edit-review.php');
			exit();
		case ACT_ADD:
			$PDid = (int)$_GET['PDid'];
			$CPid = (int)$_GET['CPid'];
			return include('../forms/item-add-review.php');	
		case ACT_SAVE:
			$id = isset($_POST['id'])?(int)$_POST['id']:null;
			$productid = (int)$_POST['PDid'];
			$content = (string)$_POST['content'];
			$name = (string)$_POST['custname'];
			$summary = (string)$_POST['summary'];
			$extra = (string)$_POST['extra'];
			$created = date('Y/m/d');
			if(!$id){
			$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'review`(`productid`,`content`,`custname`,`summary`,`extra`,`created`) 
			VALUES("'.$productid.'","'.mysql_real_escape_string(stripcslashes($content)).'"
			,"'.mysql_real_escape_string(stripcslashes($name)).'"
			,"'.mysql_real_escape_string(stripcslashes($summary)).'"
			,"'.mysql_real_escape_string(stripcslashes($extra)).'"
			,"'.mysql_real_escape_string(stripcslashes($created)).'"
			)';
			}
			else if(!is_null($id)){
				$sql = "
					UPDATE `".DB_TABLE_PREFIX."review`
					SET `content`='{$content}',`custname`='{$name}',`summary`='{$summary}',`extra`='{$extra}',`created`='{$created}'
					WHERE `id`='{$id}'
				";
			}
			_trace($sql);
			mysql_query($sql);
			redirect(URL_SELF.'?PDid='.$productid.'&CPid='.$_POST['CPid'].'&PDpage=1&PDpagesize=18');
			break;
		case ACT_LIST:
		case ACT_OPEN:
		case ACT_SEARCH:
			$this->show();break;
		case ACT_DEL:
		case ACT_REMOVE:
			$this->id = (string)$_GET['id'];
			$this->del();
			redirect(URL_SELF.'?'.urlmodify('act',NULL,'id',NULL));
			break;
		case ACT_SETCTRL:
			$this->id = (string)$_GET['id'];
			$this->ctrl = (int)$_GET['ctrl'];
			$this->nctrl = (int)$_GET['nctrl'];
			$this->setctrl();
			redirect(URL_SELF.'?'.urlmodify('act',NULL,'id',NULL,'ctrl',NULL,'nctrl',NULL));
			break;
		case ACT_UNSETCTRL:
			$this->id = (string)$_GET['id'];
			$this->ctrl = (int)$_GET['ctrl'];
			$this->unsetctrl();
			redirect(URL_SELF.'?'.urlmodify('act',NULL,'id',NULL,'ctrl',NULL,'nctrl',NULL));
			break;
		}
	}
	function del(){
		global $sql;
		// we set productid to be null, this enables reuse of id
		if(preg_match(REGEX_CHECK_ID_SERIES,$this->id)){
			$sql = 'UPDATE `'.DB_TABLE_PREFIX.'review` SET `productid`=NULL WHERE `id` IN ('.$this->id.')';
			_trace($sql);
			mysql_query($sql);
		}
	}
	function show(){ 
		$this->pagesize = (int)$_GET[ALIAS.'pagesize'];
		$this->page = (int)$_GET[ALIAS.'page'];
		$this->sortby = (int)$_GET[ALIAS.'sortby'];
		if(!$this->sortby) $this->sortby = SORTBY_ID_DESC;
		if(is_array($_GET[ALIAS.'ctrl'])) $this->ctrl = $_GET[ALIAS.'ctrl']=(int)@array_sum($_GET[ALIAS.'ctrl']);
		else $this->ctrl = (int)$_GET[ALIAS.'ctrl'];
		$this->productid = (int)$_GET['PDid'];
		$this->catproductid = (int)$_GET['CPid'];
		$sql =  'SELECT `a`.`name`'.($this->catproductid > 0 ? '':',`b`.`catproductid` ').'FROM `'.DB_TABLE_PREFIX.'product` as `a` '
		.($this->catproductid > 0 ? '':' INNER JOIN `'.DB_TABLE_PREFIX.'catproductproduct` as `b` ON `a`.`id`=`b`.`productid` ').' WHERE `id`='.$this->productid;
		$row = mysql_fetch_row($rs=mysql_query($sql));
		$this->productname=$row[0];
		if($this->catproductid <= 0)$this->catproductid = (int)$row[1];
		$PDpagesize=(int)$_GET['PDpagesize'];
		$PDpage=(int)$_GET['PDpage'];
		if($PDpage < 1) $PDpage=1;
		if($PDpagesize < 5) $PDpagesize=20;
		mysql_free_result($rs);
		$search='`tb`.`productid`='.$this->productid;
		if($q = mysql_real_escape_string($_GET['q'])){
			$search = " (`summary` LIKE '%{$q}%')";
		}
		if($id = (int)$_GET[ALIAS.'id']){
			$search = " (`id` = {$id})";
		}
		$this->ctrl_ = (int)$_GET[ALIAS.'ctrl_'];		
		$this->open("`tb`.`id`,`tb`.`summary`,DATE_FORMAT(`tb`.`created`,'".FORMAT_DB_DATE."') as `created`,`tb`.`custname`,`tb`.`email`,`tb`.`ctrl`,`tb`.`content`,`extra`",$search);		
		include PATH_ADMIN_FORM.'item-list-review.php';
		dbclose();
		exit();
	}
}
$o = new mylist;
$o->table='review';
$o->type = TABLE_REVIEW;
$o->alias = ALIAS;
$o->a_ctrl = &$REVIEW_CTRL;
$o->doctitle='L&#7901;i b&igrave;nh s&#7843;n ph&#7849;m';
$o->act = $act;
$o->process();
?>
