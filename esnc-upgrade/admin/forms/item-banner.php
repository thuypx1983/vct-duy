<?php
//duong dan den bo soan thao fckeditor
	include_once("../fckeditor/fckeditor.php") ;
	$sBasePath = URL_ADMIN.'fckeditor/' ;
//
	$URL_GO = URL_GO;
	if($URL_GO == '') $URL_GO = URL_CWD.'item-list.php?CBid='.$this->catid;
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $this->doctitle;?></title>
<link type="text/css" rel="stylesheet" href="images/style.css">
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function HIDE(id){	
	var o = document.getElementById(id);	
	if (!o) return;
	o.style.visibility ='hidden';
	
}
</script>
<style>
tr{vertical-align:bottom;}
.text{vertical-align:middle;}
</style>
</head>
<body class="text">
<?php $colsize = '670px';?>
<form id="idfrmItem"  method="post" action="<?php echo URL_SELF.'?'.urlformat($this->q,'act',ACT_SAVE,'id',$this->id,'CBid',$this->catid,'catid',$this->catid) ?>" onSubmit="return checkForm(this);">
<input type="hidden" value="<?php echo $URL_GO ?>" name="go" />
<col width="100px"/><col width="<?php echo $colsize;?>" />
<table width="95%" cellpadding="0" cellspacing="5">
	<tr>
		<td width="230" class="text">T&ecirc;n</td>
		<td><input name="name" type="text" class="input" value="<?php echo htmlspecialchars($this->name); ?>" style="width:<?php echo $colsize;?>"></td>
	</tr>
	<tr>
		<td class="text">Li&ecirc;n k&#7871;t</td>
		<td class="text"><input type="text" name="url" class="input" value="<?php echo htmlspecialchars($this->url); ?>" size="40"> Li&ecirc;n k&#7871;t ng&#432;&#7907;c <strong title="L&agrave; trang c&#7911;a &#273;&#7889;i t&aacute;c ch&#7913;a li&ecirc;n k&#7871;t c&#7911;a m&igrave;nh">(?)</strong> <input type="text" name="mybanner" class="input" value="<?php echo $this->mybanner ?>" size="40" title="L&agrave; trang c&#7911;a &#273;&#7889;i t&aacute;c ch&#7913;a li&ecirc;n k&#7871;t c&#7911;a m&igrave;nh"> </td>
	</tr>
	<tr>
		<td class="text" valign="middle">Chi&#7873;u r&#7897;ng</td>
		<td class="text">
			<input type="text" name="width" class="input" value="<?php echo $this->width ?>" size="7">
			Chi&#7873;u cao <input type="text" name="height" class="input" value="<?php echo $this->height ?>" size="7">&nbsp; <input type="checkbox" onClick="frmItem.target.value=this.checked ? '_blank': '_self';" class="input" <?php echo $this->target == "" || $this->target == '_self'? '' :'checked' ?> />
			M&#7903; c&#7917;a s&#7893; m&#7899;i <input type="text" name="target" class="input" value="<?php echo $this->target == "" ? '_self':$this->target ?>" size="7" />
			Th&#7913; t&#7921; hi&#7875;n th&#7883; <input type="text" name="view" class="input" value="<?php echo $this->view ?>" size="4" />
		</td>
	</tr>
	<tr>
		<td class="text">Ng&agrave;y t&#7841;o</td>
		<td class="text"><input type="text" name="created" class="input" value="<?php echo $this->created ?>" size="22" />  Ng&agrave;y h&#7871;t h&#7841;n <input type="text" name="expires" class="input" value="<?php echo $this->expires ?>" size="22" onblur="reformat(this);"/>  (vd: 31-12-2009)  S&#7889; l&#7847;n nh&#7845;n <?php echo $this->click ?></td>
	</tr>
	<tr>
		<td class="text">&#7842;nh</td>
		<td><input type="text" name="img" class="input" value="<?php echo htmlspecialchars($this->img); ?>" style="width:<?php echo $colsize;?>" /><br/></td>
	</tr>
	<tr>
		<td></td>
		<td border='1' alt='<?php echo $this->alt ?>' title='<?php echo $this->alt ?>' valign="top" width="906"><b>Giới hạn kích thước ảnh 1</b>:<input type="text"  value="<?php echo IMAGE_SIZE_BANNER;?>" name="size_img1"  />
	  <iframe height="40" width="100%" frameborder="0" scrolling="no" src="document-upload-one.php?c=PATH_TEMP&fn=doSaveImg"></iframe></td>
	</tr>
	<tr>
		<td></td>
		<td align="center"><?php htmlview(URL_BANNER_IMG,$this->img ? $this->img:URL_ADMIN.'images/noimage.gif'," id='idimgImg' ");?></td>
	</tr>
	<tr>
		<td class="text">Ch&uacute; th&iacute;ch</td>
		<td><input type="text" name="alt" class="input" value="<?php echo htmlspecialchars($this->alt); ?>"  style="width:<?php echo $colsize;?>" /></td>
	</tr>
	<tr>
		<td class="text">Mi&ecirc;u t&#7843;</td>
		<td>
		<textarea name="desc" rows="2" class="input" style="width:<?php echo $colsize;?>" ><?php echo $this->desc ?></textarea>
		<?php
		/*$oFCKeditor = new FCKeditor('desc') ;
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Height = 200 ;
		//$oFCKeditor->Config[ 'ToolbarLocation' ] = 'Out:xToolbar' ;
		$oFCKeditor->Value		= $this->desc;
		$oFCKeditor->Create() */
		?>
		</td>
	</tr>
	<tr>
		<td class="text">&#272;&#7863;c t&iacute;nh</td>
		<td class="text">
			<table border="0" width="100%">
<?php	$i=0;foreach($this->a_ctrl as $ctl => $text){ ?>
<?php 	if($i == 0){?>
			<tr><?php }?>
				<td width="2%" class="text"><input type="checkbox" value="<?php echo $ctl ?>" <?php if($this->ctrl & $ctl) echo 'checked' ?> name="ctrl[]"></td><td class="text"><?php echo $text ?></td>
<?php if($i == 4) { echo '</tr>'; $i = 0;} else ++$i; }?>
<?php if($i > 0) { for(;$i <= CTRL_PER_ROW;++$i) echo '<td>&nbsp;</td>'; echo '</tr>';} //padding last row ?>
			</table>
		</td>
	</tr>
<?php if (is_array($this->a_status)&&(count($this->a_status)>1)){	?>
	<tr>
		<td class="text">Tr&#7841;ng th&aacute;i</td>
		<td><select name="status" class="input">
<?php foreach($this->a_status as $key=>$value){?>
			<option value="<?php echo $key ?>" <?php if($key==$this->status) echo 'selected';?>><?php echo $value ?></option>
<?php }		?>
		</select></td>
	</tr>
<?php }		?>	
	<tr>
		<td class="text">Ghi ch&#250;</td>
		<td><textarea name="detail" rows="2" class="input" style="width:<?php echo $colsize;?>" ><?php echo $this->detail ?></textarea></td>
	</tr>
	<tr>
		<td class="text">&nbsp;</td>
		<td><input name="flag" type="checkbox" class="input" value="1" checked/>&nbsp;T&#7921; &#273;&#7897;ng ki&#7875;m tra v&agrave; b&#7887; qua n&#7871;u c&oacute; li&ecirc;n k&#7871;t r&#7891;i<br/>
<?php if (is_array($this->a_status)&&(count($this->a_status)>1)){	?>
			<input name="flag2" type="checkbox" class="input" value="1" checked/>&nbsp;T&#7921; &#273;&#7897;ng ghi &#273;&#232; n&#7871;u c&#243; th&#7875; ghi &#273;&#232;		
<?php }		?>	
		</td>
	</tr>
</table>
</form>
<script language="javascript" type="text/javascript" defer>
function reformat(o){
	if(o.value == '') o.value = '31-12-2050'; 
	else {
		if(!<?php echo REGEX_DATE ?>.test(o.value)){
			o.select();o.focus();
			window.top.banner.setStatus("&#272;&#7883;nh d&#7841;ng ng&agrave;y h&#7871;t h&#7841;n kh&ocirc;ng &#273;&uacute;ng, v&iacute; d&#7909;: 31-12-2009 l&agrave; &#273;&uacute;ng (ng&agrave;y-th&aacute;ng-n&#259;m)");
		}
	}
}
window.top.document.title = self.document.title;
var self_id = '<?php echo $this->id;?>';
var self_type = '<?php echo $this->type;?>';
var frmItem = document.getElementById("idfrmItem");
var imgImg1 = document.getElementById('idimgImg1');
var imgImg = document.getElementById('idimgImg');
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo $URL_GO ?>';
var url_newitem='#';
function checkForm(f){
	return true;
}
</script>
<script language="javascript" src="js/item-script.js"></script>
</body>
</html>
<?php dbclose(); ?>