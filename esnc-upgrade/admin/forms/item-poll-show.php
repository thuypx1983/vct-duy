<?php if($this->type ==0) $icon='<input type="radio" class="input" checked="true" disabled="true" />';
elseif($this->type==POLL_TYPE_MULTIPLE) $icon='<input type="checkbox" class="input" checked="true" disabled="true" />';
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
<style type="text/css">
TR{line-height:20px;}
</style>
</head>
<body style="margin: 0px 0px 0px 0px" >
<form action="<?php echo URL_SELF ?>" method="post" onSubmit="return checkForm(this);" id="idfrmItem">
<input type="hidden" name="act" value="<?php echo ACT_SAVE ?>" />
<input type="hidden" name="id" value="<?php echo $this->id;?>" />
<input type="hidden" name="go" value="<?php echo URL_GO ?>" />
<table width="100%" cellpadding="0" cellspacing="0">
<thead>
	<tr>
		<th width="2%"  align="center">&nbsp;</th>
		<th >&nbsp;</th>
		<th colspan="4" ><font color="red">C&acirc;u h&#7887;i n&agrave;y &#273;&atilde; c&oacute; ng&#432;&#7901;i tham gia, b&#7841;n ch&#7881; c&oacute; th&#7875; thay &#273;&#7893;i,t&ecirc;n,  th&#7913; t&#7921; l&#7921;a ch&#7885;n ho&#7863;c ng&agrave;y k&#7871;t th&uacute;c</font></th>
	</tr>
</thead>
<tbody>
	<tr><td colspan="7">
		<table width="100%" cellpadding="3" cellspacing="0">
			<tr><th align="left">T&ecirc;n</th><td colspan="5"><input type="text" name="name" class="input" value="<?php echo htmlspecialchars($this->name); ?>"  style="width:90% "/></td></tr>
			<tr><th align="left">C&#226;u h&#7887;i</th><td colspan="5"><?php echo $this->question ?></td></tr>
			<tr><th align="left">Ki&#7875;u tr&#7843; l&#7901;i</th>
				<td colspan="5"><?php echo $this->a_type[(int)$this->type];?></td>
			</tr>
			<tr><th align="left">Th&#7913; t&#7921;</th>
				<td colspan="5"><input type="text" class="input" size="2" name="view" value="<?php echo $this->view?>" /></td>
			</tr>
			<tr><th align="left" >S&#7889; ng&#432;&#7901;i tham gia</th><td><?php echo (int)$this->num; ?><input type="hidden" name="num" value="<?php echo $this->num ?>" /></td>
			<th align="left">Ng&agrave;y b&#7855;t &#273;&#7847;u</th><td ><?php echo $this->thisdate; ?></td>
			<th align="left" >Ng&agrave;y k&#7871;t th&uacute;c</th><td ><input type="text" name="enddate" value="<?php echo $this->enddate; ?>" class="input" size="20"/> (v&iacute; d&#7909;: <strong style="color:red ">31-12-2099</strong>)</td></tr>			
			<tr><th align="left">&#272;&#7863;c t&iacute;nh</th><td colspan="5">
<?php
foreach($this->a_ctrl as $ctl=>$text){
	echo '<input type="checkbox" class="input input_mini" name="ctrl[]" value="'.$ctl;
	if($this->ctrl & $ctl) echo '" checked ';else echo '"';
	echo ' />'.$text.'&nbsp;';
}
?>			
			</td></tr>		</table>
	</td></tr>
	<tr ><th width="2%">&nbsp;</th>
		<th width="0%">&nbsp;</th>
		<th >L&#7921;a ch&#7885;n</th>
		<th width="6%" >Th&#7913; t&#7921;</th>		
		<th width="6%" >S&#7889; ng&#432;&#7901;i</th>		
		<th width="8%"><strong>%</strong></th>
	</tr>
	<?php $i=0;foreach($this->a_vote as $row){?>
	<tr><td><?php echo $icon; ?> </td>
		<td >&nbsp;</td>
		<td ><?php echo $row['name']; ?><input type="hidden" name="PO[<?php echo $i ?>][id]" value="<?php echo $row['id'] ?>" /></td>
		<td   align="center"><input type="text" name="PO[<?php echo $i ?>][view]" class="input" size="2" value="<?php echo $i; ?>" /></td>		
		<td  align="center"><?php echo $row['num']; ?></td>		
		<td  align="right"><?php echo number_format($row['percent']/POLL_PERCENT_UNIT,2); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>	
	<?php ++$i;}?>
</tbody></table>
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
<?php 
	dbclose();	
?>