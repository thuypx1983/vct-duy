<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $this->doctitle;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="../images/style.css">
<script language="javascript" src="../js/library.js"></script>
<script language="javascript" src="../js.php"></script>
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

</script>
</head>
<body style="margin: 0px 0px 0px 0px" class="text"><table id="item-list" width="90%" cellpadding="0" cellspacing="0"  onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
	<thead>
	<tr>
		<th><input type="checkbox" onClick="javascript:setAll('id',this.checked);"></th>		
		<th width="<?php echo COL1_WIDTH ?>"><?php echo COL1_NAME ?></th>		
		<th nowrap><?php echo COL2_NAME ?></th>
		<th nowrap><?php echo COL3_NAME ?></th>
		<th nowrap><?php echo COL4_NAME ?></th>
		<th nowrap><?php echo COL5_NAME ?></th>
		<th nowrap><?php echo COL6_NAME ?></th>
		<th ><?php echo COL7_NAME ?></th>
	</tr>
	</thead>
	<tbody>
	<?php 
		$itemurl='item.php?'.urlformat($this->q,$this->alias.'id','');
	while ($row = mysql_fetch_array($this->rs)){ //begin row scan
		$ctrl_text = "";
		foreach($this->a_ctrl as $ctl => $text) if($row['ctrl'] & $ctl) $ctrl_text .= $text."|";
	?>
	<tr>
		<td align="center" style="background-color:#EFEDDE;"><input type="checkbox" name="id" value="<?php echo $row[0]; ?>" onClick="showSelected(this,this.parentNode.parentNode);"></td>
		<td align="left" nowrap><span onClick="urlgo('<?php echo $itemurl.$row[0] ?>');" style="margin:0px 0px 0px 5px;cursor:pointer;<?php if (($row['ctrl']&1)==0) echo "color:#CCCCCC"; ?>"><?php printf(FORMAT_ID_STRING,$row['id']);?></span></td>
		<td align="left" nowrap><span onClick="urlgo('<?php echo $itemurl.$row[0] ?>');" style="margin:0px 0px 0px 5px;cursor:pointer;<?php if (($row['ctrl']&1)==0) echo "color:#CCCCCC"; ?>"><?php if($row['user']) echo $row['user']; else echo '(none)';?></span></td>
		<td align="left" nowrap><?php echo $row['name']; ?>&nbsp;</td>
		<td align="left" nowrap><?php echo $row['email']?>&nbsp;</td>
		<td align="left" nowrap><?php echo $row['lastlogin']?></td>
		<td align="right" nowrap><?php echo (int)$row['visited']?></td>
		<td align="left" style="cursor:help" title="<?php echo $ctrl_text ?>"><?php echo ctrl_format($row['ctrl']); ?></td>
	</tr>	
	<?php }//end row scan ?>
	</tbody>
	<tfoot>
	<tr>		
        <td align="center">&nbsp;</td>
		<td colspan="6">
<?php 
	ctrl_setbox($this->a_ctrl);
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
		<td><?php ctrl_filterbox($this->a_ctrl,$this->ctrl)?></td></tr>
	</tfoot>
</table>
</body>
</html>
<script language="javascript" type="text/javascript" defer>
window.top.document.title = self.document.title;
var self_type='<?php echo $this->type ?>';
var url_self = '<?php echo URL_SELF;?>';
var url_up = '#';
var url_ctrl = url_self + '<?php echo '?'.urlmodify('ctrl','','nctrl',''); ?>';
var url_rename = url_self + '?<?php echo urlmodify('id',NULL,'name',NULL,'act','');?>';
var url_filter = url_self + '?<?php echo urlmodify('act',ACT_SEARCH,$this->alias.'ctrl',''); ?>';
var url_save = '#';
var url_del = url_self + '?<?php echo urlmodify('catid',$this->catid,'act',ACT_REMOVE,'id',''); ?>';
var url_move = url_self + '?<?php echo urlmodify('act',ACT_MOVE,'catid',$this->catid,'id',''); ?>';
var url_copy = url_self + '?<?php echo urlmodify('act',ACT_COPY,'catid',$this->catid,'id',''); ?>';
var url_newitem = '<?php echo dirname(URL_SELF) ?>/item.php?go='+encodeURIComponent(String(self.location.href).replace(URL_BASE,'/'));
</script>
<script language="javascript" src="../js/item-list.js"></script>
<?php dbclose(); ?>