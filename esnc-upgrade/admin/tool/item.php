<?php 
require '../../config.php';
require '../inc/common.php';
require '../inc/session.php';
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	exit('<script type="text/javascript">window.top.location.href="../../"</script>');
}
require '../config.php';
require '../inc/dbcon.php';
require PATH_CLASS.'tool.php';
$f = $_REQUEST['-'];
if(!preg_match('/^[\w\-]+$/',$f) || !((strpos($f,'sys') === 0 && require PATH_ADMIN.'tool/'.$f.'.php') || require PATH_COMPONENT.'tool/'.$f.'.php')){
	trigger_error(
'C&ocirc;ng c&#7909; kh&ocirc;ng t&#7891;n t&#7841;i ho&#7863;c <strong>TLfile/TLid</strong> kh&ocirc;ng t&igrave;m th&#7845;y trong <strong>$_GET/$_POST</strong><br/>
C&#7847;n s&#7917; d&#7909;ng <strong>$this-&gt;startForm,$this-&gt;makeUrl, Tool::absToolUrl()</strong>, &#273;&#7875; t&#7841;o form v&agrave; t&#7841;o link ch&#7841;y tool.<br />
C&aacute;c url kh&ocirc;ng ch&#7841;y tool d&ugrave;ng h&agrave;m <strong>urlBuild/urlSet</strong> nh&#432; v&#7899;i giao di&#7879;n view',E_USER_ERROR);
	exit();
}
header('X-ESNC-Tool:valid');//prevent code outside function/class

$className = strtr($f,'-','_');//class name must contain _ as file name seperator
$o = new $className;
$o->id = (int)$_REQUEST['@'];
$o->loadonerow();
$fn=$o->fn = $_REQUEST['()'];
$o->file=$f;//override file from database
$o->act=$act;
$o->table = 'tool';
define('URL_UP',URL_CWD.'item-list.php');
define('URL_BACK',URL_UP);
switch(strtolower($fn)){
case 'setup': $o->setup();break;
case 'remove': $o->remove(); break;
case 'about': $o->about();break;
//prevent to directly call pre-defined method
case 'addrow':
case 'save':
case 'cleanup':
case 'updaterow':
case 'loadonerow':
case 'loadrow':
case 'starttoolform':
case 'endtoolform':
case 'maketoolurl':
case 'adjusttoolurl':
	echo 'Kh&ocirc;ng th&#7875; g&#7885;i &#273;&#432;&#7907;c h&agrave;m '.$fn.' tr&#7921;c ti&#7871;p. C&oacute; th&#7875; &#273;ang b&#7883; hack';
	break;
default:
	if(method_exists($o,$fn)) call_user_func(array($o,$fn));
	else{
		$o->markrun();
		$o->run();
	}
}
dbclose();
?>