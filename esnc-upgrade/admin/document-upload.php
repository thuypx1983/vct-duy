<?php 
require('../config.php');
require("./inc/common.php");
require('./inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_DEFAULT,ACCESS_UPLOAD_FILE)){
        echo "<script language='javascript'>window.top.location='".URL_ROOT."'</script>";
        exit();
}
require './config.php';
require('../class/document.php');
class documentitem extends document{
	var $q,$act,$fn,$a_type;
	function process(){
		switch($this->act){
		case ACT_SAVE:
			$this->save();
		default:
			if($this->fn){
				echo '<script language="javascript" type="text/javascript">';
				echo $this->fn;
				echo '("';
				echo $this->name;
				echo '","';
				echo  $this->extension;
				echo '",';
				echo (int)array_search($this->extension,$this->a_type);
				echo ',0,';
				echo $this->flag;
				echo ')</script>';
			}
		}
	}
}
$o = new documentitem();
$o->act=$act;
$o->path = $FILE_ALLOW_EDIT_PATH[(int)$_GET['FLid']];
$o->a_type = &$FILE_ALLOW_EDIT_TYPE;
$o->flag= (int)$_GET['FFflag'];
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->fn = $_GET['fn'];
$o->url = URL_SELF;
$o->process();
?>