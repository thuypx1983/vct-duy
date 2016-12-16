<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $this->doctitle;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="../images/style.css">
<comment>
<link type="text/css" rel="stylesheet" href="../images/style-nonie.css" />
</comment>
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
<body style="margin: 0px 0px 0px 0px" class="text"><table id="item-list" width="100%" cellpadding="0" cellspacing="0"  onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
	<thead>
	<tr>
		<th><input type="checkbox" onClick="javascript:setAll('id',this.checked);"></th>		
		<th width="<?php echo COL2_WIDTH ?>"><?php echo COL2_NAME ?></th>
		<th width="<?php echo COL3_WIDTH ?>"><?php echo COL3_NAME ?></th>
		<th width="<?php echo COL4_WIDTH ?>"><a href="<?php echo $this->url.'?'.urlformat($this->q,$this->alias.'sortby',($this->sortby == SORTBY_VIEW_ASC ? SORTBY_VIEW_DESC : SORTBY_VIEW_ASC)) ?>" class="search"><?php echo COL4_NAME ?></a></th>
		<th ><?php echo COL5_NAME ?></th>
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
		
		<td><div onClick="urlgo('<?php echo $itemurl.$row[0] ?>');" style="margin:0px 0px 0px 5px;width:200px;overflow:hidden;height:14px;cursor:pointer;<?php if (($row['ctrl']&1)==0) echo "color:#CCCCCC"; ?>"><?php echo $row[1]; ?></div></td>
		<td nowrap><?php echo (empty($row[2]))?'(none)':$row[2]; ?></td>
		<td ><input type="text" style="width:auto;border:2px solid #FFFFFF;text-align:right;" onMouseOver="hover(this);" onFocus="hover(this);" onMouseOut="out(this);" size="5" id="<?php echo $row['id']; ?>" class="input" value="<?php echo $row['view']; ?>" name="view" /></td>
		<td align="lefl" style="cursor:help" title="<?php echo $ctrl_text ?>"><?php echo ctrl_format($row['ctrl']) ?>&nbsp;</td>
	</tr>	
	<?php } //end row scan ?>
	</tbody>
	<tfoot>
	<tr>		
        <td align="center">&nbsp;</td>
		<td colspan="2">
			<div id="attributetext" style="margin:1px 0px 1px 5px; " onClick="SHOW('attribute');HIDE('filter');"><span>Thi&#7871;t l&#7853;p &#273;&#7863;c t&#237;nh</span></div>
				<div id="attribute" style="margin:1px 0px 1px 5px; border-top:1px solid #96969D;border-right:0px;border-bottom:0px;">
				<table width="250" cellspacing="0" cellpadding="0" border="0"><tbody>
				<tr><td class="attribute">&nbsp;</td><td class="attribute" align="center">Thi&#7871;t l&#7853;p</td><td class="attribute" align="center">Hu&#7927; b&#7887;</td></tr>
			<?php
			$i=1; 
			foreach($this->a_ctrl as $ctl=>$text){
			echo '<tr><td class="attribute">&nbsp;&nbsp;'.ctrl_format($ctl).$text.'</td>
				<td class="attribute" align="center"><input id="'.$i.'" type="checkbox" name="ctrl'.$i.'" value="'.$ctl.'" onClick="singleSelect(this);"></td>
				<td class="attribute" align="center"><input id="'.($i+1).'" type="checkbox" name="ctrl'.$i.'" value="'.$ctl.'" onClick="singleSelect(this);"></td></tr>';				
				$i=$i+2;	
			}
			if(is_array($this->a_status)){
				foreach($this->a_status as $ctl=>$text){
				echo '<tr><td class="attribute">&nbsp;&nbsp;'.$text.'</td>
					<td class="attribute" align="center"><input  type="radio" name="status" value="'.$ctl.'" ></td>
					<td class="attribute">&nbsp;</td>
					</tr>';								
				$i=$i+1;	
				}
			}
			?>
				<tr><td colspan="3" align="center"><input onClick="setCtrl(ACT_SETCTRL);" type="button" value="Th&#7921;c hi&#7879;n" class="button"><input class="button" onClick="HIDE('attribute')" type="button" value="B&#7887; qua"></td></tr>
				</tbody></table>				
			</div>
<?php if($this->pagecount > 1){echo '<span class="text" >::</span>';
	$q=urlformat($this->q,$this->alias.'page','');
	for($p = 1; $p <= $this->pagecount; ++$p){ if($p != $this->page) {?>
		<a href="<?php echo "{$this->url}?{$q}{$p}" ?>" class="search">[<?php echo $p ?>]</a>
	<?php }else{ ?><span class="text" ><?php echo $p ?></span>
	<?php }
	 }
}
?>		
		</td>
		<td align="center" ><img src="../images/save.gif" onClick="doSave();" alt="Ghi l&#7841;i thay &#273;&#7893;i th&#7913; t&#7921;" title="Ghi l&#7841;i thay &#273;&#7893;i th&#7913; t&#7921;" class="imgbutton" /></td>
		<td>
			<div id="attributetext" style="margin:1px 20px 1px 5px; " onClick="SHOW('filter');HIDE('attribute');"><span>L&#7885;c theo &#273;&#7863;c t&#237;nh</span></div>
				<div id="filter" style="margin:1px 0px 1px 0px; border-top:1px solid #96969D;border-right:0px;border-bottom:0px;">
				<table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody>		
				<tr><td class="attribute">&nbsp;T&#7845;t c&#7843; c&#225;c m&#7909;c</td><td class="attribute" align="center"><input type="checkbox" name="ctrl0" value="0"></td></tr>		
			<?php
			$i=1; 
			foreach($this->a_ctrl as $ctl=>$text){
			$checked =($this->ctrl & $ctl)?'checked':'';
			echo '<tr><td class="attribute">&nbsp;&nbsp;'.ctrl_format($ctl).$text.'</td>
				<td class="attribute" align="center"><input id="'.$i.'" type="checkbox" name="ctrl" value="'.$ctl.'" '.$checked .'></td>
				</tr>';								
				$i=$i+1;	
			}
			?>
				<tr><td colspan="2" align="center"><input onClick="filterFeature('ctrl');" type="button" class="button" value="Th&#7921;c hi&#7879;n"><input class="button" onClick="HIDE('filter')" type="button" value="B&#7887; qua"></td></tr>
				</tbody></table>				
			</div>		
	</tr>
	</tfoot>
</table>
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
var url_newitem = '<?php echo dirname(URL_SELF) ?>/item.php?go='+encodeURIComponent(String(self.location.href).replace(URL_BASE,'/'));
</script>
<script language="javascript" src="../js/item-list.js"></script>