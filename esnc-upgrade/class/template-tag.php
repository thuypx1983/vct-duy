<?php
if(!is_file(PATH_META.'default.html'))
	file_put_contents(PATH_META.'default.html','<title>{{TITLE}}</title><meta content="{{KEYWORD}}" name="keywords" /><meta content="{{DESCRIPTION}}" name="description"/>');
if(!is_file(PATH_META.FILE_SELF.'.html'))
	file_put_contents(PATH_META.FILE_SELF.'.html','<title>{{TITLE}}</title><meta content="{{KEYWORD}}" name="keywords" /><meta content="{{DESCRIPTION}}" name="description"/>');
if(!is_file(PATH_META.'common.html'))
	file_put_contents(PATH_META.'common.html','<meta name="robots" content="index,follow" /><meta name="reply-to" content="'.EMAIL_WEBMASTER.'"/>');
if(!is_file(PATH_META.'common-bottom.html')) touch(PATH_META.'common-bottom.html');
	$tag = array(
	'<html xmlns="http://www.w3.org/1999/xhtml">'=>'<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esnc="http://www.esnc.net/xhtml">',
	'<base href="http://web.esnc.net'=>'<meta http-equiv="X-Powered-By" content="http://www.esnc.net/index.php ',
	'<base href="'=>'<meta http-equiv="X-Powered-By" content="',
	'<head>'=>'<head><base href="'.URL_BASE.'" />',
	'<body>'=>'<?php include PATH_COMPONENT.\'box-flash.php\' ?><body id="'.strtr(FILE_SELF,'-','_').'">',
	' href="images/style'=>' href="'.URL_IMAGES.'style',
	'content="text/html; charset=iso-8859-1"'=>'content="text/html; charset='.CHARSET.'"',
	'{{#PATH_COMPONENT.\''=>'<?php include \''.PATH_COMPONENT,
	'{{(PATH_APPLICATION.\''=>'<?php readfile(\''.PATH_APPLICATION,
	'{{#\'content.php\'}}'=>'<?php include \''.PATH_ROOT.'content.php\' ?>',
	'{{#\''=>'<?php include \''.PATH_COMPONENT,
	'{{#'=>'<?php include \''.PATH_COMPONENT,
	'{{(\''=>'<?php @readfile(\''.PATH_APPLICATION,
	'{{('=>'<?php @readfile(\''.PATH_APPLICATION,
	'{{='=>'<?php echo ',
	'{{$'=>'<?php echo $',
	'.php\'}}'=>'.php\' ?>',
	'.htm\')}}'=>'.htm\')?>',
	'.php}}'=>'.php\' ?>',
	'.htm)}}'=>'.htm\')?>',
	'  }}'=>' ?>',
	'<!--{{'=>'<?php ',
	' }}-->'=>' ?>',
	'</head>'=>'<?php 
if(!isset($title)) $title=TEXT_SITE_TITLE;
if(!isset($keyword)) $keyword = TEXT_KEYWORD;
if(!isset($description)) $description = TEXT_DESCRIPTION;
$xtitle=str_replace(\'"\',\'&quot;\',$title);
$keyword = str_replace(\'"\',\'&quot;\',$keyword);
$description = str_replace(\'"\',\'&quot;\',$description);
@define(\'METADATA\',\''.PATH_META.FILE_SELF.'.html'.'\');
if($s=@fileread(METADATA) or $s=@fileread(dirname(METADATA).\'/default.html\') or $s = @fileread(PATH_META.\'/default.html\'));
else $s = \'<title>{{TITLE}}</title><meta name="keywords" content="{{KEYWORD}}" /><meta name="description" content="{{DESCRIPTION}}" />\';
echo strtr($s,array(\'{{TITLE}}\'=>$xtitle,\'{{KEYWORD}}\'=>$keyword,\'{{DESCRIPTION}}\'=>$description));
unset($xtitle,$description,$keyword,$active_meta,$default_meta,$default_meta_db,$row);?>
'.file_get_contents(PATH_META.'common.html').'
<style type="text/css">@import url("'.URL_APPLICATION.'style.css");</style>
<script src="'.URL_APPLICATION.'config.js" language="JavaScript" type="text/javascript"></script>
</head>',
		'</body>'=>'<?php 
foreach(Esnc::$x_append as $value) echo $value;
?><script src="'.URL_ROOT.'js/library.js" language="javascript" type="text/javascript"></script>
'.file_get_contents(PATH_META.'common-bottom.html').'
<script src="'.URL_APPLICATION.'lang.js" language="javascript" type="text/javascript"></script>
<script src="'.URL_ROOT.'js/init.js" language="javascript" type="text/javascript"></script>
</body>'
	);
?>