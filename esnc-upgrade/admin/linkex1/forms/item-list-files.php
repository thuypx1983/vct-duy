<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $this->doctitle ?></title>
<base href="<?php echo URL_BASE_ADMIN ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css"/>
<link type="text/css" rel="stylesheet" href="forms/style.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0">
<thead>
	<tr>
		<th width="22px"><input type="checkbox" onClick="javascript:setAll('id',this.checked);"></th>
		<th align="center">&nbsp;</th>
		<th width="<?php echo COL2_WIDTH ?>" ><span class="text" style="font-weight:bold;color:#FF0000 "><?php echo COL2_NAME ?>*.<?php echo $this->ext; ?></span></th>
		<th >H&agrave;nh &#273;&#7897;ng</th>
	</tr>
</thead>
<tbody>
	<?php 
		$itemurl='item.php?'.urlformat($this->q,$this->alias.'id','');
		$ext = '|'.$this->ext.'|';
	for($i = $this->startrow,$j=0;($j < $this->pagesize) && ($i < $this->rowcount); ++$i,++$j){
		$showsrc='|<span class="textbutton" onClick="showsrc('.$i.');" title="Xem &#273;&#432;&#7901;ng d&#7851;n khi ch&egrave;n &#7843;nh trong so&#7841;n th&#7843;o">&#272;&#432;&#7901;ng d&#7851;n</span>';
		if(strpos((string)FILE_TYPE_RICHTEXT,$ext) !== FALSE) {
			$openact='|<span class="textbutton" onClick="openItem('.$i.');" title="D&ugrave;ng tr&igrave;nh so&#7841;n th&#7843;o c&oacute; &#273;&#7911; t&iacute;nh n&#259;ng: c&#7905; ch&#7919;, trang tr&iacute;, c&#259;n l&#7873;, ch&egrave;n &#7843;nh...">So&#7841;n th&#7843;o &#273;&#7847;y &#273;&#7911;</span>|<span class="textbutton" onClick="notepad('.$i.');" title="D&ugrave;ng tr&igrave;nh so&#7841;n th&#7843;o ch&#7881; g&otilde; &#273;&#432;&#7907;c c&aacute;c k&yacute; t&#7921;">So&#7841;n th&#7843;o &#273;&#417;n gi&#7843;n</span>';
			$openscript = "openItem({$i});";
		}elseif(strpos((string)FILE_TYPE_IMAGE,$ext) !== FALSE){
			$openact='|<span class="textbutton" onClick="openImage('.$i.',this);">Xem</span>';
			$openscript = "openImage({$i},this);";
		}elseif(strpos((string)FILE_TYPE_PLAINTEXT,$ext) !== FALSE){
			$openact='|<span class="textbutton" onClick="notepad('.$i.');" title="D&ugrave;ng tr&igrave;nh so&#7841;n th&#7843;o ch&#7881; g&otilde; &#273;&#432;&#7907;c c&aacute;c k&yacute; t&#7921;">So&#7841;n th&#7843;o &#273;&#417;n gi&#7843;n</span>';
			$openscript = "notepad({$i});";
		}
	?>
	<tr>
		<td align="center"><input type="checkbox" name="id" value="<?php echo $this->rs[$i]; ?>"></td>
		<td align="center" onClick="<?php echo $openscript; ?>" class="item_icon">&nbsp; </td>
		<td align="left"><input type="text" id="name<?php echo $i; ?>" class="input" style="border:1px solid #FFFFFF; width:95%; cursor:pointer" readonly="yes" value="<?php echo $this->rs[$i]; ?>" onDblClick="<?php echo $openscript; ?>"/></td>
		<td><span onClick="rename(<?php echo $i; ?>,this);" class="textbutton">&#272;&#7893;i t&ecirc;n</span><?php echo $openact; ?><?php echo $showsrc;?>|<span class="textbutton" onClick="downloadItem(<?php echo $i; ?>);">T&#7843;i v&#7873;</span></td>
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
		<a href="<?php echo URL_SELF."{$q}{$p}" ?>" class="search">[<?php echo $p ?>]</a>
	<?php }else{ ?><span class="text" ><?php echo $p ?></span>
	<?php }
	 }
}
?>	</td>
		<td nowrap>&nbsp;Ki&#7875;u (&#273;u&ocirc;i) t&#7853;p tin <select class="input" onChange="navigateFolder(this);">
		<?php foreach($this->a_type as $tid=>$t){?><option value="<?php echo $tid; ?>" <?php if($t == $this->ext) echo ' selected';?>>*.<?php echo $t;?></option><?php }?></select>
		</td>
	</tr>
</tfoot>
</table>
<div  style="clear:both; ">T&#7843;i t&#7853;p tin l&ecirc;n m&aacute;y ch&#7911; <iframe src="document-upload-one.php?fn=afterUpload&FLid=<?php echo $this->catid; ?>&FFflag=<?php echo (int)$_GET['FFflag'] ?>" style="vertical-align:baseline;width:240px;height:22px; " frameborder="0" scrolling="no"></iframe></div>
</body>
</html>
<script language="javascript" type="text/javascript" defer>
var url_itemlist='<?php echo URL_SELF.'?'.urlformat($this->q,'act',ACT_LIST,'FLid',$_GET['FLid'],$this->alias.'ext',''); ?>';
function navigateFolder(o){
	self.location.href = url_itemlist + o.value;
}
var ACT_RENAME=<?php echo ACT_RENAME ?>;
function doUp(){
	self.history.back();
}
var input=null,exvalue=null,engine;
try{	engine = new ActiveXObject("Microsoft.XMLHTTP");}
catch(E){	try{	engine = new XMLHttpRequest();	}
		catch(EE){	parent.banner.setStatus("Tr&igrave;nh duy&#7879;t kh&ocirc;ng h&#7895; tr&#7907; XMLHTTP!");}
}
function rename(id,o){
	if(input == null){ //first entering input
		o.innerHTML = "&#272;&#7893;i";
		input = document.getElementById('name' + id);
		input.readOnly = false;
		input.style.borderColor = "#000000";
		input.style.cursor='auto';
		input.focus();
		input.select();
		exvalue = input.value;//keep currentvalue;
		parent.banner.setStatus("Nh&#7853;p v&agrave;o t&ecirc;n m&#7899;i (<em>kh&ocirc;ng c&oacute; &#273;u&ocirc;i</em>) r&#7891;i nh&#7845;n n&uacute;t <strong>&#272;&#7893;i<\/strong>");
	}else{//finish editing, now put to server
		try{
		engine.open('GET','<?php echo $this->url.'?'.urlformat(urlchop($this->q,'name','id'),'act',ACT_RENAME); ?>' + '&name=' + encodeURI(input.value) + '&id=' + encodeURI(exvalue),false);//synchonous transfer
		}catch(E){return;}//not support xmlhttp

		engine.setRequestHeader("Accept-Charset", "utf-8");
		parent.banner.setStatus("&#272;ang &#273;&#7893;i t&ecirc;n...");
		try {engine.send(null);		eval((engine.responseText).toString());}
		catch(E){parent.banner.setStatus("L&#7895;i khi &#273;&#7893;i t&ecirc;n: " + E.description); input.value=exvalue;}
		input.readOnly = true;
		input.style.borderColor = "#FFFFFF";
		input.style.cursor = 'pointer';
		input = null;
		exvalue = null;
		o.innerHTML = "&#272;&#7893;i t&ecirc;n";
	}
}
function doSave(){
}
function doDel(){
	var v=getChecked('id');
	if(v != '' && parent.banner.ask("Ban co thuc su muon xoa khong?")) self.location.href = '<?php echo $this->url.'?'.urlformat($this->q,'FLid',$this->catid,'act',ACT_REMOVE,'id','') ?>' + v;//only remove empty
}
function doCopy(c){//c=clipboard
	v = getChecked('id');
	if(v == '') return;
	c.id = v; //keep list of id
	c.type = <?php echo $this->type ?>;//copy to clipboard
	c.excatid = <?php echo $this->catid; ?>;
	c.cut = false;
	c.setPasteMessage("Khi paste thi cac doi tuong se thuoc ca nhom moi va nhom cu");
	parent.banner.setStatus("&#272;&atilde; l&#432;u b&#7843;n sao c&#7911;a c&aacute;c &#273;&#7889;i t&#432;&#7907;ng v&agrave;o b&#7897; &#273;&#7879;m");
}
function doCut(c){
	v = getChecked('id');
	if(v == '') return;
	c.id = v; //keep list of id
	c.type = <?php echo $this->type ?>;//copy to clipboard
	c.excatid = <?php echo $this->catid; ?>;
	c.cut = true;
	c.setPasteMessage("Khi paste thi cac doi tuong se chuyen sang nhom moi va xoa khoi nhom ban dau");
	parent.banner.setStatus("&#272;&atilde; chuy&#7875;n v&agrave;o b&#7897; nh&#7899; &#273;&#7879;m");
}
function doPaste(c){
	if(c.id == ""){
		parent.banner.setStatus("B&#7897; nh&#7899; t&#7841;m &#273;ang r&#7895;ng");
	}
	else{
		if(c.type != <?php echo $this->type ?>){
			parent.banner.setStatus("L&#7895;i ki&#7875;u (v&iacute; d&#7909;: kh&ocirc;ng th&#7875; chuy&#7875;n nh&oacute;m s&#7843;n ph&#7849;m sang nh&oacute;m ti&#7879;n &iacute;ch....)");
		}else{
			if(c.cut){ //cut
				if(!parent.banner.ask("Ban co thuc su muon chuyen cac doi tuong trong bo nho sang nhom nay khong?")) return;
				parent.banner.setStatus("Th&#7921;c hi&#7879;n chuy&#7875;n c&aacute;c &#273;&#7889;i t&#432;&#7907;ng trong b&#7897; nh&#7899; t&#7841;m sang nh&oacute;m n&agrave;y");
				self.location.href = '<?php echo $this->url.'?'.urlformat($this->q,'act',ACT_MOVE,'FLid',$this->catid,'id','') ?>' + c.id + '&FLexid=' + c.excatid;
				c.id = null;
				c.type=0;
				c.setPasteMessage("Khong co doi tuong trong bo nho");
			}else{ //copy
				parent.banner.setStatus("Th&#7921;c hi&#7879;n &#273;&#432;a c&aacute;c &#273;&#7889;i t&#432;&#7907;ng trong b&#7897; nh&#7899; t&#7841;m v&agrave;o nh&oacute;m n&agrave;y");
				self.location.href = '<?php echo $this->url.'?'.urlformat($this->q,'act',ACT_COPY,'FLid',$this->catid,'id','') ?>' + c.id + '&FLexid=' + c.excatid;
			}
		}
	}
}
function doNewItem(){
	var filename=window.prompt('file name:');
	if(filename && <?php echo REGEX_CHECK_FILENAME ?>.test(filename)){
		filename += '.<?php echo $this->ext;?>';
		window.open('<?php echo URL_ADMIN ?>pte.php?<?php echo urlformat($this->q,'FLid',$this->catid,'filename','') ?>' + filename,'subWindow',sParams);
	}
}
function doNew(){
	doNewItem();
}
function doLink(){
}
function afterUpload(f,ext,extid,catid,flag){
	self.location.href = '<?php echo URL_SELF.'?'.urlformat(urlchop($this->q,'FFflag'),'act',ACT_LIST,'FFext','') ?>' + extid + '&FFflag=' + flag;
}
function returnValue(c){
}
function downloadItem(i){
	window.open('<?php echo URL_CWD ?>item.php?FLid=<?php echo $_GET['FLid'] ?>&FFid=' + document.getElementById('name'+i).value);
}
function openItem(i){
	window.open(URL_ADMIN + 'rte.php?<?php echo urlformat($this->q,'FLid',$this->catid,'filename','') ?>' + document.getElementById('name'+i).value,'subWindow',sParams);
}
function openImage(i,obj){
	var src='<?php echo $this->caturl; ?>' + document.getElementById('name' + i).value;
//	window.alert(obj.tagName + obj.src);
	try{document.removeChild(oDiv);}catch(e){}
	oDiv = document.createElement('DIV');
	oDiv.id = "picturebox";
	oDiv.style.zIndex = "1";
	oDiv.innerHTML = '<div style="display:block;height:20px;width:100%;text-transform:uppercase;font-weight:bold;text-align:right;"><strong style="cursor:pointer;padding:7px;font-size:14px;" onClick="closebox(\''+ oDiv.id +'\');" title="Click chu&#7897;t l&#234;n &#7843;nh &#273;&#7875; &#273;&#243;ng">X</strong><div>';
	oDiv.innerHTML += '<img  src="' + src + '" title="Click chu&#7897;t l&#234;n &#7843;nh &#273;&#7875; &#273;&#243;ng" onClick="closebox(\'' + oDiv.id + '\');"/>';
	oDiv.style.border="1px solid #CCCCCC";
	oDiv.style.top=posY(obj) + 'px';
	oDiv.style.left=posX(obj) + 'px';
	oDiv.style.backgroundColor="#FFFFFF";	
	document.body.appendChild(oDiv);
	try{
		var i,n;
		n=oDiv.filters.length;
		//alert(parseInt(10*Math.random(1,n)));
		i = parseInt(n*Math.random());
		//for(i=0;i < n;++i){
		oDiv.style.visibility='hidden';
		oDiv.filters.item(i).Apply();
		oDiv.style.visibility='visible';
		oDiv.filters.item(i).Play();
		//}
	}catch(e){
		oDiv.style.visibility ="visible";
	}
}
function showsrc(i){
	window.top.banner.setStatus('<b>SRC=</b><input class=input type=text size=40 onclick="this.select();" readonly="yes" value="' + '<?php echo $this->caturl; ?>' + document.getElementById('name' + i).value+'"/>');
}
function notepad(i){
	window.open(URL_ADMIN + 'pte.php?<?php echo urlformat($this->q,'FLid',$this->catid,'filename','') ?>' + document.getElementById('name'+i).value,'subWindow',sParams);
}
function closebox(id){
	document.body.removeChild(document.getElementById(id));
}
var oDiv=null;
</script>
<script language="javascript" type="text/javascript" src="js/rte.js" ></script>