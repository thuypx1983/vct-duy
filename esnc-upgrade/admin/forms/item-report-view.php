<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title><?php echo $this->name; ?></title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css">
</head>
<body style="margin:3px auto auto 8px ">
<table width="95%" border="0"><tbody class="text">
	<tr>
		<td class="text" width="15%">T&ecirc;n</td>
		<td class="text"><?php echo $this->name; ?></td>
	</tr>
	<tr><td>T&oacute;m t&#7855;t</td>
		<td><?php echo $this->summary ?></td>
	</tr>
	<tr><td>C&aacute;c c&#7897;t <br/></td>
		<td><?php echo $this->columns ?></td>
	</tr>	
	<tr><td>&#272;&#7863;c t&iacute;nh</td><td>
		<input type="checkbox" class="input"  <?php  if($this->type & 4) echo 'checked' ?> disabled/>Tr&igrave;nh b&agrave;y d&#7841;ng h&agrave;ng ngang
		<table border="0" width="100%">
<?php	$i=0;foreach($this->a_ctrl as $ctl => $text){ ?>
<?php 	if($i == 0){?><tr><?php }?>
		<td width="2%" class="text"><input type="checkbox" <?php if($this->ctrl & $ctl) echo 'checked' ?>  disabled></td><td class="text"><?php echo $text ?></td>
<?php if($i == CTRL_PER_ROW) { echo '</tr>'; $i = 0;} else ++$i; }?>
<?php if($i > 0) { for(;$i <= CTRL_PER_ROW;++$i) echo '<td>&nbsp;</td>'; echo '</tr>';} //padding last row ?>
		</table>
		</td>
	</tr>
</tbody></table>
<p class="text"><a href="<?php echo URL_CWD ?>item.php?RPid=<?php echo $this->id ?>&act=<?php echo ACT_REPORT ?>" class="item">Ch&#7841;y b&aacute;o c&aacute;o n&agrave;y</a> | <a href="<?php echo URL_CWD ?>item.php?RPid=<?php echo $this->id ?>&act=<?php echo ACT_DOWNLOAD ?>" class="item">T&#7843;i b&aacute;o c&aacute;o v&#7873; (d&#7841;ng CSV)</a></p>
</form>	
<script language="javascript" src="js/library.js" type="text/javascript"></script>
<script language="javascript" src="js.php" type="text/javascript"></script>
<script language="javascript" src="js/item-script.js" type="text/javascript"></script>
</body>
<script type="text/javascript" language="javascript">
window.top.document.title=self.document.title;
function doUp(){
	self.location.href='<?php echo URL_CWD ?>item-list.php';
}
</script>
</html>