// File Picker modification for FCK Editor v2.0 - www.fckeditor.net
// by: Pete Forde <pete@unspace.ca> @ Unspace Interactive

var urlobj;

function BrowseServer(obj)
{
	urlobj = obj;
	
	OpenServerBrowser(
		'/admin/FCKeditor/editor/filemanager/browser/default/browser.html?Type=Image&Connector=connectors/php/connector.php',
		screen.width * 0.7,
		screen.height * 0.7 ) ;
}

function OpenServerBrowser( url, width, height )
{
	var iLeft = (screen.width  - width) / 2 ;
	var iTop  = (screen.height - height) / 2 ;

	var sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes" ;
	sOptions += ",width=" + width ;
	sOptions += ",height=" + height ;
	sOptions += ",left=" + iLeft ;
	sOptions += ",top=" + iTop ;

	var oWindow = window.open( url, "BrowseWindow", sOptions ) ;
}

function SetUrl( url, width, height, alt )
{
	document.getElementById(urlobj).value = url ;
	oWindow = null;
}
