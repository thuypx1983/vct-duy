<?php 
require('../../config.php');
require("../inc/common.php");
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_PRODUCT)){
        exit('<script language="javascript">window.top.location="../../";</script>');
}
require '../config.php';
require('../inc/dbcon.php');
require(PATH_CLASS.'productphoto.php');
class itemlist {
	function show(){
		include PATH_ADMIN_FORM.'item-list-photofile.php';
		dbclose();
		exit();
	}
}
$o = new itemlist;
$o->path = $FILE_ALLOW_EDIT_PATH[$o->catid=(int)$_GET['FLid']];
define('COL2_NAME',$FILE_ALLOW_EDIT_URL[$o->catid]);
define('COL2_WIDTH','25%');
$o->q = urlchop($_SERVER['QUERY_STRING'],'act');
$o->a_type=&$FILE_ALLOW_EDIT_TYPE;
$o->url = URL_SELF;
$o->pagesize=(int)$_GET['pagesize'];
if($o->pagesize < 20) $o->pagesize = 20;
$o->page = (int)$_GET['page'];
if($o->page < 1) $o->page=1;
$o->startrow=($o->page-1) * $o->pagesize;
$cd = getcwd();
chdir($o->path);
if($o->type = (int)$_GET['FFext'])
	$o->rs = glob('*.'.($o->ext=$FILE_ALLOW_EDIT_TYPE[$o->type]));
else $o->rs = glob('*.jpg');
if (isset($_GET['q'])&&!empty($_GET['q'])){
	function make_text_safe($text) {
		$text = preg_replace("#&\#([0-9]*);#ie", "", $text);
		$text = html_entity_decode($text);
		$text = str_replace(" / ", "_", $text);
		$text = str_replace("/", "_", $text);
		$text = str_replace("'", "_", $text);
		$text = str_replace(" - ", "_", $text);
		$text = str_replace("-", "_", $text);
		$text = str_replace(" ", "_", $text);
		$text = str_replace("ä", "ae", $text);
		$text = str_replace("ö", "oe", $text);
		$text = str_replace("ü", "ue", $text);
		$text = str_replace("Ä", "Ae", $text);
		$text = str_replace("Ö", "Oe", $text);
		$text = str_replace("Ü", "Ue", $text);
		$text = str_replace("ß", "ss", $text);
		$text = str_replace("&", "and", $text);
		$text = str_replace("%", "Percent", $text);
		$text = str_replace("?", "l", $text);
		$text = str_replace("ó", "o", $text);
		$text = str_replace("?", "n", $text);
		$text = str_replace("?", "c", $text);
		$text = str_replace("?", "z", $text);
		$text = str_replace("?", "z", $text);
		$text = str_replace("?", "s", $text);
		$text = str_replace("?", "a", $text);
		$text = str_replace("?", "e", $text);
		$text = ereg_replace("[^A-Za-z0-9_]", "", $text);
		$text = str_replace("____", "_", $text);
		$text = str_replace("___", "_", $text);
		$text = str_replace("__", "_", $text);
		return $text;
	}	
	$q        = chop($_GET['q']);
	$q        = make_text_safe($q);
	$q        = str_replace('_',',',$q);
	$type     = (int)$_GET['type'];
	$type     = ($type!=0)?$FILE_ALLOW_EDIT_TYPE[$type]:'*';
	$o->rs    = glob('*{'.$q.'}*.'.$type,GLOB_BRACE);
}
chdir($cd);
$o->rowcount = count($o->rs);
$o->pagecount = ceil($o->rowcount/$o->pagesize);
$o->show();

$go = $_GET['go'];
if($go == '') $go = 'photo-upload.php?PPproductid='.$o->productid;
redirect($go);
dbclose();
?>