<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->doctitle;?></title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css" />
<comment>
<link type="text/css" rel="stylesheet" href="images/style-nonie.css" />
</comment>
<link type="text/css" rel="stylesheet" href="images/rtestyle.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
<script language="javascript" src="js/rte.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
function SHOW(id){	
	var o = document.getElementById(id);	
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
	o.style.visibility ='hidden';
}
</script>
<style type="text/css">
#idimgImg1,#idimgImg2{
	width:80px;
}
div.title{	
	font-size:11px;
	font-weight:bold;
	margin:5px 0px 5px 0px;
}
div#attribute_cat,div#filter{
	font-size:11px;
	visibility:hidden;
	position:absolute;
	border:1px solid #96969D;
	border-top:0px;
	background:#FFFFFF;	
}
div#attributetext{	
	width:136px;
	height:17px;
}
div#attributetext span{cursor:default;}
span.help{cursor:help;}
</style>
</head>
<body class="text">
<form  style="display:inline;" action="<?php echo URL_SELF.'?act='.ACT_SAVE.'&WIid='.$this->id.'&id='.$this->id ?>" method="post" onSubmit="return checkForm(this);" enctype="multipart/form-data" id="idfrmItem">	
<input name="wid" type="hidden" value="<?php echo $this->wid; ?>">
<table width="100%" border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
<tr>
	<td width="20%">
	T&ecirc;n b&#432;&#7899;c
	<input type="text" onFocus="HIDE('attribute');" value="<?php echo $this->name; ?>" name="name" width="150px"/>
	</td>
	<td width="20%">
	Nh&oacute;m s&#7843;n ph&#7849;m
	<?php 
		$a_catid=explode(',',$this->catid);
		require_once(PATH_COMPLS.'product.php');
		$rs=catproductlist(CATPRODUCT_CTRL_SHOW, NULL, FALSE, NULL,10000,PRODUCT_CTRL_SHOW);
		$a_cat=array();
		while($a_cat[]= mysql_fetch_assoc($rs));
		array_pop($a_cat);
		mysql_free_result($rs);
		echo '<div id="attributetext" onClick="SHOW(\'attribute_cat\');">Nh&#7887;m s&#7843;n ph&#7849;m</div>';
		echo '<div id="attribute_cat">';
		foreach($a_cat as $cat){
			if($cat['cnt']!=CAT_FLAG_SUBCAT){
				echo '<div><input type="checkbox" value="'.$cat['id'].'" name="catid[]"';
				if(in_array($cat['id'],$a_catid)) echo ' checked';
				echo '  />&nbsp;'.$cat['name'].'</div>';
			}
		}
			echo '<div style="text-align:right; "><a href="#" onClick="SHOW(\'attribute_cat\');return false;">&#272;&#243;ng</a></div>';
		echo '</div>';
	?>
	</td>
	<td>
	Th&#7913; t&#7921; hi&#7875;n th&#7883;
	<input type="text" onFocus="HIDE('attribute');" name="view"  class="input" value="<?php echo $this->view; ?>" width="20px"/>
	</td>
	<td>
	&#272;&#7863;c t&iacute;nh
		<div id="attributetext" onClick="SHOW('attribute');">&#272;&#259;c t&#237;nh</div>
		<div id="attribute">
			<?php 
				foreach($this->a_ctrl as $ctl=>$text){
					echo '<div><input type="checkbox" value="'.$ctl.'" name="ctrl[]" ';
					if($this->ctrl & $ctl) echo ' checked';
					echo '  />&nbsp;'.$text.'</div>';
			}?>
			<div style="text-align:right; "><a href="#" onClick="SHOW('attribute');return false;">&#272;&#243;ng</a></div>
		</div>
	</td>
</tr>
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
window.top.document.title = self.document.title;
var url_rte = URL_ADMIN + 'rte.php?filename=<?php echo $this->contentfile;?>';
var self_id = '<?php echo $this->id;?>';
var self_type = '<?php echo $this->type;?>';
var frmItem = document.getElementById("idfrmItem");
var imgImg1 = document.getElementById('idimgImg1');
var imgImg2 = document.getElementById('idimgImg2');
var imgImg = document.getElementById('idimgImg');
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo dirname(URL_SELF) ?>/item-list.php?<?php echo urlmodify($this->alias.'id',NULL,$this->catalias.'id',$this->catid); ?>';
var url_newitem=url_self + '?<?php echo urlmodify('catid',$this->catid,$this->alias.'id',0,'id',0,'type',$_GET['type']); ?>';
function showContent(o){
	window.open(url_rte, "subWindow",sParams);
}
function checkForm(f){
	if(f.name.value == ''){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p ti&ecirc;u &#273;&#7873;");
		f.name.focus();return false;
	}
	return true;
}
</script>
<script language="javascript" src="js/item-script.js"></script>