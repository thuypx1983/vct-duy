<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<base href="<?php echo URL_BASE_ADMIN ?>" />
<title>Bao cao</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="images/style.css" />
<script language="javascript" src="js/library.js" type="text/javascript"></script>
<script language="javascript" src="js.php" type="text/javascript"></script>
</head>
<body>
<form id="idfrmItem" action="<?php echo URL_SELF.'?'.urlformat($this->q,'act',ACT_SAVE,'id',$this->id); ?>" method="post" onSubmit="return checkForm(this);">	
<table width="97%" border="0"><tbody class="text">
	<tr>
		<td class="text" width="15%">T&ecirc;n</td>
		<td class="text"><input name="name" class="input" value="<?php echo htmlspecialchars($this->name); ?>" style="width:95%; "/></td>
	</tr>
	<tr><td>T&oacute;m t&#7855;t</td>
		<td><textarea name="summary" class="input" style="width:95%;"><?php echo $this->summary ?></textarea>
		</td>
	</tr>
	<tr><td>C&aacute;c c&#7897;t <br/>(d&ugrave;ng | ph&acirc;n bi&#7879;t)</td>
		<td><textarea name="columns" class="input" style="width:95%;"><?php echo $this->columns ?></textarea>
		</td>
	</tr>	
	<tr><td>&#272;&#7863;c t&iacute;nh</td><td>
		<input type="checkbox" value="1" class="input_mini"  name="type[]" <?php if($this->type & 1) echo 'checked' ?>/>H&#7879; th&#7889;ng&nbsp;&nbsp;
		<input type="checkbox" value="2" class="input_mini" name="type[]" <?php  if($this->type & 2) echo 'checked' ?> />SQL&nbsp;&nbsp;
		<input type="checkbox" value="4" class="input_mini" name="type[]" <?php  if($this->type & 4) echo 'checked' ?> />Tr&igrave;nh b&agrave;y d&#7841;ng h&agrave;ng ngang
		<input type="checkbox" value="8" class="input_mini" name="type[]" <?php if($this->type & 8) echo 'checked' ?> />Hi&#7879;n t&#7893;ng s&#7889; d&ograve;ng cu&#7889;i b&aacute;o c&aacute;o<br/>
		<input type="checkbox" value="16" class="input_mini" name="type[]" <?php if($this->type & 0x10) echo 'checked' ?> />B&#225;o c&#225;o ngo&#224;i(PATH_COMPONENT.report.php)
<?php	
foreach($this->a_ctrl as $ctl => $text){ 
	echo '<input type="checkbox" value="'.$ctl.'" name="ctrl[]" class="input_mini" '; if($this->ctrl & $ctl) echo 'checked'; echo ' />';echo $text;
}
?>
	</td></tr>
	<tr><td class="text">M&atilde;</td><td><textarea name="detail" style="width:95%;height:350px;font-family:'Courier New', Courier, mono;font-size:12px" class="input"><?php echo $this->detail; ?></textarea></td></tr>
</tbody></table>
</form>	
</body>
<script src="js/item-script.js" type="text/javascript"></script>
<script type="text/javascript">
var url_up='report/item-list.php';
var frmItem = document.getElementsByTagName('form').item(0);
function checkForm(f){
	return true;
}
</script>
</html>