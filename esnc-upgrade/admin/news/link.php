<?php 
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_NEWS)){
	echo "<script language='javascript'>window.top.location='../../';</script>";
	exit();
}
require '../config.php';
require '../inc/dbcon.php';
require PATH_CLASS.'relate.php';
define('CTRL_DIS',1);
define('CTRL_HID',0);
define('FROM',1);
$type = (string)@$_GET['NWlink'];
//$act = (int)@$_GET['act'];
if($type=='product'){
	class relates extends relate{
		function process(){
			switch($this->act){
				case ACT_SAVE:								
					$this->newsid = (int)$_GET['NWid'];				
					if($_GET['tag']!='') $this->tag = (string)$_GET['tag'];
					$this->ctrl = CTRL_DIS;		
					if($_POST['linkid'] != ''){					
						while(list($key,$value) = each($_POST['linkid'])){						
							$this->productid = $value;	
							$this->save();
						}			
					}
					$this->show();
				break;
				case ACT_EDIT:							
					$this->newsid = (int)$_GET['NWid'];
					if($_GET['tag']!='') $this->tag = (string)$_GET['tag'];
					$this->ctrl = CTRL_HID;	
					while(list($key,$value) = each($_POST['linkid'])){
						$a_list .= $value.',';
					}
					$this->arrlinkid = explode(',',$a_list);
					array_pop($this->arrlinkid);							
					$this->updatefromnews();
					$this->show();
				break;			
				case ACT_SEARCH:
					$this->newsid = (int)$_GET['NWid'];
					if($_GET['tag']!='') $this->tag = (string)$_GET['tag'];				
					$this->show();				
				case ACT_ADD:
					$this->newsid = (int)$_GET['NWid'];
					if($_GET['tag']!='') $this->tag = (string)$_GET['tag'];	
					$this->ctrl = CTRL_HID;	
					while(list($key,$value) = each($_POST['linkid'])){
						$a_list .= $value.',';
					}
					$this->arrlinkid = explode(',',$a_list);
					array_pop($this->arrlinkid);							
					$this->updatefromnews();
					$this->show();
				break;
				default:
					$this->show();
				break;
			}		
		}		
		function show(){
			$this->newsid = $_GET['NWid'];
			$sql = 'SELECT `name`,`tag` FROM `'.DB_TABLE_PREFIX.'news` WHERE `id`='.$this->newsid;
			_trace($sql);
			$row=mysql_fetch_row($rs=mysql_query($sql));
			$a_tag=explode(',', $row[1]);		
			$this->name = $row[0];		
			mysql_free_result($rs);
			$this->ctrl	= CTRL_DIS;	
			$sql = 'SELECT `id`,`name` FROM `'.DB_TABLE_PREFIX.'catproduct` WHERE `ctrl`&'.CATPRODUCT_CTRL_SHOW.'='.CATPRODUCT_CTRL_SHOW;
			_trace($sql);
			$rs = mysql_query($sql);
			$this->a_cat = array();
			while($this->a_cat[] = mysql_fetch_assoc($rs));
			array_pop($this->a_cat);		
			mysql_free_result($rs);			
			$this->getlistlink();
			include('productlink.php');			
			exit();
		}
	}
}elseif($type=='news'){
	class relates extends relate{
		function process(){
			switch($this->act){
				case ACT_SAVE:			
					$this->newsid = (int)$_GET['NWid'];				
					if($_GET['tag']!='') $this->tag = (string)$_GET['tag'];
					$this->ctrl = CTRL_DIS;		
					if($_POST['linkid'] != ''){					
						while(list($key,$value) = each($_POST['linkid'])){						
							$this->linkid = $value;	
							$this->save();
						}			
					}
					$this->show();
				break;
				case ACT_EDIT:							
					$this->newsid = (int)$_GET['NWid'];
					if($_GET['tag']!='') $this->tag = (string)$_GET['tag'];
					$this->ctrl = CTRL_HID;	
					while(list($key,$value) = each($_POST['linkid'])){
						$a_list .= $value.',';
					}
					$this->arrlinkid = explode(',',$a_list);
					array_pop($this->arrlinkid);							
					$this->update();
					$this->show();
				break;			
				case ACT_SEARCH:
					$this->newsid = (int)$_GET['NWid'];
					if($_GET['tag']!='') $this->tag = (string)$_GET['tag'];				
					$this->show();				
				case ACT_ADD:
					$this->newsid = (int)$_GET['NWid'];
					if($_GET['tag']!='') $this->tag = (string)$_GET['tag'];	
					$this->ctrl = CTRL_HID;	
					while(list($key,$value) = each($_POST['linkid'])){
						$a_list .= $value.',';
					}
					$this->arrlinkid = explode(',',$a_list);
					array_pop($this->arrlinkid);							
					$this->update();
					$this->show();
				break;
				default:
					$this->show();
				break;
			}		
		}		
		function show(){
			$this->newsid = $_GET['NWid'];
			$sql = 'SELECT `name`,`tag` FROM `'.DB_TABLE_PREFIX.'news` WHERE `id`='.$this->newsid;
			_trace($sql);
			$row=mysql_fetch_row($rs=mysql_query($sql));
			$a_tag=explode(',', $row[1]);		
			$this->name = $row[0];		
			mysql_free_result($rs);
			$this->ctrl	= CTRL_DIS;	
			$sql = 'SELECT `id`,`name` FROM `'.DB_TABLE_PREFIX.'catnews` WHERE `ctrl`&'.CATNEWS_CTRL_SHOW.'='.CATNEWS_CTRL_SHOW;
			_trace($sql);
			$rs = mysql_query($sql);
			$this->a_cat = array();
			while($this->a_cat[] = mysql_fetch_assoc($rs));
			array_pop($this->a_cat);		
			mysql_free_result($rs);			
			$this->getlistlink();
			include('newslink.php');			
			exit();
		}
	}
}
$o = new relates;
$o->act = $act;
$o->type = $type;
$o->from = FROM;
$o->process();
dbclose();
?>