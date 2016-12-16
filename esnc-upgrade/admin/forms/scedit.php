<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Thay &#273;&#7893;i c&#7845;u h&igrave;nh h&#7879; th&#7889;ng</title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<style>
th{font-size:11px;}
.tab{display:none;}
.tabactive{display:table-header-group;line-height:20px;}
textarea{width:95%;height:100%;}
.tabhead{cursor:pointer;font-size:11px;font-weight:normal;color:black;}
.tabheadactive{cursor:pointer;font-size:11px;font-weight:bold;color:green;}
tbody.tab input.input,tbody.tabactive input.input{width:90%; margin:1px;}
TD.vinput{padding:0px 0px 0px 30px;font-weight:bold;text-align:left;}
</style>
<link rel="stylesheet" type="text/css" href="images/style.css"/>
</head>
<body class="text">
<form action="<?php echo URL_SELF.'?act='.ACT_SAVE; ?>" method="post" onSubmit="return checkForm(this);">
<table  width="700px" border="0" cellspacing="1" cellpadding="1" align="center" >
<thead>
	<tr height="23" style="background-image:url(images/bg-product.gif);"><td colspan="2" align="center">
	<span name="tabhead" class="tabheadactive" onClick="showTab('_info',this);">Th&ocirc;ng tin</span>
	<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab(0,this);">Tham s&#7889; h&#7879; th&#7889;ng</span>
	<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_def',this);">C&#7845;u h&igrave;nh chu&#7849;n</span>
<?php if(MAX_ADD_CONSTANT > 0){?>
	<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_add',this);" id="tabhead_add">Th&ecirc;m m&#7899;i</span>
<?php }?>
	</td>
	</tr>
	<tr>
		<th width="10%">Tham s&#7889;</th>
		<th >Gi&aacute; tr&#7883;</th>
	</tr>
</thead>
<tbody id="tab0" class="tab" name="tab">
<tr><td colspan="2" width="100%" id="config_scedit">
	<?php 
	app_config_table_build();
	if(function_exists('app_config_show')) app_config_show();
	app_config_show_auto();
	?>
</td></tr>
</tbody>
<tbody id="tab_def" class="tab">
	<tr><td class="text" width="50%">&#272;&#7883;a ch&#7881; email c&#7911;a webmaster</td>
	<td><input type="text" class="input" name="C[EMAIL_WEBMASTER]" value="<?php echo EMAIL_WEBMASTER ?>" /></td></tr>
	<tr><td class="text">&#272;&#7883;a ch&#7881; email li&ecirc;n h&#7879;</td>
	<td><input type="text" class="input" name="C[EMAIL_CONTACT]" value="<?php echo EMAIL_CONTACT ?>" /></td></tr>
	<tr><td class="text">&#272;&#7883;a ch&#7881; email b&aacute;n h&agrave;ng</td>
	<td><input type="text" class="input" name="C[EMAIL_SALES]" value="<?php echo EMAIL_SALES ?>" /></td></tr>
	<tr><td class="text">&#272;&#7883;nh d&#7841;ng email ng&#7847;m &#273;&#7883;nh</td>
	<td><input type="text" class="input" name="C[EMAIL_MIME_DEFAULT]" value="<?php echo EMAIL_MIME_DEFAULT; ?>" /></td></tr>
	<tr><td class="text">D&#7841;ng ng&agrave;y th&aacute;ng hi&#7875;n th&#7883;</td>
	<td>
	<input type="radio" class="input_mini" name="C[DATE_FORMAT]" value="%d-%m-%Y" <?php if(DATE_FORMAT=='%d-%m-%Y') echo 'checked'?> />%d-%m-%Y&nbsp;
	<input type="radio" class="input_mini" name="C[DATE_FORMAT]" value="%m-%d-%Y" <?php if(DATE_FORMAT=='%m-%d-%Y') echo 'checked'?> />%m-%d-%Y&nbsp;
	<input type="radio" class="input_mini" name="C[DATE_FORMAT]" value="%Y-%m-%d" <?php if(DATE_FORMAT=='%Y-%m-%d') echo 'checked'?> />%Y-%m-%d
	</td></tr>
	<tr><td class="text">D&#7845;u t&aacute;ch ng&agrave;y th&aacute;ng</td>
	<td>
	<input type="radio" class="input_mini" name="C[DATE_SEPERATOR]" value="/" <?php if(DATE_SEPERATOR != '-' && DATE_SEPERATOR != '%') echo 'checked' ?>/><strong>/</strong>
	<input type="radio" class="input_mini" name="C[DATE_SEPERATOR]" value="-" <?php if(DATE_SEPERATOR == '-') echo 'checked' ?>/><strong>-</strong>&nbsp;
	<input type="radio" class="input_mini" name="C[DATE_SEPERATOR]" value="." <?php if(DATE_SEPERATOR == '.') echo 'checked' ?>/><strong>.</strong>&nbsp;
	</td></tr>
	<tr><td class="text">S&#7917; d&#7909;ng URL th&acirc;n thi&#7879;n</td>
	<td class="text"><input type="radio" class="input_mini" name="C[URL_CTRL]" value="<?php echo (is_file(PATH_COMPONENT.'urlrewrite.php') ? 4: 1)?>" <?php if(URL_CTRL) echo 'checked' ?>/>C&oacute;
	<input type="radio" class="input_mini" name="C[URL_CTRL]" value="0" <?php if((int)URL_CTRL == 0) echo 'checked' ?>/>Kh&ocirc;ng</td></tr>
	<tr><td class="text" title="Ch&#7881; th&#7921;c hi&#7879;n khi s&#7917; d&#7909;ng url th&acirc;n thi&#7879;n">D&#7845;u t&aacute;ch Url th&acirc;n thi&#7879;n</td>
	<td class="text"><input type="radio" class="input_mini" name="C[URL_DELIMETER]" value="/" <?php if((int)URL_CTRL == 0) echo 'disabled="disabled"'?> <?php if(URL_DELIMETER=='/') echo 'checked' ?>/>
	  '/' g&#7841;ch ch&eacute;o
	    <input type="radio" class="input_mini" name="C[URL_DELIMETER]" value="-" <?php if((int)URL_CTRL == 0) echo 'disabled="disabled"'?> <?php if(URL_DELIMETER == '-') echo 'checked' ?>/>
	    '-' g&#7841;ch ngang
        <input type="radio" class="input_mini" name="C[URL_DELIMETER]" value="_" <?php if((int)URL_CTRL == 0) echo 'disabled="disabled"'?> <?php if(URL_DELIMETER == '_') echo 'checked' ?>/>
        '_' g&#7841;ch d&#432;&#7899;i </td>
	</tr>
	<tr><td class="text">M&uacute;i gi&#7901; hi&#7875;n th&#7883;</td>
	<td class="text"><input type="text" name="C[TIME_ZONE]" value="<?php echo TIME_ZONE;?>" class="input" /></td></tr>
	<tr><td class="text">T&#7853;p tin thay th&#7871; trang ch&#7911;</td>
	<td><input type="text" class="input" name="C[FILE_DEFAULT]" value="<?php echo FILE_DEFAULT; ?>" /></td></tr>
	<tr><td class="text">S&#7889; ng&#432;&#7901;i &#273;ang xem c&#7897;ng th&ecirc;m</td>
	<td><input type="text" class="input" name="C[SESSION_ONLINE_INIT]" value="<?php echo (int)SESSION_ONLINE_INIT ?>" /></td></tr>
	<tr><td class="text">S&#7889; l&#432;&#7907;t truy c&#7853;p c&#7897;ng th&ecirc;m</td>
	<td><input type="text" class="input" name="C[APP_VISIT_INIT]" value="<?php echo (int)APP_VISIT_INIT ?>" /></td></tr>
	<tr><td class="text">Kho&#7843;ng th&#7901;i gian &#273;i&#7873;u &#273;&#7897; nh&#7887; nh&#7845;t (gi&acirc;y)</td>
	<td class="text"><input type="text" value="<?php echo JOB_INTERVAL ?>" name="C[JOB_INTERVAL]" class="input" /></td></tr>
	<tr><td class="text">S&#7889; l&#7847;n &#273;&#259;ng nh&#7853;p sai t&#7889;i &#273;a</td>
	<td><input type="text" class="input" name="C[MAX_LOGON_TRIES]" value="<?php echo MAX_LOGON_TRIES ?>" /></td></tr>
	<tr><td class="text">T&#7855;t b&#7897; &#273;&#7879;m (gi&#7843;m t&#7889;c &#273;&#7897;)</td>
	<td class="text">
	<input type="checkbox" class="input_mini" name="C[CACHE_OFF][]" value="0x00000001" <?php if(defined('CACHE_OFF')) echo 'checked' ?> />trang
	<?php define('CACHE_OFF',0);?>
	<input type="checkbox" class="input_mini" name="C[CACHE_OFF][]" value="0x40000000" <?php if(CACHE_OFF & 0x40000000) echo 'checked'?> />m&atilde; giao di&#7879;n
	<input type="checkbox" class="input_mini" name="C[CACHE_OFF][]" value="0x00000008" <?php if(CACHE_OFF & 0x00000008) echo 'checked' ?> />d&#7919; li&#7879;u
	<input type="checkbox" class="input_mini" name="C[CACHE_OFF][]" value="0x00000004" <?php if(CACHE_OFF & 0x00000004) echo 'checked' ?> />bi&#7871;n
	<input type="checkbox" class="input_mini" name="C[CACHE_OFF][]" value="0x00000002" <?php if(CACHE_OFF & 0x00000002) echo 'checked' ?> />kh&#7889;i
	</td></tr>
	<tr><td class="text">PHP sendmail_from</td>
	<td><input type="text" class="input" name="C[EMAIL_MASTER]" value="<?php define('EMAIL_MASTER','');echo EMAIL_MASTER ?>"/></td></tr>
	<tr><td class="text">PHP default_charset</td>
	<td><input type="text" class="input" name="C[CHARSET]" value="<?php echo CHARSET ?>" /></td></tr>
	<tr><td class="text">PHP date.time_zone</td>
	<td class="text"><input type="text" name="L_TIME_ZONE" value="<?php echo date_default_timezone_get();?>" class="input" /></td></tr>
	<tr><td class="text">PHP session.name</td>
	<td><input type="text" class="input" name="C[SESSION_NAME]" value="<?php echo SESSION_NAME ?>" /></td></tr>
	<tr><td class="text">PHP session.cache_limiter</td>
	<td><input type="text" class="input" name="C[SESSION_CACHE]" value="<?php echo SESSION_CACHE ?>" /></td></tr>
	<tr><td class="text">PHP session.cache_expire</td>
	<td><input type="text" class="input" name="C[SESSION_TIMEOUT]" value="<?php echo (int) SESSION_TIMEOUT ?>" /></td></tr>
	<tr><td class="text">SQL_NOW (NOW()=<?php echo $now ?>)</td>
	<td class="text"><input type="text" name="C[SQL_NOW]" value="<?php if(!strpos(SQL_NOW,':')) echo SQL_NOW;?>" class="input" /></td></tr>
</tbody>
<?php if(MAX_ADD_CONSTANT > 0){?>
<tbody id="tab_add" class="tab" name="tab">
<tr>
	<td>T&ecirc;n g&#7885;i trong qu&#7843;n tr&#7883;</td>
	<td ><input class="input" name="ini[name]" onFocus="this.select();" /></td>
</tr>
<tr>
	<td ><strong style="color:red ">TEN_THAM_SO</strong></td>
	<td ><input class="input" type="text" name="C_NAME" value="" onFocus="this.select();"/></td>
</tr>
<tr>
	<td width="30%">Gi&aacute; tr&#7883; ng&#7847;m &#273;&#7883;nh</td>
	<td ><input class="input" type="text" id="C_VALUE" value="" onFocus="this.select();"/></td>
</tr>
<tr>
	<td>Ki&#7875;u &ocirc; nh&#7853;p li&#7879;u</td>
	<td >
	<input type="radio" class="input_mini" name="ini[type]" value="int" checked onclick="showOption(this);" />int
	<input type="radio" class="input_mini" name="ini[type]" value="string" onclick="showOption(this);"/>string
	<input type="radio" class="input_mini" name="ini[type]" value="radio" onclick="showOption(this);" />radio
	<input type="radio" class="input_mini" name="ini[type]" value="checkbox" onclick="showOption(this);" />checkbox
	<input type="radio" class="input_mini" name="ini[type]" value="dropdown" onclick="showOption(this);" />dropdown
	<input type="radio" class="input_mini" name="ini[type]" value="real" onclick="showOption(this);" />real
	</td>
</tr>
<tr id="range">
	<td>Kho&#7843;ng gi&aacute; tr&#7883;</td>
	<td >Min: <input class="input" name="ini[min]" onFocus="this.select();" style="width:100px;" /> Max: <input class="input" name="ini[max]" onFocus="this.select();"  style="width:100px;" /></td>
</tr>
<tr id="optlist" style="display:none "><td>C&aacute;c tu&#7923; ch&#7885;n</td>
	<td><table width="97%" cellpadding="1" cellspacing="1">
			<tr><td align="center" width="25%">Value</td><td align="center">Text</td></tr><?php
			for($i=0;$i<10;++$i)
			echo '<tr><td><input type="text" name="opt['.$i.']" class="input"/></td><td><input type="text" name="value['.$i.']" class="input"/></td></tr>';
			?>
		</table>
	</td>
</tr>
<tr id="regex" style="display:none ">
	<td>Regex ki&#7875;m tra</td>
	<td><input class="input" name="ini[re1]" onFocus="this.select();" /><br />
	<input class="input" name="ini[re2]" onFocus="this.select();" /><br />
	<input class="input" name="ini[re3]" onFocus="this.select();" /><br />
	<input class="input_mini" name="ini[checktype]" type="checkbox" value="or"/> &#273;i&#7873;u ki&#7879;n <strong>ho&#7863;c</strong>
	(ng&#7847;m &#273;&#7883;nh:<strong>v&agrave;</strong>)
	</td>
</tr>
</tbody>
<?php }?>
<tbody id="tab_info" class="tabactive">
<tr><td nowrap>Qu&#7843;n tr&#7883; vi&ecirc;n</td>
	<td class="vinput"><?php echo $session->email;?></td></tr>
<tr><td nowrap>S&#7889; l&#432;&#7907;t truy c&#7853;p</td>
	<td class="vinput"><?php echo session::visit();?></td></tr>
<tr><td nowrap>S&#7889; ng&#432;&#7901;i &#273;ang xem</td>
	<td class="vinput"><?php echo session::online();?></td></tr>
<tr><td nowrap>Phi&ecirc;n b&#7843;n ESNC.Net</td>
	<td class="vinput"><?php echo str_replace('ESNC.Net','<strong style="color:green">E<font color="red">S</font>NC.Net</strong>', ESNC_VERSION);?></td></tr>
<tr><td nowrap>Phi&ecirc;n b&#7843;n PHP</td>
	<td class="vinput">PHP <?php echo  PHP_VERSION.'/'.PHP_OS;?></td></tr>
<tr><td nowrap>C&#417; s&#7903; d&#7919; li&#7879;u</td>
	<td class="vinput"><?php echo DB_TYPE;?>( db:<?php echo DB_NAME.'/'.DB_TABLE_PREFIX.'*'.', user:'.DB_USER.',  size: '.number_format($stat['dbsize'],0,'',' ') ?> KB)</td></tr>
<tr><td nowrap>K&iacute;ch th&#432;&#7899;c t&#7843;i l&ecirc;n t&#7889;i &#273;a</td>
	<td class="vinput"><?php echo ini_get('upload_max_filesize') ?></td></tr>
<tr><td nowrap>&#272;&#7883;a ch&#7881; IP m&aacute;y ch&#7911;</td>
	<td class="vinput"><?php echo $_SERVER['SERVER_ADDR']; ?></td></tr>
<tr><td nowrap>K&iacute;ch th&#432;&#7899;c th&#432; m&#7909;c</td>
	<td class="vinput"><?php echo number_format($stat['foldersize'],0,'',' '); ?> KB, <?php echo $stat['filecount'] ?> files, <?php echo $stat['foldercount'] ?> folders <span style="font-weight:normal ">(<?php echo $stat['statdate'] ?>)</span></td></tr>
<tr><td nowrap>T&#7853;p tin l&#7899;n nh&#7845;t</td>
	<td class="vinput"><?php echo $stat['filename_maxsize'] ?>: <?php echo number_format($stat['filesizemax'],0,'',' '); ?> KB</td></tr>
<tr><td nowrap>Tr&igrave;nh duy&#7879;t</td>
	<td class="vinput">(<?php echo $_SERVER['REMOTE_ADDR']; ?>) <?php echo $_SERVER['HTTP_USER_AGENT']; ?></td></tr>
<tr><td nowrap>Th&#7901;i gian hi&#7879;n t&#7841;i</td>
	<td class="vinput">web: <?php echo strftime(FORMAT_DATETIME); ?>, db: <?php echo $sql_now ?></td></tr>
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
	for(i=0;i<MAX_ADD_CONSTANT;++i){
		mc = f.elements['C_NAME'];
			if(mc.value != ''){
				if(/^[A-Z][A-Z0-9_]+$/.test(mc.value)){
					document.getElementById('C_VALUE').name='C['+mc.value+']';
				}else{
					parent.banner.setStatus('T&ecirc;n kh&ocirc;ng h&#7907;p l&#7879;');
					mc.select();
					mc.focus();
					return false;
				}
			}
	}
	document.body.style.visibility='hidden';
	for(i=0;i<n;++i){
		if( /*f.elements[i].value == '!!DELETE!!'*/
			f.elements[i].name.indexOf('ini') >=0 && f.elements[i].value==''
			|| f.elements[i].name.indexOf('opt') >=0 && f.elements[i].value==''
			|| f.elements[i].name.indexOf('value') >=0 && f.elements[i].value=='')
			f.elements[i].disabled = true; else htmlencode(f.elements[i]);
	}
	return true;
}
function showTab(id,o){
	a = document.getElementsByTagName('tbody');
	n = a.length;
	for(i=0;i < n; ++i){
		if(a.item(i).className == 'tabactive'){
			a.item(i).className='tab';
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
function doSave(){
	if(checkForm(f=document.getElementsByTagName('form').item(0))) f.submit();
}
function doUp(){
	self.location.href='<?php echo URL_CWD ?>index.php';
}
<?php if(MAX_ADD_CONSTANT>0){
echo 'function doNewItem(){
		showTab("_add",document.getElementById("tabhead_add"));
	}';
} ?>
function showOption(o){
	var _optList=document.getElementById('optlist');
	var _range=document.getElementById('range');
	var _regex = document.getElementById('regex');
	switch(o.value){
	case 'int':
	case 'real':
		_optList.style.display='none';
		_range.style.display='';
		_regex.style.display='none';
		break;
	case 'string':
		_optList.style.display='none';
		_range.style.display='none';
		_regex.style.display='';
		break;
	default:
		_optList.style.display='';
		_range.style.display='none';
		_regex.style.display='none';
	}
}
var MAX_ADD_CONSTANT = <?php echo MAX_ADD_CONSTANT; ?>;
window.top.document.title=self.document.title;

</script>
</html>
