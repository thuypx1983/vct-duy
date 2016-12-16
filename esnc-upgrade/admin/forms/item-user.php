<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<base href="<?php echo URL_BASE_ADMIN ?>" />
<title><?php echo $this->doctitle;?></title>
<link type="text/css" rel="stylesheet" href="images/style.css">
<script language="javascript" src="js/library.js" type="text/javascript"></script>
<script language="javascript" src="js.php" type="text/javascript"></script>
<style type="text/css">
DIV.input_mselect{
	width:100%;
}
DIV.input_mini{
	width:25%;
	overflow:hidden;
	float:left;
	margin:0px 3px 0px 0px;
}
</style>
</head>
<body class="text">
<table width="100%" cellpadding="0" cellspacing="3">
<form id="idfrmItem"  method="post" action="<?php echo URL_SELF ?>?act=<?php echo ACT_SAVE ?>&id=<?php echo $this->id; ?>&go=<?php echo urlencode(URL_GO) ?>" onSubmit="return checkForm(this);">
	<tr>
		<td class="text" style="color:red;font-weight:bold ">T&ecirc;n vi&#7871;t t&#7855;t (nickname)</td>
		<td ><input name="user" type="text" class="input" value="<?php echo $this->user ?>" size="50"> <strong class="required">(*)</strong></td>
	</tr>
	<tr>
		<td class="text" style="color:red;font-weight:bold ">T&ecirc;n &#273;&#7847;y &#273;&#7911;</td>
		<td ><input name="name" type="text" class="input" value="<?php echo $this->name ?>" size="80"> <strong class="required">(*)</strong></td>
	</tr>
	<tr>
		<td class="text" style="cursor:help " title="Nh&#7853;p ng&agrave;y sinh vd:<?php echo strftime(FORMAT_DATETIME) ?>">Ng&agrave;y sinh</td>
		<td class="text"><input name="birthday" type="text" class="input" value="<?php echo $this->birthday ?>" size="30"/> <strong style="color:red ">vd:<?php echo strftime(FORMAT_DATETIME) ?></strong></td>
	</tr>
	<tr>
		<td class="text">&#272;i&#7879;n tho&#7841;i</td>
		<td><input type="text" name="phone" class="input" value="<?php echo $this->phone ?>" size="50"></td>
	</tr>
	<tr>
		<td class="text">&#272;i&#7879;n tho&#7841;i 2</td>
		<td><input type="text" name="mobile"  class="input" value="<?php echo $this->mobile ?>" size="50"></td>
	</tr>
	<tr>
		<td class="text" style="color:red;font-weight:bold ">Email</td>
		<td><input type="text" name="email" class="input" value="<?php echo $this->email ?>" size="50"> <strong class="required">(*)</strong></td>
	</tr>
	<tr>
		<td class="text" style="color:red;font-weight:bold;cursor:help " title="N&#7871;u b&#7841;n &#273;&#7875; tr&#7889;ng, m&#7853;t kh&#7849;u s&#7869; gi&#7919; nguy&ecirc;n kh&ocirc;ng &#273;&#7893;i">M&#7853;t kh&#7849;u</td>
		<td><input type="text" name="password" class="input" value="" size="50" style="color:white; "> <strong class="required">(*)</strong> (N&#7871;u b&#7841;n &#273;&#7875; tr&#7889;ng, m&#7853;t kh&#7849;u s&#7869; gi&#7919; nguy&ecirc;n kh&ocirc;ng &#273;&#7893;i)</td>
	</tr>
	<tr>
		<td class="text">Gi&#7899;i t&iacute;nh</td>
	  <td class="text" valign="middle"><?php  foreach($this->a_gender as $key=>$value) echo "<input type=\"radio\" class=\"input\" name=\"gender\" value=\"{$key}\" ".($key & $this->gender ?'checked':'')."/> {$value}&nbsp;&nbsp;";?></td>
	</tr>
	<tr>
		<td class="text">T&#7881;nh/th&agrave;nh ph&#7889;</td>
		<td><input type="text"  class="input" name="city" value="<?php echo $this->city; ?>"/>&nbsp;&nbsp;<input type="text" class="input" name="cityid" value="<?php echo $this->cityid; ?>"/>
			<select  class="input" onChange="this.form.city.value=this.options[this.selectedIndex].text;this.form.cityid.value=this.value">
				<option value="<?php echo $this->cityid; ?>" selected><?php echo $this->city; ?></option>
				<?php @readfile(PATH_APPLICATION.'citycodes.htm'); ?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="text">Ng&agrave;y t&#7841;o</td>
		<td class="text"><?php echo $this->created;?></td>
	</tr>
	<tr>
		<td class="text" style="cursor:help " title="Sau th&#7901;i &#273;i&#7875;m n&agrave;y, ng&#432;&#7901;i n&agrave;y s&#7869; kh&ocirc;ng th&#7875; &#273;&#259;ng nh&#7853;p &#273;&#432;&#7907;c n&#7919;a.Nh&#7853;p ng&agrave;y th&aacute;ng v&iacute; d&#7909;: 31-12-2099 15:39:59">Ng&#224;y h&#7871;t h&#7841;n</td>
		<td class="text"><input type="text" name="expired" class="input" value="<?php echo $this->expired;?>" /> (<?php echo str_replace('%','',FORMAT_DATETIME) ?>)</td>
	</tr><!--<?php echo $this->password ?>-->	
	<tr><td class="text">&#272;&#7863;c t&iacute;nh</td>
		<td><div class="input input_mselect"><?php 
foreach($this->a_alert as $ctl=>$text){
			echo '<div class="input_mini"><input type="checkbox" name="alert[]" class="input input_mini" value="'.$ctl.'"';
			if($this->alert & $ctl) echo ' checked="true" ';
			echo ' />'.$text.'</div>';
}
foreach($this->a_ctrl as $ctl=>$text){
			echo '<div class="input_mini"><input type="checkbox" name="ctrl[]" class="input input_mini" value="'.$ctl.'"';
			if($this->ctrl & $ctl) echo ' checked="true" ';
			echo ' />'.$text.'</div>';
}
		?></div></td></tr>
	<tr>
		<td class="text">S&#7889; l&#7847;n &#273;&#259;ng nh&#7853;p</td>
		<td class="text"><?php echo $this->visited ?></td>
	</tr>
	<tr>
		<td class="text">L&#7847;n cu&#7889;i &#273;&#259;ng nh&#7853;p</td>
		<td class="text"><?php echo $this->lastlogin ?></td>
	</tr>
</form>
</table>
</body>
</html>
<script language="javascript" >
window.top.document.title = self.document.title;
var self_id = '<?php echo $this->id;?>';
var frmItem = document.getElementById("idfrmItem");
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo  URL_GO;?>';
var url_newitem='<?php echo URL_SELF;?>?id=0&go=<?php echo urlencode(URL_GO); ?>';
function checkForm(f){
	if(f.name.value == ""){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p t&ecirc;n ng&#432;&#7901;i d&ugrave;ng");
		f.name.focus();
		return false;
	}
	if(f.user.value == ""){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p nickname");
		f.user.focus();
		return false;
	}
	if(!/^[\w\-\.\+]+\@([\w\-]+\.)+\w+$/.test(f.email.value)){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p email &#273;&uacute;ng &#273;&#7883;nh d&#7841;ng (<strong>vd: username@domain.com</strong>)");
		f.email.focus();
		return false;
	}
	return true;
}
</script>
<script language="javascript" src="js/item-script.js" type="text/javascript"></script>