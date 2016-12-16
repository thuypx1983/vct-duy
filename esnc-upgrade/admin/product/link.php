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
require PATH_CLASS.'relate.php';
define('COL0_WIDTH','3%');
define('COL1_WIDTH','3%');

define('COL2_WIDTH','60%');
define('COL2_NAME','SP li&ecirc;n quan t&#7899;i:');


define('COL5_WIDTH','7%');
define('COL5_NAME','ID');

define('COL6_NAME','&#272;&#7863;c t&iacute;nh');
define('COL7_WIDTH','14%');
define('COL7_NAME','M&#227;');

define('ALIAS','PP');
if($_GET['PDlink']=='product'){
class mylist extends itemflatlist{
	function process(){
		switch($this->act){
		case ACT_LIST:
		case ACT_OPEN:
		case ACT_SEARCH:
			$this->show();
			break;
		case ACT_SAVE://save linked product
			$this->id = (int)$_GET['PDid'];
			$this->PPctrl = &$_POST['PPctrl'];
			if($this->PPctrl != unserialize($_POST['PPctrl_last'])) $this->save();
			redirect(URL_SELF.'?'.urlmodify('act',NULL));
		}
	}
	function save(){
		global $sql;
		if(is_array($this->PPctrl)){
			$value = implode(',',array_keys($this->PPctrl));
			$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'productlink` WHERE `productID`='.$this->id.' AND (`linkID` NOT IN ('.$value.'))';//delete all link
			_trace($sql);
			mysql_query($sql);
			_trace(mysql_error());
			$value = '';
			foreach($this->PPctrl as $linkID=>$ctrl){
				$value .= ',('.$this->id.','.$linkID.','.$ctrl.')';
			}
			$sql = 'REPLACE INTO `'.DB_TABLE_PREFIX.'productlink`(`productID`,`linkID`,`ctrl`) VALUES '.ltrim($value,',');
			_trace($sql);
			mysql_query($sql);
			_trace(mysql_error());
		}else{
			$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'productlink` WHERE `productID`='.$this->id;//delete all links
			_trace($sql);
			mysql_query($sql);
			_trace(mysql_error());
		}
	}
	function show(){
		global $sql;
		$PDpage=(int)$_GET['PDpage'];
		$PDpagesize=(int)$_GET['PDpagesize'];
		$this->id = (int)$_GET['PDid'];
		$this->catproductid = (int)$_GET['CPid'];
		if(!$this->catproductid){
			$sql = 'SELECT `catproductid` FROM `'.DB_TABLE_PREFIX.'catproductproduct` WHERE `productid`='.$this->id;
			$row=mysql_fetch_row($rs=mysql_query($sql));
			$this->catproductid=(int)$row[0];
			mysql_free_result($rs);
		}
		$sql = 'SELECT `name` FROM `'.DB_TABLE_PREFIX.'product` WHERE `id`='.$this->id;
		$row=mysql_fetch_row($rs=mysql_query($sql));
		$this->name=$row[0];
		mysql_free_result($rs);
		
		$this->pagesize=(int)$_GET['PPpagesize'];
		$sql = 'SELECT `a`.`id`,`a`.`code`,`a`.`name`,`b`.`ctrl` FROM `'.DB_TABLE_PREFIX.'product` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'productlink` as `b` ON `a`.`id`=`b`.`linkid` WHERE `b`.`productid`='.$this->id;
		$this->a_link=array();//fetch all linked item to array
		_trace($sql);
		$rs=mysql_query($sql);
		for($this->linkcount = 0;$this->a_link[]=mysql_fetch_row($rs);++$this->linkcount);array_pop($this->a_link);
		$search = '(`tb`.`id` NOT IN ('.$this->id;
		foreach($this->a_link as $link) $search .= ','.$link[0];
		$search .= '))';
		if($q = $_GET['q']){ // search product
			if(is_numeric($q)) $search = ' `tb`.`id`='.$q.' OR `tb`.`code`='.$q;//search by id/code
			elseif(strpos($q,'m:') === 0){//search by manufacturer
				$c = ' LIKE \'%'.mysql_real_escape_string(strtr(substr($q,2),' ','%')).'%\'';
				$search .= ' AND `tb`.`manufacturer` '.$c;
			}else{
				$c = ' LIKE \'%'.mysql_real_escape_string(strtr($q,' ','%')).'%\'';
				$search .= ' AND ( `tb`.`name` '.$c.' OR `tb`.`keyword` '.$c.' OR `tb`.`code` '.$c.')';
			}
		}elseif(($q = (int)$_GET['PPlinkid']) > 0){
			$search = ' AND  `tb`.`id`='.$q;
		}elseif($q = $_GET['PDcode']){
				$c = ' LIKE \'%'.mysql_real_escape_string(strtr($q,' ','%')).'%\'';
				$search .= ' AND ( tb`.`code` '.$c.')';
		}
		$this->table='product';
		$this->page = (int)$_GET['PPpage'];
		$this->pagesize=10;//fixed
		if(is_array($_GET['PDctrl'])){
			$this->ctrl = (int)@array_sum($_GET['PDctrl']);
			$_GET['PDctrl'] = $this->ctrl;
		}else{
			$this->ctrl = (int)($_GET['PDctrl']);
		}
		$this->open('`tb`.`id`,`tb`.`code`,`tb`.`name`',$search);
		include PATH_ADMIN_FORM.'item-list-productlink.php';
		dbclose();
		exit();
	}
}
$o = new mylist;
$o->type = TABLE_PDLINK;
$o->doctitle='S&#7843;n ph&#7849;m li&ecirc;n quan';
$o->act = $act;
$o->a_ctrl=&$PDLINK_CTRL;
$o->process();
}else{
//PHAN LAM THEM PRODUCT-NEWS ngocdq.
define('FROM',2);
class relates extends relate{
	function process(){
		switch($this->act){
			case ACT_SAVE:						
				$this->productid = (int)$_GET['PDid'];				
				if($_GET['tag']!='') $this->tag = (string)$_GET['tag'];
				$this->ctrl = 1;		
				if($_POST['linkid'] != ''){					
					while(list($key,$value) = each($_POST['linkid'])){						
						$this->newsid = $value;	
						$this->savelink();
					}			
				}
				$this->show();
			break;
			case ACT_EDIT:							
				$this->productid = (int)$_GET['PDid'];
				if($_GET['tag']!='') $this->tag = (string)$_GET['tag'];
				$this->ctrl = 0;	
				while(list($key,$value) = each($_POST['linkid'])){
					$a_list .= $value.',';
				}
				$this->arrlinkid = explode(',',$a_list);
				array_pop($this->arrlinkid);							
				$this->updatefromproduct();
				$this->show();
			break;			
			case ACT_SEARCH:
				$this->productid = (int)$_GET['PDid'];
				if($_GET['tag']!='') $this->tag = (string)$_GET['tag'];				
				$this->show();				
			case ACT_ADD:
				$this->productid = (int)$_GET['PDid'];
				if($_GET['tag']!='') $this->tag = (string)$_GET['tag'];	
				$this->ctrl = 0;	
				while(list($key,$value) = each($_POST['linkid'])){
					$a_list .= $value.',';
				}
				$this->arrlinkid = explode(',',$a_list);
				array_pop($this->arrlinkid);							
				$this->updatefromproduct();
				$this->show();
			break;
			default:
				$this->show();
			break;
		}		
	}		
	function show(){
		$this->productid = $_GET['PDid'];
		$sql = 'SELECT `name`,`tag` FROM `'.DB_TABLE_PREFIX.'product` WHERE `id`='.$this->productid;
		_trace($sql);
		$row=mysql_fetch_row($rs=mysql_query($sql));
		$a_tag=explode(',', $row[1]);		
		$this->name = $row[0];		
		mysql_free_result($rs);
		$this->ctrl	= 1;	
		$sql = 'SELECT `id`,`name` FROM `'.DB_TABLE_PREFIX.'catnews` WHERE `ctrl`&'.CATPRODUCT_CTRL_SHOW.'='.CATPRODUCT_CTRL_SHOW;
		_trace($sql);
		$rs = mysql_query($sql);
		$this->a_cat = array();
		while($this->a_cat[] = mysql_fetch_assoc($rs));
		array_pop($this->a_cat);		
		mysql_free_result($rs);			
		$this->getlistlinkfromproduct();
		include('newslink.php');			
		exit();
	}
}
$o = new relates;
$o->act = $act;
$o->type = $type;
$o->from = FROM;
$o->process();
}
?>