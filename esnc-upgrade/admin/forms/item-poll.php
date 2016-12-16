<?php
if($this->type == POLL_TYPE_MULTIPLE) $icon='<input type="checkbox" checked="true" disabled="true" />';
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->doctitle;?></title>
<link type="text/css" rel="stylesheet" href="images/style.css" />
<link type="text/css" rel="stylesheet" href="forms/style.css" />
<script language="javascript" src="js/library.js" type="text/javascript"></script>
<script language="javascript" src="js.php" type="text/javascript"></script>
</head>
<body >
<form action="<?php echo URL_SELF ?>" method="post" enctype="application/x-www-form-urlencoded" onSubmit="return checkForm(this);" id="idfrmItem">
<input type="hidden" name="act" value="<?php echo ACT_SAVE ?>" />
<input type="hidden" name="id" value="<?php echo $this->id;?>" />
<input type="hidden" name="go" value="<?php echo URL_GO ?>" />
<table width="100%" cellpadding="0" cellspacing="0" >
<thead>
	<tr >
		<th width="2%"  align="center">&nbsp;</th>
		<td >&nbsp;</th>
		<th colspan="4" >&#272;i&#7873;u tra th&#7883; tr&#432;&#7901;ng</th>
	</tr>
</thead>
	<tbody >
	<tr><td colspan="7">
		<table width="100%" cellpadding="3" cellspacing="0">
			<tr><td>T&ecirc;n cu&#7897;c &#273;i&#7873;u tra</td><td colspan="5"><input type="text" value="<?php echo htmlspecialchars($this->name); ?>" name="name" class="input" style="width:90% "/></td></tr>
			<tr><td>C&#226;u h&#7887;i &#273;i&#7873;u tra</td><td colspan="5"><textarea name="question" style="width:90%" class="input"><?php echo $this->question ?></textarea></td></tr>
			<tr><td>Ki&#7875;u tr&#7843; l&#7901;i</td>
				<td colspan="5"><select name="type" class="input">
<?php 
foreach($this->a_type as $type=>$text){
	echo '<option value="'.$type.'" ';
	if($this->type == $type) echo ' selected';
	echo '>'.$text.'</option>';
}
				?></select></td>
			</tr>
			<tr><td align="left">Th&#7913; t&#7921;</td>
				<td colspan="5"><input type="text" class="input" size="2" name="view" value="<?php echo $this->view?>" /></td>
			</tr>
			<tr><td >S&#7889; ng&#432;&#7901;i tham gia</td><td><?php echo (int)$this->num; ?></td>
			<td >Ng&agrave;y b&#7855;t &#273;&#7847;u</td><td ><input type="text" name="thisdate" value="<?php echo $this->thisdate; ?>" class="input" size="20"/></td>
			<td >Ng&agrave;y k&#7871;t th&uacute;c</td><td ><input type="text" name="enddate" value="<?php echo $this->enddate; ?>" class="input" size="20"/> (v&iacute; d&#7909;: <strong style="color:red "><?php echo strftime(FORMAT_DATETIME) ?></strong>)</td></tr>			
			<tr><td>&#272;&#7863;c t&iacute;nh</td><td colspan="5">
<?php
foreach($this->a_ctrl as $ctl=>$text){
	echo '<input type="checkbox" class="input input_mini" name="ctrl[]" value="'.$ctl;
	if($this->ctrl & $ctl) echo '" checked ';else echo '"';
	echo ' />'.$text.'<br/>';
}
?>			
			</td></tr>
		</table>
	</td></tr>
	<tr height="23" ><td width="2%">&nbsp;</td>
		<td width="0%">&nbsp;</td>
		<td >L&#7921;a ch&#7885;n <?php if($this->id >0) {?>(mu&#7889;n th&ecirc;m l&#7921;a ch&#7885;n d&ugrave;ng n&uacute;t <a href="#" onClick="doNew();return false;" class="item" style="font-weight:bold ">t&#7841;o m&#7899;i</a>,mu&#7889;n x&oacute;a l&#7921;a ch&#7885;n th&igrave; &#273;&aacute;nh d&#7845;u <strong>xo&aacute;
</strong>)<?php }?></td>
		<td width="6%" align="center">Th&#7913; t&#7921;</td>		
		<td width="0%" align="center">&nbsp;</td>		
		<td width="0%" align="center">Xo&aacute;</td>
	</tr>
	<?php $i=0; foreach($this->a_vote as $row){?>
	<tr><td><?php echo $icon; ?> </td>
		<td >&nbsp;</td>
		<td ><input type="text" name="PO[<?php echo $i ?>][name]" value="<?php echo htmlspecialchars($row['name']); ?>" class="input" style="width:95%; "/></td>
		<td align="center"><input type="text" name="PO[<?php echo $i ?>][view]" class="input" size="2" value="<?php echo $i; ?>" /></td>		
		<td align="center"><input type="hidden" name="PO[<?php echo $i ?>][id]" value="<?php echo $row['id'] ?>" /></td>		
		<td  ><input type="checkbox" name="PO[<?php echo $j ?>][flag]" value="del" /></td></tr>	
	<?php ++$i;}?>
</tbody>
	<tbody id="idnewAnswer" <?php if($this->id > 0) echo 'style="display:none"'?>>
	<?php $j=$i;$i += 12; for(;$j < $i;++$j){?>
	<tr><td><?php echo $icon; ?></td>
		<td >&nbsp;</td>
		<td ><input type="text" name="PO[<?php echo $j ?>][name]" value="" class="input" style="width:95%; "/></td>
		<td align="center"><input type="text" size="2" name="PO[<?php echo $j ?>][view]" value="<?php echo $j; ?>" class="input" /></td>		
		<td align="center">&nbsp;<input type="hidden" name="PO[<?php echo $j ?>][flag]" value="add" /></td>		
		<td  >&nbsp;</td></tr>	
	<?php }?>
	</tbody>
</table>
</form>
</body>
<script language="javascript" type="text/javascript">
window.top.document.title = self.document.title;
var self_type='<?php echo $this->type ?>';
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo URL_GO ?>';
var url_ctrl = '#';
var url_rename = '#';
var url_filter = '#';
var url_save = '#';
var url_del = '#';
var url_move = '#';
var url_copy = '#';
var url_newitem = '<?php echo dirname(URL_SELF) ?>/item.php?go=<?php echo urlencode(URL_PAGE); ?>';
var frmItem = document.getElementById('idfrmItem');
</script>
<script language="javascript" src="js/item-script.js"></script>
<script language="javascript" type="text/javascript">
function doNew(){ document.getElementById('idnewAnswer').style.display='';}
function checkForm(f){return true;}
</script>
</html>
<?php dbclose();?>