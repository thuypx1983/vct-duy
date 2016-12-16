<?php define('MAGIC_QUOTES_OFF',TRUE);
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_PRODUCT,ACCESS_READ|ACCESS_WRITE)){
	echo "<script language='javascript'>window.top.location='../../';</script>";
	exit();
}
require '../config.php';
include_once CURRENCY_FILE;
$metachar=array('"',"\r\n","\r","\n");
$quotechar=array('&quot;',' ',' ',' ');
function input_format($s){
	return str_replace($metachar,$quotechar,$s);
}
if($act == 'save'){
	@asort($_POST['O'],SORT_NUMERIC);
	$metachar = array("\\","'");
	$quotechar = array("\\\\","\\'");
	$tmp_file=PATH_TEMP.getuniquename().'.txt';
	if($fp = @fopen($tmp_file,'w')){
		fwrite($fp,"<?php /*created by currency editor*/
define('CURRENCY_FILE',__FILE__);
if(isset(\$_GET['cy'])) @define('CURRENCY',@(int)\$_GET['cy']);
else	@define('CURRENCY',@(int)\$_COOKIE['cy']);
if(CURRENCY)	\$_GET['cy']=CURRENCY;else unset(\$_GET['cy']);");
		if((int)$_POST['setcurrency'])
			fwrite($fp,"
define('CURRENCY_UNIT','".str_replace($metachar,$quotechar,$_POST['CURRENCY_UNIT'])."');
define('CURRENCY_VALUE',1);
define('CURRENCY_PREFIX','".str_replace($metachar,$quotechar,$_POST['CURRENCY_PREFIX'])."');
define('CURRENCY_THOUSAND_SEPERATOR','".str_replace($metachar,$quotechar,$_POST['CURRENCY_THOUSAND_SEPERATOR'])."');
define('CURRENCY_DECIMAL_SEPERATOR','".str_replace($metachar,$quotechar,$_POST['CURRENCY_DECIMAL_SEPERATOR'])."');
define('CURRENCY_DECIMAL_PLACE',".(int)$_POST['CURRENCY_DECIMAL_PLACE'].");
define('CURRENCY_SUFFIX','".str_replace($metachar,$quotechar,$_POST['CURRENCY_SUFFIX'])."');");
		else
			fwrite($fp,"
define('CURRENCY_UNIT','".str_replace($metachar,$quotechar,CURRENCY_UNIT)."');
define('CURRENCY_VALUE',1);
define('CURRENCY_PREFIX','".str_replace($metachar,$quotechar,CURRENCY_PREFIX)."');
define('CURRENCY_THOUSAND_SEPERATOR','".str_replace($metachar,$quotechar,CURRENCY_THOUSAND_SEPERATOR)."');
define('CURRENCY_DECIMAL_SEPERATOR','".str_replace($metachar,$quotechar,CURRENCY_DECIMAL_SEPERATOR)."');
define('CURRENCY_DECIMAL_PLACE',".(int)CURRENCY_DECIMAL_PLACE.");
define('CURRENCY_SUFFIX','".str_replace($metachar,$quotechar,CURRENCY_SUFFIX)."');");
		fwrite($fp,"
\$ORDER_CURRENCY = array(CURRENCY_UNIT,");
		if(is_array($_POST['O'])){
      foreach($_POST['O'] as $id => $v){
  			$cur=&$_POST['R'][$id];
  			if($cur[6] == '' || ($rate = floatval(currency_unformat($cur[0]))) == 0) continue;//ignore if no name
  			fwrite($fp,"
	'".str_replace($metachar,$quotechar,$cur[6])."',");
		}
  		fwrite($fp,');');
  		fwrite($fp,"
\$CURRENCY = array(
	array(CURRENCY_VALUE,CURRENCY_PREFIX,CURRENCY_THOUSAND_SEPERATOR,CURRENCY_DECIMAL_SEPERATOR,CURRENCY_DECIMAL_PLACE,CURRENCY_SUFFIX),");
  		foreach($_POST['O'] as $id => $v){
  			$cur = &$_POST['R'][$id];
  			if($cur[6] == '' || ($rate = floatval(currency_unformat($cur[0]))) == 0) continue;//ignore if no name
  			if((int)$cur[7]) $flag=',TRUE';else $flag='';
  			fwrite($fp,"
	array(".$rate.",'".str_replace($metachar,$quotechar,$cur[1])."','"
  			.str_replace($metachar,$quotechar,$cur[2])."','"
  			.str_replace($metachar,$quotechar,$cur[3])."',"
  			.(int)$cur[4].",'"
  			.str_replace($metachar,$quotechar,$cur[5])."'"
  			.$flag."),");
  		}
		}
		fwrite($fp,');');
		fwrite($fp,'?'.'>');
		fclose($fp);
		chmod(CURRENCY_FILE,0700);
		if(rename(CURRENCY_FILE,PATH_TEMP.time().'~'.basename(CURRENCY_FILE))){
			rename($tmp_file,CURRENCY_FILE);
			$t=file_get_contents(CURRENCY_FILE);
			include PATH_ADMIN.'inc/dbcon.php';
			$sql='REPLACE INTO `'.DB_TABLE_PREFIX.'fs`(`name`,`content`) VALUES(\'application/currency.php\',\''.mysql_real_escape_string(stripslashes($t)).'\')';
			mysql_query($sql);
			dbclose();
		}
		chmod(CURRENCY_FILE,0500);
	}//if write ok
	redirect(URL_SELF);
	exit();
}
$example = 123456789;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Qu&#7843;n l&yacute; b&#7843;ng &#273;&#417;n v&#7883; ti&#7873;n t&#7879;</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<style>
th{font-size:11px;}
.tab{display:none;}
.tabactive{display:table-header-group;}
textarea{width:95%;height:100%;}
.tabhead{cursor:pointer;font-size:11px;font-weight:normal;color:black;}
.tabheadactive{cursor:pointer;font-size:11px;font-weight:bold;color:green;}
tbody.tab input,tbody.tabactive input{width:90%;}
</style>
<link rel="stylesheet" type="text/css" href="images/style.css"/>
</head>
<body class="text">
<form action="<?php echo URL_SELF;?>?act=save" method="post" enctype="application/x-www-form-urlencoded" onSubmit="return checkForm(this);">
<table  width="700px" border="0" cellspacing="2" cellpadding="2" align="center" class="text">
<thead>
	<tr height="23" style="background-image:url(images/bg-product.gif);"><td colspan="2" align="center">
		<span name="tabhead" class="tabheadactive" onClick="showTab(0,this);">T&#7927; gi&aacute;</span>
		<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab(1,this);">&#272;&#417;n v&#7883; ti&#7873;n t&#7879; c&#417; b&#7843;n</span>
		<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab(2,this);">B&#7843;ng &#273;&#417;n v&#7883; ti&#7873;n t&#7879;</span>
		<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab(3,this);" id="tabhead_new">Th&ecirc;m m&#7899;i</span>
		<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('help',this);">Tr&#7907; gi&uacute;p</span>
		</td>
	</tr>
</thead>
<tbody id="tab0" class="tabactive" name="tab">
	<tr><td colspan="2">
		<table cellpadding="3" cellspacing="3" border="1" style="border-collapse:collapse " width="100%"><thead>
		<tr><th width="30%">T&ecirc;n hi&#7875;n th&#7883;</th>
			<th>T&#7927; gi&aacute; (so v&#7899;i <?php echo CURRENCY_UNIT; ?>, VD:<font color="red"><?php echo number_format($example,4,CURRENCY_DECIMAL_SEPERATOR,CURRENCY_THOUSAND_SEPERATOR);?></font>)</th></tr>
		</thead><tbody class="text">
		<tr><td><?php echo CURRENCY_UNIT; ?></td>
			<td><?php echo CURRENCY_VALUE; ?></td></tr>
<?php 
unset($ORDER_CURRENCY[0]);
foreach($ORDER_CURRENCY as $i => $cname){?>
		<tr><td><?php echo $cname; ?></td>
			<td><input name="R[<?php echo $i ?>][0]" value="<?php echo number_format($CURRENCY[$i][0],4,CURRENCY_DECIMAL_SEPERATOR,CURRENCY_THOUSAND_SEPERATOR);?>" size="10" class="input" type="text"  /></td></tr>
<?php }
++$i;
?>		</tbody></table>
	</td></tr>
</tbody>
<tbody id="tab2" class="tab" name="tab">
<tr><td colspan="2">
	<table cellpadding="3" cellspacing="3" border="1" style="border-collapse:collapse " width="100%"><thead>
		<tr><th width="3%">Th&#7913; t&#7921;</th>
			<th width="20%">T&ecirc;n hi&#7875;n th&#7883;</th>
			<th width="6%">Ti&#7873;n t&#7889;</th>
			<th width="6%">D&#7845;u nh&oacute;m s&#7889;</th>
			<th width="6%">D&#7845;u th&#7853;p ph&acirc;n</th>
			<th >S&#7889; ch&#7919; s&#7889; th&#7853;p ph&acirc;n</th>
			<th >H&#7853;u t&#7889;</th>
			<th >T&#7927; gi&aacute; ngh&#7883;ch<br/> &#273;&#7843;o</th>
			<th width="30%">V&iacute; d&#7909;</th></tr>
		</thead><tbody class="text">
		<tr><td><strong style="color:red ">0</strong></td>
			<td><?php echo CURRENCY_UNIT; ?></td>
			<td><?php echo CURRENCY_PREFIX; ?></td>
			<td><?php echo CURRENCY_THOUSAND_SEPERATOR; ?></td>
			<td><?php echo CURRENCY_DECIMAL_SEPERATOR; ?></td>
			<td><?php echo CURRENCY_DECIMAL_PLACE; ?></td>
			<td><?php echo CURRENCY_SUFFIX; ?></td>
			<td>&nbsp;</td>
			<td><?php echo currency_format($example);?></td>
		</tr>
<?php 
foreach($ORDER_CURRENCY as $i => $cname){?>
		<tr><td><input name="O[<?php echo $i ?>]" value="<?php echo $i ?>" size="3" class="input" type="text" /></td>
			<td><input name="R[<?php echo $i ?>][6]" value="<?php echo input_format($cname); ?>" size="10" class="input" type="text"/> </td>
			<td><input name="R[<?php echo $i ?>][1]" value="<?php echo input_format($CURRENCY[$i][1]); ?>" size="10" class="input" type="text" /></td>
			<td><input name="R[<?php echo $i ?>][2]" value="<?php echo input_format($CURRENCY[$i][2]); ?>" size="10" class="input" type="text" /></td>
			<td><input name="R[<?php echo $i ?>][3]" value="<?php echo input_format($CURRENCY[$i][3]); ?>" size="10" class="input" type="text" /></td>
			<td><input name="R[<?php echo $i ?>][4]" value="<?php echo $CURRENCY[$i][4]; ?>" size="10" class="input" type="text" /></td>
			<td><input name="R[<?php echo $i ?>][5]" value="<?php echo input_format($CURRENCY[$i][5]); ?>" size="10" class="input" type="text" /></td>
			<td><input type="checkbox" value="1" name="R[<?php echo $i ?>][7]" class="input" <?php if(isset($CURRENCY[$i][6])) echo 'checked';  ?>/></td>
			<td><?php echo $CURRENCY[$i][1].number_format($example,$CURRENCY[$i][4],$CURRENCY[$i][3],$CURRENCY[$i][2]). $CURRENCY[$i][5];?></td>
		</tr>
<?php }
++$i;
?>	</tbody></table>
</td></tr>
</tbody>
<tbody class="tab" id="tab3" name="tab">
	<tr><td width="50%">Th&#7913; t&#7921;</td><td><input name="O[<?php echo $i ?>]" value="<?php echo $i+1 ?>" class="input" style="width:40px" type="text"/></td></tr>
	<tr><td>T&ecirc;n hi&#7875;n th&#7883;</td><td><input name="R[<?php echo $i ?>][6]" value="" class="input" type="text"/> </td></tr>
	<tr><td>T&#7927; gi&aacute;(so v&#7899;i <?php echo CURRENCY_UNIT; ?>), VD:<?php echo number_format($example,4,CURRENCY_DECIMAL_SEPERATOR,CURRENCY_THOUSAND_SEPERATOR);?></td><td><input name="R[<?php echo $i ?>][0]" value=""  class="input" type="text" /></td></tr>
	<tr><td>Ti&#7873;n t&#7889; (k&yacute; hi&#7879;u &#273;&#7913;ng tr&#432;&#7899;c)</td><td><input name="R[<?php echo $i ?>][1]" value="" class="input" type="text" /></td></tr>
	<tr><td>D&#7845;u nh&oacute;m (ph&acirc;n t&aacute;ch h&agrave;ng tri&#7879;u, h&agrave;ng ngh&igrave;n)</td><td><input name="R[<?php echo $i ?>][2]" value="" class="input" type="text" /></td></tr>
	<tr><td>K&yacute; hi&#7879;u th&#7853;p ph&acirc;n</td>	<td><input name="R[<?php echo $i ?>][3]" value="" class="input" type="text" /></td></tr>
	<tr><td>S&#7889; ch&#7919; s&#7889; th&#7853;p ph&acirc;n (&#273;&#7897; ch&iacute;nh x&aacute;c)</td><td><input name="R[<?php echo $i ?>][4]" value="" class="input" type="text" /></td></tr>
	<tr><td>H&#7853;u t&#7889; (k&yacute; hi&#7879;u &#273;&#7913;ng sau)</td><td><input name="R[<?php echo $i ?>][5]" value="" class="input" /></td></tr>
	<tr><td>T&#7927; gi&aacute; ngh&#7883;ch &#273;&#7843;o</td><td><input value="1"  name="R[<?php echo $i ?>][7]" value="" class="input" type="checkbox" style="width:20px"/></td></tr>
</tbody>
<tbody id="tab1" class="tab" name="tab">
<tr><td width="50%">T&ecirc;n hi&#7875;n th&#7883;</td><td><input type="text" name="CURRENCY_UNIT" value="<?php echo input_format(CURRENCY_UNIT); ?>" class="input r" /></td></tr>
<tr><td>Gi&aacute; tr&#7883; (so v&#7899;i <?php echo CURRENCY_UNIT; ?>)</td><td><?php echo CURRENCY_VALUE; ?></td></tr>
<tr><td>Ti&#7873;n t&#7889; (k&yacute; hi&#7879;u &#273;&#7913;ng tr&#432;&#7899;c)</td><td><input type="text" name="CURRENCY_PREFIX" value="<?php echo input_format(CURRENCY_PREFIX); ?>" class="input r" /></td></tr>
<tr><td>D&#7845;u nh&oacute;m (ph&acirc;n t&aacute;ch h&agrave;ng tri&#7879;u, h&agrave;ng ngh&igrave;n)</td><td><input type="text" name="CURRENCY_THOUSAND_SEPERATOR" value="<?php echo input_format(CURRENCY_THOUSAND_SEPERATOR); ?>" class="input r" /></td></tr>
<tr><td>K&yacute; hi&#7879;u th&#7853;p ph&acirc;n</td><td><input type="text" name="CURRENCY_DECIMAL_SEPERATOR" value="<?php echo input_format(CURRENCY_DECIMAL_SEPERATOR); ?>" class="input r" /></td></tr>
<tr><td>S&#7889; ch&#7919; s&#7889; th&#7853;p ph&acirc;n (&#273;&#7897; ch&iacute;nh x&aacute;c)</td><td><input type="text" name="CURRENCY_DECIMAL_PLACE" value="<?php echo CURRENCY_DECIMAL_PLACE; ?>" class="input r" /></td></tr>
<tr><td>H&#7853;u t&#7889; (k&yacute; hi&#7879;u &#273;&#7913;ng sau)</td><td><input type="text" name="CURRENCY_SUFFIX" value="<?php echo input_format(CURRENCY_SUFFIX); ?>" class="input r" /></td></tr>
<tr><td>V&iacute; d&#7909; hi&#7875;n th&#7883;</td><td><?php echo currency_format($example);; ?></td></tr>
<tr><td>Thay &#273;&#7893;i &#273;&#417;n v&#7883; ti&#7873;n t&#7879; c&#417; b&#7843;n ?</td><td align="left"><input type="checkbox" name="setcurrency" value="1" onClick="remind(this);" class="input" style="width:auto; " /></td></tr>
</tbody>
<tbody class="tab" id="tabhelp">
<tr><td colspan="2" style="line-height:20px; "><strong>C&aacute;c l&#432;u &yacute;:</strong><br />
&#272;&#417;n v&#7883; ti&#7873;n t&#7879; c&oacute;  t&#7927; gi&aacute; l&agrave; 1 l&agrave; &#273;&#417;n v&#7883; c&#417; b&#7843;n v&agrave; lu&ocirc;n lu&ocirc;n &#273;&#432;&#7907;c x&#7871;p &#273;&#7847;u ti&ecirc;n (kh&ocirc;ng th&#7875; thay &#273;&#7893;i th&#7913; t&#7921; c&#7911;a &#273;&#417;n v&#7883; ti&#7873;n t&#7879; c&#417; b&#7843;n). <br />
Khi nh&#7853;p gi&aacute; s&#7843;n ph&#7849;m v&agrave; nh&#7853;p t&#7927; gi&aacute;, <strong style="color:green ">E<font color="red">S</font>NC.Net</strong> ch&#7881; cho ph&eacute;p nh&#7853;p gi&aacute; theo &#273;&#417;n v&#7883; c&#417; b&#7843;n tr&ecirc;n.
C&aacute;c &#273;&#417;n v&#7883; ti&#7873;n t&#7879; kh&aacute;c &#273;&#432;&#7907;c quy &#273;&#7893;i theo t&#7927; gi&aacute; so v&#7899;i &#273;&#417;n v&#7883; ti&#7873;n t&#7879; c&#417; b&#7843;n. <br />
N&#7871;u b&#7841;n thay &#273;&#7893;i &#273;&#417;n v&#7883; ti&#7873;n t&#7879; c&#417; b&#7843;n, b&#7841;n ph&#7843;i t&#7921; c&#7853;p nh&#7853;t l&#7841;i b&#7843;ng gi&aacute; c&#7911;a c&aacute;c s&#7843;n ph&#7849;m &#273;&atilde; nh&#7853;p, <strong style="color:green ">E<font color="red">S</font>NC.Net</strong> kh&ocirc;ng t&#7921; c&#7853;p nh&#7853;t l&#7841;i gi&aacute; c&#7911;a c&aacute;c s&#7843;n ph&#7849;m &#273;&atilde; nh&#7853;p theo &#273;&#417;n v&#7883; m&#7899;i. Thay &#273;&#7893;i ch&#7881; c&oacute; t&aacute;c &#273;&#7897;ng t&#7899;i c&aacute;c s&#7843;n ph&#7849;m s&#7855;p t&#7841;o.<br/>
&#272;&#7875; <strong>xo&aacute; (th&ocirc;i kh&ocirc;ng d&ugrave;ng)</strong> m&#7897;t &#273;&#417;n v&#7883; ti&#7873;n t&#7879; n&agrave;o &#273;&oacute;, b&#7841;n xo&aacute; to&agrave;n b&#7897; d&ograve;ng &#273;&oacute;.<br>
<strong>Gi&#7843;i th&iacute;ch t&#7927; gi&aacute; ngh&#7883;ch &#273;&#7843;o:</strong><br />
Khi vi&#7871;t: t&#7927; gi&aacute; USD so v&#7899;i VND l&agrave; 16200 ngh&#297;a l&agrave; <strong>1USD= 16200VND</strong>. khi &#273;&oacute; t&#7927; gi&aacute; &#273;&#7843;o l&agrave; <strong>1VND=1/16200USD.(0.0000617283USD)</strong><br />
N&#7871;u &#273;&#417;n v&#7883; ti&#7873;n t&#7879; ng&#7847;m &#273;&#7883;nh c&#7911;a b&#7841;n l&agrave; USD th&igrave; b&#7841;n ph&#7843;i t&iacute;nh ng&#432;&#7907;c t&#7845;t c&#7843;  ph&eacute;p t&iacute;nh &#273;&#7875; quy &#273;&#7893;i ng&#432;&#7907;c t&#7915; VND sang USD v&agrave; v&#7899;i gi&aacute; tr&#7883; nh&#7887; nh&#432; v&#7853;y th&igrave; sai s&#7889; l&agrave;m tr&ograve;n v&agrave; c&ocirc;ng s&#7913;c b&#7887; ra s&#7869; r&#7845;t l&#7899;n. &#272;&#7875; tr&aacute;nh t&igrave;nh hu&#7889;ng nh&#432; v&#7853;y, b&#7841;n nh&#7853;p s&#7889; 16200 v&agrave;o &ocirc; t&#7927; gi&aacute; r&#7891;i ch&#7885;n ch&#7871; &#273;&#7897; t&#7927; gi&aacute; ngh&#7883;ch &#273;&#7843;o, <strong style="color:green ">E<font color="red">S</font>NC.Net</strong> s&#7869; hi&#7875;u v&agrave; t&iacute;nh gi&uacute;p b&#7841;n theo ngh&#297;a ng&#432;&#7907;c l&#7841;i.
</td></tr>
</tbody>
</table>
</form>
</body>
<script language="javascript">
function htmlencode(o){
	var s,ss,i,n;
	s=String(o.value);
	ss="";
	n=s.length;
	for(i=0;i<n;++i){
 		if((code=Number(s.charCodeAt(i))) > 128)
			ss += "&#" + code + ";";
		else{
			switch(c = s.charAt(i)){
			default:		 ss += c;
			}
		}
	}
	o.value=ss;
}
function checkForm(f){
	var i,n;
	n = f.elements.length;
	document.body.style.visibility='hidden';
	for(i=0;i<n;++i){
		htmlencode(f.elements[i]);
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
	self.location.href='<?php echo URL_CWD ?>index.php';
}
var MAX_ADD_CONSTANT = <?php echo MAX_ADD_CONSTANT; ?>;
function forceValue(o){
	if(o.value == '1'){
		/\[(\d+)\]/.exec(o.name);
		var name='R[' + RegExp.$1 + '][0]';
		o.form[name].value = 1;
	}
}
function forceOrder(o){
	if(o.value == '1'){
		/\[(\d+)\]/.exec(o.name);
		var name='O[' + RegExp.$1 + ']';
		o.form[name].value = 1;
	}
}
function remind(o){
	if(o.checked)
		if(window.confirm('Luu y:\nBan can doc ky cac chu thich ben duoi truoc khi quyet dinh thay doi don vi tien te co ban!!\nBan phai tu cap nhat lai gia cac san pham da nhap tu don vi cu sang don vi moi\nBan co chac chan khong?')) return;
	o.checked = false;
}
function doNewItem(){
	showTab(3,document.getElementById('tabhead_new'));
}
window.top.document.title=self.document.title;
</script>
</html>
