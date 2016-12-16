<?php require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_FILE)){
        echo "<script language='javascript'>window.top.location='".URL_ROOT."'</script>";
        exit();
}
require '../config.php';
unset($FILE_ALLOW_EDIT_FOLDER_NAME[1],$FILE_ALLOW_EDIT_FOLDER_NAME[2]);
class folderlist{
	var $alias='FL',$pagecount=0,$page=0,$url,$act,$q,$a_type;
	function process(){
		switch($this->act){
		default:
			$this->show();
		}
	}
	function show(){
		include_once('../forms/folder-list-files.php');
	}
}
$o = new folderlist;
$o->rs = &$FILE_ALLOW_EDIT_FOLDER_NAME;
$o->act=$act;
$o->url = URL_SELF;
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->a_type=&$FILE_ALLOW_EDIT_TYPE;
$o->process();
?>