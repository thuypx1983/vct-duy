<?php 
require '../../config.php';
require '../config.php';
require PATH_ADMIN.'inc/common.php';
require PATH_ADMIN.'inc/dbcon.php';
require PATH_ADMIN.'inc/session.php';
$session->getaccess(SESSION_CTRL_ADMIN) or redirect(URL_ROOT.'logon.htm');
define('FILE_CM',PATH_APPLICATION.'commonvalue.php');
include FILE_CM;
if(!isset($CM_NAME)){
	$fh = fopen(FILE_CM,'r');
	$s = fgets($fh);
	fclose($fh);
	$CM_NAME=explode(',',trim(preg_replace('/[\,\s]{2,}/',',',substr($s,9)),', '));
}
if($act == ACT_SAVE){
 	foreach($_POST as $kk=>&$v)
		if(is_array($v)){
			foreach($v as $k=>&$vv) if($vv=='(!)') unset($_POST[$kk][$k]);
		}else
			if($v=='(!)') unset($_POST[$kk]);
	$fh = fopen(FILE_CM,'w');
	fwrite($fh,'<?php //#'.implode(',',$CM_NAME).'
');	
	foreach($CM_NAME as $cm_name){
			fwrite($fh,'$'.$cm_name.'='.var_export($_POST[$cm_name],TRUE));
			fwrite($fh,';
');
	}
	fwrite($fh,'
?>');
	fclose($fh);
redirect(URL_SELF);
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<head><title>Gi&aacute; tr&#7883; th&#432;&#7901;ng d&ugrave;ng</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
th{font-size:11px;}
.tab{display:none;}
.tabactive{display:table-header-group;}
textarea{width:95%;height:100%;}
.tabhead{cursor:pointer;font-size:11px;font-weight:normal;color:black;}
.tabheadactive{cursor:pointer;font-size:11px;font-weight:bold;color:green;}
tbody.tab input,tbody.tabactive input{width:90%;}
</style>
<link rel="stylesheet" type="text/css" href="images/style.css"/>
</head>

<body>
<form action="<?php echo URL_SELF ?>?act=<?php echo ACT_SAVE ?>" method="post" onsubmit="return checkForm(this);">
<table >
<tr><th>Gi&aacute; tr&#7883;</th><th>T&ecirc;n</th><th align="right">B&#7887;</th></tr>
<?php
foreach($CM_NAME as $cm_name){
if(is_array($$cm_name)){
	echo '<tbody><tr><td colspan="3">'.$cm_name.'</td></tr>';
	foreach($$cm_name as $cm_key=>$cm_value){
		echo '<tr><td><input type="text" value="'.$cm_key.'" /></td><td colspan="2"><input type="text" name="'.$cm_name.'['.$cm_key.']" value="'.$cm_value.'" onchange="this.nextSibling.checked=(this.value == \'\')" /><input type="checkbox" value="(!)"  name="'.$cm_name.'['.$cm_key.']"/></td></tr>';
	}
	for($i=1000;$i<1004;++$i)
		echo '<tr><td><input type="text"  /></td><td colspan="2"><input type="text" name="'.$cm_name.'[]" value="" onchange="this.nextSibling.checked=(this.value == \'\')" /><input type="checkbox" value="(!)" name="'.$cm_name.'[]" checked/></td></tr>';
	echo '</tbody>';
}else{
	echo '<tr><td>'.$cm_name.'</td><td colspan="2"><input type="text" name="'.$cm_name.'" value="'.$$cm_name.'" /><input type="checkbox" name="'.$cm_name.'" value="(!)" /></td></tr>';
}
}
?>
</table>
<div align="center"><input type="submit" value="submit" class="button" /></div>
</form>
</body>
<script language="javascript" type="text/javascript">
frmItem=document.getElementsByTagName('form').item(0);
function checkForm(){
	r = document.getElementsByTagName('input');
	n = r.length;
	for(i=0;i < n; ++i){
		o=r.item(i);
		if(o.value=='(!)');
		else{
			if(/\[[^\]]*\]/.test(o.name)){
				k = o.parentNode.previousSibling.firstChild.value;
				if(k == '') k=o.value;
				if( k!= ''){
					o.name = o.name.replace(/\[[^\]]*\]/, '[' + k + ']');
				}else o.disabled = true;
			}
		}
	}
	return true;
}
window.top.document.title=self.document.title;
</script>
<script language="javascript" type="text/javascript" src="js/js.php"></script>
<script language="javascript" type="text/javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js/item-script.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo URL_ROOT ?>js/admin-overload.js"></script>
</html>
<?php dbclose();?>