<?php 
require('../../config.php');
require('../inc/common.php');
require('../config.php');
require('../inc/dbcon.php');
require('modulelinkexchange.php');
require('../inc/session-linkex.php');
require('../../class/misc.php');?>
<?php
$message='';
$LXid = NULL;
$item = NULL;
if($_GET['LXid']){
	if($_POST['ACT_UPDATE']){
		$item;
		$item = new linkexchange();
		$item->id = (int)$_GET['LXid'];
		$item->loadonerow();
		$item->name = $_POST['name'];
		$item->url = $_POST['url'];
		$item->src = $_POST['src'];
		$item->desc = $_POST['src'];
		$item->ctrl = $_POST['ctrl'];
		if(($item->name!='')&&($item->url!='')){
			$item->updaterow();
			redirect('cat-list.php?CLid='.linkexchange::getcatfield($item->id,'id'));			
		}
		else
			$message = 'cap nhat khong thanh cong!!\nrat co the do name hoac url sai';
	}elseif($_POST['ACT_UP']){
		redirect('cat-list.php?CLid='.linkexchange::getcatfield($item->id,'id'));
	}
}
?>
<?php
if($_GET['LXid']){
	$LXid = (int)$_GET['LXid'];
	$item = new linkexchange();
	$item->id = $LXid;
	$item->loadonerow();
}
?>
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
	<script type="text/javascript">
		<?php if($message!='')echo 'alert(\''.$message.'\');';?>
	</script>
</head>
<body style="margin: 0px 0px 0px 0px" class="text"><form method="post" name="form1" id="form1">
	<table>
		<tr>
			<td style="vertical-align:top;">
				<table>
				<tr>
				<td>Name</td>
				<td><input type="text" name="name" class="textbox" value="<?php echo $item->name;?>" /></td>
				</tr>
				<tr>
				<td>Url</td>
				<td><input type="text" name="url" class="textbox" value="<?php echo $item->url;?>" /></td>
				</tr>
				<tr>
				<td>Src</td>
				<td><input type="text" name="src" class="textbox" value="<?php echo $item->src;?>" /></td>
				</tr>
				<tr>
				<td>Desc</td>
				<td><input type="text" name="desc" class="textbox" value="<?php echo $item->desc;?>" /></td>
				</tr>
				</table>
			</td>
			<td style="vertical-align:top;">
				<table>
				<tr>
				<td>Status</td>
				<td>
                  <select name="ctrl">
                    <option value="0" <?php if($item->ctrl==0)echo 'selected="selected"';?>>&#272;ợi tr&#7843; lời </option>
                    <option value="1" <?php if($item->ctrl==1)echo 'selected="selected"';?>>&#272;ợi tr&#7843; lời lần hai</option>
                    <option value="2" <?php if($item->ctrl==2)echo 'selected="selected"';?>>&#272;ợi tr&#7843; lời lần ba</option>
                    <option value="3" <?php if($item->ctrl==3)echo 'selected="selected"';?>>&#272;&atilde; hiển th&#7883;</option>
                    <option value="4" <?php if($item->ctrl==4)echo 'selected="selected"';?>>&#272;ợi  ghi &#273;&egrave;</option>
                  </select>
				</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td>
				<input type="submit" class="button" name="ACT_UPDATE" value="Cập nhật " />
				<input type="submit" class="button" name="ACT_UP" value="Tr&#7903; lại " />
				</td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
</form></body>
</html>
<?php dbclose();?>