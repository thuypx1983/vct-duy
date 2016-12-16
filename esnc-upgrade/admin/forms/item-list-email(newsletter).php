<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $this->doctitle;?></title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css">
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

function doMail(){		
	var Reception = getChecked('id');
	if(Reception != '' && Reception  != null)
		self.location.href='<?php echo dirname(URL_SELF) ?>/item.php?id='+Reception;
}
</script>
</head>
<body style="margin: 0px 0px 0px 0px" class="text"><table id="item-list" width="90%" cellpadding="0" cellspacing="0"  >
	<thead>
	<tr>
		<th><input type="checkbox" onClick="javascript:setAll('id',this.checked);"></th>		
		<th width="<?php echo COL1_WIDTH ?>"><?php echo COL1_NAME ?></th>		
		<th nowrap valign="middle"><?php echo COL2_NAME ?></th>
		<th nowrap><?php echo COL3_NAME ?></th>		
		<th ><?php echo COL7_NAME ?></th>
	</tr>
	</thead>
	<tbody style="display:none " id="dlgNewItem">
	<form action="<?php echo URL_SELF ?>">
	<tr >
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<input type="hidden" name="act" value="<?php echo ACT_ADD ?>" />
		<input type="text" id="inputEmail" class="input" name="email" size="60" style="border:1px solid #000000;width:auto" value="&#272;&#7883;a ch&#7881; email..." onFocus="clearTextBox(this);"  onClick="clearTextBox(this);"/>
		</td>
		<td>
		<input type="image" src="images/save.gif" class="imgbutton"/>
		</td>
		<td>&nbsp;</td>
	</tr>
	</form>
	</tbody>
	<tbody>
	<?php 
		$itemurl='item.php?'.urlformat($this->q,$this->alias.'id','');
		while ($row = mysql_fetch_row($this->rs)){ //begin row scan
		$ctrl_text = "";
		foreach($this->a_ctrl as $ctl => $text) if($row['ctrl'] & $ctl) $ctrl_text .= $text."|";
	?>
	<tr>
		<td align="center" style="background-color:#EFEDDE;"><input type="checkbox" name="id" value="<?php echo $row[0]; ?>" onClick="showSelected(this,this.parentNode.parentNode);"></td>
		<td align="right" nowrap><?php printf(FORMAT_ID_STRING,$row['0']);?></td>
		<td align="right" nowrap>[<a href="mailto:<?php echo $row[1]; ?>" class="item" <?php ($row['ctrl'] & 1 == 0) and print ('style="color:#cccccc"'); ?>><?php echo $row[1]; ?></a>]</td>
		<td align="center" nowrap><?php echo $row['3']; ?></td>		
		<td align="left" style="cursor:help" title="<?php echo $ctrl_text ?>"><?php echo ctrl_format($row['']); ?></td>
	</tr>	
	<?php }//end row scan ?>
	</tbody>
	<tfoot>
	<tr>		
        <td align="center">&nbsp;</td>
		<td colspan="3" >
<?php if($this->pagecount > 1){echo '<span class="text" >::</span>';
	$q=urlformat($this->q,$this->alias.'page','');
	for($p = 1; $p <= $this->pagecount; ++$p){ if($p != $this->page) {?>
		<a href="<?php echo "{$this->url}?{$q}{$p}" ?>" class="search">[<?php echo $p ?>]</a>
	<?php }else{ ?><span class="text" ><?php echo $p ?></span>
	<?php }
	 }
}
?>&nbsp;</td>
		<td><?php ctrl_filterbox($this->a_ctrl,$this->ctrl)?></td></tr>
	</tfoot>
</table>
</body>
</html>
<script language="javascript" type="text/javascript" defer>
window.top.document.title = self.document.title;
var self_type='<?php echo $this->type ?>';
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo URL_SELF ?>';
var url_ctrl = url_self + '<?php echo '?'.urlmodify('ctrl','','nctrl',''); ?>';
//var url_rename = url_self + '?<?php echo urlmodify('id',NULL,'name',NULL,'act','');?>';
var url_filter = url_self + '?<?php echo urlmodify('act',ACT_SEARCH,$this->alias.'ctrl',''); ?>';
//var url_save = url_self + '?<?php echo urlmodify('act',ACT_REORDER,'idvalue','') ?>';
var url_del = url_self + '?<?php echo urlmodify('act',ACT_REMOVE,'id',''); ?>';
//var url_move = url_self + '?<?php echo urlmodify('act',ACT_MOVE,'id',''); ?>';
//var url_copy = url_self + '?<?php echo urlmodify('act',ACT_COPY,'id',''); ?>';
var url_newitem='#';
</script>
<script language="javascript" src="js/item-list.js"></script>
<script language="javascript" type="text/javascript">
function doNewItem(){
	document.getElementById('dlgNewItem').style.display='';
	document.getElementById('inputEmail').focus();
	document.getElementById('inputEmail').select();
}
</script>
<?php dbclose(); ?>