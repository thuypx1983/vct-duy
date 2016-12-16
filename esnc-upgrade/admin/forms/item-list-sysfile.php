<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<base href="<?php echo URL_BASE_ADMIN ?>" />
<title>Th&ocirc;ng tin li&ecirc;n h&#7879;,b&#7843;n quy&#7873;n....</title>
<link type="text/css" rel="stylesheet" href="images/style.css">
<link type="text/css" rel="stylesheet" href="forms/style.css">
<comment>
<link type="text/css" rel="stylesheet" href="images/style-nonie.css" />
</comment>
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
<body >
<table id="item-list" width="100%" cellpadding="0" cellspacing="0"  onclick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
	<thead>
	<tr>
		<th class="item_icon">&nbsp;</th>
		<th ><?php echo COL2_NAME?></th>
		<th ><?php echo COL3_NAME ?></th>
		<th ><?php echo COL4_NAME ?></th>
	</tr>
	</thead>
	<tbody>
<?php for($j=0,$i=$this->startrow;$j < $this->pagesize and $i < $this->rowcount;++$i,++$j) {
	$filename=$this->rs[$i];
	if(!$name = $this->description[$filename]['name']) $name='';
	$urlitem_plain='javascript:window.open(&quot;'.URL_ADMIN.'pte.php?FLid=1&filename='.$filename.'&title='.urlencode($name).'&quot;,&quot;_wplain&quot;,sPlainWin);return false;"';
	$urlitem_rich='javascript:window.open(&quot;'.URL_ADMIN.'rte.php?FLid=1&filename='.$filename.'&title='.urlencode($name).'&quot;,&quot;_wplain&quot;,sParams);return false;"';
	$urlitem_img='javascript:openImage(&quot;'.URL_APPLICATION.$filename.'&quot;)';
	$extchooser='|'.pathinfo($filename,PATHINFO_EXTENSION).'|';
	if(strpos(FILE_TYPE_PLAINTEXT,$extchooser) !== FALSE) $urlitem_def=&$urlitem_plain;
	elseif(strpos(FILE_TYPE_RICHTEXT,$extchooser) !== FALSE) $urlitem_def=&$urlitem_rich;
	elseif(strpos(FILE_TYPE_IMAGE.FILE_TYPE_WINDOWS_MOVIE.FILE_TYPE_FLASH,$extchooser) !== FALSE)	$urlitem_def=&$urlitem_img;
	else $urlitem_def='javascript:;';
?>
	<tr>
		<td class="item_icon">&nbsp;</td>
		<td nowrap>&nbsp;<a href="javascript:;" onclick="<?php echo $urlitem_def ?>" class="item"><?php echo $filename ?></a></td>
		<td>&nbsp;<a href="javascript:;" onclick="<?php echo $urlitem_def ?>" class="item"><?php echo $name ?></a></td>
		<td>&nbsp;
<?php
echo '<a href="'.URL_SELF.'?act='.ACT_RENAME.'&FLid=1&FFextid='.$this->extid.'&filename='.$filename.'&newname=" onclick="return rename(this,&quot;'.$filename.'&quot;);" class="item">&#272;&#7893;i t&ecirc;n</a>';
if($urlitem_def == $urlitem_img)
	echo '<a href="javascript:;" onclick="'.$urlitem_img.'" class="item item_action">Xem</a>';
else{
if($urlitem_def != 'javascript:;')
	echo '<a href="javascript:;" onclick="'.$urlitem_plain.'" class="item item_action">So&#7841;n th&#7843;o &#273;&#417;n gi&#7843;n</a>';
if($urlitem_def == $urlitem_rich)
	echo '<a href="javascript:;" onclick="'.$urlitem_rich.'" class="item item_action">So&#7841;n th&#7843;o &#273;&#7847;y &#273;&#7911;</a>';
}
	echo '<a href="'.URL_SELF.'?act='.ACT_SAVE.'&filename='.urlencode($filename).'&name=" onclick="return changeDescription(this,&quot;'.htmlspecialchars($filename).'&quot;,&quot;'.htmlspecialchars($name).'&quot;);" class="item item_action">Ghi ch&uacute;</a>';
	echo '<a href="'.URL_ADMIN.'files/item.php?FLid=1&FFid='.$filename.'" class="item item_action">T&#7843;i v&#7873;</a>';
	echo '<a href="'.URL_SELF.'?act='.ACT_REMOVE.'&FLid=1&filename='.$filename.'&go=" onclick="return confirmDelete(this,&quot;'.htmlspecialchars($filename).'&quot;)" class="item item_action">Xo&aacute;</a>';
?>
	
	</tr>	
<?php } //end row scan ?>
	</tbody>
	<tfoot>
	<tr>		
        <td colspan="3">&nbsp;
<?php if($this->pagecount > 1){
	$q = $_GET;
	$q[ALIAS.'pagesize']=$this->pagesize;
	unset($q[ALIAS.'page']);
	$q[ALIAS.'page']='';
	$pUrl = URL_SELF.'?'.http_build_query($q);//this make url: URL_SELF?&pagezie=xxx&page=
	echo 'Trang: ';
	for($p=1;$p <= $this->pagecount;++$p)
		if($p == $this->page) echo ' <span class="paging" >'.$p.'</span> ';
		else echo ' [ <a href="'.$pUrl.$p.'" class="paging" > '.$p.'</a> ] ';
}
?>		
		</td>
		<td>&nbsp;Ki&#7875;u (&#273;u&ocirc;i) t&#7853;p tin
<?php $q = $_GET;
unset($q['FFextid']);
$q['FFextid']='';
$eUrl = URL_SELF.'?'.http_build_query($q);//this make url: URL_SELF?....FFextid=
echo '<select class="input" onchange="self.location.href = &quot;'.$eUrl.'&quot; + this.value">';
foreach($FILE_ALLOW_EDIT_TYPE as $extid=>$ext) if($this->extid == $extid) echo '<option selected>*.'.$ext.'</option>'; else echo '<option value="'.$extid.'">*.'.$ext.'</option>';
echo '</select>';
?>		
		</td>
	</tr>
	</tfoot>
</table>
<div  style="clear:both; ">T&#7843;i t&#7853;p tin l&ecirc;n m&aacute;y ch&#7911; <iframe src="<?php echo URL_ADMIN;?>document-upload-one.php?fn=parent.afterUpload&FLid=<?php echo $this->catid; ?>&FFflag=<?php echo (int)$_GET['FFflag'] ?>" style="vertical-align:baseline;width:240px;height:22px; " frameborder="0" scrolling="no"></iframe></div>
<div id="imageViewer" onclick="this.style.display='none';"></div>
</body>
<script type="text/javascript">
function openImage(filename){
	var t=document.getElementById('imageViewer');
	t.innerHTML=htmlview('',filename);
	t.style.display='block';
}
function confirmDelete(o,filename){
	if(window.top.confirm('Are you sure to remove ' + filename)){
		o.href += encodeURIComponent(self.location.href);
		return true;
	}
	return false;
}
function rename(o,filename){
	var newname=window.prompt('Enter new name:',filename);
	if(newname && newname != filename && /^[\w\-]+(?:\.[a-z]{1,5}){0,1}$/.test(newname)){
		o.href += encodeURIComponent(newname) + '&go=' + encodeURIComponent(self.location.href);
		return true;
	}
	parent.banner.setStatus('T&ecirc;n t&#7853;p tin kh&ocirc;ng h&#7907;p l&#7879;');
	return false;
}
function changeDescription(o,filename,name){
	var newName = window.prompt('Enter description for file ' + filename,name);
	if(newName && newName != name){
		o.href += encodeURIComponent(newName) + '&go=' + encodeURIComponent(self.location.href);
		return true;
	}
	return false;
}
function afterUpload(uploaded,ext,extid){
	if(!uploaded) return parent.banner.setStatus('L&#7895;i, c&oacute; th&#7875; t&#7853;p tin k&ocirc; h&#7907;p l&#7879;, &#273;&#432;&#7901;ng truy&#7873;n ch&#7853;m..');
	self.location.href="<?php
$q = $_GET;
unset($q['FFextid'],$q['FFpage']);
$q['FFextid']='';
echo URL_SELF.'?'.http_build_query($q);	
	?>" + extid;
}
function doNewItem(){parent.banner.setStatus('D&ugrave;ng ch&#7913;c n&#259;ng t&#7843;i l&ecirc;n &#7903; cu&#7889;i trang')}
window.top.document.title=self.document.title;
</script>
<script src="js/pte.js" type="text/javascript"></script>
<script src="js/rte.js" type="text/javascript"></script>

</html>