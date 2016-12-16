<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<title><?php echo $this->doctitle ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
<comment>
<link type="text/css" rel="stylesheet" href="images/style-nonie.css" />
</comment>
<link type="text/css" rel="stylesheet" href="images/rtestyle.css"/><!--css rte-->
<script language="javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
<script language="javascript" src="js/tooltip.js" type="text/javascript"></script>
<script language="javascript" src="js/tip.js" type="text/javascript"></script>
<script language="javascript" src="js/rte.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
</script>
<style type="text/css">
.tabhead{
	color:#000000;
	cursor:pointer;
}
.tab{
display:none;
}
.tabhead_active{
	color:#0000FF;
	cursor:default;
}
.tab_active{
display:block;
}
</style>
</head>
<body class="text">
<form id="idfrmItem" action="<?php echo URL_SELF.'?act='.ACT_SAVE.'&id='.$this->id.'&go='.urlencode(URL_CWD.'item-list.php'); ?>" method="post" onSubmit="return checkForm(this);" enctype="multipart/form-data">	
<table width="100%" border="0">
	<input type="hidden" name="countryid" value="vn" />
	<input type="hidden" name="country" value="Vi&#7879;t nam" />
	<tr>
		<td width="15%" class="text"><strong>T&ecirc;n</strong></td>
		<td><input name="name" id="name" type="text" class="input" style="width:100%" value="<?php echo htmlspecialchars($this->name); ?>" onblur="getUrlRewrite();"></td>
	</tr>
	<tr>
		<td width="10%" class="text"><strong>Url khi rewrite</strong></td>
		<td><input name="urlrewrite" id="urlrewrite" type="text" class="input" size="120" value="<?php echo htmlspecialchars($this->urlrewrite); ?>"  style="width:100%" /></td>
	</tr>
	<tr>
		<td class="text"><strong>&#272;&#7883;a ch&#7881;</strong></td>
		<td><textarea name="address" class="input" style="width:100%;height:100% "><?php echo $this->address; ?></textarea></td>
	</tr>
	<tr>
		<td class="text"><strong>T&#7881;nh/Th&agrave;nh ph&#7889;</strong></td>
		<td class="text" nowrap>
			<select class="input" onChange="frmItem.cityid.value=this.value;frmItem.city.value=this.options[this.selectedIndex].text;">
				<option value="<?php echo $this->cityid; ?>" selected><?php echo $this->city; ?></option>
				<?php readfile(PATH_APPLICATION.'citycodes.htm'); ?>
			</select>&nbsp;	
			<input type="text" name="city" value="<?php echo $this->city; ?>" style="width:45%" class="input" /><span style="padding-left:53px; ">Vi&#7871;t t&#7855;t</span>
			<input type="text" name="cityid" style="width:23% " value="<?php echo $this->cityid; ?>" class="input"/>
		</td>
	</tr>
	<tr>
		<td class="text"><strong>&#272;i&#7879;n tho&#7841;i</strong></td>
		<td class="text">
			<input name="phone" class="input" type="text" style="width:45%" value="<?php echo htmlspecialchars($this->phone); ?>"><span style="padding-left:43px; ">Fax</span>
			<input name="fax" class="input" type="text" style="width:45%" value="<?php echo htmlspecialchars($this->fax); ?>">
		</td>
	</tr>
	<tr>
		<td class="text"><strong>Email</strong></td>
		<td class="text">
			<input name="email" class="input" type="text" style="width:45%" value="<?php echo $this->email ?>"><span style="padding-left:23px; ">Website</span>
			<input name="website" class="input" type="text" style="width:45%" value="<?php echo htmlspecialchars($this->website); ?>">
		</td>
	</tr>
	<tr>
		<td class="text"><strong>Ng&#432;&#7901;i li&ecirc;n h&#7879;</strong></td>
		<td class="text">
			<input name="contact" class="input" type="text" style="width:45%" value="<?php echo htmlspecialchars($this->contact); ?>"><span style="padding-left:13px; ">&#272;i&#7879;n tho&#7841;i</span>
			<input name="contactphone" class="input" type="text" style="width:45%" value="<?php echo $this->contactphone ?>">
		</td>
	</tr>
	<tr>
		<td class="text"><strong>&#7842;nh minh h&#7885;a</strong></td>
		<td>
			<table width="100%">
				<tr>
					<td width="32%" title='<?php echo $this->alt ?>' border='0' alt='<?php echo $this->alt ?>'>
						<?php htmlview(URL_AGENT_IMG,$this->img,' id="idimgImg"','<img src="'.URL_ADMIN.'images/noimage.gif" id="idimgImg" />');?>
					</td>
					<td width="68%" align="left" valign="middle" nowrap class="text">
						<table width="100%">
							<tr>
								<td width="29%" align="right" class="text">&#7842;nh:</td>
								<td width="71%"><input type="text" name="img" class="input" value="<?php echo $this->img ?>" style="width:100%" /></td>
							</tr>
							<tr valign="top">
								<td class="text" align="right">Link</td>
								<td><iframe height="40" width="100%" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg"></iframe></td>
							</tr>
							<tr>
								<td class="text" align="right">Ch&uacute; th&iacute;ch &#7843;nh:</td>
								<td><input type="text" name="alt" class="input" value="<?php echo $this->alt ?>"  style="width:100%" /></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="text"><strong>Th&#7913; t&#7921; hi&#7875;n th&#7883;</strong></td>
		<td class="text"><input type="text" name="view" class="input" value="<?php echo $this->view ?>" size="4" /></td>
	</tr>
	<tr>
		<td class="text"><strong>&#272;&#7863;c t&iacute;nh</strong></td>
		<td class="text">
			<table border="0" width="100%">
				<?php	$i=0;foreach($this->a_ctrl as $ctl => $text){ ?>
				<?php 	if($i == 0){?>
				<tr><?php }?>
					<td width="2%" class="text">
						<input type="checkbox" value="<?php echo $ctl ?>" <?php if($this->ctrl & $ctl) echo 'checked' ?> name="ctrl[]">
					</td>
					<td class="text"><?php echo $text ?></td>
						<?php 
							if($i == CTRL_PER_ROW) { 
								echo '</tr>'; $i = 0;} else ++$i; 
							}
							if($i > 0) { 
								for(;$i <= CTRL_PER_ROW;++$i) 
								echo '<td>&nbsp;</td>'; 
								echo '</tr>';
							} //padding last row ?>
			</table>
		</td>
	</tr>
	<tr>
		<td class="text"><strong>Ki&#7875;u</strong></td>
		<td><select name="type" class="input"><?php  
	if($this->id <=0){
		$modify = 'selected';
		foreach($this->a_type as $type=>$text){
			echo '<option value="'.$type.'" ';	
			echo $modify.'>';$modify='';
			echo $text;
			echo '</option>';
		}
	}else{
		foreach($this->a_type as $type=>$text){
			echo '<option value="'.$type.'"';	
			if($type == $this->type) echo ' selected>';else echo '>';
			echo $text;
			echo '</option>';
		}
	}?></select></td>
	</tr>
	<tr><td colspan="3"><div class="title"><strong>M&#244; t&#7843; t&#243;m t&#7855;t</strong></div>
	<div><?php
	$rte = new RTE('rte_detail',NULL,RTE_B_ALL);	
	$rte->show('detail',$this->detail,'120px');
	?></div>
</td>
	</tr>
	<!--tr><td colspan="2" class="text" align="center"><input type="submit" class="button" value="Ch&#7845;p nh&#7853;n">&nbsp;<input type="button" class="button" value="H&#7911;y b&#7887;"></td></tr-->
</table>
</form>	
<?php RTE::loadRTEDialog();?>
</body>
<script language="javascript" type="text/javascript" src="<?php echo URL_ADMIN?>.js/rte.js"></script><!--Them vao dung rte-->
<?php $rte->initRteObjectScript();?>
</html>
<script language="javascript" type="text/javascript">
window.top.document.title = self.document.title;
var self_id = '<?php echo $this->id;?>';
var self_type = '<?php echo $this->type;?>';
var frmItem = document.getElementById("idfrmItem");
var imgImg = document.getElementById('idimgImg');
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo URL_CWD ?>item-list.php';
var url_newitem='#';
function checkForm(f){
	if(f.name.value == ''){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p ti&ecirc;u &#273;&#7873;");
		f.name.focus();return false;
	}
	if(rte_detail) rte_detail.rteToInput();
	return true;
}
function SHOW(id){	
	var o = document.getElementById(id);	
	if (!o) return;
	if (o.style.visibility =='hidden' || o.style.visibility ==''){
		o.style.visibility='visible';
	}
	else{
		o.style.visibility='hidden';
	}
	if (o.clientWidth<154) o.style.width= '154px';
}
function HIDE(id){
	var o = document.getElementById(id);	
	if (!o) return;
	o.style.visibility ='hidden';	
}
showTab('_summary',document.getElementById('tabhead_summary'));

function removeMark(str){ 
	var delimeter = "<?php echo URL_DELIMETER?>";
    //str= str.toLowerCase();  
    str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");  
    str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");  
    str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");  
    str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");  
    str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");  
    str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");  
    str= str.replace(/đ/g,"d");  
	str= str.replace(/Đ/g,"D");  
    str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_|-/g,delimeter); 
 /* repalce special character -> '-' */ 
    str= str.replace(/-+-/g,delimeter); //thay thế 2- thành 1- 
	str= str.replace(/_+_/g,delimeter); //thay the 2_ thanh 1_
    str= str.replace(/^\-+|\-+$/g,"");
	str= str.replace(/^\_+|\_+$/g,"");    
 //cắt bỏ ký tự - ở đầu và cuối chuỗi  
   return str;  
}   

function getUrlRewrite(){
	var name = document.getElementById('name');
	var urlrewrite = document.getElementById('urlrewrite');		
	urlrewrite.value = removeMark(name.value);		
}
</script>
<script language="javascript" src="js/item-script.js" type="text/javascript"></script>