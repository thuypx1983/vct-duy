function CssEventSelector(){
	this.apply=function(node){
		var k=this.baseIdx,j,e;
		if(this.part[k].test(node)){
			j= k - 1;
			e=node.parentNode;
			while(j>=0 && e){
				if(this.part[j].test(e)) --j;
				e = e.parentNode;
			}
			if(j < 0)	return (node[this.evt]=this.fn);
		}
		return false;
	}
	this.part = new Array();
	this.evt = null;
	this.fn = null;
}
//define basic selector
function IDSelector(id){
	this.id = id;
	this.test=function(node){return node.id == this.id}
}
function ClassSelector(cssClass){
	this.re = new RegExp('\\b' + cssClass + '\\b');
	this.test=function(node){return this.re.test(node.className)}
}
function TagSelector(nodeName){
	this.nodeName = nodeName.toUpperCase();
	this.test = function (node){return this.nodeName == node.nodeName;}
}
function UniversalSelector(){ this.test=function(){return true;}}

function IDTagSelector(nodeName,id){
	this.nodeName = nodeName.toUpperCase();
	this.id = id;
	this.test=function(node){return node.id == this.id && node.nodeName==this.nodeName}
}
function ClassTagSelector(nodeName,cssClass){
	this.nodeName = nodeName.toUpperCase();
	this.re = new RegExp('\\b' + cssClass + '\\b');
	this.test=function(node){return this.re.test(node.className) && node.nodeName == this.nodeName;}
}


function _applyCssEventSelector(){
	var selector,l,p,part,t,j,nodeName,id,cssClass,pp;	
	var CSS_EVENT_SELECTORS = new Array();
	for(l=0;l < CSS_EVENT_SELECTOR_RULE.length;++l){
		p = CSS_EVENT_SELECTOR_RULE[l].split(':');
		selector = new CssEventSelector;
		if(p[2]=='function'){
			selector.evt=p[1];
			selector.fn=eval(p[1]);
		}else{
			selector.evt='on' + p[1];
			selector.fn = eval(p[2]);
		}
		part = p[0].split(' ');//split into component
		selector.baseIdx = part.length-1;
		//build function test for each part to check if a node match
		for(j = 0; j <= selector.baseIdx ; ++j){
			pp = part[j].split('.');
			if(pp.length == 2){
				if(pp[0] == '' || pp[0] == '*') selector.part[j] = new ClassSelector(pp[1]);
				else selector.part[j] = new ClassTagSelector(pp[0],pp[1]);
				continue;
			}
			pp = part[j].split('#'); //check if id selector
			if(pp.length == 2){
				if(pp[0] == '' || pp[0] == '*') selector.part[j] = new IDSelector(pp[1]);
				else selector.part[j] = new IDTagSelector(pp[0],pp[1]);
				continue;
			}
			if(part[j] == '*') selector.part[j] = new UniversalSelector();
			else selector.part[j] = new TagSelector(part[j]);
		}
		CSS_EVENT_SELECTORS[l] = selector;
	}
	var nodes = document.getElementsByTagName('*');//get all nodes
	var nodes_count = nodes.length;
	var i,j;
	for(i=0;i<nodes_count;++i)
		for(j=0;j < CSS_EVENT_SELECTORS.length;++j)
			CSS_EVENT_SELECTORS[j].apply(nodes.item(i));
}

document.getElementsBySelector=function(sel){
	var	part = sel.split(' ');//split into component
	var part_count = part.length-1;
	var i,j,pp,ps = new Array;
	for(j = 0; j <= part_count ; ++j){
		pp = part[j].split('.');
		if(pp.length == 2){
			if(pp[0] == '' || pp[0] == '*') ps[j] = new ClassSelector(pp[1]);
			else ps[j] = new ClassTagSelector(pp[0],pp[1]);
			continue;
		}
		pp = part[j].split('#'); //check if id selector
		if(pp.length == 2){
			if(pp[0] == '' || pp[0] == '*') ps[j] = new IDSelector(pp[1]);
			else ps[j] = new IDTagSelector(pp[0],pp[1]);
			continue;
		}
		if(part[j] == '*') ps[j] = new UniversalSelector();
		else ps[j] = new TagSelector(part[j]);
	}
	var nodes = document.getElementsByTagName('*');
	var nodes_count = nodes.length;
	var result=new Array;
	var result_count = 0;
	var node,e,k=part_count;
	for(i = 0; i <  nodes_count; ++i){
		node = nodes.item(i);
		if(ps[k].test(node)){
			j= k - 1;
			e=node.parentNode;
			while(j>=0 && e){
				if(ps[j].test(e)) --j;
				e = e.parentNode;
			}
			if(j < 0)	result[result_count++] = node;
		}
	}
	return result;
}
function _bindingForm(){
	var fs = document.getElementsByTagName('FORM');
	var i;
	for(i=0;i<fs.length;++i) fs.item(i).fail = function(msg,el){ window.alert(msg);this.elements[el].focus(); try{this.elements[el].select();} catch(EE){}; return false;}
}
_bindingForm();
if(typeof(CSS_EVENT_SELECTOR_RULE) != 'undefined' && CSS_EVENT_SELECTOR_RULE.length >0) _applyCssEventSelector();
/*@cc_on @if(1) $=document.getElementById;@else@*/ function $(id){ return document.getElementById(id);} /*@end@*/
Array.prototype.item = function (i) { return this[i];}
