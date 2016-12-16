<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Qu&#7843;n l&yacute; th&#432; vi&#7879;n t&agrave;i li&#7879;u, th&#432; vi&#7879;n &#7843;nh...</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../images/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php echo $this->url.'?'.urlformat($this->q,'act',ACT_SAVE) ?>" method="post" enctype="multipart/form-data">
<table width="100%"  border="0">
	<tr>
		<td class="text" width="15%">L&#7921;a ch&#7885;n</td>
		<td><input name="userfile" type="file" class="input" /></td>
	</tr>
	<tr>
		<td class="text">Mi&ecirc;u t&#7843; ng&#7855;n g&#7885;n</td>
		<td class="text"><input name="desc" type="text" class="input" style="width:400px" value="<?php echo $this->desc ?>" />
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input  type="submit" class="input" value="&#272;&#7891;ng &yacute;" />
			<input type="reset" class="input" value="Nh&#7853;p l&#7841;i" />
	</td>
	</tr>
	<tr>
		<td class="text">K&#7871;t qu&#7843;
		</td>
		<td id="idhtmlView"><?php $this->htmlview()?></td>	
	</td>
	</tr>
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript" defer>
var doc = document.getElementById('idhtmlView');
var indesc = document.getElementsByName('desc').item(0);
<?php if($this->act == ACT_OPEN){?>o = self.opener.<?php echo $this->fn ?>(null,null,null,true);
/*	window.alert(typeof(o));
	for(p in o){indesc.value = indesc.value + String(p);}*/
	doc.innerHTML = o.htmlView;
	indesc.value = o.desc;
	<?php }
else{ ?>
self.opener.<?php echo $this->fn ?>(<?php echo $this->name ? "'{$this->name}'": 'null'?>,<?php echo $this->desc ? "indesc.value":'null' ?>,doc.innerHTML,false);
<?php }?>
</script>
