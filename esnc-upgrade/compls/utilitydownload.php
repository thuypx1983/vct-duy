<?php
@define('FILE_TYPE_CODE','|php|asp|asa|inc|ini|');
$UTpath = (string) $_GET['UTpath'];
$file=PATH_UTILITY_PATH.$UTpath;
if(is_readable($file) && !is_executable($file) ){
	$ext = pathinfo($UTpath,PATHINFO_EXTENSION);
	if(strpos(FILE_TYPE_CODE,$ext) !== FALSE) exit();//prevent download
	header('Content-Type:application/octet-stream');
	header('Content-Length:'.filesize($file));
	header('Content-Disposition:attachment;filename="'.basename($UTpath).'"');
	@readfile($file);
	exit;
}
$URL_DOWNLOAD = urlrel(URL_UTILITY_PATH,$UTpath);
if($s=@file_get_contents(PATH_APPLICATION.'msg_download.htm')){
	$tag = array('{{DOWNLOAD_URL}}');
	$tagvalue = array($URL_DOWNLOAD);
	echo str_replace($tag,$tagvalue,$s);
	exit();
}
?><html>
<head>
<base href="<?php echo URL_BASE ?>" />
<meta http-equiv="refresh" content="0;url=<?php echo $URL_DOWNLOAD ?>" />
<link href="images/style.css" type="text/css" rel="stylesheet" />
</head>
<body class="text">
&#272;ang chuy&#7875;n t&#7899;i trang t&#7843;i d&#7919; li&#7879;u. N&#7871;u tr&igrave;nh duy&#7879;t kh&#244;ng t&#7921; chuy&#7875;n, m&#7901;i b&#7841;n <a href="<?php echo $URL_DOWNLOAD; ?>">nh&#7845;n v&#224;o &#273;&#226;y</a>
</body>
<script language="javascript" type="text/javascript" defer>
window.setTimeout('self.location.href="<?php echo $URL_DOWNLOAD ?>";',200);
</script>
</html>