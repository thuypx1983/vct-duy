<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->doctitle ?></title>
<base href="<?php echo URL_BASE_ADMIN ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css"/>
<link type="text/css" rel="stylesheet" href="forms/style.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
<style type="text/css">
DIV#imageViewer{
position:absolute;
z-index:1;
top:10px;left:10px;
border:1px solid #FFF000;
cursor:pointer;
background-color:#006633;
display:none;
}
DIV#imageViewer *{
	padding:5px;
}
</style>
</head>
<body style="margin: 0px 0px 0px 0px" class="text">
<table width="100%" cellpadding="0" cellspacing="0">
<thead>
	<tr>
		<th align="center">&nbsp;</th>
		<th >&nbsp;</th>
		<th class="action">H&agrave;nh &#273;&#7897;ng</th>
	</tr>
</thead>
<tbody>
<?php 
unset($FILE_ALLOW_EDIT_PATH[$this->FLid]);
foreach($FILE_ALLOW_EDIT_PATH as $key=>$value){?>
	<tr>
		<td class="folder_icon" style="background-image:url(images/base.gif); ">&nbsp;</td>
		<td><a href="<?php echo URL_SELF.'?FFextid='.$this->extid.'&FLid='.$key ?>" class="item"><?php echo $FILE_ALLOW_EDIT_URL[$key];?></a></td>
		<td class="action">(Th&#432; m&#7909;c c&#417; b&#7843;n)</td>
	</tr>
<?php }?>
	<tr>
		<td class="folder_icon">&nbsp;</td>
		<td style="font-weight:bold; "><?php echo $this->FLurl.$this->FLsubFolder ?></td>
		<td class="action">(Th&#432; m&#7909;c hi&#7879;n th&#7901;i)</td>
	</tr>
</tbody>
<tr><td colspan="3">&nbsp;</td></tr>
<tbody >
<?php if($this->FLparent){?>
<tr>
	<td class="folder_icon">&nbsp;</td>
	<td ><a href="<?php echo URL_SELF.'?'.urlmodify('FLsubFolder',$this->FLparent)?>" class="item">..</a><script language="javascript">function doUp(){self.location.replace("<?php echo URL_SELF.'?'.urlmodify('FLsubFolder',$this->FLparent)?>");}</script></td>
	<td class="action">&nbsp;<a href="<?php echo URL_SELF.'?'.urlmodify('FLsubFolder',$this->FLparent)?>" class="item">L&ecirc;n</a></td>
</tr>
<?php }?>
</tbody>
<tbody>
<?php foreach($this->rsFolder as $i=>$row){?>
<tr>
	<td class="folder_icon">&nbsp;</td>
	<td ><a href="<?php echo URL_SELF.'?'.urlmodify('FLsubFolder',$this->FLsubFolder.'/'.$row)?>" class="item"><?php echo $row ?></a></td>
	<td class="action"><?php if($this->newSubFolder){?>
	<a href="<?php echo URL_SELF.'?'.urlmodify('act',ACT_RENAME,'newname',NULL,'id',$row).'&newname='; ?>" class="item" onclick="return getNewName(this);">&#272;&#7893;i t&ecirc;n</a>
	<a href="<?php echo URL_SELF.'?'.urlmodify('act',ACT_REMOVE,'id',$row); ?>" class="item item_action" onclick="return confirmRemove('<?php echo htmlspecialchars($row); ?>',this);">Xo&aacute;</a>
	<?php }?>&nbsp;</td>
</tr>
<?php }?>
</tbody>
<tbody>
	<?php 
	for($j=0,$i=$ESNC_ROWSTART-1;($j < $this->pagesize) && ($row=$this->rs[$i]);++$i,++$j){
		$showsrc='<a href="javascript" class="item item_action" onClick="showsrc(\''.$row.'\');return false;" title="Xem &#273;&#432;&#7901;ng d&#7851;n khi ch&egrave;n &#7843;nh trong so&#7841;n th&#7843;o">&#272;&#432;&#7901;ng d&#7851;n</a>';
		$ext = '|'.pathinfo($row,PATHINFO_EXTENSION).'|';
		if(strpos((string)FILE_TYPE_IMAGE.FILE_TYPE_FLASH.FILE_TYPE_WINDOWS_MOVIE,$ext) !== FALSE){
			ob_start();
			htmlview($this->url,$row,'','',TRUE);
			$code=ob_get_clean();
			$openact='<a href="javascript:;"  class="item item_action" onClick="openImage(\''.$row.'\',this,\''.htmlspecialchars($code).'\');return false;">Xem</a>';
		}
	?>
	<tr>
		<td align="center" onclick="<?php echo $openscript; ?>" class="item_icon">&nbsp; </td>
		<td align="left"><?php echo $row; ?></td>
		<td class="action">
			<a href="<?php echo URL_SELF.'?'.urlmodify('act',ACT_RENAME,'newname',NULL,'id',$row).'&newname='; ?>" class="item" onclick="return getNewName(this);">&#272;&#7893;i t&ecirc;n</a>
			<a href="<?php echo URL_SELF.'?'.urlmodify('act',ACT_REMOVE,'id',$row); ?>" class="item item_action" onclick="return confirmRemove('<?php echo htmlspecialchars($row); ?>',this);">Xo&aacute;</a>
			<?php echo $openact; echo $showsrc;?></td>
	</tr>	
	<?php }//end row scan?>	
</tbody>
<tbody>
<?php if($this->newSubFolder){?>
<tr >
	<td class="folder_icon">&nbsp;</td>
	<td><form action="<?php echo URL_SELF.'?'.urlmodify('act',ACT_ADD); ?>" method="post" id="form_newFolder" onsubmit="return checkFolderForm(this);"><input type="text" class="input" style="width:250px;border:0px none;border-bottom:1px dashed #111111; " name="newSubFolder" value="(newfolder)" onclick="this.select();"/></form></td>
	<td class="action"><a href="#" class="item" onclick="if(checkFolderForm(t=document.getElementById('form_newFolder'))) t.submit();return false;">T&#7841;o th&#432; m&#7909;c</a></td>
</tr>
<?php }?>
</tbody>
<tfoot>
	<tr>
        <td align="center">&nbsp;</td>
		<td nowrap>&nbsp;
<?php if($this->pagecount > 1){
	$q = $_GET;
	$q['pagesize']=$this->pagesize;
	unset($q['page']);
	$q['page']='';
	$pUrl = URL_SELF.'?'.http_build_query($q);//this make url: URL_SELF?&pagezie=xxx&page=
	echo ' :: ';
	for($p=1;$p <= $this->pagecount;++$p)
		if($p == $this->page) echo ' <span class="paging" >'.$p.'</span> ';
		else echo ' [ <a href="'.$pUrl.$p.'" class="paging" > '.$p.'</a> ] ';
}
?>		
	</td>
	<td nowrap> T&igrave;m ki&#7871;m:<form action="<?php echo URL_SELF ?>" method="get"><input type="text" class="input" name="q" style="width:100px; " value="<?php echo $_GET['q'] ?>" />
<?php 	foreach($_GET as $name=>$value)
	if($name != 'page' && $name != 'q' && $name!= 'FFextid') echo '<input type="hidden" value="'.$value.'" name="'.$name.'" />';
	echo '<select name="FFextid" class="input" onchange="this.form.submit();"><option value="-1">*.*</option>';
	foreach($FILE_ALLOW_EDIT_TYPE as $extid=>$extname){
		echo '<option value="'.$extid.'"';
		if($this->extid == $extid) echo ' selected ';
		echo '>*.'.$extname.'</option>';
	}
	echo '</select>';
?></form>
</td>
	</tr>
</tfoot>
</table>
T&#7843;i l&ecirc;n:<iframe align="bottom" height="22" width="250"  frameborder="0" scrolling="no" src="document-upload-one.php?fn=parent.afterUpload&FLsubFolder=<?php echo $this->FLsubFolder;?>&FLid=<?php echo $this->FLid; ?>"></iframe>
<div id="imageViewer" onclick="this.style.display='none';"></div>
</body>
<script language="javascript" type="text/javascript" defer>
function openImage(file,obj,code){
document.getElementById('imageViewer').innerHTML = code;
document.getElementById('imageViewer').style.display='block';
}
function showsrc(file){
	window.prompt("src=","<?php echo rtrim($this->FLurl.$this->FLsubFolder,'/').'/' ?>"+file);
}
function checkFolderForm(f){
	if(/^[\w\-]+$/.test(f.newSubFolder.value)) return true;
	window.alert('invalid folder name');
	f.newSubFolder.focus();
	f.newSubFolder.select();
	return false;
}
function getNewName(o){
	var t = window.prompt('New name','');
	if(t && <?php echo REGEX_CHECK_FILENAME ?>.test(t)){
		o.href += encodeURIComponent(t);
		return true;
	}
	return false;
}
function confirmRemove(name,o){
	return window.top.confirm('Are you sure to remove ' + name);
}
function afterUpload(){
	self.location.href=self.location.href;
}
function doNew(){
	(t=document.getElementsByName('newSubFolder').item(0)).focus();
	t.select();
}
function doNewItem(){
	parent.banner.setStatus('S&#7917; d&#7909;ng ch&#7913;c n&#259;ng t&#7843;i l&ecirc;n &#7903; cu&#7889;i trang');
}
function doSearch(){ document.getElementsByName('q').item(0).focus();}
</script>
</html>