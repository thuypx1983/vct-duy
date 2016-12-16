<?php define('MAGIC_QUOTES_OFF',TRUE);
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
require(PATH_CLASS.'session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_JOB)){
	echo "<script language='javascript'>window.top.location='../';</script>";
	exit();
}
require '../config.php';
$metachar=array('"',"\r\n","\r","\n");
$quotechar=array('&quot;',' ',' ',' ');
function input_format($s){
	return str_replace($metachar,$quotechar,$s);
}
require PATH_ADMIN.'inc/dbcon.php';
require PATH_ADMINCOMPLS.'jobitem.php';
$rs = mysql_query($sql='SELECT DATE_FORMAT('.SQL_NOW.',\''.FORMAT_DB_DATETIME.'\')');
$row = mysql_fetch_row($rs);
$NOW=$row[0]; 
if($act == 'save'){
	$jobcount=(int)$_POST['JBcount'];
	$job = new jobitem();
	$id='';
	for($i=0;$i<$jobcount;++$i){
		if($job->id=$_POST['JBid'.$i]){
			$job->scheduled=$_POST['JBscheduled'.$i];
			$job->interval = $_POST['JBinterval'.$i];
			$job->update();
		}
	}
	jobitem::remove(trim($id,','));
	if(($job->scheduled = $_POST['JBscheduled']) && ($job->name = $_POST['JBname'])){//add row
		$job->interval = $_POST['JBinterval'];
		$job->add();
	}
}elseif($act=='reboot'){
	jobitem::reboot();
}elseif($act=='runnow'){
	$JBid=$_GET['JBid'];
	jobitem::setctrl($JBid,JOB_CTRL_RUNOW);
	jobitem::reboot();
	dbclose();
	exit(
'<html><head><base href="'.URL_BASE.'" />'
.'<script src="js/job.php?'.rand().'" language="JavaScript" type="text/javascript"></script>'
.'</head><body style="background:transparent url('.URL_ADMIN.'images/load.gif) no-repeat scroll 200px 13px">'
.'Executing job, please wait.....'
.'</body>'
.'<script language="javascript">window.setTimeout("window.location.href=\''.URL_ROOT.'\'",8000)</script>'
.'</html>'
	);
}elseif($act=='remove'){
	$id='';
	$jobcount=(int)$_POST['JBcount'];
	for($i=0;$i<$jobcount;++$i){
		if($_POST['JBid'.$i]){
			$id .=$_POST['JBid'.$i].',';
		}
	}
	_trace($id);
	jobitem::remove(trim($id,','));
}
$rs=jobitem::search();
?>
<head><title>Qu&#7843;n l&yacute; l&#7883;ch &#273;i&#7873;u &#273;&#7897;</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<style>
	th{font-size:11px;}
	.tab{display:none;}
	.tabactive{display:table-header-group;}
	textarea{width:95%;height:100%;}
	.tabhead{cursor:pointer;font-size:11px;font-weight:normal;color:black;}
	.tabheadactive{cursor:pointer;font-size:11px;font-weight:bold;color:green;}
	tbody.tab input,tbody.tabactive input{width:90%;}
	input.input_r{border:0px none;}
</style>
<link rel="stylesheet" type="text/css" href="images/style.css"/>
</head>
<body class="text">
<form action="<?php echo URL_SELF; ?>?act=save" method="post" enctype="application/x-www-form-urlencoded" onSubmit="return checkForm(this);">
<table  width="700px" border="0" cellspacing="2" cellpadding="2" align="center" class="text">
<thead>
	<tr height="23" style="background-image:url(images/bg-product.gif);"><td colspan="2" align="center">
		<span name="tabhead" class="tabheadactive" onClick="showTab(0,this);">B&#7843;ng &#273;i&#7873;u &#273;&#7897;</span>
<?php if($session->getaccess(SESSION_CTRL_ADMIN,MODULE_JOB,ACCESS_DEVELOPPER)){?>
		<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab(1,this);" id="tabhead_new">Th&ecirc;m m&#7899;i</span>
<?php } ?>
		</td>
	</tr>
</thead>
<tbody id="tab0" class="tabactive" name="tab">
<tr>
	<td colspan="2">
	<table cellpadding="3" cellspacing="3" border="1" style="border-collapse:collapse " width="100%" bordercolor="#A0A0A4">
		<thead>
			<tr>
				<th >S&#7917;a</th>
				<th >ID</th>
				<th >T&ecirc;n</th>
				<th nowrap>Th&#7901;i gian ch&#7841;y</th>
				<th >L&#7863;p l&#7841;i</th>
				<th >Ch&#7841;y</th>
				<th nowrap>L&#7847;n g&#7847;n &#273;&acirc;y</th>
				<th width="20%">L&#7847;n ti&#7871;p theo</th>
				<th >K.qu&#7843;</th>
			</tr>
		</thead>
		<tbody class="text">
		<?php 
		for($i=0;$row=mysql_fetch_assoc($rs);++$i){
		?>
			<tr <?php if(((int)$row['ctrl'] & 1) == 0) echo 'style="color:#CCCCCC"';?>>
				<td><input type="checkbox" value="<?php echo $row['id'] ?>" name="JBid<?php echo $i?>" class="input" onclick="enableEdit(this,<?php echo $i?>);"/></td>
				<td><?php printf(FORMAT_ID_STRING,$row['id']);?></td>
				<td><a class="item" href="<?php echo URL_SELF; ?>?act=runnow&JBid=<?php echo $row['id'] ?>" target="_blank" title="Nh&#7845;n &#273;&#7875; ch&#7841;y ngay job n&agrave;y &#7903; c&#7917;a s&#7893; kh&aacute;c"><?php echo $row['name'] ?></a></td>
				<td nowrap><?php echo $row['firsttime']?></td>
				<td><input name="JBinterval<?php echo $i ?>" value="<?php echo $row['interval'] ?>"  style="width:95%" class="input input_r" readonly="true" /></td>
				<td align="center"><?php echo $row['run'] ?></td>
				<td nowrap><?php echo $row['lastrun'] ?></td>
				<td><input name="JBscheduled<?php echo $i ?>" value="<?php echo $row['scheduled']?>" style="width:95%" class="input input_r" readonly="true" /></td>
				<td><?php echo $row['msg'];?></td>
			</tr>
		<?php }?>
		</tbody>
	</table>
	<input type="hidden" value="<?php echo $i ?>" name="JBcount" />
	</td>
</tr>
</tbody>
<?php if($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){?>
<tbody id="tab1" class="tab" name="tab">
	<tr><td width="50%">T&ecirc;n</td><td><input type="text" name="JBname" value="" class="input" /></td></tr>
	<!--tr><td>L&#7879;nh</td><td><input type="text" name="JBcmd" value="" class="input" /></td></tr-->
	<!--tr><td>Tham s&#7889;</td><td><input type="text" name="JBparam" value="" class="input" /></td></tr-->
	<tr><td>Th&#7901;i gian ch&#7841;y</td><td><input type="text" name="JBscheduled" value="" class="input" /></td></tr>
	<tr><td>L&#7863;p l&#7841;i</td><td><input type="text" name="JBinterval" value="0" class="input" /></td></tr>
	<!--tr><td>Ki&#7875;u</td><td--><input type="hidden" name="JBtype" value="1" class="input" /><!--/td></tr-->
</tbody>
<?php }?>
<tfoot>
	<tr><td colspan="2" align="center"><hr style="color:green;background-color:green;width:80%; " /></td></tr>
	<tr><td colspan="2" style="line-height:20px; "><strong>C&#7847;n l&#432;u &yacute;:</strong><br/>
	L&#7883;ch &#273;i&#7873;u &#273;&#7897; <strong style="color:red; ">ch&#7881; d&agrave;nh cho ng&#432;&#7901;i n&#7855;m r&otilde; v&#7873; h&#7879; th&#7889;ng</strong>.<br/>
	H&atilde;y li&ecirc;n h&#7879; v&#7899;i h&#7879; th&#7889;ng h&#7895; tr&#7907; c&#7911;a <strong style="color:green; ">E<font color=red>S</font>NC.Net</strong> &#273;&#7875; bi&#7871;t ch&#7855;c ch&#7855;n b&#7841;n kh&ocirc;ng l&agrave;m h&#7887;ng h&#7879; th&#7889;ng.<br />
	T&ecirc;n c&ocirc;ng vi&#7879;c nh&#7853;p b&#7857;ng ch&#7919; <strong  style="color:green; ">IN_HOA</strong> <em>kh&ocirc;ng c&oacute; d&#7845;u ti&#7871;ng vi&#7879;t</em>.<br />
	Th&#7901;i gian ch&#7841;y vi&#7871;t theo &#273;&#7883;nh d&#7841;ng (v&iacute; d&#7909; th&#7901;i gian hi&#7879;n t&#7841;i):&nbsp;<strong style="color:green; "><?php echo str_replace('%','',FORMAT_DATETIME).'<span style="font-weight:normal;color:black"> t&#7913;c l&agrave; </span>'.$NOW.'<!--'.strftime(FORMAT_DATETIME).'-->'?></strong><br />
	Kho&#7843;ng th&#7901;i gian l&#7863;p l&#7841;i vi&#7871;t theo d&#7841;ng th&#7913;c ti&#7871;ng anh: <strong style="color:green; ">1 DAY, 2 DAY, 1 MINUTE, 2 MINUTE, 1 HOUR, 2 HOUR</strong>, kh&ocirc;ng c&oacute; s&#7889; nhi&#7873;u<br />
	Th&#7901;i gian l&#7863;p l&#7841;i nh&#7887; nh&#7845;t cho ph&eacute;p l&agrave;:<strong style="color:green; "><?php echo JOB_INTERVAL;?> SECOND</strong><br/>
	Th&#7901;i gian &#273;i&#7873;u &#273;&#7897; ti&#7871;p theo: <strong style="color:green; "><?php
		if(($t=@fileatime(FILE_JOB_CTRL) + JOB_INTERVAL) < time()) echo strftime(FORMAT_DATETIME);
		else echo strftime(FORMAT_DATETIME,$t);
	?></strong>&nbsp;b&#7841;n c&#361;ng c&oacute; th&#7875;&nbsp;<a href="<?php echo URL_SELF ?>?act=reboot" class="item">&#273;i&#7873;u &#273;&#7897; ngay</a><br/>
	&#272;&#7875; <strong>s&#7917;a</strong> m&#7897;t d&ograve;ng, &#273;&aacute;nh d&#7845;u v&agrave;o checkbox s&#7917;a r&#7891;i nh&#7853;p v&agrave;o th&#7901;i gian ch&#7841;y v&agrave; l&#7863;p l&#7841;i<br />
	&#272;&#7875; <strong  style="color:red; ">xo&aacute;</strong> m&#7897;t job, h&atilde;y &#273;&aacute;nh d&#7845;u checkbox v&agrave;o d&ograve;ng r&#7891;i nh&#7845;n n&uacute;t <strong  style="color:red; ">xo&aacute;</strong> tr&ecirc;n thanh c&ocirc;ng c&#7909;<br />
	&#272;&#7875; <strong>ch&#7841;y ngay</strong> m&#7897;t job m&agrave; kh&ocirc;ng &#273;&#7907;i t&#7899;i th&#7901;i gian &#273;i&#7873;u &#273;&#7897; ti&#7871;p theo, nh&#7845;n v&agrave;o t&ecirc;n job &#273;&oacute;<br/>
	Nh&#7919;ng <font color="#CCCCCC">d&ograve;ng m&#7901;</font> l&agrave; nh&#7919;ng d&ograve;ng c&ocirc;ng vi&#7879;c kh&ocirc;ng ch&#7841;y
	</td></tr>
	<tr><td colspan="2" align="center"><hr style="color:green;background-color:green;width:80%; " /></td></tr>
</tfoot>
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
function enableEdit(o,i){
	if(o.checked){
		o.form['JBscheduled'+i].readOnly=o.form['JBinterval'+i].readOnly=false;
		o.form['JBscheduled'+i].className=o.form['JBinterval'+i].className='input';
//		o.form['JBscheduled'+i].style.border=o.form['JBinterval'+i].style.border='1px solid #000000';
	}else{
		o.form['JBscheduled'+i].readOnly=o.form['JBinterval'+i].readOnly=true;
		o.form['JBscheduled'+i].className=o.form['JBinterval'+i].className='input input_r';
//		o.form['JBscheduled'+i].style.border=o.form['JBinterval'+i].style.border='0px none';
	}
}
function doDel(){
<?php if($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){?>
	if(window.top.confirm('Chac chan xoa?')){
		f=document.getElementsByTagName('form').item(0);
		f.action += '&act=remove';
		f.submit();
	}
<?php }?>
}
function doNewItem(){
<?php if($session->getaccess(SESSION_CTRL_ADMIN,MODULE_SYS,ACCESS_DEVELOPPER)){?>
showTab(1,document.getElementById('tabhead_new'));
<?php }?>
}
function doNew(){
	doNewItem();
}
window.top.document.title=self.document.title;

</script>
</html>
<?php dbclose();?>
