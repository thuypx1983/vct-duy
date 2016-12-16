<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>User tracing setup</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link href="images/style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
span.label{display:-moz-inline-box;display:inline-block; width:200px; margin:6px 0px 0px 0px;}
</style>
</head>
<body>
Check PDOSQLite:<?php
try{
	$db = new PDO('sqlite:'.PATH_TEMP.'db_log.sqlite',0666);
	echo ' <strong style="color:green">PDOSQLite installed</strong><br/>';
	unset($db);//close
	unlink(PATH_TEMP.'db_log.sqlite');
	$ok=TRUE;
}catch(Exception $EE){
	echo '<strong style="color:red">PDOSQLite is not installed. Setup cannot continue</strong>';
	$ok=FALSE;
}
if($ok){$this->startForm(ACT_SAVE,NULL,'setup')?>
<span class="label">Import external stylesheet file</span>:<input type="text" class="input" size="100" value="<?php echo $this->cfg['STYLE'] ?>" name="cfg[STYLE]" /><br />
<span class="label">Default pagesize</span>:<input type="text" class="input" name="cfg[PZ]" value="<?php echo $this->cfg['PZ'] ?>" /><br />
<a href="<?php echo $this->makeUrl(ACT_DOWNLOAD,NULL,'setup') ?>" class="item">Zip and download database file</a><br />
<a href="<?php echo $this->makeUrl(ACT_REMOVE,NULL,'setup') ?>" class="item">Purge logging database (keep only records since 1 week)</a>
<p>
Please add following for into every page you want to trace<br />
(or you can put into file: <strong>PATH_COMPONENT.commonguest.php</strong> and include into every page)<br />
You can add code to prevent logging of console activities, like:<br/>
<br/><code>if(!isset($_SESSION['ESNCID'])){...}</code><br /><br/>
</p>
<textarea cols="120" rows="15" readonly onclick="this.select();" class="code">
&lt;?php 
try{
$db_log=new PDO(DB_LOG,0777);
$db_log->exec('INSERT INTO log(ip,url,ua,refer,tm,q) VALUES(
\''.$_SERVER['REMOTE_ADDR'].'\',
\''.URL_SELF.'\',
'.$db_log->quote($_SERVER['HTTP_USER_AGENT']).',
'.$db_log->quote(@$_SERVER['HTTP_REFERER']).',
CURRENT_TIME,
'.$db_log->quote(@$_SERVER['QUERY_STRING']).')');
unset($db_log);
}catch(Exception $EE){}
?&gt;</textarea>
<div align="center"><input type="submit" value="Setup" class="button" name="accept" /></div>
<?php $this->endForm()?>
<?php } // if OK?>
</body><script type="text/javascript">
var url_up="<?php echo URL_UP ?>";
var url_back="<?php echo URL_BACK ?>";
function doSave(){
	document.getElementsByName('accept').item(0).value=1;
	document.forms[0].submit();
}
window.top.document.title=self.document.title;
</script>
<script src="js/item-script.js" type="text/javascript"></script>
</html>