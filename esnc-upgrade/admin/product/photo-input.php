<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Product</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="../images/style.css"/>
<link type="text/css" rel="stylesheet" href="../forms/style.css"/>
<script language="javascript" src="../js/library.js"></script>
<script language="javascript" src="../js.php"></script>
<style type="text/css">
.action{
	color:#0000FF;
	cursor:pointer;
	font-weight:bold;
}
</style>
</head>
<body style="margin: 0px 0px 0px 0px" class="text">
<table width="100%" cellpadding="5" cellspacing="1">
<thead>
	<tr>
		<th width="35%">&#272;&#432;&#7901;ng d&#7851;n &#7843;nh</th>
		<th width="25%">Title</th>
		<th width="25%">Alt</th>	
		<th width="15%">Url</th>	
	</tr>
</thead>
<tbody>
	<tr><td colspan="3">
	<form id="frmadimage" method="post" action="photoprocess.php?productid=<?php echo $_GET['PPproductid']; ?>">		
		<div style="clear:both;margin:0px 0px 5px 0px;">
			<div style="float:left;width:50%;text-align:center;"><input type="text" class="input" name="img[]" style="width:95%; "/></div>
			<div style="float:left;width:25%;text-align:center;"><input type="text" name="title[]" value="" class="input" style="width:95%; "/></div>
			<div style="float:left;width:20%;text-align:center;"><input type="text" name="alt[]" value="" class="input" style="width:95%; "/></div>
			<div style="float:left;width:20%;text-align:center;"><input type="text" name="url[]" value="" class="input" style="width:95%; "/></div>
			<div style="padding:0px;clear:both;">&nbsp;</div>
		</div>		
	</form>	
	</td></tr>	
	<tr><td colspan="3" style="padding-left:10px; "><span onClick="insertInput('frmadimage');" class="action">Th&#234;m &#7843;nh</span></td></tr>
</tbody>
</table>
<script language="javascript" type="text/javascript">
function isURL(urlStr){
	if (urlStr.indexOf(" ")!=-1){
		//alert("Spaces are not allowed in a URL");
		return false;
	}
	if(urlStr==""||urlStr==null){
		return false;
	}
	urlStr=urlStr.toLowerCase();
	var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
	var validChars="\[^\\s" + specialChars + "\]";
	var atom=validChars + '+';
	var urlPat=/^http:\/\/(\w*)\.([\-\+a-z0-9]*)\.(\w*)/;
	var matchArray=urlStr.match(urlPat);
	if (matchArray==null){
		//alert("The URL seems incorrect \ncheck it begins with http://\n and it has 2 .'s");
		return false;
	}
	var user=matchArray[2];
	var domain=matchArray[3];
	for (i=0; i<user.length; i++) {
		if (user.charCodeAt(i)>127) {
			//alert("This domain contains invalid characters.");
			return false;
		}
	}
	for (i=0; i<domain.length; i++) {
		if (domain.charCodeAt(i)>127) {
			//alert("This domain name contains invalid characters.");
			return false;
		}
	}
	var atomPat=new RegExp("^" + atom + "$");
	var domArr=domain.split(".");
	var len=domArr.length;
	for (i=0;i<len;i++) {
		if (domArr[i].search(atomPat)==-1) {
			//alert("The domain name does not seem to be valid.");
			return false;
		}
	}
	if (domArr[domArr.length-1].length!=2 && domArr[domArr.length-1].search(atomPat)==-1) {
		//alert("The address must end in a well-known domain or two letter " + "country.");
		return false;
	}
	return true;
}
function doSave(){
	var f = document.getElementById('frmadimage');
	var p = document.getElementsByName('img[]');
	var lim = p.length;
	for (var j = 0;j<lim;j++){
		if (p[j].value!=''){
			if (!isURL(p[j].value)) {
				alert("Duong dan anh khong chinh xac lam on kiem tra lai");
				p[j].select();
				return false;
			}			
		}
	}
	f.submit();
}
var i=0;
function insertInput(parentid){
	var p = document.getElementById(parentid);
	var c = document.createElement('div');	
	var htmltext = '';
	htmltext  = '<div style="float:left;width:50%;text-align:center;"><input type="text" class="input" name="img[]" style="width:95%; "/></div>';
	htmltext +=	'<div style="float:left;width:25%;text-align:center;"><input type="text" name="title[]" value="" class="input" style="width:95%; "/></div>';
	htmltext +=	'<div style="float:left;width:20%;text-align:center;"><input type="text" name="alt[]"   value="" class="input" style="width:95%; "/></div>';
	htmltext +=	'<div style="float:left;width:5%;text-align:center;"><span onClick="removeInput(\'input'+i+'\');"  class="action">Xo&#225;</span></div>';
	htmltext +=	'<div style="padding:0px;clear:both;">&nbsp;</div>';
	c.setAttribute('id','input'+i);
	c.style.clear = "both";
	
	c.innerHTML = htmltext;
	p.appendChild(c);
	i++;
}
function removeInput(id){
	var o = document.getElementById(id);	
	o.parentNode.removeChild(o);
}
</script>
</body>
</html>