<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	echo "<script language='javascript'>window.top.location='../';</script>";
	exit();
}
define('MAGIC_QUOTES_OFF',TRUE);
require '../config.php';
define('FILE_ALERT_TEXT',PATH_APPLICATION.'lang.js');
if($act == 'save'){
	$metachar = array("\\","'","\r\n","\n");
	$quotechar = array("\\\\","\\'","\\n","\\n");
	$tmp_file=PATH_TEMP.getuniquename().'.txt';//write to temporary file first;
	if($fp = fopen($tmp_file,'w')){
		fwrite($fp,"/*created by alert language editor*/
");
		foreach($_POST['C'] as $name=>$value){
			if($value != ''){
				if(is_numeric($value))
					fwrite($fp,"
var {$name} = ".$value.';');
				else
					fwrite($fp,"
var {$name} = '".str_replace($metachar,$quotechar,stripslashes($value))."';");
			}
		}
		if(isset($_POST['MC'])){
			foreach($_POST['MC'] as $id=>$name){
				if(preg_match('/^[A-Z][A-Z0-9_]+$/',$name))
					if(($value=$_POST['MV'][$id]) != '')
						fwrite($fp,"
var {$name}='".str_replace($metachar,$quotechar,stripslashes($value))."';");
			}
		}
		fclose($fp);
		chmod(FILE_ALERT_TEXT,0700);
		if(rename(FILE_ALERT_TEXT,PATH_TEMP.time().'~'.basename(FILE_ALERT_TEXT))){
			rename($tmp_file,FILE_ALERT_TEXT);
			$t = file_get_contents(FILE_ALERT_TEXT);
			include PATH_ADMIN.'inc/dbcon.php';
			$sql = 'REPLACE INTO `'.DB_TABLE_PREFIX.'fs`(`name`,`content`) VALUES (\'application/lang.js\',\''.mysql_real_escape_string(stripslashes($t)).'\')';
			mysql_query($sql);
			dbclose();
		}
		chmod(FILE_ALERT_TEXT,'0500');
	}
	redirect(URL_SELF);
	exit();
}
define('MAX_ADD_CONSTANT',12);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Thay &#273;&#7893;i c&aacute;c th&ocirc;ng b&aacute;o tr&ecirc;n tr&igrave;nh duy&#7879;t</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<style>
th{font-size:11px;}
.tab{display:none;}
.tabactive{display:table-header-group;}
textarea{width:95%;height:100%;}
.tabhead{cursor:pointer;font-size:11px;font-weight:normal;color:black;}
.tabheadactive{cursor:pointer;font-size:11px;font-weight:bold;color:green;}
TEXTAREA.input{height:20px;}
</style>
<link rel="stylesheet" type="text/css" href="images/style.css"/>
</head>
<body class="text">
<form action="<?php echo URL_SELF; ?>?act=save" method="post" enctype="multipart/form-data" onSubmit="return checkForm(this);">
<table  width="700px" border="0" cellspacing="2" cellpadding="2" align="center" >
<thead>
	<tr height="23" style="background-image:url(images/bg-product.gif);"><td colspan="2" align="center">
		<span name="tabhead" class="tabheadactive" onClick="showTab(0,this);">T&#7915; ng&#7919;</span>
		<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab(2,this);">Kh&aacute;c</span>
		<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab(3,this);" id="tabhead_new">Th&ecirc;m m&#7899;i</span></td>
	</tr>
	<tr>
		<th width="10%">T&#7915; vi&#7871;t t&#7855;t</th>
		<th >Gi&aacute; tr&#7883; &#273;&#7847;y &#273;&#7911;</th>
	</tr>
</thead>
<?php 
$stext = '<tbody id="tab0" class="tabactive" name="tab">';
$smisc = '<tbody id="tab2" class="tab"  name="tab">';
$fp = fopen(FILE_ALERT_TEXT,'r');
$s = fgets($fp);//process exceptional first line with BOM character
$s = substr($s,strpos($s,'var'));
if(preg_match('/^\s*var\s+([A-Z0-9_]+)\s*\=/',$s,$m)){
	$c=$m[1];
	$ss ='<tr><td class="text" style="font-weight:bold" nowrap>'.$c.'</td><td><textarea class="input" name="C['.$c.']" onFocus="this.select();" ></textarea></td></tr>';
	if(strpos($c,'T_') === 0 || strpos($c,'_') === 0) $stext .=  $ss;
	else $smisc .= $ss;
}
for($j=0;$j < 1000 && !feof($fp);++$j){
	$s = fgets($fp); 
	if(preg_match('/^\s*var\s+([A-Z0-9_]+)\s*\=/',$s,$m)){
		$c=$m[1];
		$ss ='<tr><td class="text" style="font-weight:bold" nowrap>'.$c.'</td><td><textarea class="input" name="C['.$c.']" onFocus="this.select();" ></textarea></td></tr>';
		if(strpos($c,'T_') === 0 || strpos($c,'_') === 0) $stext .=  $ss;
		else $smisc .= $ss;
	}
}
fclose($fp);
echo $stext;echo '</tbody>';
echo $smisc;echo '</tbody>';
unset($stext,$smisc);
?>
<tbody id="tab3" class="tab" name="tab">
<tr>
<td colspan="2" class="text">Th&ecirc;m  m&#7899;i (t&#7915; vi&#7871;t t&#7855;t ch&#7881; ch&#7845;p nh&#7853;n <strong style="color:red ">CH&#7918; IN HOA [A-Z]</strong> v&agrave; d&#7845;u g&#7841;ch d&#432;&#7899;i <strong style="color:red ">_</strong>) </td>
<?php for($i=0;$i < MAX_ADD_CONSTANT;++$i){?>
<tr>
	<td><input class="input" type="text" name="MC[<?php echo $i ?>]" value="" onFocus="this.select();"/></td>
	<td colspan="2"><textarea class="input" name="MV[<?php echo $i ?>]"  onFocus="this.select();"></textarea></td>
</tr>
<?php }?>
</tbody>
</table>
</form>
</body>
<script language="javascript" src="<?php echo URL_APPLICATION ?>lang.js?rnd=<?php echo time() ?>" type="text/javascript"></script>
<script language="javascript" defer>
function checkForm(f){
	var i,n;
	n = f.elements.length;
	for(i=0;i<MAX_ADD_CONSTANT;++i){
		mc = document.getElementsByName('MC[' + i + ']').item(0);
			if(mc.value != ''){
				if(!/^[A-Z][A-Z0-9_]+$/.test(mc.value)){
					doNewItem();//display tab new
					parent.banner.setStatus('T&#7915; vi&#7871;t t&#7855;t kh&ocirc;ng h&#7907;p l&#7879;');
					mc.select();
					mc.focus();
					return false;
				}
			}else{
				mc.disabled = true;//prevent submit
				document.getElementsByName('MV[' + i + ']').item(0).disabled = true;
			}
	}
	return true;
}
function showTab(id,o){
	a = document.getElementsByTagName('tbody');
	n = a.length;
	for(i=0;i < n; ++i){
		if(a.item(i).className == 'tabactive'){
			a.item(i).className='tab';
//			a.item(i).style.display='none';
		}
	}
	document.getElementById('tab' + id).className='tabactive';
//	document.getElementById('tab' + id).style.display='table-header-group';
	a = document.getElementsByTagName('span');
	n = a.length;
	for(i=0;i < n; ++i){
		if(a.item(i).className == 'tabheadactive') {
			a.item(i).className = 'tabhead';
		}
	}
	o.className='tabheadactive';
}
function doSave(){
	if(checkForm(f=document.getElementsByTagName('form').item(0))) f.submit();
}
function doUp(){
	self.location.href = '<?php echo URL_CWD ?>index.php';
}
function doNewItem(){
	showTab(3,document.getElementById('tabhead_new'));
}
var MAX_ADD_CONSTANT = <?php echo MAX_ADD_CONSTANT; ?>;
window.top.document.title=self.document.title;
//now set the value of all textareas
var a = document.getElementsByTagName('textarea');
var n = a.length,r;
for(i=0;i<n;++i)
	if(r = a.item(i).name.match(/^C\[(\w+)\]$/))
		try{a.item(i).value = eval(RegExp.$1);}catch(EE){}
</script>
</html>
