<?php 
require('../../config.php');
require('../inc/common.php');
require('../config.php');
require('../inc/dbcon.php');
require('modulelinkexchange.php');
require('../inc/session-linkex.php');?>
<?php 
$catitem=NULL;
$CLid=NULL;
if($_GET['CLid'])$CLid=(int)$_GET['CLid'];
$catitem = catlinkexchange::open($CLid);
if($catitem === NULL)redirect('cat-list.php');
?>
<?php
if($_POST['ACT_UPDATE']){
	$catitem = new catlinkexchange();
	$catitem->id = (int)$_GET['CLid'];
	$catitem->loadonerow();
	$catitem->name = $_POST['name'];
	$catitem->desc = $_POST['desc'];
	$catitem->img1 = $_POST['img1'];
	$catitem->alt1 = $_POST['alt1'];
	$catitem->view = $_POST['view'];
	$catitem->updaterow();	
	redirect('cat-list.php?CLid='.$catitem->parentid);
}else if($_POST['ACT_UP']){
	$catitem = new catlinkexchange();
	$catitem->id = (int)$_GET['CLid'];
	$catitem->loadonerow();
	redirect('cat-list.php?CLid='.$catitem->parentid);
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Esnc console, module link exchange, category list</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="<?php echo URL_BASE_ADMIN."linkex/" ?>" />
	<style>
		INPUT.textbox{border:solid 1px #CCCCCC;}
		INPUT.button{border:solid 1px #CCCCCC;}
	</style>
</head>
<body style="margin: 0px 0px 0px 0px" class="text"><form method="post" name="form1" id="form1">
<table>
	<tr>
		<td>Name</td>
		<td><input type="text" name="name" class="textbox" value="<?php echo $catitem->name; ?>"/></td>	
	</tr>
	<tr>
		<td>Desc</td>
		<td><input type="text" name="desc" class="textbox" value="<?php echo $catitem->desc; ?>"/></td>
	</tr>
	<tr>
		<td>Img</td>
		<td><input type="text" name="img1" class="textbox" value="<?php echo $catitem->img1; ?>"/></td>
	</tr>
	<tr>
		<td>Alt</td>
		<td><input type="text" name="alt1" class="textbox" value="<?php echo $catitem->alt1; ?>"/></td>
	</tr>
	<tr>
		<td>View</td>
		<td><input type="text" name="view" class="textbox"  value="<?php echo $catitem->view; ?>" style="width:30px;" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input type="submit" name="ACT_UPDATE" value="Cap nhat" class="button" />&nbsp;
			<input type="submit" name="ACT_UP" value="Tro lai" class="button" />			
		</td>
	</tr>
</table>
</form></body>
</html>
<?php dbclose();?>