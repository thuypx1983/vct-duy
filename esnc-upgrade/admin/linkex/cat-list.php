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
if($_POST['ACT_SET']){
	if($_POST['ck']){
		$catitem;
		foreach($_POST['ck'] as $catid){
			$catitem = new catlinkexchange();
			$catitem->id = (int)$catid;
			$catitem->loadonerow();
			if($_POST['ck_set']){
				foreach($_POST['ck_set'] as $ctrl){
					$catitem->ctrl = $catitem->ctrl | (int)$ctrl;
				}
			}
			if($_POST['ck_unset']){
				foreach($_POST['ck_unset'] as $ctrl){
					$catitem->ctrl = ($catitem->ctrl | (int)$ctrl)^(int)$ctrl;
				}
			}
			$catitem->updaterow();
		}
	}
}else if($_POST['ACT_ADD']){
	if($_POST['catname']){
		$catitem;
		$catitem = new catlinkexchange();
		$catitem->name = $_POST['catname'];
		if($_GET['CLid'])$catitem->parentid = $_GET['CLid'];
		$catitem->ctrl = CATLINKEXCHANGE_CTRL_SHOW;
		$catitem->addrow();
	}
}else if($_POST['ACT_ADD_ITEM']){
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
}else if($_POST['ACT_UP']){
	if($_GET['CLid']){
		$catitem = new catlinkexchange();
		$catitem->id = (int)$_GET['CLid'];
		$catitem->loadonerow();
		redirect('cat-list.php?CLid='.$catitem->parentid);
	}
}else if(($_POST['itemid'])&&($_POST['editnewtname'])&&($_POST['editnewtname']!='ACT_DEL')){
	$catitem = new catlinkexchange();
	$catitem->id = (int)$_POST['itemid'];
	$catitem->loadonerow();
	$catitem->name = $_POST['editnewtname'];
	$catitem->updaterow();
}else if(($_POST['itemid'])&&($_POST['editnewtname'])&&($_POST['editnewtname']=='ACT_DEL')){
	$catitem = new catlinkexchange();
	$catitem->id = (int)$_POST['itemid'];
	$catitem->deleterow();
}?>
<?php 
$CLid=NULL;

if($_GET['CLid']){
	$CLid=(int)$_GET['CLid'];
	$rs = linkexchange::listitem(NULL,$CLid);
	if(mysql_affected_rows()>0){
		redirect('item-list.php?CLid='.$CLid);
	}
}
$rs = catlinkexchange::listitem(NULL,$CLid);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Esnc console, module link exchange, category list</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="<?php echo URL_BASE_ADMIN."linkex/" ?>" />
	<style>
		INPUT.textbox{border:solid 1px #CCCCCC;}
		INPUT.button{border:solid 1px #CCCCCC;}

		DIV.setctrl{width:217px;height:21px;border:solid 1px #CCCCCC;padding-left:30px;background-color:#CC6699;}
		DIV.listctrl{width:250px;background-color:gray;display:none;}
		DIV.ctrl{width:4px;height:15px;margin:2px 3px 0px 0px;float:left;vertical-align:bottom;}
		DIV.ctrl_0{background-color:#666666;}
		DIV.ctrl_1{background-color:#993300;}
		DIV.ctrl_2{background-color:#FF6600;}
		DIV.ctrl_3{background-color:#999900;}
		DIV.ctrl_4{background-color:#993399;}
		DIV.ctrl_5{background-color:#CC6699;}
		DIV.ctrl_6{background-color:#006699;}
		DIV.ctrl_7{background-color:#FF0000;}
		DIV.ctrl_8{background-color:#CC33CC;}
		DIV.ctrl_9{background-color:#FF66CC;}
		DIV.ctrl_10{background-color:#330033;}																				
		SPAN.ctrl{width:3px;margin:0px 2px 0px 2px;}
		SPAN.ctrl_0{background-color:#666666;}
		SPAN.ctrl_1{background-color:#993300;}
		SPAN.ctrl_2{background-color:#FF6600;}
		SPAN.ctrl_3{background-color:#999900;}
		SPAN.ctrl_4{background-color:#993399;}
		SPAN.ctrl_5{background-color:#CC6699;}
		SPAN.ctrl_6{background-color:#006699;}
		SPAN.ctrl_7{background-color:#FF0000;}
		SPAN.ctrl_8{background-color:#CC33CC;}
		SPAN.ctrl_9{background-color:#FF66CC;}
		SPAN.ctrl_10{background-color:#330033;}
		A{text-decoration:none;color:#006699;}
		A:hover{text-decoration:underline;}		
		A.ctrl{}
		A.ctrl_0{color:#999999;}
		A.ctrl_1{}
		TD.folder_icon{width:20px;background-image:url(../images/folder2.gif); background-position:right;background-repeat:no-repeat;}
		INPUT.editname{width:290px;}
		/*format cho tab*/
		DIV.tab_object{}
		DIV.tab_object DIV.tab_name{width:100%;}
		DIV.tab_object DIV.tab_name DIV.tab_name_item{float:left;line-height:20px;padding:0px 1px 0px 0px;background-color:gray;border:solid 1px #ffffff;}
		DIV.tab_object DIV.tab_name DIV.tab_name_item_active{float:left;line-height:20px;padding:0px 1px 0px 0px;background-color:#CC6699;border:solid 1px #ffffff;}
		DIV.tab_object DIV.tab_name DIV.tab_name_item_notuse{line-height:20px;border:solid 0px #ffffff;background-color:#ffffff;}
		
		DIV.tab_object DIV.tab_content{clear:both;}
		DIV.tab_object DIV.tab_content DIV.tab_content_item{display:none;}
		DIV.tab_object DIV.tab_content DIV.tab_content_item_active{display:block;}
		
		DIV.tab_object DIV.tab_name DIV.tab_name_item DIV.tab_name_item_left{}
		DIV.tab_object DIV.tab_name DIV.tab_name_item DIV.tab_name_item_middle{}
		DIV.tab_object DIV.tab_name DIV.tab_name_item DIV.tab_name_item_right{line-height:20px;}
		
		DIV.tab_object DIV.tab_name DIV.tab_name_item_active DIV.tab_name_item_left{line-height:20px;}
		DIV.tab_object DIV.tab_name DIV.tab_name_item_active DIV.tab_name_item_middle{line-height:20px;}
		DIV.tab_object DIV.tab_name DIV.tab_name_item_active DIV.tab_name_item_right{line-height:20px;}
		/*ket thuc format cho tab*/
		
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
		function showObject(id){
			var o = document.getElementById(id);
			if(o.style.display=='none')o.style.display = 'block';
			else o.style.display = 'none';
		}
		function setcheck(idx){
			ck_set = document.getElementsByName('ck_set[]');
			ck_unset = document.getElementsByName('ck_unset[]');
			if(ck_set[idx].checked==true)
				ck_unset[idx].checked = false;
		}
		function unsetcheck(idx){
			ck_set = document.getElementsByName('ck_set[]');
			ck_unset = document.getElementsByName('ck_unset[]');
			if(ck_unset[idx].checked==true)
				ck_set[idx].checked = false;
		}
		function showedit(id){
			var cur = document.getElementsByName('cur');
			var name = document.getElementsByName('name');
			var editname = document.getElementsByName('editname');
			for(i=0;i<cur.length;i++){
				cur.item(i).innerHTML = 'T&ecirc;n';
				cur.item(i).href = 'javascript:showedit('+cur.item(i).id.replace('cur_','')+');';
				name.item(i).style.display = 'block';
				editname.item(i).style.display = 'none';
			}
			cur = document.getElementById('cur_'+id);
			name = document.getElementById('name_'+id);
			editname = document.getElementById('editname_'+id);
			cur.innerHTML = '&#272;ổi';
			cur.href = 'javascript:editname('+id+');';
			name.style.display = 'none';
			editname.style.display = 'block';
		}
		function editname(id){
			var cur = document.getElementById('cur_'+id);		
			var name = document.getElementById('name_'+id);
			var editname = document.getElementById('editname_'+id);
			var itemid = document.getElementById('itemid');
			var editnewtname = document.getElementById('editnewtname');
			if((editname.value!=null)&&(editname.value!='')){
				if(editname.value!=name.innerHTML){
					itemid.value = id;
					editnewtname.value = editname.value;
					document.forms[0].submit();
				}else{
					cur.innerHTML = 'T&ecirc;n';
					cur.href = 'javascript:showedit('+id+');';
					name.style.display = 'block';
					editname.style.display = 'none';
				}
			}else if(editname.value!=''){
				alert('Ban chua nhap ten nhom');
			}
		}
		function deleteitem(id){
			var itemid = document.getElementById('itemid');
			var editnewtname = document.getElementById('editnewtname');
			itemid.value = id;
			editnewtname.value = 'ACT_DEL';
			document.forms[0].submit();
		}
	</script>
</head>
<body style="margin: 0px 0px 0px 0px" class="text"><form method="post" name="form1" id="form1">
<?php if(mysql_affected_rows()>0){?>
	Th&ecirc;m nhóm mới&nbsp;&nbsp;<input type="text" class="textbox" name="catname" />&nbsp;&nbsp;<input type="submit" class="button" name="ACT_ADD" value="Them" />&nbsp;<?php if($_GET['CLid']){?><input type="submit" class="button" name="ACT_UP" value="Tro lai" /><?php }?>
	<div class="listitem">
		<table>
		<col width=""/><col width=""/><col width="300px"/><col width=""/><col width=""/>
			<thead>
				<tr>
					<td><input type="checkbox" onClick="javascript:checkall();" /></td>
					<td>&nbsp</td>
					<td>name</td>
					<td>action</td>
					<td>ctrl</td>
				</tr>
			</thead>
<?php $count=0;if($row = mysql_fetch_assoc($rs)){do{?>
			<tr>
				<td><input type="checkbox" name="ck[]" id="<?php echo $row['id']; ?>" value="<?php echo $row['id']?>" /></td>		
				<td class="folder_icon">&nbsp</td>
				<td>
					<input name="editname" id="editname_<?php echo $row['id']?>" class="textbox editname editname_<?php echo $row['ctrl']?>" value="<?php echo $row['name'];?>" style="display:none;"/>
					<a name="name" id="name_<?php echo $row['id']?>" class="ctrl ctrl_<?php echo $row['ctrl']?>" href="cat-list.php?CLid=<?php echo $row['id']?>"><?php echo $row['name']?></a></td>
				<td>
					<a name="cur" id="cur_<?php echo $row['id']?>" class="ctrl ctrl_<?php echo $row['ctrl']?>" href="javascript:showedit('<?php echo $row['id']?>');">T&ecirc;n</a>|
					<a class="ctrl ctrl_<?php echo $row['ctrl']?>" href="cat-edit.php?CLid=<?php echo $row['id']?>">Sửa</a>|
					<a class="ctrl ctrl_<?php echo $row['ctrl']?>" href="javascript:deleteitem('<?php echo $row['id']?>');">Xóa</a>
				</td>
				<td>
<?php 
$temp = $CATLINKEXCHANGE_CTRL;
while(list($i,$val) = each($temp )){
 	if($row['ctrl']&$i == $i){
		echo '		<div title="'.$val.'" class="ctrl ctrl_'.$i.'">&nbsp;</div>';
	}
}?>
				</td>
			</tr>
<?php $count++;}while($row = mysql_fetch_assoc($rs));}?>		
		</table>
	</div>
	<div onclick="showObject('listctrl')" class="setctrl">Thiết lập &#273;ặc tính</div>

<?php 
$ctrl = new ctrl_object();
$ctrl->ID=listctrl;
$ctrl->arr_ctrl_name =  $CATLINKEXCHANGE_CTRL;
$ctrl->text_set = 'Thiet lap';
$ctrl->text_unset = 'Huy bo';
$ctrl->text_ok = 'Thuc hien';
$ctrl->text_cancel = 'Bo qua';
$ctrl->show();
?>
	<div>
		<input type="hidden" name="itemid" id="itemid" />
		<input type="hidden" name="editnewtname" id="editnewtname" />
	</div>
<?php }else{
$cat_content='Ten nhóm &nbsp;<input type="text" class="textbox" name="catname" />&nbsp;&nbsp;<input type="submit" class="button" name="ACT_ADD" value="Them" />&nbsp;';
if($_GET['CLid']){$cat_content .= '<input type="submit" class="button" name="ACT_UP" value="Tro lai" />';}
$item_content='
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
<input type="submit" class="button" name="ACT_ADD_ITEM" value=" Th&ecirc;m " />&nbsp;';
if($_GET['CLid']){$item_content .= '<input type="submit" class="button" name="ACT_UP" value="Tro lai" />';}
$item_content.='
</td>
</tr>
</table>
</td>
</tr>
</table>
&nbsp;';
$o_tab = new tab_object();
$o_tab->arr_tab_name = array('Th&ecirc;m nhóm mới&nbsp;&nbsp;','Th&ecirc;m item');
$o_tab->arr_tab_content = array($cat_content,$item_content);
$o_tab->show();
 }?>	
</form></body>
<script src="csseventselector-rule.js" language="javascript" type="text/javascript"></script>
<script src="csseventselector.js" language="javascript" type="text/javascript"></script>
</html>
<?php dbclose();?>
