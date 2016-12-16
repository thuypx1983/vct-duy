function doUp(){
	self.location.href = url_up;
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
		input.focus();
		input.select();
		exvalue = input.value;//keep currentvalue;
		parent.banner.setStatus("Nh&#7853;p v&agrave;o t&ecirc;n m&#7899;i r&#7891;i nh&#7845;n n&uacute;t <strong>&#272;&#7893;i<\/strong>");
	}else{//finish editing, now put to server
		try{
		engine.open('GET',url_rename + ACT_RENAME + '&name=' + encodeURIComponent(input.value) + '&id=' + id,false);//synchonous transfer
		}catch(E){return;}//not support xmlhttp

		engine.setRequestHeader("Accept-Charset", "utf-8");
		parent.banner.setStatus("&#272;ang &#273;&#7893;i t&ecirc;n...");
		try {engine.send(null);		eval((engine.responseText).toString());}
		catch(E){parent.banner.setStatus("L&#7895;i khi &#273;&#7893;i t&ecirc;n: " + E.description); input.value=exvalue;}
		input.readOnly = true;
		input.style.borderColor = "#FFFFFF";
		input = null;
		exvalue = null;
		o.innerHTML = "T&ecirc;n";
	}
}
function doSave(){
	v = getIdValuesPair('view');
	engine.open("GET",url_save + encodeURIComponent(v),false);
	engine.setRequestHeader("Accept-Charset", "utf-8");
	parent.banner.setStatus("&#272;ang c&#7853;p nh&#7853;t...");
	try {engine.send(null);		eval((engine.responseText).toString());}
	catch(E){parent.banner.setStatus("L&#7895;i khi c&#7853;p nh&#7853;t: " + E.description);}
}
function doDel(){
	var v = getChecked('id');
	if(v != '' && parent.banner.ask("Ban co thuc su muon xoa khong?")) {
		//alert(url_del + v);
		self.location.href = url_del + v;//only remove empty
	}
}
function doCopy(c){//c=clipboard
	v = getChecked('id');
	if(v == '') return;
	c.id = v; //keep list of id
	c.type = self_type;//copy to clipboard
	c.cut = false;
	c.setPasteMessage("Khi paste thi cac doi tuong se thuoc ca nhom moi va nhom cu");
	parent.banner.setStatus("&#272;&atilde; l&#432;u b&#7843;n sao c&#7911;a c&aacute;c &#273;&#7889;i t&#432;&#7907;ng v&agrave;o b&#7897; &#273;&#7879;m");
}
function doCut(c){
	v = getChecked('id');
	if(v == '') return;
	c.id = v; //keep list of id
	c.type = self_type;//copy to clipboard
	c.cut = true;
	c.setPasteMessage("Khi paste thi cac doi tuong se chuyen sang nhom moi va xoa khoi nhom ban dau");
	parent.banner.setStatus("&#272;&atilde; chuy&#7875;n v&agrave;o b&#7897; nh&#7899; &#273;&#7879;m");
}
function doPaste(c){
	if(c.id == ""){
		parent.banner.setStatus("B&#7897; nh&#7899; t&#7841;m &#273;ang r&#7895;ng");
	}
	else{
		if(c.type != self_type){
			parent.banner.setStatus("L&#7895;i ki&#7875;u (v&iacute; d&#7909;: kh&ocirc;ng th&#7875; chuy&#7875;n nh&oacute;m s&#7843;n ph&#7849;m sang nh&oacute;m ti&#7879;n &iacute;ch....)");
		}else{
			if(c.cut){ //cut
				if(!parent.banner.ask("Ban co thuc su muon chuyen cac doi tuong trong bo nho sang nhom nay khong?")) return;
				parent.banner.setStatus("Th&#7921;c hi&#7879;n chuy&#7875;n c&aacute;c &#273;&#7889;i t&#432;&#7907;ng trong b&#7897; nh&#7899; t&#7841;m sang nh&oacute;m n&agrave;y");
				self.location.href = url_move + c.id;
				c.id = null;
				c.type=0;
				c.setPasteMessage("Khong co doi tuong trong bo nho");
			}else{ //copy
				parent.banner.setStatus("Th&#7921;c hi&#7879;n &#273;&#432;a c&aacute;c &#273;&#7889;i t&#432;&#7907;ng trong b&#7897; nh&#7899; t&#7841;m v&agrave;o nh&oacute;m n&agrave;y");
				self.location.href = url_copy + c.id;
			}
		}
	}
}
function doNewItem(){	
	var aself = self.location.href;		
	if (aself.indexOf('product')<=0) {
		//self.location.href=url_newitem;
		//self.location.href='<?php echo URL_SELF; ?>/item.php?<?php echo urlformat($this->q,'catid',$this->catid,$this->alias.'id',''); ?>';
		//var url_newitem = '<?php echo dirname(URL_SELF) ?>/item.php?<?php echo urlmodify('catid',$this->catid); ?>';
		self.location.href = url_newitem;
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
function doNewItemByType(type){
	type = '&type='+type;	
	parent.document.getElementById('newitemmenu').style.visibility='hidden';
	self.location.href = url_newitem+type;	
}
function doNew(){
	parent.banner.setStatus('Kh&ocirc;ng th&#7875; t&#7841;o nh&oacute;m khi &#273;ang hi&#7879;n danh s&aacute;ch &#273;&#7889;i t&#432;&#7907;ng');
}
function doLink(){
	
}
//DungHM them vao 18/1/2007
function singleSelect(obj){ 
	var o = document.getElementsByName(obj.name);
	var l = o.length;
	for (var i=0;i<l;i++){
		if ((o[i].id!=obj.id)&&o[i].checked) o[i].checked=false; 
	} 
} 
function getCtrl(n){ // n = 0/1 
	var o = document.getElementsByTagName('input');
	var l = o.length; var v=0;
	for(var i=0;i<l;i++){ 
		if (o[i].type=='checkbox'){ 
			if ((Number(o[i].id)%2==Number(n))&&(Number(o[i].id)!=0)){ 
				if (o[i].checked) v = v | parseInt(o[i].value); 
			} 
		} 
	} 
	return v; 
}
function setCtrl(act){
	var v = getChecked('id');
	var s = getCtrl(1);
	var u = getCtrl(0);	
	if(v==''){
		parent.banner.setStatus("Ch&#432;a c&oacute; &#273;&#7889;i t&#432;&#7907;ng n&agrave;o &#273;&#7921;oc ch&#7885;n");
		//o.options[0].selected = true;
	}else{
		st = document.getElementsByName('status');
		for(i=0,state = '';i<st.length;++i){
			//found whether status checked
			if(st.item(i).checked){
				state='&status=' + st.item(i).value;
			}
		}
		url = self.location.href;
		v=encodeURIComponent(v);
		url = (url.indexOf('?')>0)?url +'&ctrl='+ s +'&nctrl='+u+ '&id=' + v + '&act=' + act + state:url +'?ctrl='+ s +'&nctrl='+u+ '&id=' + v + '&act=' + act + state;	
		//alert(url);return;
		self.location.href = url;		
	}
}
function getCheckboxValueByName(name){
	var o = document.getElementsByName(name);
	var l = o.length;
	var v = 0;
	for (var i=0;i<l;i++){
		if (o[i].checked) v = v | parseInt(o[i].value);
	}
	return v;
}
function filterFeature(name){
	var v = getCheckboxValueByName(name);
	self.location.href = url_filter + v;
}
function doSearch(){
		frmSearch.style.top='2px';
		frmSearch.style.left='180px';
		frmSearch.q.select();
		frmSearch.q.focus();
}
function noSearch(){
	frmSearch.style.top='-600px';
	frmSearch.style.left='-600px';
}