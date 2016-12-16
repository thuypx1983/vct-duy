<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Product</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="../images/style.css"/>
<link type="text/css" rel="stylesheet" href="../forms/style.css"/>
<script language="javascript" src="../js/library.js"></script>
<script language="javascript" src="../js.php"></script>
</head>
<body style="margin: 5px 0px 0px 0px" class="text">
<table width="100%"><tbody><tr>
	<td>
		<form name="frmsearch" method="get">
			<fieldset style="height:40px;"><legend>T&#236;m ki&#7871;m &#7843;nh</legend>
			<input type="hidden" name="PPproductid" value="<?php echo $_GET["PPproductid"] ?>"/>
			<input type="hidden" name="FLid" value="<?php echo $_GET["FLid"] ?>"/>
			<label>T&#7915; g&#7907;i nh&#7899;</label>
			<input type="text" name="q" class="input" value=""	/>&nbsp;
			<label>ki&#7875;u file</label><select name="type" class="input">
			<option value="0">Ch&#7885;n ki&#7875;u file</option>
			<?php foreach($this->a_type as $tid=>$t){?><option value="<?php echo $tid; ?>" <?php if($tid == $_GET['type']) echo ' selected';?>>*.<?php echo $t;?></option><?php }?>
			</select>
			<input type="submit" class="button" value="T&#236;m"/>
			</fieldset>
		</form>	
	</td>
	<td>
		<fieldset style="height:40px;"><legend>T&#7843;i th&#234;m &#7843;nh l&#234;n m&#225;y ch&#7911;</legend>
		<iframe align="bottom" height="25" width="100%" frameborder="0" scrolling="no" src="../document-upload-one.php?fn=afterUpload&FLid=<?php echo $this->catid; ?>&FFflag=<?php echo (int)$_GET['FFflag'] ?>"></iframe>		
		</fieldset>
	</td>	
</tr></tbody></table>
<form id="addimage" action="photoprocess.php?productid=<?php echo $_GET["PPproductid"] ?><?php //echo URL_SELF.'?'.urlmodify('act',ACT_SAVE); ?>" method="post">
<table width="100%" cellpadding="0" cellspacing="0">
<thead>
	<tr>
		<th><input type="checkbox" onClick="javascript:setAll('img[]',this.checked);" title="Ch&#7885;n t&#7845;t c&#7843;"></th>
		<th align="center"><img src="../images/icon_help.jpg" border="0" onMouseOver="this.nextSibling.style.display='list-item';" onMouseOut="this.nextSibling.style.display='none';"/><div style="position:absolute;display:none;background-color:#FFFFCC;border:1px solid #333333;width:250px;text-align:justify;padding:3px;" >H&#227;y ch&#7885;n c&#225;c file &#7843;nh r&#7891;i k&#237;ch chu&#7897;t v&#224;o n&#250;t save &#273;&#7875; l&#432;u l&#7841;i<br>N&#250;t save- l&#224; n&#250;t c&#243; h&#236;nh chi&#7871;c &#273;&#297;a m&#7873;m &#7903; tr&#234;n thanh c&#244;ng c&#7909; ph&#237;a tr&#234;n m&#224;n h&#236;nh</div></th>
		<th width="<?php echo COL2_WIDTH ?>" ><span class="text" style="font-weight:bold;color:#FF0000 "><?php echo COL2_NAME ?>*.<?php echo $this->ext; ?></span></th>
		<th >title</th>
		<th >alt</th>
	</tr>
</thead>
<tbody>
	<?php
	$ext = '|'.$this->ext.'|';
	for($i = $this->startrow,$j=0;($j < $this->pagesize) && ($i < $this->rowcount); ++$i,++$j){
	?>
	<tr>
		<td align="center" width="1%"><input type="checkbox" name="img[]" value="<?php echo COL2_NAME.$this->rs[$i]; ?>" onClick="highlighter(this);" /></td>
		<td align="center" width="1%"><img src="../images/item.gif" border="0" style="cursor:pointer" /></td>
		<td align="left" width="30%" title="<?php echo $this->rs[$i]; ?>"><span style="cursor:pointer; " onClick="loadimage(this,'<?php echo COL2_NAME.$this->rs[$i]; ?>');"><?php echo $this->rs[$i]; ?></span></td>
		<td align="center" width="30%"><input type="text" name="title[]" value="" class="input" style="width:160px " /></td>
		<td align="center" width="30%"><input type="text" name="alt[]"   value="" class="input" style="width:160px " /></td>
	</tr>	
	<?php }//end row scan?>	
</tbody>
<tfoot>
	<tr>
		<td >&nbsp;</td>
        <td align="center">&nbsp;</td>
		<td nowrap>&nbsp;
<?php if($this->pagecount > 1){echo '<span class="text" >::</span>';
$q=urlformat($this->q,$this->alias.'page','');
	for($p = 1; $p <= $this->pagecount; ++$p){ if($p != $this->page) {?>
		<a href="<?php echo "{$this->url}?{$q}{$p}" ?>" class="search">[<?php echo $p ?>]</a>
	<?php }else{ ?><span class="text" ><?php echo $p ?></span>
	<?php }
	 }
}
?>	</td>
		<td nowrap colspan="2">Ki&#7875;u (&#273;u&ocirc;i) t&#7853;p tin <select class="input" onchange="navigateFolder(this);">
		<?php foreach($this->a_type as $tid=>$t){?><option value="<?php echo $tid; ?>" <?php if($t == $this->ext) echo ' selected';?>>*.<?php echo $t;?></option><?php }?></select></td>
	</tr>
</tfoot>
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript" defer>
function HIDE(){}
function afterUpload(f,ext,extid,catid,flag){
	self.location.href = '<?php echo $this->url.'?'.urlformat(urlchop($this->q,'FFflag'),'act',ACT_LIST,'FFext','') ?>' + extid + '&FFflag=' + flag;
}
var url_itemlist='<?php echo URL_SELF.'?'.urlformat($this->q,'act',ACT_LIST,'FFext',''); ?>';
function navigateFolder(o){
	self.location.href = url_itemlist + o.value;
}
function doSave(){
	var chk = document.getElementsByName('img[]');
	var len = chk.length;
	var val = '';
	for (var i=0;i < len;i++){		
		if (chk[i].checked){
			var f  = document.getElementById('addimage');
			f.submit();
			break;
		}		
	}
	//if (val=='') alert('Xin moi chon mot anh de them vao thu vien anh cua san pham!');
}
function loadimage(obj,url){
	var img = new Image();
	img.src = url;
	img.style.position = "absolute";
	img.style.border   = "3px solid #CCC000";
	img.setAttribute('id','imgpreview');
	img.onclick = function (){
		this.style.cursor = "pointer";
		this.parentNode.removeChild(this);
	}
	obj.parentNode.appendChild(img);	
	img.style.top  = posY(obj)+30+"px";
	img.style.left = posX(obj)+"px";
	obj.onmouseout = function (){
		obj.parentNode.removeChild(img);
	}
}
function highlighter(chk){
	var o = chk.parentNode.parentNode;
	if (chk.checked){
		o.style.backgroundColor = "#CCCCCC";
	}else {
		o.style.backgroundColor = "#FFFFFF";
	}
}
</script>
<script language="javascript" type="text/javascript" src="../js/item-script.js"></script>