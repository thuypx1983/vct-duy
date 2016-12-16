function navigateFolder(id,flag){
	switch (flag){
		case 0://empty
		case 2: self.location.href=url_self + '?' + catalias + 'parentid=' + id;break;//sub-folder
		default:
		self.location.href=url_cwd + 'item-list.php?' + catalias + 'id=' + id;
	}
}
function doNew(){
	dlgNewGroup.style.display='';
	frmNewGroup.name.focus();
	frmNewGroup.name.select();
}
function doCancel(){
	dlgNewGroup.style.display='none';
}
function doUp(){
	self.location.href = url_self + '?' + catalias + 'parentid=' + grandparentid;
}
var input=null,exvalue=null,engine,submitting=false;
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
		engine.open('GET',url_self + '?act=' + ACT_RENAME + '&name=' + encodeURIComponent(input.value) + '&id=' + id,false);//synchonous transfer
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
	engine.open("GET",url_sort + v,false);
	engine.setRequestHeader("Accept-Charset", "utf-8");
	parent.banner.setStatus("&#272;ang c&#7853;p nh&#7853;t...");
	try {engine.send(null);		eval((engine.responseText).toString());}
	catch(E){parent.banner.setStatus("L&#7895;i khi c&#7853;p nh&#7853;t: " + E.description);}
}
function doDelGroup(id,flag){
	if(flag == 0 && parent.banner.ask("Ban co thuc su muon xoa nhom nay khong?")) 
		self.location.href = url_remove + id;//only remove empty
	else parent.banner.setStatus("Ch&#7881; c&oacute; th&#7875; xo&aacute; nh&oacute;m r&#7895;ng");
}
function doDel(){
	parent.banner.setStatus("Nh&#7845;n v&agrave;o <strong>Xo&aacute;</strong> &#273;&#7875; xo&aacute; nh&oacute;m r&#7895;ng");
}
function doCopy(c){//c=clipboard
	parent.banner.setStatus("Ch&#7881; c&oacute; th&#7875; chuy&#7875;n nh&oacute;m, kh&ocirc;ng th&#7875; sao ch&eacute;p nh&oacute;m");
}
function doCut(c){
	v = getChecked('id');
	if(v == '') return;
	c.id = v; //keep list of id
	c.type = self_type;
	c.cut = true;
	c.setPasteMessage("Nh&#7845;n n&uacute;t n&agrave;y &#273;&#7875; chuy&#7875;n sang nh&oacute;m m&#7899;i (v&agrave; xo&aacute; kh&#7887;i nh&oacute;m c&#361;)");
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
			if(!parent.banner.ask("Ban co thuc su muon chuyen cac nhom trong bo nho sang nhom nay khong?")) return;
			parent.banner.setStatus("Th&#7921;c hi&#7879;n chuy&#7875;n c&aacute;c nh&oacute;m trong b&#7897; nh&#7899; t&#7841;m sang nh&oacute;m n&agrave;y");
			self.location.href = url_move + c.id;
		}
	}
}
function doNewItem(){
	self.location.href=url_newitem;
}
function doLink(c){
	parent.banner.setStatus("Kh&ocirc;ng th&#7875; t&#7841;o li&ecirc;n k&#7871;t &#273;&#7889;i v&#7899;i nh&oacute;m, ch&#7881; c&oacute; th&#7875; li&ecirc;n k&#7871;t c&#7911;a c&aacute;c &#273;&#7889;i t&#432;&#7907;ng");
}
function checkForm(f){
	if(f.name.value == '' || f.name.value.indexOf('..') >-1){
		parent.banner.setStatus('B&#7841;n c&#7847;n nh&#7853;p t&ecirc;n nh&oacute;m');
		return false;
	}
	if(submitting) return false;//prevent double submit
	submitting=true;
	return true;
}
function submitNewGroup(){
	if(checkForm(frmNewGroup)) frmNewGroup.submit();
}
//Dunghm them vao ngay 18/1/2006
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
	}else{
		url = self.location.href;
		url = url +'&ctrl='+ s +'&nctrl='+u+ '&id=' + v + '&act=' + act;
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