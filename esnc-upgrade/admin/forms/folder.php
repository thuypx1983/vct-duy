<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<title>Chi ti&#7871;t nh&oacute;m</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
<link type="text/css" rel="stylesheet" href="images/rtestyle.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
<script language="javascript" type="text/javascript" src="js/rte.js"></script>
<style type="text/css">
DIV.colorSelect,DIV.colorSelect-hover,DIV.rteButton,DIV.rteButton-hover,DIV.rteButtonBlock,DIV.rteButtonBlock-hover{behavior:url(js/IEhover.htc);}
</style>
</head>
<body class="text">
<?php
	include_once("../fckeditor/fckeditor.php") ;
	$sBasePath = URL_ADMIN.'fckeditor/' ;
?>
<form action="<?php echo URL_SELF.'?act='.ACT_SAVE.'&id='.$this->id ?>" method="post" onSubmit="return checkForm(this);"  id="idfrmItem" class="text">
<input type="hidden" name="parentid" value="<?php echo $this->parentid; ?>"/>
<table width="100%" border="0" class="text"><tbody>
	<tr>
		<td width="10%" class="text"><strong>Ti&ecirc;u &#273;&#7873;</strong></td>
		<td><input name="name" id="name" type="text" class="input" size="120" value="<?php echo htmlspecialchars($this->name); ?>"  style="width:100%" onblur="getUrlRewrite();"/></td>
	</tr>
	<tr>
		<td width="10%" class="text"><strong>Url khi rewrite</strong></td>
		<td><input name="urlrewrite" id="urlrewrite" type="text" class="input" size="120" value="<?php echo htmlspecialchars($this->urlrewrite); ?>"  style="width:100%" /></td>
	</tr>
	<tr><td class="text"><strong>T&oacute;m t&#7855;t</strong></td>
		<td>
		<?php
			$oFCKeditor = new FCKeditor('desc') ;
			$oFCKeditor->BasePath	= $sBasePath ;
			$oFCKeditor->Height = 300 ;
			//$oFCKeditor->Config[ 'ToolbarLocation' ] = 'Out:xToolbar' ;
			$oFCKeditor->Value		= $this->desc;
			$oFCKeditor->Create() 
		?>		
		</td>
	</tr>
	<tr><td class="text"><strong>Th&#7913; t&#7921;</strong></td>
	<td><input type="text" size="2" name="view" class="input" value="<?php echo $this->view ?>" /></td></tr>
	<tr><td class="text"><strong>&#272;&#7863;c t&iacute;nh</strong></td>
	<td class="text"><?php $i=0;foreach($this->a_ctrl as $ctl=>$text){
	echo '<input type="checkbox" value="'.$ctl.'" name="a_ctrl" ';
	if($this->ctrl & $ctl) echo ' checked';
	echo ' />'.$text.'&nbsp;&nbsp;';++$i;
	if($i == 3) { echo '<br/>'; $i=0;}
	}?></td></tr>
	<tr><td><strong>&#7842;nh</strong></td>
	<td><input type="text" name="img1" class="input" id="idImg1" style="width:100%" value="<?php echo htmlspecialchars($this->img1); ?>"/></td></tr>
	<tr><td><strong>Ch&uacute; th&iacute;ch</strong></td>
	<td><input type="text" name="alt1" class="input" style="width:100%" value="<?php echo htmlspecialchars($this->alt1); ?>"/></td></tr>
	<tr><td><strong>T&#7843;i l&ecirc;n</strong></td>
	<td><iframe align="bottom" height="40" width="100%" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg1&FLid=<?php echo $this->catid; ?>&FFflag=<?php echo (int)$_GET['FFflag'] ?>"></iframe></td></tr>
	<tr><td><b>Giới hạn kích thước</b>:<input type="text"  value="<?php echo IMAGE_SIZE_CAT;?>" name="size_img1"  /></td><td><?php htmlview($this->url_img1,$this->img1,'border=1 id=idimgImg1','<img src="images/noimage.gif" id="idimgImg1" border="1" />');?></td></tr>
</tbody>
</table>
<input type="hidden" name="ctrl" value="" />
</form>	
<?php RTE::loadRTEDialog();?>
</body>
</html>
<script language="javascript" type="text/javascript">
window.top.document.title = self.document.title;
var self_id = '<?php echo $this->id;?>';
var self_type = '<?php echo $this->type;?>';
var frmItem = document.getElementById("idfrmItem");
var imgImg1 = document.getElementById('idimgImg1');
var imgImg = document.getElementById('idimgImg');
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo URL_CWD ?>/index.php?<?php echo urlmodify($this->alias.'id',NULL,$this->alias.'parentid',$this->parentid); ?>';
var url_newitem=url_self + '?<?php echo urlmodify('catid',$this->id,$this->alias.'id',0,'id',0); ?>';
function checkForm(f){
	if(f.name.value == ''){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p ti&ecirc;u &#273;&#7873;");
		f.name.focus();return false;
	}
	a = document.getElementsByName('a_ctrl');
	v = 0;
	for(i = 0;i < a.length; ++i){
		if(a.item(i).checked) v += parseInt(a.item(i).value);
	}
	f.ctrl.value = v;
	return true;
}
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
<script language="javascript" src="js/item-script.js"></script>
<?php @$rte->initRteObjectScript();?>

