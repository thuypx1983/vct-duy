<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>t&#7843;i l&ecirc;n</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link href="images/style.css" rel="stylesheet" type="text/css">
<comment><link href="images/style-nonie.css" rel="stylesheet" type="text/css"></comment>
<style type="text/css">div{height:20px;width:235px} div#idtrProgress{height:16px;padding:4px 0px 0px 0px;display:none;text-align:center}</style>
</head>
<body>
<div id="idtrForm"><form action="<?php echo URL_SELF.'?'.urlmodify('act',ACT_SAVE); ?>" method="post" enctype="multipart/form-data"><input name="userfile" type="file" class="input input_file" onchange="doSubmit(this.form);" /></form></div>
<div id="idtrProgress" class="progress"><strong>&#272;ang x&#7917; l&yacute;...</strong></div>
</body>
</html>
<script language="javascript" type="text/javascript" defer>
function doSubmit(f){
	if(f.userfile.value != ''){
		document.getElementById('idtrProgress').style.display='block';
		document.getElementById('idtrForm').style.display='none';
		f.submit();
	}
}
<?php if($act == ACT_SAVE){
	if(preg_match('/^\w+$/',$this->fn)) echo 'window.top.content.'; echo $this->fn ?>('<?php echo $this->name ?>','<?php echo $this->extenstion ?>',<?php echo (int)array_search($this->extension,$FILE_ALLOW_EDIT_TYPE); ?>,0);
<?php }
?></script>
