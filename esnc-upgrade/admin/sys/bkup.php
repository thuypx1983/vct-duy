<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_BACKUP|ACCESS_RESTORE)){
	echo "<script language='javascript'>window.top.location='../';</script>";
	exit();
}
define('MAGIC_QUOTES_OFF',TRUE);
require('../config.php');
require('../inc/dbcon.php');
switch ($act){
	case "download":
		if(isset($_GET['file']))$file= (string)$_GET['file'];
		else $file="all";
		$path_backup=PATH_BACKUP;
		header('Content-Type:application/octet-stream');
		header('Content-Length:'.filesize($path_backup.$file.'.dat').'\'');
		header('Content-Disposition:attachment;filename="'.$file.'.dat"');
		if($file!='all'){
			readfile($path_backup.$file.'.dat');
		}else{
			echo 'you cannot download all file in one times!please try again';
		}
		return;
	default:
		$title="Sao l&#432;u d&#7919; li&#7879;u";	
}
set_time_limit(3600);
$db_name = DB_NAME;
$db_host = DB_HOST;
$db_user = DB_USER;
$db_pwd = DB_PWD;
$db_table_prefix = DB_TABLE_PREFIX;
$path_backup = PATH_BACKUP;
$table=array();
for($i=0;$i<2;$i++){$table[$i]=array();}
define('TEXT_0','&#272;&#7891;ng &yacute;');
define('TEXT_1','Sao l&#432;u');
define('TEXT_2','K&#7871;t th&uacute;c');
define('TEXT_STOP','D&#7915;ng l&#7841;i');
define('TEXT_CONTINUTE','Ti&#7871;p t&#7909;c');
define('TEXT_DOWNLOAD','download');

function getIndexBackup($f){
	global $table,$db_table_prefix;
	if(is_file($f)){
		$s = trim(file_get_contents($f),',');
		$table[0] = explode(',',$s);
		for($i=0;$i<count($table[0]);$i++){
			$sql='SELECT * FROM `'.$db_table_prefix.$table[0][$i];
			$rs=mysql_query($sql);
			$table[1][$i]=(int)mysql_num_rows($rs);
		}
		mysql_free_result($rs);
		return true;
	}else{
		$table[0]=array('catnews','catutility','catbanner','catproduct','order','poll','news','job','fs','product','utility','user','report','access','quote','setting','feedback','banner','counter','city','country','agent','faq','customer','email','catproductproduct','catnewsnews','productphoto','catbannerbanner','vote','orderhistory','newslink','objectlink','feature','productlink','catutilityutility','orderdetail','objectfeature');
		for($i=0;$i<count($table[0]);$i++){
			$sql='SELECT * FROM `'.$db_table_prefix.$table[0][$i];
			$rs=mysql_query($sql);
			$table[1][$i]=(int)mysql_num_rows($rs);
		}
		mysql_free_result($rs);
		return false;
	}
}

?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head><title><?php echo $title;?></title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link href="images/style.css" rel="stylesheet" type="text/css"/>
<style type="text/css" media="all">
BODY,TD,INPUT,BUTTON{font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;margin:5 0 5 0;}
DIV#start{text-align:center;}
TABLE.table{border-collapse:collapse;border-color:#111111;width:400px;}
DIV#step0{text-align:center;}
.chan{background-color:#f2f1eb;height:25px;}
.le{height:25px;}
A.download{font-size:11px;color:#0000FF;}
INPUT.input_small{width:30px;}
</style>
</head>
<body>
<script language="javascript" src="js/library.js"></script>
<form name="form1" action="" method="post" enctype="multipart/form-data" >
<?php 
if($_POST['step0']!=''){?>
 <div id="step0">
  <div align="center">
    <?php
	$table_name=array();
	if(isset($_POST['check'])){
		$table_name=$_POST['check'];
	}
	$datebackup = $_POST['datebackup'];
	$interval = $_POST['interval'];
	$file_label=$_POST['file_label'];
	if(isset($_POST['tbi'])) $tbi=$_POST['tbi']; else $tbi=0;
	$smode = 'ab';
	if($table_name[$tbi]){
		$fh = fopen($path_backup.sprintf('%08u_%s_%s_%s.dat',$tbi,$file_label,$table_name[$tbi],$datebackup),$smode);
		$char = array("\r","\n","\0x1A");
		$quotechar = array('\\r','\\n','\\0x26');
		$sql='SHOW COLUMNS FROM `'.$db_table_prefix.$table_name[$tbi].'` FROM '.$db_name;
		$rs = mysql_query($sql);
		$sql = 'SELECT CONCAT_WS(\',\'';
		$field='';
		while($row=mysql_fetch_row($rs)){
			$sql .=',quote(`'.$row[0].'`)';
			$field .=','.$row[0];
		}
		mysql_free_result($rs);
		fwrite($fh,'table:'.$table_name[$tbi].':'.ltrim($field,',')."\r\n");
		$sql .= ') as t FROM `'.$db_table_prefix.$table_name[$tbi].'`';
		$rs = mysql_query($sql);
		while($row=mysql_fetch_row($rs)){
			fwrite($fh,'(');
			fwrite($fh,str_replace($char,$quotechar,$row[0]));
			fwrite($fh,")\r\n");
		}
		mysql_free_result($rs);
		$tbi++;
		fclose($fh);
	}?>
	<table>
		<tr><td>Ti&#7871;n tr&igrave;nh th&#7921;c hi&#7879;n</td><td>&nbsp;</td></tr>
		<tr><td>Th&#432; m&#7909;c l&#432;u k&#7871;t qu&#7843;</td><td><?php echo $path_backup;?></td></tr>		
		<tr><td>T&#7921; &#273;&#7897;ng refresh sau</td><td><input type="text" name="interval" class="input_small" value="<?php echo $interval; ?>"/></td></tr>
		<tr><td align="center" colspan="2"><input type="button" class="button" value="<?php echo TEXT_STOP;?>" onClick="OnStop();" />
		<input type="submit" name="<?php echo ($tbi<count($table_name))? 'step0':'';?>" class="button" value="<?php echo TEXT_CONTINUTE;?>" onClick="OnResume();" /></td></tr>
	</table>
	<table cellpadding="1" cellspacing="1" class="table" border="1px">
	<col width="50px"><col width=""><col width="100px">
		<th align="center">TT</th><th align="left">T&ecirc;n b&#7843;ng</th><th><a href="ftp://<?php echo $_SERVER['HTTP_HOST']; ?>" class="download">download</a></th>
		<?php for($i=0;$i<(count($table_name));$i++){?>
		<tr class="<?php echo (($i%2)==0)? 'chan':'le';?>">
			<td align="center"><?php echo $i;?></td>
			<td><?php echo $table_name[$i];?></td>
			<td align="center"><?php echo ($i<$tbi)? '<a href="'.URL_SELF.'?act=download&file='.sprintf('%08u_%s_%s_%s',$i,$file_label,$table_name[$i],$datebackup).'" class="download">'.TEXT_DOWNLOAD.'</a>':'&nbsp;';?></td>
		</tr>
		<?php }?>
	</table>
	<input type="hidden" name="tbi" value="<?php echo $tbi; ?>" />
	<input type="hidden" name="step0" value="1" />
	<input type="hidden" name="file_label" value="<?php echo $file_label; ?>" />		
	<input type="hidden" id="datebackup" name="datebackup" value="<?php echo $datebackup; ?>"/>	
		<?php for($i=0;$i<count($table_name);$i++){?>
	<input type="hidden" name="check[<?php echo $i;?>]" value="<?php echo $table_name[$i] ?>" />
		<?php }?>
	<?php if($tbi==count($table_name)){?>	
	<script language="javascript" type="text/javascript" >
		var startdiv = document.getElementById('start');
		startdiv.style.display = "none";
	</script>
	Qu&aacute; tr&igrave;nh sao l&#432;u &#273;&atilde; ho&agrave;n th&agrave;nh<br/>
	&#272;&#7875; download file k&#7871;t qu&#7843; <a href="ftp://<?php echo $_SERVER['HTTP_HOST']; ?>" class="download" >&#7845;n v&agrave;o &#273;&acirc;y</a>
	<?php }else{?>
	<script language="javascript" type="text/javascript" >
	<?php if($interval>=5){?>
		window.setTimeout("submitForm()",<?php echo $interval;?>*1000);
	<?php }?>
	</script>
	<?php }	?>
</div></div>	
<?php 
}/*end step0*/
else{?>
<div id="start"><div align="center">
	<?php if(!getIndexBackup($path_backup.'config.txt')){?>
	<p style="color:red;">S&#7917; d&#7909;ng c&#7845;u h&igrave;nh m&#7863;c &#273;&#7883;nh</p><br/>
	<?php } ?>
	<table>
		<tr><td>&#272;&#7883;a ch&#7881; m&aacute;y ch&#7911;&nbsp;</td><td><?php echo $db_host;?></td></tr>
		<tr><td>T&ecirc;n c&#417; s&#7903; d&#7919; li&#7879;u:&nbsp;</td><td><?php echo $db_name;?></td></tr>
		<tr><td>User:&nbsp;</td><td><?php echo $db_user;?></td></tr>
		<tr><td>Ti&#7873;n t&#7889; b&#7843;ng:&nbsp;</td><td><?php echo $db_table_prefix;?></td></tr>
		<tr><td>Nh&atilde;n t&#7853;p tin:&nbsp;</td><td><input name="file_label" type="text" class=""/></td></tr>		
		<tr><td>T&#7921; &#273;&#7897;ng refresh sau:&nbsp;</td><td><input type="text" name="interval" class="input_small" value="5"/></td></tr>
		<tr><td>Th&#432; m&#7909;c l&#432;u k&#7871;t qu&#7843;:&nbsp;</td><td><?php echo $path_backup;?></td></tr>
	</table>
	<input type="submit" name="step0" value="<?php echo TEXT_1;?>" class="button" />	
	<table cellpadding="1" cellspacing="1" class="table" border="1px">
	<col width="30px"><col width="50px"><col width=""><col width="90px">
	<th><input id="all" onClick="setAll('check[]',this.checked);" type="checkbox" checked></th>
	<th align="center">TT</th><th align="left">T&ecirc;n b&#7843;ng</th>
	<th>S&#7889; record</th>
	<?php for($i=0;$i<count($table[0]);$i++){?>
		<tr class="<?php echo (($i%2)==0)? 'chan':'le';?>">
			<td align="center"><input name="check[]" value="<?php echo $table[0][$i];?>" type="checkbox" checked></td>
			<td align="center"><?php echo $i; ?></td>
			<td><?php echo $db_table_prefix.$table[0][$i]; ?></td>
			<td align="center"><?php echo $table[1][$i];?></td>
		</tr>
	<?php } ?>
	</table>
	<input type="hidden" id="datebackup" name="datebackup" value="test1"/>
	<input type="submit" name="step0" value="<?php echo TEXT_1;?>" class="button" />	
</div></div>
<script language="javascript" type="text/javascript" defer>
	var now = new Date();
	var datebackup = document.getElementById('datebackup');
	datebackup.value=(now.getDate()+"_"+now.getMonth()+"_"+now.getYear());
</script>
<?php
}
?>
<script language="javascript" type="text/javascript" defer>
	var f=document.getElementsByTagName('form').item(0);
	var checksubmit = true;
function OnStop(){
	checksubmit = false;
}
function OnResume(){
	checksubmit = true;
}
function submitForm(){
	if(checksubmit)f.submit();
}
window.top.document.title=self.document.title;
</script>
</form>
</body>
</html>
<?php dbclose();
?>