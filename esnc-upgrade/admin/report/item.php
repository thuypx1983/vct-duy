<?php 
require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_REPORT)){
	header('HTTP/1.0 404 Not Found');
    exit();
}
require '../config.php';
require("../inc/dbcon.php");
require(PATH_CLASS.'report.php');
define('ALIAS','RP');
class item extends report{
	var $act,$q,$alias='RP',$type=TABLE_REPORT;
	function show(){
		global $session;
		if($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){
			include PATH_ADMIN_FORM.'item-report.php';
		}
		dbclose();
		exit();
	}
	function doreport(){
		if($this->id > 0){
			$this->loadonerow();
			if($this->type & 1) include('./sysreport.php');
			elseif($this->type & 0x10) include(PATH_COMPONENT.'report.php');
			global $sql;
			$sql = 'UPDATE `'.DB_TABLE_PREFIX.'report` SET `lastrun`='.SQL_NOW.' WHERE `id`='.$this->id;
			mysql_query($sql);//update last run
			$sql = NULL;
			eval((string)$this->detail.';');//generate function
			if($sql){//report is simple sql SELECT STATEMENT
				$this->rs = mysql_query($sql);
			}else{
				$this->rs = execreport();//run the report
			}
			if(!function_exists('fetch_row')){
				if(is_array($this->rs)){
					function fetch_row($i,&$rs){
						return isset($rs[$i]) ? $rs[$i]: FALSE;
					}
				}else{
					function fetch_row($i,$rs){
						return mysql_fetch_row($rs);
					}				
				}
			}
			$this->a_columns = explode('|',trim($this->columns,'|'));
			if($this->type & 4) include PATH_ADMIN_FORM.'report-columna.php';
			else include PATH_ADMIN_FORM.'report-tabular.php';
		}
		dbclose();
		exit();
	}
	function display(){
		include PATH_ADMIN_FORM.'item-report-view.php';
		dbclose();
		exit();
	}
	function exportcsv(){
		global $sql;
		if($this->id > 0){
			$this->loadonerow();
			if($this->type & 1) include('./sysreport.php');
			elseif($this->type & 0x10) include(PATH_COMPONENT.'report.php');
			$sql = 'UPDATE `'.DB_TABLE_PREFIX.'report` SET `lastrun`='.SQL_NOW.' WHERE `id`='.$this->id;
			mysql_query($sql);//update last run
			$sql = NULL;
			eval((string)$this->detail.';');//generate function
			if($sql){//report is simple sql SELECT STATEMENT
				$this->rs = mysql_query($sql);
			}else{
				$this->rs = execreport();//run the report
			}
			if(!function_exists('fetch_row')){
				if(is_array($this->rs)){
					function fetch_row($i,&$rs){
						return isset($rs[$i]) ? $rs[$i]: FALSE;
					}
				}else{
					function fetch_row($i,$rs){
						return mysql_fetch_row($rs);
					}				
				}
			}
			$this->a_columns = explode('|',trim($this->columns,'|'));
			header('Content-Type:application/octet-stream;charset=utf-8');
			header('Content-Disposition:attachment;filename=report-'.$this->id.'.csv');
			foreach($this->a_columns as $colname){
				echo '"';
				echo $colname;
				echo '",';
			}
			for($i=0;($row=fetch_row($i,$this->rs)) && $i < 1000;++$i){
				echo "\r\n";
				foreach($row as $value){
					echo '"';
					echo $value;
					echo '",';
				}
			}
		}
		dbclose();
		exit();
	}
}
$o = new item();
$o->act=$act;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->url = URL_SELF;
$o->a_ctrl = &$REPORT_CTRL;
switch($o->act){
	case ACT_SAVE:
		if($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){
			$o->fetch();
			if($o->id > 0) {
				if($o->updaterow())
					redirect('item-list.php');
			}elseif($o->addrow()) redirect('item-list.php');
		}
		break;
	case ACT_DOWNLOAD: //export report to csv
		$o->id = (int)$_GET[ALIAS.'id'];
		$o->exportcsv();
		exit();
	case ACT_EDIT:
		if($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){
			$o->id = (int)$_GET[ALIAS.'id'];
			if($o->id > 0) $o->loadonerow();
			$o->show();
			dbclose();
		}
		exit();
	case ACT_OPEN://view report
	case ACT_LIST: //view (not edit) report
		$o->id = (int)$_GET[ALIAS.'id'];
		if($o->id > 0) $o->loadonerow();
		$o->display();
		dbclose();
		exit();
	case ACT_REPORT:
	default://run report
		$o->id = (int)$_GET[ALIAS.'id'];
		$o->doreport();
		dbclose();
		exit();
}
$o->msg='L&#7895;i khi c&#7853;p nh&#7853;t';
$o->show();
dbclose();
?>
