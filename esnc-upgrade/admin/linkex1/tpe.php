<?php define('MAGIC_QUOTES_OFF',TRUE);
require('../config.php');
require('inc/common.php');
require('inc/session.php');
 if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){
	exit("<script language='javascript'>window.top.location='../';</script>");
}
require './config.php';
require PATH_CLASS.'rte.php';
$filename=$_GET['filename'];
$active_file=PATH_TEMPLATES.$filename;
if(!is_file($active_file)) return;
if($act == ACT_SAVE){
	rename($active_file,PATH_TEMP.time().'~'.$filename);
	file_put_contents($active_file,$_POST['data']);
	$autoclose='window.setTimeout("self.close()",3000)';
}
$btn=array('rteBnSave',URL_ADMIN.'images/rteimages/save.gif','Ghi l&#7841;i','saveData()');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $filename; ?> - so&#7841;n th&#7843;o tr&#7921;c tuy&#7871;n</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<base href="<?php echo URL_BASE_ADMIN?>" />
<link type="text/css" rel="stylesheet" href="images/style.css" />
<link type="text/css" rel="stylesheet" href="images/rtestyle.css" />
<style>
body{overflow:visible;}
</style>
</head>
<body>
<form method="post" enctype="multipart/form-data" action="<?php echo URL_SELF ?>?<?php echo urlmodify('filename',$filename,'act',ACT_SAVE); ?>" onsubmit="return checkForm(this);" id='content' style="display:block;width:100%; ">
<div align="center">L&#432;u &yacute;: s&#7917;a &#273;&#7893;i template c&oacute; th&#7875; l&agrave;m <strong style="color:red;font-size:12px;text-decoration:blink; ">h&#7887;ng ho&agrave;n to&agrave;n</strong> site c&#7911;a b&#7841;n. H&atilde;y <strong style="color:red;font-size:12px;text-decoration:blink; ">backup</strong> tr&#432;&#7899;c khi th&#7921;c hi&#7879;n</div>
<div class="rteToolbar" style="position:relative">
	<div style="float:left;padding:3px 0px 0px 0px "><span style="padding:0px 20px 0px 10px; ">file:</span><strong><?php echo $filename ?></strong></div>
	<div style="position:absolute;right:100px; ">
	<?php RTE::showButtonEx($btn[1],$btn[2],$btn[3],$btn[0]);
	RTE::showButtonEx('preview.gif','Xem tr&#432;&#7899;c','pte_data.showPreview();','rteBnPreview');?>
	</div>
</div>
<textarea class="input" name="data" style="width:98%; height:475px;margin:0px 0px 0px 3px; "><?php echo file_get_contents($active_file); ?></textarea>
</form>
</body>
<script language="javascript" type="text/javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js/pte.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
<script language="javascript" type="text/javascript">
var pte_data = new PTE(document.getElementsByName('data').item(0),'<?php echo URL_BASE ?>');
function checkForm(f){
	if(f.data.value == ''){
		window.alert('empty data!');
		f.data.focus();
		return false;
	}
	return true;
}
function saveData(){
	if(checkForm(f=document.getElementById('content'))){
		f.submit();
	}
}
<?php echo $autoclose; ?>
</script>
</html>
