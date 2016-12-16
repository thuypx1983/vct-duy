<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Thêm mới link footer</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
<link type="text/css" rel="stylesheet" href="forms/style.css" />
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
<style type="text/css">
TABLE.list{
	clear:both;
	margin:0px;
}
table th{
	height:25px;
	background-color:#EFEDDE;
	border-top:1px solid #C0C0C0;
	border-right:1px solid #ACA899;
	border-bottom:1px solid #ACA899;
}
table tr td{
	padding:1px;	
	border-right:1px solid #C0C0C0;
	border-bottom:1px solid #C0C0C0;
	font:tahoma;
	font-size:12px;
}
table tr td{
	border-top:0px;
	border-right:1px solid #ACA899;
	border-bottom:1px solid #ACA899;
}
</style>
</head>
<body style="margin: 0px 0px 0px 0px;" class="text">
<?php
$url = URL_SELF.'?act='.ACT_SAVE;
?>
<form name="form" method="post" action="<?php echo URL_SELF.'?act='.ACT_ADD.'&PDid='.$PDid.'&catid='.$CPid ?>" class="head"></form>
<form action="<?php echo $url;?>" method="post" name="formnew">
<table width="70%" cellpadding="3" cellspacing="0" border="0">
	<tbody>
  <tr>
   	<td>Lời bình</td>
   	<td><textarea name="content" cols="50" rows="6"></textarea></td>
  </tr>
 <tr>
 	<td>Người Gửi</td>
 	<td><input type="text" size="50" name="custname"></td>
 </tr>
 </tbody>
</table>
<input type="hidden" name="PDid" value="<?php echo $PDid?>">
<input type="hidden" name="CPid" value="<?php echo $CPid?>">
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
function doNewItem(){
	document.form.submit();
}
function doSave(){
	f = document.formnew;	
	document.formnew.submit();
}
</script>
