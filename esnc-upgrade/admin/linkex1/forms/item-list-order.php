<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->doctitle;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?php echo URL_BASE_ADMIN ?>" />
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

function SHOW(id){	
	var o = document.getElementById(id);	
	if (o.style.visibility =='hidden' || o.style.visibility == ''){
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
function doSearch(){    
    document.getElementById('search').style.display = "inline";
}
function cancel(){
    document.getElementById('search').style.display = "none";
}
</script>
<style type="text/css">
select{font-family:tahoma;font-size:11px;width:170px;}
input.text{width:170px;}
div.name{
    float:left;
    width:180px;    
}
tr th.cell{    
    border-bottom:1px solid #CCCCCC;
    border-right:1px solid #CCCCCC;
    background:#EFEDDE;
}
table.search{    
    border-top:1px solid #CCCCCC;
    border-left:1px solid #CCCCCC;
    border-bottom:1px solid #CCCCCC;
    margin:5px 5px 5px 200px;    
}
table.search tr td{
    padding:3px;
    border-right:1px solid #CCCCCC;
    border-bottom:0px;
}
</style>
</head>
<body style="margin: 0px 0px 0px 0px" class="text">
<table id="item-list" width="100%" cellpadding="0" cellspacing="0"  onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
	<thead>
	<tr>
		<th><input type="checkbox" onClick="javascript:setAll('id',this.checked);"></th>		
		<th width="<?php echo COL1_WIDTH ?>"><?php echo COL1_NAME ?></th>		
		<th nowrap><?php echo COL2_NAME  ?></th>
		<th nowrap><?php echo COL3_NAME  ?></th>
		<th nowrap><?php echo COL4_NAME  ?></th>
		<th nowrap><?php echo COL5_NAME  ?></th>
		<th nowrap><?php echo COL6_NAME  ?></th>
		<th ><?php echo COL7_NAME ?></th>
	</tr>
	</thead>
	<tbody>
	<?php 
	$itemurl=URL_CWD.'item.php?'.urlformat($this->q,$this->alias.'id','');
	if (!empty($this->rs)){
	while ($row = mysql_fetch_array($this->rs)){ //begin row scan
		$ctrl_text = "";
		foreach($this->a_ctrl as $ctl => $text) if($row['ctrl'] & $ctl) $ctrl_text .= $text."|";
	?>
	<tr>
		<td align="center" style="background-color:#EFEDDE;"><input type="checkbox" name="id" value="<?php echo $row[0]; ?>" onClick="showSelected(this,this.parentNode.parentNode);"></td>
		<td align="center" nowrap><a href="<?php echo $itemurl.$row[0] ?>" class="item"><?php printf(FORMAT_ID_STRING,$row['id']);?></a></td>
		<td align="left" nowrap><a href="<?php echo $itemurl.$row[0] ?>" class="item" <?php if (($row['ctrl']& ORDER_CTRL_CANCELED)==ORDER_CTRL_CANCELED) echo 'style="color:#CCCCCC"'; ?>><?php echo $row[1] ?></a></td>
		<td align="left" nowrap><a href="mailto:<?php echo $row['custemail']; ?>" class="item"><?php echo $row[2].'&nbsp;'.$row[3]; ?></a></td>
		<td align="center" nowrap><?php echo $row['created']?></td>
		<td align="center" nowrap><?php echo $row['expireddate']?></td>
		<td align="right" nowrap><?php echo currency_format_number($row['value']);?></td>
		<td align="left" style="cursor:help" title="<?php echo $ctrl_text ?>"><?php echo ctrl_format($row['ctrl']).' '.$ORDER_STATUS[$row['status']]; ?></td>
	</tr>	
	<?php }
    }//end row scan ?>
	</tbody>
	<tfoot>
	<tr>		
        <td align="center">&nbsp;</td>
		<td colspan="6" >
<?php if($this->pagecount > 1){echo '<span class="text" >::</span>';
	$q=urlformat($this->q,$this->alias.'page','');
	for($p = 1; $p <= $this->pagecount; ++$p){ if($p != $this->page) {?>
		<a href="<?php echo "{$this->url}?{$q}{$p}" ?>" class="search">[<?php echo $p ?>]</a>
	<?php }else{ ?><span class="text" ><?php echo $p ?></span>
	<?php }
	 }
}
?>&nbsp;</td>
		<td><?php ctrl_filterbox($this->a_ctrl,$this->ctrl)?></td>
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
var url_newitem = '<?php echo dirname(URL_SELF) ?>/item.php?<?php echo urlmodify('catid',$this->catid); ?>';
</script>
<script language="javascript" src="js/item-list.js"></script>
<?php dbclose();?>