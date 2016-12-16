function PTE(editorArea,baseHref){
	this.area=editorArea;
	this.baseHref = baseHref;
	this.showPreview=function(){
		var pre = window.top.open('','preview','toolbar=no,status=yes,location=no,resizable=yes');
		pre.document.write('<html><head><meta name="http-equiv" content="text/html;charset=iso-8859-1"/><base href="'
		   +    this.baseHref
		   +	'" ></base><title>ESNC.Net-xem tr&#432;&#7899;c-so&#7841;n th&#7843;o tr&#7921;c tuy&#7871;n</title>'
		   +	'<style type="text/css">body, a, p, td{ font:10pt arial,verdana,sans-serif;}\n body{ margin:1px;}</style>'
		   +	'<link rel="stylesheet" type="text/css" href="images/style.css" />'
		   +	'<style type="text/css">body{background-color:transparent;}</style>'
		   +	'</head><body>' + this.area.value + '</body></html>');
	}
}
var sPlainWin = "status=yes,scrollbars=no,toolbar=no,menubar=no,resizable=yes,location=no,height=525,width=780,top=50,left=100";