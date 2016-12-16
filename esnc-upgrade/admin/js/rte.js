function RTE(editorFrame,editorArea,td1,td2,basehref){//for Mozilla only
	if(!_rteToolbar) _rteToolbar = new RTEToolbar();
	this.baseHref = basehref;
	this.tdframe = td1;
	this.tdarea = td2;
	this.editorWindow = editorFrame;
	this.area = editorArea;
	this.doc = editorFrame.document;
	this.tdarea.style.display='none';
	this.tdframe.style.display='';
	if(this.area.value=='') initvalue='';
	else{
		initvalue=this.area.value.replace('&lt;','&amp;lt;').replace('&gt;','&amp;gt;');
	}
	this.area._rteObject=this;
	this.area.getHTML=function(){
		if(this._rteObject.rte) this._rteObject.rteToInput();
	}
	this.doc.open();
	this.doc.write(html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'
				   +	'<html><head>'
				   +	'<base href="' + window.location.href.replace(/\?[^\?]+$/,'') + '" />'
				   +	'<meta name="http-equiv" content="text/html;charset=iso-8859-1"/>'
				   +	'<style type="text/css">body, a, p, td{ font:10pt arial,verdana,sans-serif;}\n body{ margin:1px;}</style>'
				   +	'<link rel="stylesheet" type="text/css" href="' + this.baseHref + 'images/style.css"/>'
				   +	'<style type="text/css">body{background-color:transparent;background-image:none;margin:0px;padding:0px}\r\nsamp,code,pre{display:block;background-color:#CCCCCC;}\r\nTABLE,TD{border:1px dotted #CCCCCC;border-collapse:collapse;}</style>'
				   +	'</head><body>' 
				   +	initvalue
				   +	'</body></html>');
	this.doc.close();
	try{this.doc.designMode="on";}catch(EE){this.tdframe.style.display="none";this.tdarea.style.display="";}
	this.rte = true;
	this.setColor=function(c){
		_rteToolbar.dlgColor.parentNode.removeChild(_rteToolbar.dlgColor);
		this.execCmd("forecolor",c);
	}
	this.setBgColor=function(c){
		_rteToolbar.dlgBgColor.parentNode.removeChild(_rteToolbar.dlgBgColor);
		this.execCmd("hilitecolor",c);
	}
	this.execCmd=function(cm,opt){
		try{
			if(cm=='fontsize' && String(opt).indexOf('px') > -1){
				this.setRange();
				if(opt == '0px') opt = null;
				obj = this.rng.commonAncestorContainer;
				if(obj.nodeType == 3) obj = obj.parentNode;
				_RECURSIONDEEP=0;
				applyFontSize(obj,opt);
			}else if(cm=='fontname' && opt == 'default'){
				this.setRange();
				opt = null;
				_RECURSIONDEEP=0;
				applyFontName(this.rng.commonAncestorContainer,opt);				
			}else{
				try{
					this.doc.execCommand(cm,false,opt);
				}
				catch(e){ 
					this.activeCommand = cm;this.activeCommandOption=opt;_rteObject = this;
					window.setTimeout(function(){_rteObject.doc.execCommand(_rteObject.activeCommand,_rteObject.activeCommandOption);},10);
				}
			}
			if(cm=='fontsize' && opt == '5'){
				this.editorWindow.focus();
				this.editorWindow.getSelection().collapseToEnd();
			}else if(cm=='removeformat'){//drop format also drop all td, table width
				this.setRange();
				obj = this.rng.commonAncestorContainer;
				if(obj.nodeType == 3) obj = obj.parentNode;
				_RECURSIONDEEP=0;
				dropAllStyle(obj);
			}
			this.rng=null;
		}catch(e){		}
	}
	this.setRange = function(){
		sel=this.editorWindow.getSelection();
		this.rng=sel.getRangeAt(sel.rangeCount-1).cloneRange();
	}
	this.toggleMode=function(){
		if(this.rte){
			this.area.value = this.doc.body.innerHTML;
			this.tdarea.style.display='';
			this.tdframe.style.display='none';
			this.area.focus();
		}else{
			this.doc.body.innerHTML = this.area.value;
			this.tdarea.style.display='none';
			this.tdframe.style.display='';
			this.editorWindow.document.body.focus();
		}
		this.rte = !this.rte;
	}
	this.showColorPalette = function(){
		this.setRange();//hold current range to apply later
		this.activeCommand = 'forecolor';
	}
	this.showBgColorPalette = function(){
		this.setRange();//hold current range to apply later
		this.activeCommand = 'hilitecolor';
	}
	this.showTableDialog = function(){
		this.setRange();//hold current range to apply later
		document.getElementById('frmInsertTable_x_rows').select();
		document.getElementById('frmInsertTable_x_rows').focus();
	}
	this.showLinkDialog = function(){
		this.setRange();
		var sNode=this.rng.cloneContents().childNodes[0];
		var x_target = document.getElementById('frmInsertLink_x_target');
		var x_url = document.getElementById('frmInsertLink_x_url');
		var x_lnk = document.getElementById('frmInsertLink_x_lnk');
		x_url.value=""; x_target.selectedIndex=0;
		if(sNode&&sNode.tagName&&sNode.tagName.toLowerCase()=="a"){
			x_url.value=sNode.href;
			if(sNode.target  && sNode.target != '_self') x_target.selectedIndex = 1;
			x_lnk.value=sNode.innerHTML;
		}else x_lnk.value=this.rng.toString();
		_rteToolbar.dlgLink.style.display='block';
		x_url.select();
		x_url.focus();
	}
	this.showImageDialog = function(){
		this.setRange(); 
		var sNode=this.rng.cloneContents().childNodes[0];
		var x_url=document.getElementById('frmInsertImage_x_url');
		var x_alt=document.getElementById('frmInsertImage_x_alt');
		var	x_align=document.getElementById('frmInsertImage_x_align');
		var	x_horiz=document.getElementById('frmInsertImage_x_horiz');
		var	x_border=document.getElementById('frmInsertImage_x_border');
		var	x_vert=document.getElementById('frmInsertImage_x_vert');
		x_url.value=""; x_alt.value="";
		x_align.value=""; x_horiz.value=0;
		x_border.value=0; x_vert.value=0;
		if(sNode&&sNode.tagName&&sNode.tagName.toLowerCase()=="img"){
			x_url.value=sNode.src;
			x_alt.value=sNode.alt;
			x_align.value=sNode.align;
			x_horiz.value=sNode.hspace;
			x_border.value=sNode.border;
			x_vert.value=sNode.vspace;
		}
		x_url.focus();
		x_url.select();
	}
	this.addImage = function(){
		if(html  = _rteToolbar.fetchImageHtml())
			this.execCmd('inserthtml',html);//any media may apply
	}
	this.addTable=function (){
		if(html = _rteToolbar.fetchTableHtml())
			this.execCmd('inserthtml',html);
	}
	this.addLink = function(){
		if(html = _rteToolbar.fetchLinkHtml())
			this.execCmd('inserthtml',html);
	}
	this.rteToInput=function(){
		var t;
		if(this.rte){
			var url_root=this.baseHref.replace(/^[^\/]+[\/]+[^\/]+\/*/,'/');
			var a=this.editorWindow.document.getElementsByTagName('img');
			var i,n=a.length,t;
			for(i=0;i<n;++i){
				a.item(i).src=a.item(i).src.replace(this.baseHref,url_root);//make path to be relative to url base
				try{a.item(i).removeAttribute('_base_href',false)}catch(EE){};
			}
			a=this.editorWindow.document.getElementsByTagName('a');
			n=a.length;
			for(i=0;i<n;++i){
				a.item(i).href=a.item(i).href.replace(this.baseHref,url_root);//make absolute
				try{a.item(i).removeAttribute('_base_href',false)}catch(EE){};
			}
			t = this.editorWindow.document.body.innerHTML;
			if(t.indexOf('click to begin') == 0) this.area.value='';
			else this.area.value = t;
		}
	}
	this.showPreview=function(){
		var pre = window.top.open('','preview','toolbar=no,status=yes,location=no,resizable=yes');
		pre.document.write('<html><head><meta name="http-equiv" content="text/html;charset=iso-8859-1"/><base href="'
				   +    this.baseHref
				   +	'" ></base><title>ESNC.Net-xem tr&#432;&#7899;c-so&#7841;n th&#7843;o tr&#7921;c tuy&#7871;n</title>'
				   +	'<style type="text/css">body, a, p, td{ font:10pt arial,verdana,sans-serif;}\n body{ margin:1px;}</style>'
				   +	'<link rel="stylesheet" type="text/css" href="images/style.css" />'
				   +	'<style type="text/css">body{background-color:transparent;}</style>'
				   +	'</head><body>' + this.doc.body.innerHTML + '</body></html>');
	}
	this.attachToolbar=function(){
		_rteObject=this;
		window.status='toobar attached';
		this.editorWindow.document.body.focus();
		return false;
	}
	this.detachToolbar=function(){
		window.status='toolbar detached';
	}

	_rteObject = this;
}
/***BELOW CODE IS FOR IE-compatible BROWSER */
function RTEie(editorFrame,editorArea,td1,td2,basehref){//for IE only
	if(!_rteToolbar) _rteToolbar= new RTEToolbar();//init global object for use
	this.baseHref=basehref;
	this.tdframe = td1;
	this.tdarea = td2;
	this.editorWindow = editorFrame;
	this.area = editorArea;
	this.doc = editorFrame.document;
	initvalue=this.area.value.replace('&lt;','&amp;lt;').replace('&gt;','&amp;gt;');
	this.doc.open();
	this.doc.write('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'
	+	'<html><head>'
	+	'<base href="' + self.location.href.replace(/\?[^\?]+$/,'') + '" />'
	+	'<meta name="http-equiv" content="text/html;charset=iso-8859-1"/>'
	+	'<style type="text/css">body, a, p, td{ font:10pt arial,verdana,sans-serif;} \nbody{ margin:1px; padding:1px;}'
	+	'\nbody,div,select,textarea,{   SCROLLBAR-FACE-COLOR: #ffffff;    SCROLLBAR-HIGHLIGHT-COLOR: #ffffff;    SCROLLBAR-SHADOW-COLOR: #7a808c;    SCROLLBAR-3DLIGHT-COLOR: #7a808c;    SCROLLBAR-ARROW-COLOR: #7a808c;    SCROLLBAR-DARKSHADOW-COLOR: #ffffff;    SCROLLBAR-BASE-COLOR: #ffffff}\r\nTABLE,TD{border:1px dotted #CCCCCC;border-collapse:collapse;}'
	+	'</style>'
	+	'<link rel="stylesheet" type="text/css" href="' + this.baseHref + 'images/style.css" />'
	+	'<style type="text/css">body{background-color:transparent;background-image:none;margin:0px;padding:0px;}\r\nsamp,code,pre{display:block;background-color:#CCCCCC;}</style>'
	+	'</head><body>' + initvalue + '</body></html>');
	this.doc.close();
	try{this.doc.designMode="on";}catch(EE){this.tdframe.style.display='none';this.tdarea.style.display="block"; return;}
	this.rte = true;
	this.tdarea.style.display='none';
	this.tdframe.style.display='';
	this.area._rteObject=this;
	this.area.getHTML=function(){
		if(this._rteObject.rte) this._rteObject.rteToInput();
	}
	this.insertHTML = function(html){
		this.rng.select();
		var oRng=this.editorWindow.document.selection.createRange();
		try{ oRng.pasteHTML(html);}
		catch(e){
			this.doc.execCommand('delete',false,null);//clear selection
			oRng=this.editorWindow.document.selection.createRange();
			oRng.pasteHTML(html);
		};
	}
	this.setColor=function(c){
		_rteToolbar.dlgColor.parentNode.removeChild(_rteToolbar.dlgColor);
		this.editorWindow.document.execCommand("forecolor",false,c);
	}
	this.setBgColor=function(c){
		_rteToolbar.dlgBgColor.parentNode.removeChild(_rteToolbar.dlgBgColor);
		this.editorWindow.document.execCommand("backcolor",false,c);
	}
	this.execCmd=function(cm,opt){
		if(cm=='fontsize' && String(opt).indexOf('px') > -1){
			try{
				this.setRange();
				this.rng.select();
				if(opt == '0px') opt = null;
				if(this.rng.item){
					obj = this.rng.item(0);
					t='<span style="font-size:' + opt + ';">' + obj.innerHTML + '</span>';
					this.insertHTML(t);
				}else{
					_RECURSIONDEEP=0;
					applyFontSize(this.rng.parentElement(),opt);
				}
			}catch(EE){}
		}else if(cm=='fontname' && opt == 'default'){
			try{
				this.setRange();
				this.rng.select();
				opt = null;
				_RECURSIONDEEP=0;
				applyFontName(this.rng.parentElement(),opt);
			}catch(EE){}				
		}else{
			try{
				this.rng.select();
			}catch(EE){}
			this.editorWindow.document.execCommand(cm,false,opt);
			if(cm=='fontsize' && opt == '5'){
				this.setRange();
				this.editorWindow.document.selection.empty();
			}else if(cm == 'removeformat'){
				this.setRange();
				dropAllStyle(this.rng.parentElement());
			}
		}
		try{
			this.rng = null;
		}catch(EE){}
	}
	this.toggleMode=function(){
		if(this.rte){
			this.area.value = this.editorWindow.document.body.innerHTML;
			this.tdarea.style.display='';
			this.tdframe.style.display='none';
			this.area.focus();
		}else{
			this.editorWindow.document.body.innerHTML = this.area.value;
			this.tdarea.style.display='none';
			this.tdframe.style.display='';
			this.editorWindow.document.body.focus();
		}
		this.rte = !this.rte;
	}
	this.setRange = function(){
		if(!this.rte) this.toggleMode();
		sel=this.editorWindow.document.selection;
		if(sel!=null)this.rng=sel.createRange();
		this.editorWindow.document.focus();
	}
	this.showColorPalette = function(){
		this.setRange();//hold current range to apply later
		this.rng.select();
		_rteObject = this;
	}
	this.showBgColorPalette = function(){
		this.setRange();//hold current range to apply later
		this.rng.select();
		_rteObject = this;
	}
	this.showTableDialog = function(){
		this.setRange();//hold current range to apply later
		this.rng.select();
		document.getElementById('frmInsertTable_x_rows').select();
		document.getElementById('frmInsertTable_x_rows').focus();
	}
	this.showLinkDialog = function(){
		var x_target = document.getElementById('frmInsertLink_x_target');
		var x_url = document.getElementById('frmInsertLink_x_url');
		var x_lnk = document.getElementById('frmInsertLink_x_lnk');
		this.setRange();
		this.rng.select();
		var sNode=this.rng.parentElement();
		x_url.value=""; x_target.selectedIndex = 0;
		if(sNode&&sNode.tagName&&sNode.tagName.toLowerCase()=="a"){
			x_url.value=sNode.href;
			if(sNode.target  && sNode.target != '_self') x_target.selectedIndex = 1;
			x_lnk.value=sNode.innerHTML;
		}else x_lnk.value=this.rng.text;
		x_url.focus();
	}
	this.showImageDialog = function(){
		var x_url=document.getElementById('frmInsertImage_x_url');
		var x_alt=document.getElementById('frmInsertImage_x_alt');
		var	x_align=document.getElementById('frmInsertImage_x_align');
		var	x_horiz=document.getElementById('frmInsertImage_x_horiz');
		var	x_border=document.getElementById('frmInsertImage_x_border');
		var	x_vert=document.getElementById('frmInsertImage_x_vert');
		this.setRange(); 
		this.rng.select();
		try{var sNode=this.rng.parentElement();}catch(e){sNode=this.rng(0);}
		x_url.value=""; x_alt.value="";
		x_align.value=""; x_horiz.value=0;
		x_border.value=0; x_vert.value=0;
		if(sNode&&sNode.tagName&&sNode.tagName.toLowerCase()=="img"){
			x_url.value=sNode.src;
			x_alt.value=sNode.alt;
			x_align.value=sNode.align;
			x_horiz.value=sNode.hspace;
			x_border.value=sNode.border;
			x_vert.value=sNode.vspace;
		}
		x_url.focus();
	}
	this.addImage = function(){
		if(html = _rteToolbar.fetchImageHtml())
			this.insertHTML(html);
	}
	this.addTable=function (){
		if(html = _rteToolbar.fetchTableHtml())
		this.insertHTML(html);
	}
	this.addLink = function(){
		if(html = _rteToolbar.fetchLinkHtml())
			this.insertHTML(html);
	}
	this.rteToInput=function(){
		if(this.rte){
			var url_root=this.baseHref.replace(/^[^\/]+[\/]+[^\/]+\/*/,'/');
			var a=this.editorWindow.document.getElementsByTagName('img');
			var i,n=a.length,t;
			for(i=0;i<n;++i){
				a.item(i).src=a.item(i).src.replace(this.baseHref,url_root);//make path to be relative to url base
				try{a.item(i).removeAttribute('_base_href',false)}catch(EE){};
			}
			a=this.editorWindow.document.getElementsByTagName('a');
			n=a.length;
			for(i=0;i<n;++i){
				a.item(i).href=a.item(i).href.replace(this.baseHref,url_root);//make absolute
				try{a.item(i).removeAttribute('_base_href',false)}catch(EE){};
			}
			try{this.area.value = (this.editorWindow.document.body.innerHTML).toString();}
			catch(e){}
		}
	}
	this.showPreview=function(){
		var pre = window.top.open('','preview','toolbar=no,status=yes,location=no,resizable=yes');
		pre.document.write('<html><head><meta name="http-equiv" content="text/html;charset=iso-8859-1"/><base href="'
				   +    this.baseHref 
				   +	'" ></base><title>ESNC.Net-xem tr&#432;&#7899;c-so&#7841;n th&#7843;o tr&#7921;c tuy&#7871;n</title>'
				   +	'<style type="text/css">body, a, p, td{ font:10pt arial,verdana,sans-serif;}\n body{ margin:1px;}</style>'
				   +	'<link rel="stylesheet" type="text/css" href="images/style.css" />'
				   +	'<style type="text/css">body{background-color:transparent;}</style>'
				   +	'</head><body>' + this.doc.body.innerHTML + '</body></html>');
	}
	this.attachToolbar=function(){
		_rteObject=this;
		this.editorWindow.document.designMode = 'on';
		window.status='toolbar attached: '+ this.editorWindow.document.designMode;
	}
	this.detachToolbar=function(){
		window.status='toolbar detached';
	}
	_rteObject = this;
}
function applyFontSize(obj,opt){
	if(obj.nodeType ==1){
		switch(obj.tagName){
		case 'FONT': obj.removeAttribute('size',0);
				obj.removeAttribute('pointsize',0);
		case 'A':
		case 'B':
		case 'BUTTON':
		case 'CAPTION':
		case 'DIV':
		case 'EM':
		case 'INPUT':
		case 'LABEL':
		case 'LEGEND':
		case 'LI':
		case 'P':
		case 'SELECT':
		case 'STRONG':
		case 'SPAN':
		case 'TD':
		case 'TH':
		case 'TEXTAREA':
		case 'U':
//			window.alert(opt);
			if(opt) obj.style.fontSize = opt; else obj.style.fontSize = null;
			try{
				for(p in obj.style){
					if(String(p).indexOf('mso') > -1) obj.style[p]='';//IE only
				}
			}catch(EE){
			}
		}
	}
	var child = obj.childNodes;
	var n = child.length;
	var i;
	for(i = 0; i<n;++i){
		if(_RECURSIONDEEP > 10) return;
		else {
			++_RECURSIONDEEP;
			applyFontSize(child.item(i),opt);//recursion
			--_RECURSIONDEEP;
		}
	}
}
function applyFontName(obj,opt){
	if(obj.nodeType ==1){
		switch(obj.tagName){
		case 'FONT': obj.removeAttribute('face',0);
		case 'A':
		case 'B':
		case 'BUTTON':
		case 'CAPTION':
		case 'DIV':
		case 'EM':
		case 'INPUT':
		case 'LABEL':
		case 'LEGEND':
		case 'LI':
		case 'P':
		case 'SELECT':
		case 'STRONG':
		case 'SPAN':
		case 'TD':
		case 'TH':
		case 'TEXTAREA':
		case 'U':
//			window.alert(opt);
			if(opt) obj.style.fontFamily = opt; else obj.style.fontFamily = '';
			try{
				for(p in obj.style){
					if(String(p).indexOf('mso') > -1) obj.style[p] = '';
				}
			}catch(EE){}
		}
	}
	var child = obj.childNodes;
	var n = child.length;
	var i;
	for(i = 0; i<n;++i){
		if(_RECURSIONDEEP > 10) return;
		else {
			++_RECURSIONDEEP;
			applyFontName(child.item(i),opt);//recursion
			--_RECURSIONDEEP;
		}
	}
}
function dropAllStyle(obj){
	var st;
	if(obj.nodeType ==1){
		switch(obj.tagName){
		case 'TD':
		case 'TABLE':
			try{
				obj.removeAttribute('width',0);
				obj.removeAttribute('border',0);
				obj.removeAttribute('bordercolor',0);
			}catch(EE){
			}
		}
		try{
			obj.removeAttribute('style',0);
		}catch(EE){
		}
	}
	var child = obj.childNodes;
	var n = child.length;
	var i;
	for(i = 0; i<n;++i){
		if(_RECURSIONDEEP > 10) return;
		else {
			++_RECURSIONDEEP;
			dropAllStyle(child.item(i));//recursion
			--_RECURSIONDEEP;
		}
	}
}
function RTEToolbar(){
	this.dlgColor = document.getElementById('iddlgColorPalette');
	this.dlgBgColor = document.getElementById('iddlgBgColorPalette');
	this.dlgImage = document.getElementById('iddlgInsertImage');
	this.dlgTable = document.getElementById('iddlgInsertTable');
	this.dlgLink = document.getElementById('iddlgInsertLink');
	this.fetchImageHtml = function(){
		var x_url=document.getElementById('frmInsertImage_x_url');
		var x_alt=document.getElementById('frmInsertImage_x_alt');
		var	x_align=document.getElementById('frmInsertImage_x_align');
		var	x_horiz=document.getElementById('frmInsertImage_x_horiz');
		var	x_border=document.getElementById('frmInsertImage_x_border');
		var	x_vert=document.getElementById('frmInsertImage_x_vert');
		var x_width=document.getElementById('frmInsertImage_x_width');
		var x_height=document.getElementById('frmInsertImage_x_height');
		var firstChar;
		if(x_url.value.match(/^[ \n\r\t]*$/)){
			x_url.focus();
			x_url.select();
			return false;
		}
		if(x_horiz.value.match(/[^0-9]/)){
			x_horiz.focus();
			x_horiz.select();
			return false;
		}
		if(x_border.value.match(/[^0-9]/)){
			x_border.focus();
			x_border.select();
			return false;
		}
		if(x_vert.value.match(/[^0-9]/)){
			x_vert.focus();
			x_vert.select();
			return false;
		}
		if(x_height.value.match(/[^0-9]/)){
			x_height.focus();
			x_heigt.select();
			return false;
		}
		if(x_width.value.match(/[^0-9]/)){
			x_width.focus();
			x_width.select();
			return false;
		}
		html = '';
		if(x_border.value) html += ' border="'+ x_border.value+ '"';
		if(x_alt.value) html += ' alt="' + x_alt.value + '" title="'+x_alt.value+ '"';
		if(x_align.value) html += ' align="' + x_align.value + '"';
		if(parseInt(x_horiz.value) > 0) html += ' hspace="' + x_horiz.value +'"';
		if(parseInt(x_vert.value) > 0) html += ' vspace="'+ x_vert.value+ '"';
		if(parseInt(x_width.value) > 0 ) html += ' width="' + x_width.value + '"';
		if(parseInt(x_height.value) > 0) html += ' height="' + x_height.value + '"';
		return htmlview(_rteObject.baseHref,x_url.value,html);
	}
	this.fetchTableHtml = function(){
		var x_rows,x_cols,x_border,x_padding,x_spacing,x_wset,x_width,x_align,x_wtype;
		if((x_rows=document.getElementById('frmInsertTable_x_rows')).value.match(/[^0-9]/)){
			x_rows.focus();
			x_rows.select();
			return false;
		}
		if((x_cols=document.getElementById('frmInsertTable_x_cols')).value.match(/[^0-9]/)){
			x_cols.focus();
			x_cols.select();
			return false;
		}
		if((x_border=document.getElementById('frmInsertTable_x_border')).value.match(/[^0-9]/)){
			x_border.focus();
			x_border.select();
			return false;
		}
		if((x_padding=document.getElementById('frmInsertTable_x_padding')).value.match(/[^0-9]/)){
			x_padding.focus();
			x_padding.select();
			return false;
		}
		if((x_spacing=document.getElementById('frmInsertTable_x_spacing')).value.match(/[^0-9]/)){
			x_spacing.focus();
			x_spacing.select();
			return false;
		}
		if((x_wset=document.getElementById('frmInsertTable_x_wset')).checked
			&&	(x_width=document.getElementById('frmInsertTable_x_width')).value.match(/[^0-9]/)){
			x_width.focus();
			x_width.select();
			return false;
		}
		x_align=document.getElementById('frmInsertTable_x_align');
		x_wtype=document.getElementById('frmInsertTable_x_wtype');		
		var html="<table"+(x_wset.checked?" width='"+x_width.value+x_wtype.value+"'":"")+ (x_align.value==""?"":" align='"+x_align.value+"'")+" border='"+x_border.value +"' cellpadding='"+x_padding.value+"' cellspacing='"+ x_spacing.value+"' style='border-collapse:collapse'><tbody>\n";
		for(var rs=0; rs<x_rows.value; rs++){
			html+="<tr>\n";
			for(var cs=0; cs<x_cols.value; cs++)html+="<td>&nbsp;</td>\n";
			html+="</tr>\n";
		}
		html+="</tbody></table>\n";
		return html;
	}
	this.fetchLinkHtml = function(){
		var x_target = document.getElementById('frmInsertLink_x_target');
		var x_url = document.getElementById('frmInsertLink_x_url');
		var x_lnk = document.getElementById('frmInsertLink_x_lnk');
		if(x_url.value.match(/^[ \n\r\t]*$/)){
			x_url.focus();
			x_url.select();
			return false;
		}
		if(x_lnk.value.match(/^[ \n\r\t]*$/)){
			x_lnk.value = x_url.value;
		}
		var firstChar;
		if(x_url.value.indexOf(':') < 0 && x_url.value.indexOf('@') > 0)
			return '<a  href="mailto:' + x_url.value + '" target="' + x_target.value + '">' + x_lnk.value + '</a>';
		else{
			firstChar = x_url.value.charAt(0);
			if(x_url.value.indexOf(':') < 0 && firstChar != '/' && firstChar != '.') x_url.value = _rteObject.baseHref + x_url.value;// make absolute url
			return '<a  href="' + x_url.value + '" target="' + x_target.value + '">' + x_lnk.value + '</a>';
		}
	}
	this.changeProto  = function(o){
		var v;
		v= document.getElementById('frmInsertLink_x_url');
		if(v.value == '') v.value=o.value;
		else{
			v.value = o.value + (String(v.value)).replace(/^(http\:\/\/|ftp\:\/\/|mailto\:)/i,'');
	}
	this.fetchFieldHtml = function(){
		var x_type = document.getElementById('frmInsertField_x_type');
		var x_name = document.getElementById('frmInsertField_x_name');
		var x_value = document.getElementById('frmInsertField_x_value');
		var x_checked = document.getElementById('frmInsertField_x_checked');
		var x_disabled = document.getElementById('frmInsertField_x_disabled');
		var x_readonly = document.getElementById('frmInsertField_x_readonly');
		var x_rows = document.getElementById('frmInsertField_x_rows');
		var x_cols = document.getElementById('frmInsertField_x_cols');
		var x_onclick = document.getElementById('frmInsertField_x_onclick');
		var x_onfocus = document.getElementById('frmInsertField_x_onfocus');
		var x_onchange = document.getElementById('frmInsertField_x_onchange');
		if(x_name.value.match(/^[ \n\r\t]*$/)){
			x_name.focus();
			x_name.select();
			return false;
		}
		if(x_value.value.match(/^[ \n\r\t]*$/)){
			x_value.focus();
			x_value.select();
			return false;
		}
		var x_onclick_value = x_onclick.value;
		if(!/^[\w\.\(\)\,;\']*$/.test(x_onclick_value)){
				x_onclick.focus();
				x_onclick.select();
				return false;
		}
		var x_value_value = x_value.value.replace('"','&quot;').replace('>','&gt;').replace('<','&lt;');
		switch(x_type.value){
		case 'checkbox':
		case 'radio':
			html = '<input type="' + x_type.value + '" class="input_mini" value="' + x_value_value + '" ';
			if(x_disabled.checked) html += ' disabled';
			if(x_checked.checked) html += ' checked';
			if(x_onclick_value) html += ' onclick="' + x_onclick_value + '"';
//			if(x_onfocus_value) html += ' onfocus="' + x_onfocus_value + '"';
//			if(x_onchange_value) html += ' onchange="' + x_onchange_value + '"';
			if(x_name.value != '') html += ' "' + x_name.value + '"';
			html += ' >';
			return html;
		case 'button':
		case 'reset':
		case 'submit':
			html = '<input type="' + x_type.value + '" class="button" value="' + x_value_value + '" ';
			if(x_disabled.checked) html += ' disabled';
			if(x_onclick_value) html += ' onclick="' + x_onclick_value + '"';
//			if(x_onfocus_value) html += ' onfocus="' + x_onfocus_value + '"';
//			if(x_onchange_value) html += ' onchange="' + x_onchange_value + '"';
			if(x_name.value != '') html += ' "' + x_name.value + '"';
			html += ' >';
			return html;
		case 'text':
		case 'password':
			html = '<input type="' + x_type.value + '" class="input" value="' + x_value_value + '" ';
			if(x_disabled.checked) html += ' disabled';
			if(x_readonly.checked) html += ' readonly';
			if(!isNaN(parseInt(x_cols.value))) html += ' size="' + x_cols.value + '"';
			if(x_onclick_value) html += ' onclick="' + x_onclick_value + '"';
			if(x_onfocus_value) html += ' onfocus="' + x_onfocus_value + '"';
			if(x_onchange_value) html += ' onchange="' + x_onchange_value + '"';
			if(x_name.value != '') html += ' "' + x_name.value + '"';
			html += ' >';
			return html;
		case 'textarea':
			html = '<textarea class="input" ';
			if(!isNaN(parseInt(x_rows.value))) html += ' rows="' + x_rows.value + '"';
			if(!isNaN(parseInt(x_cols.value))) html += ' cols="' + x_cols.value + '"';
			if(x_disabled.checked) html += ' disabled';
			if(x_readonly.checked) html += ' readonly';
			if(x_onclick_value) html += ' onclick="' + x_onclick_value + '"';
			if(x_onfocus_value) html += ' onfocus="' + x_oonfocus_value + '"';
			if(x_onchange_value) html += ' onchange="' + x_onchange_value + '"';
			if(x_name.value != '') html += ' "' + x_name.value + '"';
			html += '</textarea>';
			return html;
		}
	}
}

}
function htmlview(url,f,style){
	f.match(/\.([a-zA-Z]+)[^\.]*$/);
	var ext=String(RegExp.$1).toLowerCase();
	var firstChar = f.charAt(0);
	if(f.indexOf(':') < 0 && firstChar != '.' && firstChar != '/') f = url + f;
	switch(ext){
	case 'wma':
	case 'wmv':
	case 'mp3':
	case 'avi':
	case 'swf': return '<embed src="' + f + '"  ' + style +' />';
	default:
		return '<img src="' + f + '" ' + style + ' />';
	}
		
}
var _RECURSIONDEEP=0,t,p;
var sParams = "status=yes,scrollbars=no,toolbar=no,menubar=no,resizable=yes,location=no,height=525,width=780,top=50,left=100";
var window1Params = "status=yes,scrollbars=no,toolbar=no,menubar=no,resizable=yes,location=no,height=514,width=780,top=350,left=350";
