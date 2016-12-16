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
if($_POST['ACT_ADD_ITEM']){
	$item;
	$item = new linkexchange();
	$item->name = $_POST['name'];
	$item->url = $_POST['url'];
	$item->src = $_POST['src'];
	$item->desc = $_POST['src'];
	$item->ctrl = $_POST['ctrl'];
	if($_GET['CLid']){
		if(($item->name!='')||($item->url!='')){
			$item->a_cat = array($_GET['CLid']);
			$item->addrow();
			redirect('item-list.php?CLid='.$_GET['CLid']);
		}
	}
}elseif($_POST['ACT_UP']){
	$catitem = catlinkexchange::open((int)$_GET['CLid']);
	if(($catitem->parentid!=NULL)&&($catitem->parentid!=0))
		redirect('cat-list.php?CLid='.$catitem->parentid);
	else
		redirect('cat-list.php');
}elseif($_POST['ACT_DELETE']){
	if($_POST['ck']){
		$item;
		foreach($_POST['ck'] as $id){
			$item = new linkexchange();
			$item->id = (int)$id;
			$item->deleterow();
		}
	}
}elseif($_POST['ACT_SAVE_VIEW']){
	if($_POST['ck']){
		$item;
		foreach($_POST['ck'] as $id){
			$item = new linkexchange();
			$item->id = (int)$id;
			$item->loadonerow();
			$item->view = (int)$_POST['view_'.$id];
			$item->updaterow();
		}
	}
}elseif($_POST['ACT_SAVE_CTRL']){
	if($_POST['ck']){
		$item;
		foreach($_POST['ck'] as $id){
			$item = new linkexchange();
			$item->id = (int)$id;
			$item->loadonerow();
			$item->ctrl = (int)$_POST['up_ctrl'];
			$item->updaterow();
		}
	}
}
?>
<?php
$page=1;$pagecount=0;$pagesize=15;
if($_GET['page'])$page= (int)$_GET['page'];
$ctrl=NULL;
if($_GET['ctrl'])$CLid = (int)$_GET['ctrl'];
$CLid=NULL;
if($_GET['CLid']){
	$CLid = (int)$_GET['CLid'];
}
$rs = linkexchange::pagelist($page,$pagecount,$pagesize,$CLid,$ctrl);?>
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
		var checked = true;
		function checkall(){
			var ck=null;
			ck = document.getElementsByName('ck[]');
			for(i=0;i<ck.length;i++){
				ck[i].checked = checked;
			}
			checked = !checked;
		}
		function doLocate(LXid){
			var RequestObj = false;
			var result='';
			if(window.XMLHttpRequest)RequestObj = new XMLHttpRequest();
			else if(window.ActiveXObject)RequestObj = new ActiveXObject("Microsoft.XMLHttp");
			if(RequestObj){
				RequestObj.open('GET','checklink.php?act=0&LXid='+LXid);
				RequestObj.onreadystatechange = function(){
					if((RequestObj.readyState == 4)&&(RequestObj.status == 200)){
						window.prompt('Vi tri link tren site',RequestObj.responseText);
					}
				}
				RequestObj.send(null);
			}else{
				alert('khong khoi tao duoc doi tuong');
			}
		}		
		function doCheck(LXid){
			var RequestObj = false;
			var result='';
			if(window.XMLHttpRequest)RequestObj = new XMLHttpRequest();
			else if(window.ActiveXObject)RequestObj = new ActiveXObject("Microsoft.XMLHttp");
			if(RequestObj){
				RequestObj.open('GET','checklink.php?act=1&LXid='+LXid);
				RequestObj.onreadystatechange = function(){
					if((RequestObj.readyState == 4)&&(RequestObj.status == 200)){
						window.prompt('Vi tri link tren site',RequestObj.responseText);
					}
				}
				RequestObj.send(null);
			}else{
				alert('khong khoi tao duoc doi tuong');
			}
		}		
	</script>
</head>
<body style="margin: 0px 0px 0px 0px" class="text"><form method="post" name="form1" id="form1">
<?php if(mysql_affected_rows()>0){?>
	<table>
		<tr>
			<td style="vertical-align:top;">
				<table>
				<tr>
				<td>Name</td>
				<td><input type="text" name="name" class="textbox"/></td>
				</tr>
				<tr>
				<td>Url</td>
				<td><input type="text" name="url" class="textbox"/></td>
				</tr>
				<tr>
				<td>Src</td>
				<td><input type="text" name="src" class="textbox"/></td>
				</tr>
				<tr>
				<td>Desc</td>
				<td><input type="text" name="desc" class="textbox"/></td>
				</tr>
				</table>
			</td>
			<td style="vertical-align:top;">
				<table>
				<tr>
				<td>Status</td>
				<td>
                  <select name="ctrl">
                    <option value="0">&#272;ợi tr&#7843; lời </option>
                    <option value="1">&#272;ợi tr&#7843; lời lần hai</option>
                    <option value="2">&#272;ợi tr&#7843; lời lần ba</option>
                    <option value="3">&#272;&atilde; hiển th&#7883;</option>
                    <option value="4">&#272;ợi  ghi &#273;&egrave;</option>
                  </select>
				</td>
				</tr>
				<tr>
				<td>&nbsp;</td>
				<td>
				<input type="submit" class="button" name="ACT_ADD_ITEM" value=" Th&ecirc;m " <?php if($CLid==NULL) echo 'disabled="disabled"';?> />
				<input type="submit" class="button" name="ACT_UP" value="Tr&#7903; lại " />
				</td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
	<div class="listitem">
		<input type="submit" class="button" name="ACT_SAVE_VIEW" value="Cập nhật view" />
		<input type="submit" class="button" name="ACT_SAVE_CTRL" value="Cập nhật status" />
		<select name="up_ctrl">
			<option value="-1"></option>
			<option value="0">&#272;ợi tr&#7843; lời </option>
			<option value="1">&#272;ợi tr&#7843; lời lần hai</option>
			<option value="2">&#272;ợi tr&#7843; lời lần ba</option>
			<option value="3">&#272;&atilde; hiển th&#7883;</option>
			<option value="4">&#272;ợi  ghi &#273;&egrave;</option>
		</select>
		<input type="text" class="textbox" name="qsearch" />
		<input type="submit" class="button" name="ACT_SEARCH" value="Tim kiem" />
		<input type="submit" class="button" name="ACT_DELETE" value="Xóa" />
		<table width="100%">
		<col width="25px"/><col width=""/><col width=""/><col width=""/><col width="35px"/><col width="120px"/><col width="40px"/>
			<thead>
				<tr>
					<td><input type="checkbox" onClick="javascript:checkall();" /></td>
					<td>Nhom</td>
					<td>name</td>
					<td>Url</td>
					<td>View</td>					
					<td>&nbsp;</td>										
					<td>status</td>
				</tr>
			</thead>
<?php $count=0;if($row = mysql_fetch_assoc($rs)){do{?>
			<tr>
				<td><input type="checkbox" name="ck[]" id="<?php echo $row['id']; ?>" value="<?php echo $row['id']?>" /></td>		
				<td><?php echo linkexchange::getcatfield($row['id'],'name');?></td>
				<td><?php echo $row['name'];?></td>
				<td><?php echo $row['url'];?></td>
				<td><input type="text" name="view_<?php echo $row['id'];?>" class="textbox" style="width:30px;" value="<?php echo $row['view'];?>" /></td>
				<td>
					<a class="ctrl ctrl_<?php echo $row['ctrl']?>" href="item-edit.php?LXid=<?php echo $row['id']?>$page=<?php echo $page;?>">sửa</a>|
					<a class="ctrl ctrl_<?php echo $row['ctrl']?>" href="javascript:doLocate('<?php echo $row['id']?>');">locate</a>|
					<a class="ctrl ctrl_<?php echo $row['ctrl']?>" href="javascript:doCheck('<?php echo $row['id']?>');">check</a>										
				</td>
				<td><?php echo $row['ctrl'];?></td>
			</tr>
<?php $count++;}while($row = mysql_fetch_assoc($rs));}elseif($page>1){redirect('item-list.php?'.(($CLid!=NULL)?'CLid='.$CLid.'&':'')).'page='.$page-1;}?>
		</table>
	<div>
<?php 
if($pagecount>1){
	for($i=0;$i<$pagecount;$i++){
		echo '<a';
		if($i!=($page-1))
			if($CLid!=NULL)
				echo ' href="item-list.php?CLid='.$CLid.'&page='.($i+1).'"';
			else
				echo ' href="item-list.php?page='.($i+1).'"';
		echo '>'.($i+1).'</a>';
		if(($i>=0)&&($i<($pagecount-1)))echo '|';
	}
}
?>
	</div>
	</div>
<?php }?>
</form></body>
</html>
<?php dbclose();?>