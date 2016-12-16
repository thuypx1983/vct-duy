<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
$session->getaccess(SESSION_CTRL_ADMIN,MODULE_ORDER) or exit('<script language="JavaScript" type="text/javascript">window.top.location.href="../../";</script>');
require '../config.php';
require('../inc/dbcon.php');
require(PATH_CLASS.'order.php');
require(PATH_CLASS.'orderlist.php');
include_once PATH_GLOBAL.'order.php';
include_once PATH_GLOBAL.'currency.php';

class item extends orderlist{
	var $rowcount,$aDetail,$aHistory;
	function show(){
		global $ORDER_CTRL,$CURRENCY,$ORDER_STATUS;
		$CURRENCY=array($CURRENCY[(int)$this->currencyid]);
		$CURRENCY[0][0] = (real)$this->currencyvalue;
		$CURRENCY[0][6] = (int)$this->currencyctrl;
		if(!$ORDER_STATUS) $ORDER_STATUS=&$ORDER_CTRL;
		$this->loadonerow();
		if(! @include PATH_TEMPLATES.'admin/item-order.php') 	include PATH_ADMIN_FORM.'item-order.php';
		exit();
	}
	function detailList(){
		global $sql;
		$sql='SELECT `productid`,`code`,`class`,`parentid`,`qty`,`qty2`,`qty3`,`qty4`,`saleprice`,`finalprice`,`tax`,DATE_FORMAT(`start`,\''.FORMAT_DB_DATETIME.'\') as `start`,DATE_FORMAT(`stop`,\''.FORMAT_DB_DATETIME.'\') as `stop`,`notes`,`subtotal`,`onetimecharge`,`productctrl`,`promotiontype`,`promotionfrom`
		FROM `'.DB_TABLE_PREFIX.'orderdetail` WHERE `orderid`='.$this->id;
		$this->aDetail=array();
		$rs=mysql_query($sql);
		for($this->rowcount=0;$this->aDetail[]=mysql_fetch_assoc($rs);++$this->rowcount);
		array_pop($this->aDetail);
		mysql_free_result($rs);
	}
	function historyList(){
		global $sql;
		$sql='SELECT `a`.`userid`,`a`.`status`,`a`.`data`,`a`.`created`,`b`.`name` as `user`,`b`.`email` as `useremail`	FROM `'.DB_TABLE_PREFIX.'orderhistory` as `a` LEFT JOIN `'.DB_TABLE_PREFIX.'user` as `b` ON `a`.`userid`=`b`.`id` WHERE `a`.`orderid`='.$this->id.' ORDER BY `a`.`created` DESC';
		$this->aHistory=array();
		$rs=mysql_query($sql);
		for($this->historyLength=0;$this->aHistory[]=mysql_fetch_assoc($rs);++$this->historyLength);
		array_pop($this->aHistory);
		mysql_free_result($rs);
	}
}
$o = new item();
$o->id = (int)$_GET['id'];
$o->doctitle='&#272;&#416;N H&#192;NG';
switch($act){
case ACT_SAVE:
	$o->status = (int)$_POST['status'];
	$o->statusdata = $_POST['data'];
	$o->userid=$session->id;
	$o->setstatus();
	redirect(URL_SELF.'?ORid='.$o->id);
	break;
default:
	$o->id = (int)$_GET['ORid'];
	$o->show();
}
?>