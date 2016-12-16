<html><head><title><?php echo $this->doctitle;?></title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css">
<script language="javascript" src="js/library.js" type="text/javascript"></script>
<script language="javascript" src="js.php" type="text/javascript"></script>
</head>
<body>
<form id="idfrmItem" action="<?php echo URL_SELF.'?act='.ACT_SAVE.'&id='.$this->id.'&go='.urlencode(URL_CWD.'item-list.php'); ?>" method="post" onSubmit="return checkForm(this);" enctype="multipart/form-data">	
<table width="100%" border="0">
	<input type="hidden" name="countryid" value="vn" />
	<input type="hidden" name="country" value="Vi&#7879;t nam" />
	<tr>
		<td class="text" width="15%">T&ecirc;n</td>
		<td><input name="name" type="text" class="input" style="width:100%" value="<?php echo htmlspecialchars($this->name); ?>"></td>
	</tr>
	<tr>
		<td class="text">&#272;&#7883;a ch&#7881;</td>
		<td><textarea name="address" class="input" style="width:100%;height:100% "><?php echo $this->address; ?></textarea></td>
	</tr>
	<tr>
		<td class="text">T&#7881;nh/Th&agrave;nh ph&#7889;</td>
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
		<td class="text">&#272;i&#7879;n tho&#7841;i</td>
		<td class="text">
			<input name="phone" class="input" type="text" style="width:45%" value="<?php echo htmlspecialchars($this->phone); ?>"><span style="padding-left:43px; ">Fax</span>
			<input name="fax" class="input" type="text" style="width:45%" value="<?php echo htmlspecialchars($this->fax); ?>">
		</td>
	</tr>
	<tr>
		<td class="text">Email</td>
		<td class="text">
			<input name="email" class="input" type="text" style="width:45%" value="<?php echo $this->email ?>"><span style="padding-left:23px; ">Website</span>
			<input name="website" class="input" type="text" style="width:45%" value="<?php echo htmlspecialchars($this->website); ?>">
		</td>
	</tr>
	<tr>
		<td class="text">Ng&#432;&#7901;i li&ecirc;n h&#7879;</td>
		<td class="text">
			<input name="contact" class="input" type="text" style="width:45%" value="<?php echo htmlspecialchars($this->contact); ?>"><span style="padding-left:13px; ">&#272;i&#7879;n tho&#7841;i</span>
			<input name="contactphone" class="input" type="text" style="width:45%" value="<?php echo $this->contactphone ?>">
		</td>
	</tr>
	<tr>
		<td class="text">&#7842;nh minh h&#7885;a</td>
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
		<td class="text">Th&#7913; t&#7921; hi&#7875;n th&#7883;</td>
		<td class="text"><input type="text" name="view" class="input" value="<?php echo $this->view ?>" size="4" /></td>
	</tr>
	<tr>
		<td class="text">&#272;&#7863;c t&iacute;nh</td>
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
		<td class="text">Ki&#7875;u</td>
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
	<tr>
		<td class="text">Chi ti&#7871;t </td>
		<td><textarea name="detail" style="width:100%;height:80px;" class="input"><?php echo $this->detail; ?></textarea></td>
	</tr>
	<!--tr><td colspan="2" class="text" align="center"><input type="submit" class="button" value="Ch&#7845;p nh&#7853;n">&nbsp;<input type="button" class="button" value="H&#7911;y b&#7887;"></td></tr-->
</table>
</form>	
</body>
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
	return true;
}
</script>
<script language="javascript" src="js/item-script.js" type="text/javascript"></script>