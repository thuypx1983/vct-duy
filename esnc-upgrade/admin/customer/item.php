<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_MEMBER)){
	exit();
}
require '../config.php';
require('../inc/dbcon.php');
require(PATH_CLASS.'customer.php');
class item extends customer{
	function save(){
		global $sql;
		$sql = 'SELECT `id` FROM `'.DB_TABLE_PREFIX.'customer` WHERE `code`=\''.mysql_real_escape_string($this->code).'\' AND `id`<>'.(int)$this->id;
		$rs = mysql_query($sql);
		if(mysql_fetch_row($rs)){
			$this->msg='Tr&#249;ng m&#227; th&#224;nh vi&#234;n';
			return FALSE;
		}
		settype($this->agentid,'int');
		$sql = 'SELECT `name` FROM `'.DB_TABLE_PREFIX.'agent` WHERE `id`='.$this->agentid;
		$rs = mysql_query($sql);
		if($row=mysql_fetch_assoc($rs)){
			$sql = 'UPDATE `'.DB_TABLE_PREFIX.'customer` SET `ctrl`='.(int)$this->ctrl
				.",`countryid`='".mysql_real_escape_string($this->countryid)."'"
				.",`cityid`='".mysql_real_escape_string($this->cityid)."'"
				.",`code`='".mysql_real_escape_string($this->code)."'"
				.",`agentid`=".(int)$this->agentid
				.",`organ`='".mysql_real_escape_string($row['name'])."'"
				.",`type`=".$this->type
				.",`ctrl`=".($this->ctrl | CUSTOMER_CTRL_AGENT)
				." WHERE `id`=".(int)$this->id;
		}else 
			$sql = 'UPDATE `'.DB_TABLE_PREFIX.'customer` SET `ctrl`='.(int)$this->ctrl
				.",`countryid`='".mysql_real_escape_string($this->countryid)."'"
				.",`cityid`='".mysql_real_escape_string($this->cityid)."'"
				.",`code`='".mysql_real_escape_string($this->code)."'"
				.",`type`=".$this->type
				.",`ctrl`=".($this->ctrl & ~CUSTOMER_CTRL_AGENT)
				." WHERE `id`=".(int)$this->id;
		mysql_free_result($rs);
		_trace($sql);
		if(mysql_query($sql)){
			$this->msg='C&#7853;p nh&#7853;t th&#224;nh c&#244;ng';
			return TRUE;
		}else{
			$this->msg='L&#7895;i: d&#7919; li&#7879;u kh&#244;ng &#273;&#250;ng';
			return FALSE;
		}
	}
	function show(){
		$this->loadonerow();
		include('../forms/item-customer.php');
		exit();
	}
}
$o = new item();
$o->id = (int)$_GET['id'];
$o->doctitle='th&agrave;nh ph&#7847;n';
$o->a_ctrl = &$CUSTOMER_CTRL;
$o->a_gender = &$USER_GENDER;
switch($act){
case ACT_SAVE:
	$o->fetch();
	$o->agentid=$_POST['agentid'];
/* 	$o->ctrl = @array_sum($_POST['ctrl']);
	$o->countryid = $_POST['countryid'];
	$o->cityid = $_POST['cityid'];
	$o->code = $_POST['code'];
 */	$o->save();
	$o->show();
	break;
default:
	$o->id = (int)$_GET['CSid'];
	$o->show();
}
?>
