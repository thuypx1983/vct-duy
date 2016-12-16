<?php require('../config.php');
require('./inc/common.php');
require('./inc/session.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	echo "<script language='javascript'>window.top.location='../';</script>";
	exit();
}
require './config.php';
require('./inc/dbcon.php');
if($DB_R_NAME){
	dbclose();
	r_open($DB_R_HOST,$DB_R_USER_ADMIN,$DB_R_PWD_ADMIN,$DB_R_NAME);//open remote
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<title>Th&ocirc;ng tin t&agrave;i kho&#7843;n, m&#7853;t kh&#7849;u</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css">
<script language="javascript" src="js/library.js" type="text/javascript"></script>
<script language="javascript" src="js.php" type="text/javascript"></script>
<style>
td{padding:1px 4px 1px 0px;}
th{font-size:11px;}
.tab{display:none;}
.tabactive{display:table-header-group;line-height:20px;}
textarea{width:95%;height:100%;}
.tabhead{cursor:pointer;font-size:11px;font-weight:normal;color:black;}
.tabheadactive{cursor:pointer;font-size:11px;font-weight:bold;color:green;}
</style>
</head>
<body style="margin:0px 0px 0px 10px">
<table  width="700px" border="0" cellspacing="2" cellpadding="2" align="center" >
<thead>
	<tr height="23px" style="background-image:url(images/bg-product.gif);"><td align="center">
	<span name="tabhead" class="tabheadactive" onClick="showTab('account',this);">Th&ocirc;ng tin c&aacute; nh&acirc;n</span>
	<strong> | </strong>
	<span id="tabheadpwd" class="tabhead" onClick="showTab('pwd',this);">&#272;&#7893;i m&#7853;t kh&#7849;u</span>
	</td>
	</tr>
</thead>
<tbody class="tab" id="tabpwd"><tr><td>
<form action="<?php echo URL_SELF; ?>?act=<?php echo ACT_PASSWD ?>" method="post" onSubmit="return checkForm(this);">
<table  cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td class="text" >&nbsp;&nbsp;&nbsp;M&#7853;t kh&#7849;u &#273;ang d&ugrave;ng</td><td><input type="password" size="20" class="input" name="ADpassword" /></td></tr>
<tr><td class="text">&nbsp;&nbsp;&nbsp;M&#7853;t kh&#7849;u m&#7899;i</td><td><input type="password" size="20" class="input" name="ADnewpassword" /></td></tr>
<tr><td class="text">&nbsp;&nbsp;&nbsp;Nh&#7853;p l&#7841;i m&#7853;t kh&#7849;u m&#7899;i</td><td><input type="password" size="20" class="input" name="ADnewpassword2" /></td></tr>
<tr><td>&nbsp;</td><td ><input type="submit" value="&#272;&#7893;i m&#7853;t kh&#7849;u" class="button" /></td></tr>
</table>
</form>
</td></tr></tbody>
<?php require('../class/user.php');
class item extends user{
	function process(){
		switch($this->act){
		case ACT_SAVE:
			$this->name=(string)$_POST['name'];
			$this->gender=(int)@array_sum($_POST['gender']);
			$this->birthday=$_POST['birthday'];
			$this->address=(string)$_POST['address'];
			$this->cityid=(string)$_POST['cityid'];
			$this->city=(string)$_POST['city'];
			$this->phone=(string)$_POST['phone'];
			$this->mobile=(string)$_POST['mobile'];
			$this->alert=(int)@array_sum($_POST['alert']);
		$sql = "UPDATE `".DB_TABLE_PREFIX."user` SET"
			." `Name`='".mysql_escape_string($this->name)."'"
			.",`Gender`=".(int)$this->gender	
			.",`Birthday`='".mysql_format_date($this->birthday)."'"
			.",`Address`='".mysql_escape_string($this->address)."'"
			.",`CityID`='".mysql_escape_string($this->cityid)."'"
			.",`City`='".mysql_escape_string($this->city)."'"
			.",`Phone`='".mysql_escape_string($this->phone)."'"
			.",`Mobile`='".mysql_escape_string($this->mobile)."'"
			.",`Alert`=".(int)$this->alert	
			.",`LastUpdate`=".SQL_NOW
			." WHERE `id` = {$this->id}";
			if(mysql_query($sql)){?>
<script language="javascript" type="text/javascript" defer>
parent.banner.setStatus("C&#7853;p nh&#7853;t th&ocirc;ng tin th&agrave;nh c&ocirc;ng");
</script>			
<?php			}else{?>
<script language="javascript" type="text/javascript" defer>
parent.banner.setStatus("L&#7895;i khi c&#7853;p nh&#7853;t");
</script>			
<?php	}
	
		default:
		$this->show();
		}
	}
	function show(){
		global $session;
		$this->loadonerow();
?>
<tbody class="tabactive" id="tabaccount"><tr><td>
<form action="<?php echo URL_SELF; ?>?act=<?php echo ACT_SAVE ?>" method="post" onSubmit="return checkForm2(this);" id="idfrmItem">
<table cellpadding="0" cellspacing="0" border=0 align="center" width="650px">
<tr><td class="text">T&ecirc;n &#273;&#259;ng nh&#7853;p/Email</td><td class="text"><?php echo $this->email ?></td></tr>
<tr><td class="text" >T&ecirc;n &#273;&#7847;y &#273;&#7911;</td><td><input type="text" class="input" name="name" style="width:70%" value="<?php echo $this->name ?>"/></td></tr>
<tr><td class="text">&#272;&#7883;a ch&#7881;</td><td><textarea name="address" class="input" style="width:70%;height:100% "><?php echo $this->address ?></textarea></td><tr>
<tr><td class="text">T&#7881;nh, th&agrave;nh ph&#7889;</td><td class="text"><input type="text" name="city" value="<?php echo $this->city ?>" class="input" class="text" style="width:30%" /> <input type="text" style="width:20% " name="cityid" class="text" value="<?php echo $this->cityid ?>"/>  <select class="input" onChange="this.form.cityid.value=this.value;this.form.city.value = this.options[this.selectedIndex].text;"><option value="<?php echo $this->cityid ?>" selected><?php echo $this->city ?></option><?php readfile(PATH_APPLICATION.'citycodes.htm');?></select></td><tr>
<tr><td class="text">&#272;i&#7879;n tho&#7841;i</td><td class="text"><input type="text" class="input" value="<?php echo $this->phone ?>" name="phone" />  S&#7889; di &#273;&#7897;ng <input type="text" name="mobile" value="<?php echo $this->mobile ?>" class="input" /></td><tr>
<tr><td class="text">Ng&agrave;y sinh</td><td class="text"><input type="text" name="birthday" value="<?php echo $this->birthday ?>" class="input" /> (vd: 31-12-1978)</td><tr>
<tr><td class="text">Gi&#7899;i t&iacute;nh</td><td class="text"><input name="gender[]" type="checkbox" value="1" <?php if ($this->gender & 1) echo 'checked';?> class="input" />Nam <input name="gender[]" type="checkbox" value="2" <?php if ($this->gender & 2) echo 'checked';?> class="input" />N&#7919;</td><tr>
<tr><td class="text">Ng&agrave;y h&#7871;t h&#7841;n</td><td class="text"><?php echo $this->expired ?></td><tr>
<tr><td class="text">S&#7889; l&#7847;n &#273;&#259;ng nh&#7853;p</td><td class="text"><?php echo $this->visited ?></td><tr>
<tr><td class="text">L&#7847;n cu&#7889;i &#273;&#259;ng nh&#7853;p</td><td class="text"><?php echo $session->lastlogin ?></td><tr>
</table>
</form>
</td></tr></tbody>
<?php }
}
$o = new item;
$o->id = $session->id;
$o->act = $act;
$o->a_alert = &$USER_ALERT;
$o->process();
?>
</body>
</html>
<script language="javascript" defer>
var frmItem = document.getElementById("idfrmItem");
<?php 
if($act == ACT_PASSWD){
	$ADpassword = (string)$_POST['ADpassword'];
	$ADnewpassword = (string)$_POST['ADnewpassword'];
	if($session->passwd($ADpassword,$ADnewpassword)){;?>
		window.alert('Da thay doi xong mat khau\n. Moi ban Thoat ra va dang nhap lai');
		window.top.location.href=URL_ADMIN + 'logoff.php?go=<?php echo URL_ROOT ?>logon.htm';
<?php	}
	else{ ?>
		window.alert('Khong thay doi duoc mat khau. Xin vui long lam lai');
		showTab('pwd',document.getElementById('tabheadpwd'));
		document.getElementsByName('ADpassword').item(0).focus();
	<?php } ?>
<?php }
?>
function checkForm(f){
	if(f.ADnewpassword.value != f.ADnewpassword2.value || !/^[a-zA-Z0-9]{6,50}$/.test(String(f.ADnewpassword.value))){
		parent.banner.setStatus('Mat khau khong  trung nhau hoac khong hop le.<br/>(Phai co 6 ky tu, chu cai hoac chu so)');
		return false;
	}
	return true;
}
function checkForm2(f){
	if(f.name.value == '') { parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p t&ecirc;n"); f.name.focus(); return false;}
	return true;
}
function doSave(){
	if(checkForm2(frmItem)) frmItem.submit();
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
	a = document.getElementsByTagName('span');
	n = a.length;
	for(i=0;i < n; ++i){
		if(a.item(i).className == 'tabheadactive') {
			a.item(i).className = 'tabhead';
		}
	}
	o.className='tabheadactive';
}
window.top.document.title = self.document.title;
</script><?php dbclose();?>