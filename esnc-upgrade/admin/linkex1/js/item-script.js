function doUpload(){
}
function doUp(){
try{	
	self.location.href = url_up;
}catch(e){}	
}
function doCopy(c){
	c.id = self_id;
	c.type = self_type;
	c.cut = false;
	c.setPasteMessage("Trong bo nho co 1 san pham.Khi thuc hien paste thi se copy sang");
	parent.banner.setStatus("&#272;&atilde; &#273;&#432;a &#273;&#7889;i t&#432;&#7907;ng v&agrave;o b&#7897; nh&#7899; t&#7841;m");
}
function doCut(){
	c.id = self_id;
	c.type = self_type;
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
	if(url_newitem == '#'){
		parent.banner.setStatus('Ch&#7913;c n&#259;ng kh&#244;ng &#273;&#432;&#7907;c h&#7895; tr&#7907;');
		return false;
	}	
	var aself = self.location.href;		
	if (aself.indexOf('product')<=0) {
		self.location.href=url_newitem;
		return;
	}
	var ie = document.all?true:false;
	var o = parent.document.getElementById('newitemmenu');
	if (o.style.visibility == "hidden"){
		if (ie)	{
			o.style.position   = "absolute";			
			o.style.top        = "50px";
			o.style.left       = "220px";		
		}
		o.style.visibility = "visible";
	}else{
		o.style.visibility = "hidden";
	}
	
}
/*function doNewItem(){
	alert("Hello");
//	self.location.href = url_newitem;
	var o = parent.document.getElementById('newitemmenu');
	if (o.style.visibility=="hidden"){
		o.style.visibility="visible";
	}else{
		o.style.visibility="hidden";
	}
}*/
function doNewItemByType(type){
	type = '&type='+type;	
	parent.document.getElementById('newitemmenu').style.visibility='hidden';
	self.location.href = url_newitem+type;	
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
		o.desc     = frmItem.alt2.value;
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

