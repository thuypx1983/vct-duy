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
if($id) $url.='&id='.$id;
?>
<form name="form" method="post" action="footer.php?act=<?php echo ACT_ADD;?>" class="head"></form>
<form action="<?php echo $url;?>" method="post" onsubmit="return checkform(this);" name="formnew">
<table width="70%" cellpadding="0" cellspacing="0" id="table">
  <tr>
    <th width="24%" height="50" align="left" valign="top">Tên trang hiển thị</th>
    <th width="76%" align="left" valign="top">Soạn thảo chuỗi hiển thị link footer trên trang(viết code html)</th>
  </tr>
  <tr>
    <td valign="top">     
        <input type="text" name="url" style="width:250px;" value="<?php echo @$o->Url;?>"/>    </td>
    <td><textarea name="text" rows="6" cols="65"><?php echo @$o->Text;?></textarea></td>  
  </tr>
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
function doNewItem(){
	document.form.submit();
}
function checkform(f){
	if((f.url.value=='')||(f.url.value==null)){
		window.alert('Bạn hãy nhập URL!');
		f.url.focus();
		return false;
	}
	if((f.text.value=='')||(f.text.value==null)){
		window.alert('Bạn hãy nhập chuỗi hiển thị!');
		f.text.focus();
		return false;
	}
	return true;
	//return esnc_aform(f);
}
function doSave(){
	f = document.formnew;
	if(checkform(f)){	
		document.formnew.submit();
	}
}
</script>
