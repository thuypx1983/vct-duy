<?php require('../config.php');
require('inc/common.php');
require('inc/session.php');
 if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	echo "<script language='javascript'>window.top.location='../../';</script>";
	exit();
}
define('MAGIC_QUOTES_OFF',TRUE);
require './config.php';
$filename=preg_replace(REGEX_NORMAL_FILENAME,'_',(string)$_GET['filename']);//normalize
if($filename=='') $filename=getuniquename().'.txt';
else{
	$a=pathinfo($filename,PATHINFO_EXTENSION);
	if(strpos((string)FILE_ALLOW_UPLOAD_TYPE,'|'.$a.'|') === FALSE) $filename=$filename.'.txt';
}
require(PATH_CLASS.'rte.php');
$rte = new RTE('oRte',URL_ADMIN.'images/rteimages/',0xFFFFFFFF,array(array('rteBnSave',URL_ADMIN.'images/rteimages/save.gif','Ghi l&#7841;i','saveData()')));
$path = $FILE_ALLOW_EDIT_PATH[(int)$_GET['FLid']];
$file = $path.$filename;
if($act == ACT_SAVE){
	switch($_GET['c']){
	default: ;
	}
	if($_POST['rte_tag_data'])
		RTE::normalizeHTML($_POST['data']);
	@chmod($file,0777);
	if(!file_put_contents($file,$_POST['data']))
		echo $file;
	@chmod($file,0555);
	$autoclose='window.setTimeout("self.close()",3000)';
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $filename; ?> - so&#7841;n th&#7843;o tr&#7921;c tuy&#7871;n</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<base href="<?php echo URL_BASE;?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo URL_ADMIN; ?>images/style.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo URL_ADMIN; ?>images/rtestyle.css"/>
<script language="javascript" src="<?php echo URL_ADMIN; ?>js/library.js" type="text/javascript"></script>
<script language="javascript" src="<?php echo URL_ADMIN; ?>js/rte.js" type="text/javascript"></script>
<script language="javascript" src="<?php echo URL_ADMIN; ?>js.php" type="text/javascript"></script>
<style>
body{overflow:visible;}
DIV.colorSelect,DIV.colorSelect-hover,DIV.rteButton,DIV.rteButton-hover,DIV.rteButtonBlock,DIV.rteButtonBlock-hover{
    BEHAVIOR: url('<?php echo URL_ADMIN ?>js/IEhover.htc')
}
</style>
</head>
<body class="text" >
<form method="post" enctype="multipart/form-data" action="<?php echo URL_SELF ?>?<?php echo urlformat($_SERVER['QUERY_STRING'],'filename',$filename,'act',ACT_SAVE); ?>" onSubmit="return checkForm(this);" id='content'>
<div style="width:100%;height:510px "><?php $t = @file_get_contents($path.$filename);$rte->show('data',$t,'480px');?></div>
</form>
<?php RTE::loadRTEDialog();?>
</body>
</html>
<?php //exit();?>
<script language="javascript" type="text/javascript">
function checkForm(f){
	oRte.rteToInput();
	return true;
}
function closeWindow(){
	self.close();
}
function saveData(){
	if(checkForm(f=document.getElementById('content'))){
		f.submit();
	}
}
function showMeta(){
	a=document.getElementById('idmetaArea');
	if(a.style.display=='') a.style.display='none';else a.style.display='';
}
function autoResizeEditor(o){
window.alert(window.width);
}
<?php echo $autoclose;?>
</script>
<?php $rte->initRteObjectScript();?>