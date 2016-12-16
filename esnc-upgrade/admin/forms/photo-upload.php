<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Upload photo gallery</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript">
function insertItem(){
	var oParent = document.getElementById('body');
	var form = document.getElementsByTagName('form');
	if (form.length>=10) {
		alert("Reached limitation");
		return;
	}
	var code = '<form name="upload" action="abc.php"><input type="file" name="userfile" /></form>';	
	var f = document.getElementById('upload');
	var f = document.createElement('form');
	var file = document.createElement('input');
	file.type = "file";
	file.name = "userfile";
	f.action = "abc.php";
	f.appendChild(file);
	oParent.appendChild(f);
}
</script>
</head>
<body>
<div id="body">
<form  name="upload" action="abc.php">
	<input type="file" name="userfile"/>
</form>
</div>
<input type="button" value="insert" onclick="insertItem();">
</body>
</html>
<?php dbclose();?>