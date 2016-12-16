<?php define('MAGIC_QUOTES_OFF',TRUE);
require('../config.php');
require('inc/common.php');
require('inc/session.php');
 if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	echo "<script language='javascript'>window.top.location='../';</script>";
	exit();
}
require './config.php';
require PATH_CLASS.'rte.php';
$filename=preg_replace(REGEX_NORMAL_FILENAME,'_',(string)$_GET['filename']);//normalize
if($filename=='') $filename=getuniquename().'.txt';
else{
	$a=pathinfo($filename,PATHINFO_EXTENSION);
	if(strpos((string)FILE_ALLOW_UPLOAD_TYPE,'|'.$a.'|') === FALSE) $filename=$filename.'.txt';
}
$path = $FILE_ALLOW_EDIT_PATH[(int)$_GET['FLid']];
$active_file=$path.$filename;
if($act == ACT_SAVE){
	@chmod($active_file,0700);
	if($_POST['rte_tag_data']) RTE::normalizeHTML($_POST['data']);
	@file_put_contents($active_file,$_POST['data']);
	@chmod($active_file,0544);
	$autoclose='window.setTimeout("self.close()",3000)';
}
$btn=array('rteBnSave',URL_ADMIN.'images/rteimages/save.gif','Ghi l&#7841;i','doSave()');
$mode=$_GET['mode'];
$title=$_GET['title'];
if(!$title) $title=$filename.' - so&#7841;n th&#7843;o tr&#7921;c tuy&#7871;n';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<base href="<?php echo URL_BASE_ADMIN?>" />
<link href="images/style.css" type="text/css" rel="stylesheet" />
<comment><link href="images/style-nonie.css" type="text/css" rel="stylesheet" /></comment>
<link href="images/rtestyle.css" type="text/css" rel="stylesheet" />
<style>
body{overflow:visible;}
</style>
</head>
<body>
<form method="post" enctype="multipart/form-data" action="<?php echo URL_SELF ?>?<?php echo urlmodify('filename',$filename,'act',ACT_SAVE); ?>" onsubmit="return checkForm(this);" id='content' style="display:block;width:100%; ">
<?php if($mode != 'embed'){?><div class="rteToolbar" style="position:relative">
	<div style="float:left;padding:3px 0px 0px 0px "><span style="padding:0px 20px 0px 10px; ">file:</span><strong><?php echo $filename ?></strong></div>
	<div style="position:absolute;right:100px; ">
	<div style="float:left;" class="rteButton">
		<input type="checkbox" name="rte_tag_data" value="1" title="Chu&#7849;n ho&aacute; c&aacute;c th&#7867; HTML"  class="input input_mini" unselectable="on" />
	</div>
	<?php RTE::showButtonEx($btn[1],$btn[2],$btn[3],$btn[0]);
	RTE::showButtonEx('preview.gif','Xem tr&#432;&#7899;c','pte_data.showPreview();','rteBnPreview');?>
	</div>
</div><?php }?>
<textarea class="input" name="data" style="width:98%; height:490px;margin:0px 0px 0px 3px; "><?php $s = @file_get_contents($active_file);RTE::quoteHTML($s);echo $s; ?></textarea>
</form>
<script language="javascript" type="text/javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js/pte.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
<script language="javascript" type="text/javascript">
var pte_data = new PTE(document.getElementsByName('data').item(0),'<?php echo URL_BASE ?>');
function checkForm(f){
	return true;
}
function doSave(){
	if(checkForm(f=document.getElementById('content'))){
		f.submit();
	}
}
<?php
if($mode != 'embed'){
	echo $autoclose;
}else echo 'window.top.document.title=self.document.title'; ?>
</script></body>
</html>