var agt=navigator.userAgent.toLowerCase();
var isIE=((agt.indexOf("msie")!=-1)&&(agt.indexOf("opera")==-1)&&(agt.indexOf("webtv")==-1));
var isGecko=(navigator.product=="Gecko");
var isSafari=(agt.indexOf("safari")!=-1);
var isKonqueror=(agt.indexOf("konqueror")!=-1);
var scrW=screen.width,scrH=screen.height;

function linkExchangeRewrite(url){
	return url;
}
function clearTextBox(o){
	if(o.value.indexOf('..') >=0 ) o.select();
}
function getChecked(name){
/*	getChecked(name): return a comma seperated value (value1,value2,value3...)for all checkbox with same name
name	: name of the checkbox
need to create array of check box with same name like:
<input type=checkbox name='name' value=value1>
<input type=checkbox name='name' value=value2>
<input type=checkbox name='name' value=value3>
*/
	var o=document.getElementsByName(name);
	var i,s,v;
	for(i=0,s='';i < o.length; ++i){
		v=o.item(i);
		if(v.type == "checkbox"){
			if(v.checked) s += ',' + String(v.value);
		}
	}
	return s.substr(1);//remove leading ,
}
//////////////////////
function getIdValuesPair(name){
/*	getIdValuesPair(name): return a comma seperated (id1=value1,id2=value2...) for all input with same name
name	: name of input
need to create array of input with same name like:
<input type=text name='name' id='id1' value=value1>
<input type=text name='name' id='id2' value=value2>
<input type=text name='name' id='id3' value=value3>
*/
	var o=document.getElementsByName(name);
	var s='';
	for(i=0;i<o.length;++i){
		v=String(o.item(i).value);
		if(v != '') s += 'aa' + o.item(i).id + 'bb' + v;
	}
	return s.substr(2);
}
//////////////////////
function checkAll(name){
/*	checkAll(name):	mark as checked all checkbox with same name
name	: name of the checkbox
*/
	var o=document.getElementsByName(name);
	var i;
	for(i=0;i < o.length; o.item(i).checked=true, ++i);
}
////////////////////////
function setAll(name,state){
/*	setAll(name,state):	mark all checkbox with same name to the specified state
name	: name of the checkbox
state	: true/false status
*/
	var o=document.getElementsByName(name);
	var i;
	for(i=0;i < o.length; o.item(i).checked=state, ++i);
}

////////////////////////
function clearAll(name){
/*	clearAll(name):	uncheck all checkbox with same name
name	: name of the checkbox
*/
	var o=document.getElementsByName(name);
	var i;
	for(i=0;i < o.length; o.item(i).checked=false, ++i);
}
/////////////
////////////////////////
function resetAllName(name){
/*	resetAllName(name):	set name to empty string to exclude from submitting
name	: name of the checkbox
*/
	var o=document.getElementsByName(name);
	var i;
	for(i=0;i < o.length; o.item(i).name='', ++i);
}
/////////////
function urlgo(page,q){
/*	urlgo(page,q,[<name1,value1>[,..n]][,'-',<namex>[,...n]])
	tell browser to goto specified location
page:	page name to goto
q	:	query string
<name1,value1>:	append parameter name=value to query string q
namex	: chop this parameter from query string q
*/
	var c=arguments.length;
	if(c==1){ 
		if (page != "" && page != null){
			if(page.indexOf('?') <0) page +='?go=' + encodeURIComponent(String(self.location.href).replace(URL_BASE,URL_ROOT));
			else page += '&go=' + encodeURIComponent(String(self.location.href).replace(URL_BASE,URL_ROOT))
			self.location.href=page;
		}
		return;
	}
	var re=new RegExp;
	for(i = 2; (argv=String(arguments[i])) != '-' && i < c; ++i){
		re.compile("(?:\\&|^)" + argv + "=[^\\&]*(?=\\&|$)","ig");
		q=q.replace(re,"&");//append to url
		q += "&" + argv + "=" + String(arguments[++i]);
	}
	for(++i; i < c; ++i){ //ignore -, denote a start of chopping parameters)
		argv=String(arguments[i]);
		re.compile("(?:\\&|^)" + argv + "=[^\\&]*(?=\\&|$)","ig");
		q=q.replace(re,"&"); //chop from url
	}
	q=q.replace(/\&{2,}/ig,"&").replace(/(?:^\&|\&$)/ig,"");
	self.location.href=page + "?" + q;
}
///////////////
function urlchop(q){
/*	urlchop(q,[name][,...n])
	chop name from query string q
q	: original query string
name: chop this parameter from q
*/
	var c=arguments.length;
	var re=new RegExp;
	for(i=1; i < c; ++i){ //ignore -, denote a start of chopping parameters)
		argv=String(arguments[i]);
		re.compile("(?:\\&|^)" + argv + "=[^\\&]*(?=\\&|$)","ig");
		q=q.replace(re,"&"); //chop from url
	}
	return q.replace(/\&{2,}/ig,"&").replace(/(?:^\&|\&$)/ig,"");
}
////////////////
function urlformat(q){
/*	urlgo(q,[<name1,value1>[,..n]][,'-',<namex>[,...n]])
	append or chop specified parameters from query string
q				: original query string
<name1,value1>	: append parameter name1=value1 to query string q
namex			: chop this parameter from q
*/
	var c=arguments.length;
	var re=new RegExp;
	for(i = 1; (argv=String(arguments[i])) != '-' && i < c; ++i){
		re.compile("(?:\\&|^)" + argv + "=[^\\&]*(?=\\&|$)","ig");
		q=q.replace(re,"&");//append to url
		q += "&" + argv + "=" + String(arguments[++i]);
	}
	for(++i; i < c; ++i){ //ignore -, denote a start of chopping parameters)
		argv=String(arguments[i]);
		re.compile("(?:\\&|^)" + argv + "=[^\\&]*(?=\\&|$)","ig");
		q=q.replace(re,"&"); //chop from url
	}
	return q.replace(/\&{2,}/ig,"&").replace(/(?:^\&|\&$)/ig,"");
}
/*created by DungHM*/
function hideButton(){
//An button tren thanh cong cu voi doi so la id cua td chua nut	
	argLen = arguments.length;
	for(i=0;i<argLen;i++){
		arg = String(arguments[i]);
		with(parent.banner){
			document.getElementById(arg).style.display="none";
		}
	}
}
function showButton(){	
//Hien button tren thanh cong cu voi doi so la id cua td chua nut	
	argLen = arguments.length;
	for(i=0;i<argLen;i++){
		arg = String(arguments[i]);
		with(parent.banner){
			document.getElementById(arg).style.display="";
		}
	}
}
function oversort(id){
	document.getElementById(id).style.backgroundImage="url(../images/over.gif)";	
}
function outsort(id){
	document.getElementById(id).style.backgroundImage="url(../images/bg-product.gif)";	
}
function showContextMenu(o){	
	o.style.visibility = "visible";
}
function hideContextMenu(o){
	o.style.visibility = "hidden";
}
function checknumber(val){
	if (isNaN(val)){
		alert("Day khong phai la mot so!");
		return false;
	}
	if (val == null || val ==""){
		alert("Ban khong duoc bo trong truong nay!");
		return false;
	}
	return true;
}
var __tested__ = false;
function storeCaret (textEl) {
	__tested__=true;
	if (textEl.createTextRange) {
		textEl.caretPos = document.selection.createRange().duplicate();
	}
}
function insertAtCaret (textEl, text) {
	if(!__tested__) return;
	if (textEl.createTextRange && textEl.caretPos) {
		var caretPos = textEl.caretPos;
		caretPos.text =
		caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?	text + ' ' : text;
		textEl.focus();
	}
	else textEl.value = text;
}
function EnterToBr(){
	if(window.event.keyCode == 13 && ! window.event.shiftKey){
		insertAtCaret(window.event.srcElement,"<br>");
	}
}
function openDocumentLibrary(url,c,n,callBack){
	self.open('../document-library.php?rel=' + url + '&c=' + c + '&n=' + n +'&fn=' + callBack);
}
/*---end---*/
// Resize images
function setImgBorder(o){
	o.style.border="1px solid #0066CC";
}
function unsetImgBorder(o){
	o.style.border="0px";
}
function showImage(id,maxwidth){
	var o = document.getElementById(id);
	if (o.width>=maxwidth){
		o.width = maxwidth;
	}
}
function popupURL(sUrl,sWname,w,h){
	return window.open(sUrl,sWname,"toolbar=no,menubar=no,personalbar=no,scrollbars=no,resizable=no,status=no,width="+w+",height="+h+",left="+((scrW-w)/2)+",top="+((scrH-h)/2)+",dependent=yes");
}
function posX(obj){
	var vX=0;
	if(obj.x)vX=obj.x;
	else if(obj.offsetParent)
		while(obj.offsetParent){
			vX+=obj.offsetLeft;
			obj=obj.offsetParent;
		}
	return vX;
}
function posY(obj){
	var vX=0;
	if(obj.y)vX=obj.y;
	else if(obj.offsetParent)
		while(obj.offsetParent){
			vX+=obj.offsetTop;
			obj=obj.offsetParent;
		}
	return vX;
}
function winWidth(){
	if(typeof(window.innerWidth)=="number")return window.innerWidth;
	else if(document.documentElement&&document.documentElement.clientWidth)return document.documentElement.clientWidth;
	else if(document.body&&document.body.clientWidth)return document.body.clientWidth;
	else return screen.width;
}
function stripHTML(s){
	return s.replace(/(<([^>]+)>)/ig,"").replace(/^(?:( |\n|\r|\t)+)/,"").replace(/(?:( |\n|\r|\t)+)$/,"");
}
function showHideEl(el,Show){
	if(Show)el.style.display="";
	else el.style.display="none";
}
function orderPrint(id){
	window.open(URL_ROOT + 'order-print.php?ORid='+id);
}
function orderPDF(id){
}
function htmlview(url,file,style){
	
}
function showTip(evt){
	var tip = document.getElementById(this.getAttribute('_block_tip_id'));
        if(!tip) return;
	var cssTip=tip.style;
	var _body = document.documentElement;
/*cach lay toa do cua chuot luc xay ra su kien*/
/*@cc_on  @if(1)
	var x=window.event.clientX + _body.scrollLeft - _body.clientLeft;
	var y=window.event.clientY + _body.scrollTop - _body.clientTop;
	if(!this.getAttribute('_first_time')){
		cssTip.visibility='hidden';
		tip.filters.item(0).Apply();
	}
  @else@*/
	var x=evt.pageX;
	var y=evt.pageY;
/*@end@*/
	var top,left;
	if(y + tip.offsetHeight > _body.clientHeight + _body.scrollTop){ // outside of screen
		 top = Math.max(y - tip.offsetHeight + 10,_body.scrollTop + 10);
	}else{
		top = 10 + y;
	}
	if(x + tip.offsetWidth > _body.clientWidth + _body.scrollLeft){
		left = Math.max(x - tip.offsetWidth + 10,_body.scrollLeft + 10);
	}else{
		left = 10 + x;
	}
	if(top < y && y < top + tip.offsetHeight && left < x && x < left + tip.offsetWidth){ 
                  //mouse still inside the rectangle
		cssTip.top = y+10+'px';
		cssTip.left = x+10+'px';
	}else{
		cssTip.top = top + 'px';
		cssTip.left = left + 'px';
	}
}
function hideTip(){
	var tip = document.getElementById(this.getAttribute('_block_tip_id'));
	if(tip){
		tip.style.top = '-20000px';
		tip.style.left = '-20000px';
		this.setAttribute('_first_time',0);
	}
}

function fetchHTML(s){
	s=String(s).replace(/\\(\"|\')/gi,"$1").replace(/\r/g,"").replace(/\n+/g,"\n");
	s=s.replace(/<(\!\-\-|base|meta|\!doctype|html|\/html|body|\/body|head|\/head|div|\/div|button|applet|base|input|form|\/form|noframes|\/noframes|iframe|\/iframe|frame)(>|\s([^>]*)>)/gi,"");
	s=s.replace(/(<title([^>]*)>)([^<]*)(<\/title([^>]*)>)/gi,"");
	s=s.replace(/(<noscript([^>]*)>)([^<]*)(<\/noscript([^>]*)>)/gi,"");
	s=s.replace(/(<noframes([^>]*)>)([^<]*)(<\/noframes([^>]*)>)/gi,"");
	s=s.replace(/(<style([^>]*)>)([^<]*)(<\/style([^>]*)>)/gi,"");
	s=s.replace(/(<textarea([^>]*)>)([^<]*)(<\/textarea([^>]*)>)/gi,"");
	s=s.replace(/(<select([^>]*)>)([^<]*)(<\/select([^>]*)>)/gi,"");
	s=s.replace(/(<option([^>]*)>)([^<]*)(<\/option([^>]*)>)/gi,"");
	s=s.replace(/(<script([^>]*)>)([^<]*)(<\/script([^>]*)>)/gi,"");
	s=s.replace(/(<style([^>]*)>)((.|\n|\r|$|^)*)(<\/style([^>]*)>)/gi,"");
	s=s.replace(/(<script([^>]*)>)((.|\n|\r|$|^)*)(<\/script([^>]*)>)/gi,"");
	s=s.replace(/(<textarea([^>]*)>)((.|\n|\r|$|^)*)(<\/textarea([^>]*)>)/gi,"");
	s=s.replace(/<(\/)?(title|script|noscript|noframes|style|textarea|select|option)(>|\s([^>]*)>)/gi,"");
	s=s.replace(/<(.*)(\'|\")javascript:(.*)(\'|\")(\s|>)/gi,"<$1$2$4$5");
	s=s.replace(/<(.*)(\s*)(onclick|ondblclick|onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|onkeydown|onkeyup|onload|onunload|onfocus|onblur|class|id|name|value)(\s*)=(\s*)(\'|\")([^\'\"]*)(\'|\")/gi,"<$1");
	return s.replace(/\n+/g,"\n").replace(/^(?:( |\t|\r|\n)+)/,"").replace(/(?:( |\t|\r|\n)+)$/,"");
}
function SHOW(id){	
	var o = document.getElementById(id);	
	if (o.style.visibility =='hidden' || o.style.visibility == ''){
		o.style.visibility='visible';
	}
	else{
		o.style.visibility='hidden';
	}
	if (o.clientWidth<154) o.style.width= '154px';
}
function HIDE(id){
	var o;
	if( o = document.getElementById(id))	
		o.style.visibility ='hidden';
}
