<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<title><?php echo $this->doctitle;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
<link type="text/css" rel="stylesheet" href="forms/style.css" />
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
<style>
thead tr{height:15px;background-color:#EFEDDE;}
thead tr th{
	font-weight:normal;
	border-right:1px solid #ACA899;
	border-bottom:1px solid #ACA899;
}
tbody tr td{
	padding:1px;
	border-right:1px solid #C0C0C0;
	border-bottom:1px solid #C0C0C0;
}
tfoot tr{height:15px; background-color:#EFEDDE;}
tfoot tr td{
	border-right:1px solid #ACA899;
	border-bottom:1px solid #ACA899;
	vertical-align:middle;
}
td.attribute{
	background:#FFFFFF;
}
</style>
<script language="javascript" type="text/javascript">
function showSelected(child,parent){
	var v =  document.getElementById(child.value);
	if (child.checked){
		parent.style.backgroundColor = "#A9D2EB";		
		v.style.backgroundColor = "#A9D2EB";
		v.style.border = "2px solid #A9D2EB";
	}else{
		parent.style.backgroundColor = "#FFFFFF";
		v.style.backgroundColor = "#FFFFFF";
		v.style.border = "2px solid #FFFFFF";
	}
}
function hover(o){
	var c = document.getElementsByName('id');
	var l = c.length;
	for (var i = 0; i<l;i++){
		if ((c[i].checked) &&(o.id == c[i].value)){
			o.style.border='2px solid #FFFFFF';
			return;
		}
	}
	o.style.border='2px solid #000000';
}
function out(o){
	var c = document.getElementsByName('id');
	var l = c.length;
	for (var i = 0; i<l;i++){
		if ((c[i].checked) &&(o.id == c[i].value)){
			o.style.border='2px solid #A9D2EB';
			return;
		}
	}	
	o.style.border='2px solid #FFFFFF';
}

function SHOW(id){	
	var o = document.getElementById(id);	
	if (o.style.visibility =='hidden' || o.style.visibility ==''){
		o.style.visibility='visible';
	}
	else{
		o.style.visibility='hidden';
	}
	if (o.clientWidth<154) o.style.width= '154px';
}
function HIDE(id){
	var o = document.getElementById(id);	
	o.style.visibility ='hidden';
}
</script>
</head>
<body style="margin: 0px 0px 0px 0px;width:770px;" class="text">
<table width="100%" cellpadding="0" cellspacing="0"  onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
	<thead>
	<tr>
		<th><input class="input input_mini" type="checkbox" onClick="javascript:setAll('id',this.checked);" /></th>		
		<th width="<?php echo COL7_WIDTH ?>"><?php echo COL7_NAME ?></th>
		<th width="<?php echo COL2_WIDTH ?>"><?php echo COL2_NAME ?></th>
		<th width="<?php echo COL3_WIDTH ?>"><?php echo COL3_NAME ?></th>
		<!--th width="<?php echo COL4_WIDTH ?>"><?php echo COL4_NAME ?></th-->
		<th width="<?php echo COL5_WIDTH ?>"><a href="<?php echo $this->url.'?'.urlformat($this->q,$this->alias.'sortby',($this->sortby == SORTBY_VIEW_ASC ? SORTBY_VIEW_DESC : SORTBY_VIEW_ASC)) ?>" class="search"><?php echo COL5_NAME ?></a></th>
		<th ><?php echo COL6_NAME ?></th>
	</tr>
	</thead>
	<tbody>
	<?php 		
		$itemurl=URL_CWD.'item.php?'.urlformat($this->q,$this->alias.'id','');
	while ($row = mysql_fetch_array($this->rs)){ //begin row scan
		$ctrl_text = "";
		foreach($this->a_ctrl as $ctl => $text) if($row['ctrl'] & $ctl) $ctrl_text .= $text."|";
	?>
	<tr>
		<td align="center" style="background-color:#EFEDDE;"><input type="checkbox" name="id" value="<?php echo $row[0]; ?>" onClick="showSelected(this,this.parentNode.parentNode);"></td>
		<td onClick="urlgo('<?php echo $itemurl.$row[0] ?>');" style="cursor:pointer "><?php echo $row['code']; ?>&nbsp;</td>
		<td align="left"><span onClick="urlgo('<?php echo $itemurl.$row[0] ?>');" style="margin:0px 0px 0px 5px;cursor:pointer;<?php if (($row['ctrl']&1)==0) echo "color:#CCCCCC"; ?>"><?php echo (empty($row[1]))?'(none)':$row[1] ?>&nbsp;</span></td>
		<td align="center" nowrap><a href="<?php echo URL_CWD ?>photo-list.php?PPproductid=<?php echo $row['id'] ?>&PPpagesize=20&<?php echo CATALIAS ?>id=<?php echo $this->catid ?>&PDpage=<?php echo $this->page ?>&PDpagesize=<?php echo $this->pagesize ?>" class="item">&#7842;nh</a>
			<a href="<?php echo URL_CWD ?>meta.php?<?php echo ALIAS ?>id=<?php echo $row['id'] ?>&<?php echo CATALIAS ?>id=<?php echo $this->catid ?>&PDpage=<?php echo $this->page ?>&PDpagesize=<?php echo $this->pagesize ?>" class="item" style="border-left:1px solid darkgray;padding-left:3px; ">Meta</a>
			<a href="<?php echo URL_CWD ?>link.php?<?php echo ALIAS ?>id=<?php echo $row['id'] ?>&<?php echo CATALIAS ?>id=<?php echo $this->catid ?>&PDpage=<?php echo $this->page ?>&PDpagesize=<?php echo $this->pagesize ?>" class="item"  style="border-left:1px solid darkgray;padding-left:3px; ">Li&ecirc;n quan</a>
			<a href="<?php echo URL_CWD ?>review.php?<?php echo ALIAS ?>id=<?php echo $row['id'] ?>&<?php echo CATALIAS ?>id=<?php echo $this->catid ?>&PDpage=<?php echo $this->page ?>&PDpagesize=<?php echo $this->pagesize ?>" class="item"  style="border-left:1px solid darkgray;padding-left:3px; ">L&#7901;i b&igrave;nh</a>
			<?php 
			if(PRICE_MANAGER_TYPE == 1)
				echo '<a href="'.URL_CWD.'package.php?'.ALIAS.'id='.$row['id'].'&'.CATALIAS.'id='.$this->catid.'&PDpage='.$this->page.'&PDpagesize='.$this->pagesize.' "class="item"  style="border-left:1px solid darkgray;padding-left:3px; ">Package</a>';
			?>
		</td>
		<!--td align="right"><?php echo $row[3] ?>&nbsp;</td-->
		<td align="center"><input type="text" style="width:auto;border:2px solid #FFFFFF;text-align:right;" onMouseOver="hover(this);" onFocus="hover(this);" onMouseOut="out(this);" size="5" id="<?php echo $row['id']; ?>" class="input" value="<?php echo $row[4]; ?>" name="view" /></td>
		<td align="left" style="cursor:help" title="<?php echo $ctrl_text ?>"><?php echo ctrl_format($row['ctrl']); ?></td>
	</tr>	
	<?php }//end row scan?>
	</tbody>
	<tfoot>
	<tr>		
        <td align="center"><a href="<?php echo URL_CWD ?>index.php?<?php echo $this->catalias."parentid={$this->catid}" ?>" class="item item_icon" >&nbsp;</a></td>
		<td colspan="3">
<?php 
	ctrl_setbox($this->a_ctrl,$this->a_status);
	if($this->pagecount > 1){echo '<span class="text" >::</span>';
	$q=urlformat($this->q,$this->alias.'page','');
	for($p = 1; $p <= $this->pagecount; ++$p){ if($p != $this->page) {?>
		<a href="<?php echo "{$this->url}?{$q}{$p}" ?>" class="search">[<?php echo $p ?>]</a>
	<?php }else{ ?><span class="text" ><?php echo $p ?></span>
	<?php }
	 }
}
?>           
        </td>
		<td align="center" ><div id="bnSave" class="imgbutton" style="width:22px;height:22px;" onClick="doSave();" title="Ghi l&#7841;i thay &#273;&#7893;i th&#7913; t&#7921;">&nbsp;</div></td>
		<td><?php ctrl_filterbox($this->a_ctrl,$this->ctrl);?></td></tr>
	</tfoot>
</table>
<form action="<?php echo URL_SELF ?>" method="get" id="idfrmSearch">
<input type="hidden" value="<?php echo ACT_SEARCH ?>" name="act" />
<table width="350px">
	<tr><th colspan="2">T&igrave;m ki&#7871;m</th></tr>
	<tr><td>T&#7915; kho&aacute;</td><td><input type="text" class="input search_hint" name="q" value="<?php echo $_GET['q']; ?>"  /></td></tr>
	<tr><td>&#272;&#7863;c t&iacute;nh</td>
		<td><?php foreach($this->a_ctrl as $ctl => $text){?>
		<div class="ctrl_list"><input type="checkbox" class="input input_mini" value="<?php echo $ctl ?>" <?php if($this->ctrl & $ctl) echo checked ?> name="<?php echo ALIAS ?>ctrl[]" /><?php echo $text ?></div>
		<?php }?>
		</td></tr>
	<tr><td>T&igrave;m theo m&atilde;</td><td><input type="text" class="input search_hint" name="<?php echo ALIAS ?>code" value="<?php echo $_REQUEST[ALIAS.'code'] ?>" /> </td></tr>
	<tr><td>T&igrave;m theo ID</td><td><input type="text" class="input search_hint" name="<?php echo ALIAS ?>id" value="<?php echo $_REQUEST[ALIAS.'id'] ?>" /> </td></tr>
	<tr><td align="center" colspan="2"><input type="submit" value="Th&#7921;c hi&#7879;n" class="button" />&nbsp;<input type="button" value="&#272;&oacute;ng" class="button" onclick="noSearch();"/></td></tr>
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript" defer>
window.top.document.title = self.document.title;
var self_type='<?php echo $this->type ?>';
var url_self = '<?php echo URL_SELF;?>';
var url_up = url_self + '?<?php echo $this->catalias.'parentid='.$this->grandparentid; ?>';
var url_ctrl = url_self + '<?php echo '?'.urlmodify('ctrl','','nctrl',''); ?>';
var url_rename = url_self + '?<?php echo urlmodify('id',NULL,'name',NULL,'act','');?>';
var url_filter = url_self + '?<?php echo urlmodify('act',ACT_SEARCH,$this->alias.'ctrl',''); ?>';
var url_save = url_self + '?<?php echo urlmodify('act',ACT_REORDER,'idvalue','') ?>';
var url_del = url_self + '?<?php echo urlmodify('catid',$this->catid,'act',ACT_REMOVE,'id',''); ?>';
var url_move = url_self + '?<?php echo urlmodify('act',ACT_MOVE,'catid',$this->catid,'id',''); ?>';
var url_copy = url_self + '?<?php echo urlmodify('act',ACT_COPY,'catid',$this->catid,'id',''); ?>';
var frmSearch = document.getElementById('idfrmSearch');
</script>
<script language="javascript" src="js/item-list.js"></script>
<script language="javascript" type="text/javascript">
<?php if($this->catid) echo 'var url_newitem="'.dirname(URL_SELF).'/item.php?'.urlmodify('catid',$this->catid,$this->alias.'id',NULL).'";'; 
else echo 'function doNewItem(){window.alert("Day la mot ket qua tim kiem khong thuoc nhom nao.\nBan phai chon mot nhom o cay ben trai\nroi moi tao doi tuong duoc");}' ;?>;
</script>
<?php dbclose(); ?>