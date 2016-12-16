<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->doctitle ?></title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css">
<link type="text/css" rel="stylesheet" href="forms/style.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
</head>
<body style="margin: 0px 0px 0px 0px" class="text">
<table width="100%" cellpadding="0" cellspacing="0">
<thead>
        <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>Nh&oacute;m n&#7897;i dung t&#297;nh</th>
                <th title="H&#7879; th&#7889;ng ch&#7881; cho ph&eacute;p b&#7841;n l&agrave;m vi&#7879;c v&#7899;i c&aacute;c ki&#7875;u t&#7853;p tin n&agrave;y, c&aacute;c ki&#7875;u t&#7853;p tin kh&aacute;c l&agrave; kh&ocirc;ng &#273;&#432;&#7907;c ph&eacute;p">Ch&#7885;n c&aacute;c ki&#7875;u t&#7853;p tin th&ocirc;ng d&#7909;ng (c&aacute;c ki&#7875;u kh&aacute;c ch&#7885;n &#7903; d&#432;&#7899;i)</th>
        </tr>
</thead>
        <?php foreach($this->rs as $id=>$name){//begin row scan
		$itemlisturl="item-list.php?{$this->alias}id={$id}&FFext=";
        ?>
<tbody>
        <tr class="folderlist" valign="middle">
			<td ><input class="input" type="radio" name="FLid" value="<?php echo $id ?>" /></td>
			<td ><img src="images/folder.gif" border="0" /></td>
			<td nowrap><?php echo $name; ?></td>
			<td align="center"><?php foreach($this->a_type as $tid=>$t){ if ($tid > 20) break; ?><a href="<?php echo $itemlisturl.$tid; ?>" class="item"><?php echo $t ?></a>&nbsp;&nbsp;<?php  ++$i;}?></td>
        </tr>
        <?php } //end row scan?>
        <tr>
</tbody>
<tfoot>
		<tr>
			<td colspan="3">&nbsp;
<?php if($this->pagecount > 1){echo '<span class="text" >::</span>';
	$q=urlformat($this->q,$this->alias.'page','');
	for($p = 1; $p <= $this->pagecount; ++$p){ if($p != $this->page) {?>
		<a href="<?php echo "{$this->url}?{$q}{$p}" ?>" class="search">[<?php echo $p ?>]</a>
	<?php }else{ ?><span class="text" ><?php echo $p ?></span>
	<?php }
	 }
}
?>		</td>
		<td nowrap align="center">Ch&#7885;n  th&#432; m&#7909;c sau &#273;&oacute; ch&#7885;n ki&#7875;u t&#7853;p tin &#273;&#7875; l&agrave;m vi&#7879;c
			<select class="input" onChange="navigateFolder(this);">
			<?php 
			$navfolder = dirname(URL_SELF);
			foreach($this->a_type as $tid=>$t){
			 echo '<option value="';
			 echo $navfolder;
			 echo '/item-list.php?FFext=';
			 echo $tid;
			 echo '&FLid=">*.';
			 echo $t;
			 echo '</option>';
			 }?>
			</select>
		</td>
	</tr>
</tfoot>
</table>
</body>
</html>
<script language="javascript" type="text/javascript">
window.top.document.title=self.document.title;//set title for window
function navigateFolder(o){
	a=document.getElementsByName('FLid');
	for(i = 0;i < a.length; ++i){
		if(a.item(i).checked){
			self.location.href=o.value + a.item(i).value;
			return;
		}
	}
	parent.banner.setStatus('B&#7841;n c&#7847;n ch&#7885;n m&#7897;t nh&oacute;m sau &#273;&oacute; ch&#7885;n ki&#7875;u t&#7853;p tin');
}
function doNew(){
}
function doCancel(){
}
function doUp(){
}
function setCtrl(act,o){
}
function doSave(){
}
function doDel(){
}
function doCopy(c){//c=clipboard
}
function doCut(c){
}
function doPaste(c){
}
function doNewItem(){
}
function doLink(c){
}
</script>