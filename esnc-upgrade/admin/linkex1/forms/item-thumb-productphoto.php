<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Th&#432; vi&#7879;n &#7843;nh</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="images/style.css">
<style>
div#divFormEditImage{
display:none;
width:400px;
height:80px;
z-index:1;
position:absolute;
top:50px;
left:50px;
background-color:#ece9d8;
margin:10px auto auto 20px;
border:2px inset #CCFFCC;
}
div#divFormEditImage input.input{
	width:350px;
}
div#divFormEditImage div{
	line-height:18px;
}
</style>
</head>
<body style="margin: 5px 0px 0px 0px">
<div class="text">Th&#432; vi&#7879;n &#7843;nh minh ho&#7841; s&#7843;n ph&#7849;m: 
	<strong>
		<?php 
			$rs = mysql_select('`a`.`name` as `pname`','`#product` as `a`','`a`.`id`='.(int)$this->productid);
			$row =  mysql_fetch_row($rs);
			mysql_free_result($rs);
			echo $row[0];
		?>
	</strong>
</div>
<form action="<?php echo URL_SELF ?>?productid=<?php echo $this->productid ?>&act=" method="post" id="PPlist">
<?php
	for($i=0;$row=mysql_fetch_assoc($this->rs);++$i,$lastview=(int)$row['view']){?>
		<div class="text box_item_thumbs">
			<?php 
				htmlview(URL_MYIMAGES,$row['img'],'class="item_thumbs_img" onclick="showRealSize(this);" alt="'.$row['alt'].'" title="'.$row['name'].'"');
			?>
			<div class="text item_thumbs_alt"><?php echo $row['name'];?>&nbsp;</div>
			<div class="text item_thumbs_view">
				<input  title="<?php echo $row['img'] ?>" name="idview[<?php echo $row['img'] ?>]" value="<?php echo $row['view'];?>" class="input" style="width:30px " />&nbsp;&nbsp;
				<input type="checkbox" value="<?php echo htmlspecialchars($row['img']) ?>" name="img[]"  class="input"/>&nbsp;
				<span class="textbutton" onClick="editImage('<?php echo $row['img']; ?>','<?php echo htmlspecialchars($row['alt']) ?>','<?php echo $row['name'] ?>','<?php echo $row['view'] ?>','<?php echo $row['url'] ?>');">S&#7917;a</span>
			</div>
		</div>
	<?php }
	?>
</form>
<br/>
<fieldset id="divUpload" style="width:720px; ">
	<legend class="text">T&#7843;i th&ecirc;m &#7843;nh cho s&#7843;n ph&#7849;m v&agrave;o th&#432; m&#7909;c 
		<select class="input" onChange="setUploadFolder(this);" id="selUploadFolder">
		<?php 
			global $FILE_ALLOW_EDIT_FOLDER_NAME,$FILE_ALLOW_EDIT_PATH;
			unset($FILE_ALLOW_EDIT_FOLDER_NAME[0],$FILE_ALLOW_EDIT_FOLDER_NAME[1],$FILE_ALLOW_EDIT_FOLDER_NAME[2]);
			foreach($FILE_ALLOW_EDIT_FOLDER_NAME as $id=>$name){
		?>	
			<option value="<?php echo $id ?>" <?php if($FILE_ALLOW_EDIT_PATH[$id] == PATH_PRODUCTPHOTO_IMG) echo 'selected' ?> >
				<?php echo $name ?>
			</option>
		<?php }?>
		</select>&nbsp;
<!--		<a href="<?php echo URL_CWD ?>photo-browse.php?PPproductid=<?php echo $this->productid ?>&FFext=3&FLid=" onClick="this.href += FLid;" class="item" >Ch&#7885;n &#7843;nh t&#7915; th&#432; m&#7909;c tr&ecirc;n m&aacute;y ch&#7911;</a>| 
		<a href="<?php echo URL_CWD ?>photo-input.php?PPproductid=<?php echo $this->productid ?>&FFext=3" class="item">Nh&#7853;p tr&#7921;c ti&#7871;p &#273;&#432;&#7901;ng d&#7851;n &#7843;nh</a>
-->
	</legend>
	<table border="0" bordercolor="#111111" style="border-collapse:collapse" class="text" cellspacing="3" align="center">
		<thead class="text"><tr><td>TT</td><th>Ch&#7885;n &#7843;nh</th><th>title</th><th>alt</th><th>url</th></tr></thead>
		<tbody class="text">
			<form action="<?php echo URL_CWD ?>photo-upload.php?fn=window.top.content.nextupload&act=<?php echo ACT_SAVE;?>&productid=<?php echo $this->productid;?>&FLid=" id="frmUpload1" enctype="multipart/form-data" target="frameupload" method="post" class="frmMultiUpload">
				<input type="hidden" name="ctrl[]" value="1"/>
				<tr>
					<td>
						<input name="view" value="<?php echo ++$lastview; ?>" class="input" style="width:20px "/>
					</td>
					<td>
						<input type="file" name="userfile" class="input" />
					</td>
					<td><textarea class="input" name="title" ></textarea></td>
					<td><textarea class="input" name="desc" ></textarea></td>
					<td><input type="text" class="input" name="url" /></td>
				</tr>
			</form>
			<form action="<?php echo URL_CWD ?>photo-upload.php?fn=window.top.content.nextupload&act=<?php echo ACT_SAVE;?>&productid=<?php echo $this->productid;?>&FLid=" id="frmUpload2" enctype="multipart/form-data" target="frameupload" method="post" class="frmMultiUpload">
				<input type="hidden" name="ctrl[]" value="1"/>
				<tr>
					<td><input name="view" value="<?php echo ++$lastview; ?>" class="input" style="width:20px "/></td>
					<td>
						<input type="file" name="userfile"/>
					</td>
					<td><textarea class="input" name="title"></textarea></td>
					<td><textarea class="input" name="desc" ></textarea></td>
					<td><input type="text" class="input" name="url" /></td>
				</tr>
			</form>
			<form action="<?php echo URL_CWD ?>photo-upload.php?fn=window.top.content.nextupload&act=<?php echo ACT_SAVE;?>&productid=<?php echo $this->productid;?>&FLid=" id="frmUpload3" enctype="multipart/form-data" target="frameupload" method="post" class="frmMultiUpload">
				<input type="hidden" name="ctrl[]" value="1"/>
				<tr>
					<td><input name="view" value="<?php echo ++$lastview; ?>" class="input" style="width:20px "/></td>
					<td>
						<input type="file" name="userfile"/>
					</td>
					<td><textarea class="input" name="title"></textarea></td>
					<td><textarea class="input" name="desc" ></textarea></td>
					<td><input type="text" class="input" name="url" /></td>
				</tr>
			</form>
			<form action="<?php echo URL_CWD ?>photo-upload.php?fn=window.top.content.nextupload&act=<?php echo ACT_SAVE;?>&productid=<?php echo $this->productid;?>&FLid=" id="frmUpload4" enctype="multipart/form-data" target="frameupload" method="post" class="frmMultiUpload">
				<input type="hidden" name="ctrl[]" value="1"/>
				<tr>
					<td><input name="view" value="<?php echo ++$lastview; ?>" class="input" style="width:20px "/></td>
					<td>
						<input type="file" name="userfile"/>
					</td>
					<td><textarea class="input" name="title"></textarea></td>
					<td><textarea class="input" name="desc" ></textarea></td>
					<td><input type="text" class="input" name="url" /></td>
				</tr>
			</form>
		</tbody>
	</table>
	<input type="button" onclick="doUploadMulti()" value="T&#7843;i l&ecirc;n" class="button"/>
</fieldset>
<div id="divProgress" style="display:none ">
	<img src="images/load.gif" />
	<strong id="filecounter">0</strong> t&#7853;p tin t&#7843;i l&ecirc;n
</div>
<div id="divFormEditImage" class="text">
	<form action="<?php echo URL_SELF ?>?act=<?php echo ACT_SAVE;?>&productid=<?php echo $this->productid ?>" method="post" id="frmEditImage">
		<div class="text">&nbsp;title&nbsp;&nbsp;<textarea name="name" class="input" style="width:250px; "></textarea></div>
		<div class="text">&nbsp;alt&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="alt" class="input" style="width:250px; "></textarea></div>
		<div class="text">&nbsp;url&nbsp;&nbsp;&nbsp;&nbsp;<input name="url" class="input"  type="text" style="width:250px; " /></div>
		<div class="text">&nbsp;tt&nbsp;&nbsp;&nbsp;&nbsp;<input name="view" class="input"  type="text" style="width:20px; " /></div>
		<div style="text-align:center " class="text"><input class="button"  type="submit" value="Ch&#7845;p nh&#7853;n" />&nbsp;
			<input class="button"  type="button" value="Hu&#7927; b&#7887;" onClick="doCancel();" />
		</div>
		<input type="hidden" name="img" />
		<input type="hidden" name="ctrl[]" value="1" />
	</form>
</div>
<iframe name="frameupload" class="hiddenframe"></iframe>
</body>
<?php
	$rs=mysql_select('`catproductid` as `id`','`#catproductproduct` as `a`','`a`.`productid` = '.(int)$this->productid);
	$row=mysql_fetch_row($rs);
	mysql_free_result($rs);
?>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
<script language="javascript">
var url_up = URL_ADMIN + 'product/item-list.php?CPid=' + '<?php echo $row['0'];?>';
function nextupload(){
	var i = frmI++;
	document.getElementById('filecounter').innerHTML=counter++;
	if(f = document.getElementById('frmUpload' + i)){
		if(f.userfile.value != ''){
			f.action += FLid; 
			f.submit();
			
		} else window.setTimeout('nextupload()',500);
	}else{
		parent.banner.setStatus(--counter + 't&#7853;p tin t&#7843;i l&ecirc;n xong');
		window.location.href = window.location.href;//reload
	}
}
function doUploadMulti(){
	document.getElementById('divUpload').style.display='none';
	document.getElementById('divProgress').style.display='block';
	frmI=1;
	counter=0;
	nextupload();
}
function setUploadFolder(o){
	FLid = o.value;
}
var frmI,counter,FLid=document.getElementById('selUploadFolder').value;
function doDel(){
	if(parent.banner.ask('chac chan xoa?')){
		f=document.getElementById('PPlist');
		f.action += ACT_REMOVE;
		f.submit();
	}
}
function editImage(v_img,v_alt,v_name,v_view,v_url){
	var dlg = document.getElementById('divFormEditImage');
	var frm = document.getElementById('frmEditImage');
	frm.img.value = v_img;
	frm.alt.value = v_alt;
	frm.name.value = v_name;
	frm.view.value = v_view;
	frm.url.value = v_url;
	window.doSave = function (){
		document.getElementById('frmEditImage').submit();
	}
	var a = document.getElementsByTagName('select');
	for(i=0;i<a.length;++i) a.item(i).style.visibility='hidden';
	dlg.style.display='block';
}
function doCancel(){
	var dlg = document.getElementById('divFormEditImage');
	dlg.style.display='none';
	window.doSave = function(){
		f=document.getElementById('PPlist');
		f.action += ACT_REORDER;
		f.submit();
	}
	var a = document.getElementsByTagName('select');
	for(i=0;i<a.length;++i) a.item(i).style.visibility='visible';
}
window.doSave = function(){
	f=document.getElementById('PPlist');
	f.action += ACT_REORDER;
	f.submit();
}
function doUp(){
	self.location.href=url_up;
}
function showRealSize(){}
</script>
</html>
<?php dbclose();?>