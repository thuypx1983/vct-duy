<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<title><?php echo $this->name ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css"/>
<link type="text/css" rel="stylesheet" href="forms/style.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
</head>
<body style="margin: 0px 0px 0px 8px" class="text"><br>
T&ecirc;n b&aacute;o c&aacute;o: <strong><?php echo $this->name;?></strong><br><br>
Mi&ecirc;u t&#7843;:<?php echo $this->summary;?><br /><br />
<table width="95%" cellpadding="0" cellspacing="0" align="left" border="1" bordercolor="#111111" style="border-collapse:collapse;line-height:18px; ">
<thead>
	<tr><?php foreach($this->a_columns as $colname){?>
		<th><?php echo $colname ?></th>
		<?php }?>
	</tr>
</thead>
<tbody class="text">
<?php
for($i=0;($row = fetch_row($i,$this->rs)) && ($i < 20);++$i){
	echo '<tr>';
	foreach($row as $value){
		echo '<td>';
		echo $value;
		echo '</td>';
	}
	echo '</tr>';
}
?>
</tbody>
</table><br/>
<?php if($this->type & 8){?>
<p class="text" style="clear:both">T&#7893;ng s&#7889; b&#7843;n ghi <strong><?php echo $i;?></strong></p>
<?php }?>
<p class="text" style="clear:both "><a id="idadownload" href="<?php echo URL_CWD ?>item.php?RPid=<?php echo $this->id ?>&act=<?php echo ACT_DOWNLOAD ?>" class="item">T&#7843;i b&aacute;o c&aacute;o v&#7873; (d&#7841;ng CSV)</a></p>
<script language="javascript" type="text/javascript">
window.top.document.title=self.document.title;
function doSave(){
	document.getElementById("idadownload").click();
}
function doUp(){
	self.location.href="<?php echo URL_CWD ?>item-list.php";
}
</script>
</html>
