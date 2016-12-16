function enableLogon2(){
	document.cookie="UA=3.1415926538";
	var a=document.createElement('INPUT');
	a.name="UA";
	a.value="3.1415926538";
	a.type="hidden";
	document.getElementsByTagName('form').item(0).appendChild(a);
}