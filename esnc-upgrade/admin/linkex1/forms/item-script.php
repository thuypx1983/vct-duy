<?php $this->url = URL_SELF;?>
<script language="javascript" type="text/javascript" defer>
var frmItem = document.getElementById("idfrmItem");
var imgImg1 = document.getElementById('idimgImg1');
var imgImg = document.getElementById('idimgImg');
function checkForm(f){
	if(f.name.value == ''){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p ti&ecirc;u &#273;&#7873;");
		f.name.focus();return false;
	}
	return true;
}
function doUpload(){
}
function doUp(){
	self.location.href = "<?php echo dirname($this->url) ?>/item-list.php?<?php echo urlformat(urlchop($this->q,$this->alias.'id'),$this->catalias.'id',$this->catid) ?>";
}
function doCopy(c){
	c.id = <?php echo $this->id ?>;
	c.type = <?php echo $this->type ?>;
	c.cut = false;
	c.setPasteMessage("Trong bo nho co 1 san pham.Khi thuc hien paste thi se copy sang");
	parent.banner.setStatus("&#272;&atilde; &#273;&#432;a &#273;&#7889;i t&#432;&#7907;ng v&agrave;o b&#7897; nh&#7899; t&#7841;m");
}
function doCut(){
	c.id = <?php echo $this->id ?>;
	c.type = <?php echo $this->type ?>;
	c.cut = false;
	c.setPasteMessage("Trong bo nho co 1 san pham.Khi thuc hien paste thi se chuyen sang.Khong thuoc nhom cu nua.");
	parent.banner.setStatus("&#272;&atilde; &#273;&#432;a &#273;&#7889;i t&#432;&#7907;ng v&agrave;o b&#7897; nh&#7899; t&#7841;m");
}
function doPaste(){
	parent.banner.setStatus("Kh&ocirc;ng th&#7875; th&#7921;c hi&#7879;n paste khi &#273;ang l&agrave;m vi&#7879;c v&#7899;i &#273;&#7889;i t&#432;&#7907;ng");
}
function doSave(){
	if(checkForm(frmItem)) frmItem.submit();
}
function doNewItem(){
	self.location.href = '<?php echo $this->url.'?'.urlformat($this->q,'catid',$this->catid,$this->alias.'id',0,'id',0) ?>';
}
function doNew(){
	parent.banner.setStatus("Kh&ocirc;ng th&#7875; t&#7841;o m&#7899;i nh&oacute;m khi &#273;ang t&#7841;o &#273;&#7889;i t&#432;&#7907;ng");
}
function doDel(){
	parent.banner.setStatus("Kh&ocirc;ng th&#7875; xo&aacute; &#273;&#7889;i t&#432;&#7907;ng &#273;ang m&#7903;");
}
function  doSaveImg1(newImg1){
	try{ rnd=Math.random();//parameter null means keep current value
		if(newImg1 != null) {frmItem.img1.value = newImg1; imgImg1.src = URL_TEMP + newImg1 + '?'+rnd}
	}
	catch(E){} //ignore error
}
function  doSaveImg(newImg){
	try{ rnd=Math.random();//parameter null means keep current value
		if(newImg != null) {frmItem.img.value = newImg; imgImg.src = URL_TEMP + newImg + '?'+rnd;}
	}
	catch(E){} //ignore error
}
function doSaveImg2(newImg2,newAlt,htmlView,read){
	if(read) { o = new Object();
		o.htmlView = imgImg2.innerHTML;
		o.desc = frmItem.alt2.value;
		return o;
	}
	try{ rnd=Math.random();//parameter null means keep current value
		if(newImg2 != null) {frmItem.img2.value = newImg2; imgImg2.src = URL_TEMP + newImg2 + '?rnd=' + rnd;}
		if(newAlt2 != null && newAlt2 != '') {frmItem.alt2.value = newAlt2; imgImg2.alt = imgImg2.title = newAlt2;}
	}
	catch(E){} //ignore error
}
function doLink(){
}
</script>