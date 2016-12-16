<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
<link type="text/css" rel="stylesheet" href="forms/style.css" />
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
<style type="text/css">
FORM.head{
	float:left;
	margin-bottom:20px;
	
}
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
}
table tr{height:15px;}
table tr td{
	border-top:0px;
	border-right:1px solid #ACA899;
	border-bottom:1px solid #ACA899;
	vertical-align:middle;
}
</style>
</head>
<body style="margin: 0px 0px 0px 0px;" class="text">
<form name="form" method="post" action="footer.php?act=<?php echo ACT_ADD;?>" class="head"></form>
<form name="fsearch" method="post" action="footer.php?act=<?php echo ACT_SEARCH;?>" class="head">
	<strong>Nhập từ khóa </strong><input type="text" name="key" title="Tìm kiếm" size="55" maxlength="2048"/><input type="submit" value="Tìm kiếm" name="submit"	/>
</form>
<table cellpadding="0" cellspacing="0" width="94%" class="list">
<tr align="left">
	<th width="28%">Tên trang hiển thị</th>
    <th width="57%">Chuỗi hiển thị link footer trên trang</th>
    <th width="15%">Chức năng </th>
</tr>
<?php
$rs = getlist($key);
while($row = mysql_fetch_assoc($rs)){
	echo '<tr>';
		echo '<td>'.$row['Url'].'</td>';
		echo '<td>'.htmlspecialchars_decode($row['Text']).'</td>';
		echo '<td><a href="footer.php?act='.ACT_EDIT.'&id='.$row['Id'].'">Sửa</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="msg('.$row['Id'].')">Xóa</a></td>';
	echo '</tr>';
}
mysql_free_result($rs);
?>	
</table>
</body>
</html>
<script language="javascript" type="text/javascript">
function doNewItem(){
	document.form.submit();
}
function msg(id){	
	var answer=confirm("Bạn có thật sự muốn xóa!");
	if(answer){
		window.location = "<?php echo 'footer.php?act='.ACT_DEL.'&id=';?>"+id;		
	}
}
</script>