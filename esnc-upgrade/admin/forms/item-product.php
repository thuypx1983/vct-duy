<html><head><title><?php echo $this->doctitle;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="../images/style.css" />
<link type="text/css" rel="stylesheet" href="../images/rtestyle.css"/>
<script language="javascript" src="../js/library.js"></script>
<script language="javascript" type="text/javascript" src="../js.php"></script>
<script language="javascript" src="../js/rte.js" type="text/javascript"></script>
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
div#attribute{
	font-size:11px;
	visibility:hidden;
	position:absolute;
	border:1px solid #96969D;
	border-top:0px;
	background:#FFFFFF;	
}
div#attributetext{
	padding:5px 0px 0px 20px;
	font-size:11px;
	background:url(images/selectbox.gif);
	width:136px;
	height:17px;
}
#idimgImg1,#idimgImg2{
	width:80px;
}
.tab{display:none; width:100%;}
.tabactive{display:table;width:100%;}
.tabhead{cursor:pointer;font-size:11px;font-weight:bold;color:black;width:100%;}
.tabheadactive{cursor:pointer;font-size:11px;font-weight:bold;color:green;width:100%;}

</style>
</head>
<body class="text">
<?php
//require fckeditor.
include_once("../fckeditor/fckeditor.php") ;
$sBasePath = URL_ADMIN.'fckeditor/' ;
?>
<form action="<?php echo "{$this->url}?act=".ACT_SAVE."&id={$this->id}&catid={$this->catid}" ?>" method="post" onSubmit="return checkForm(this);" enctype="multipart/form-data" id="idfrmItem" name="frmItem">	
<?php if (isset($_GET['PDkeyword'])){ ?>
<input name="qkey" type="hidden" value="<?php echo $_GET['PDkeyword']; ?>">
<?php }?>
<table width="100%" border="0">
<tr>
	<td width="17%">
	<div class="title">M&#227; </div>
	<div><input type="text" value="<?php echo $this->code; ?>" style="width:150px;"></div>
	</td>
	<td width="62%">
	<div style="float:left;width:49%;">
		<div class="title">T&#234;n </div>
		<div><input type="text" id="name" name="name" value="<?php echo $this->name; ?>" style="width:300px;" onBlur="getUrlRewrite();"></div>
	</div>
	<div style="float:left;width:49%;margin:0px 0px 0px 10px;">
		<div class="title">Url khi rewrite</div>
			<div><input type="text" id="urlrewrite" name="urlrewrite" value="<?php echo $this->urlrewrite; ?>" style="width:300px;"></div>
	</div>
	</td>
	<td width="21%">
		<div class="title">Tag&nbsp;&nbsp;&nbsp;&nbsp;<span class="style1">&nbsp;<a href="javascript:void" title="Tag là 1 dạng từ khóa tìm kiếm nhanh,giúp ta có thể xem các bài có nội dung hay chủ đề liên quan đến từ khóa(tag)">Tag là gì</a></span><a href="javascript:void" title="Tag là 1 dạng từ khóa tìm kiếm nhanh,giúp ta có thể xem các bài có nội dung hay chủ đề liên quan đến từ khóa(tag)">?</a></div>
		<div><input name="tag" type="text" class="input" style="width:200px;"  value="<?php echo htmlspecialchars($this->tag); ?>"/></div>	

	</td>
</tr>
<tr>
	<td>
		<div class="title">Nh&#224; s&#7843;n xu&#7845;t</div>
		<div><input name="manufacturer" type="text" class="input" style="width:150px;"  value="<?php echo htmlspecialchars($this->manufacturer); ?>" title="C&oacute; th&#7875; l&agrave; nh&agrave; s&#7843;n xu&#7845;t ho&#7863;c nh&agrave; nh&#7853;p kh&#7849;u"/></div>
	</td>
	<td>
	<div style="float:left;width:314px;">
		<div class="title">Ch&#250; th&#237;ch</div>
		<div><input name="include" type="text" class="input" style="width:100%;"  value="<?php echo htmlspecialchars($this->include); ?>" title=""/></div>
	</div><div style="float:left;width:314px;margin-left:5px;">
		<div class="title">Gi&#225; b&#225;n</div>
		<div><input name="saleprice" type="text" class="input" style="width:100%;"  value="<?php echo currency_format_number($this->saleprice); ?>" title="&#272;&#417;n v&#7883; t&iacute;nh c&#7911;a h&agrave;ng ho&aacute; d&ugrave;ng &#273;&#7875; hi&#7875;n th&#7883;"/></div>
	</div>
	</td>
	<td>
	<div class="title">Gi&#225; hi&#7875;n th&#7883;</div>
		<div><input name="price" type="text" class="input" style="width:100px;"  value="<?php echo htmlspecialchars($this->price); ?>" title="Gi&aacute; l&agrave; m&#7897;t x&acirc;u k&yacute; t&#7921; bao g&#7891;m c&#7843; &#273;&#417;n v&#7883; ti&#7873;n t&#7879;"/></div>
	</td>	
</tr>
<tr><td colspan="3">
	<div class="title">
		<span name="tabhead" class="tabhead" onClick="showTab('_summary',this);">T&oacute;m t&#7855;t</span>		
		<strong> | </strong><span onClick="showContent(this);" class="textbutton" style="color:blue">M&#244; t&#7843; chi ti&#7871;t</span>
		<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab('_cf0',this);">Thông tin tùy biến </span>
		&nbsp;|&nbsp;Ki&#7875;u 
	    <select class="input" name="type" onChange="switchType(this);">
<?php
	if(!isset($this->a_type[0])) $this->a_type[0]='Chung chung';
	foreach($this->a_type as $id=>$name){
		echo '<option value="';
		echo $id;
		if($this->type==$id) echo '" selected>';
		else echo '">';
		echo $name;
		echo '</option>';
	}
?>
	</select>
	</div>
	<div>
		<table style="width:100%;" cellpadding="0" cellspacing="0">
			<tbody id="tab_summary" class="tab">
				<tr><td>
				<div style="width:100% ">
				<?php
					$oFCKeditor = new FCKeditor('summary') ;
					$oFCKeditor->BasePath = $sBasePath ;
					$oFCKeditor->Height = 300 ;
					$oFCKeditor->Value = $this->summary;
					$oFCKeditor->Create() ;
                 ?>
				</div>
				</td></tr>
				</tbody>
				<tbody id="tab_cf0" class="tab">
				<tr><td>
				<div style="width:100% ">
				<?php
					$oFCKeditor = new FCKeditor('cf[0]') ;
					$oFCKeditor->BasePath = $sBasePath ;
					$oFCKeditor->Height = 300 ;
					$oFCKeditor->Value = $this->cf[0];
					$oFCKeditor->Create() ;
                 ?>
				</div>
				</td></tr>
			</tbody>
		</table>
	</div>
	</td>
</tr>
<tr>
	<td>
		<div class="title">&#272;&#7863;c t&#237;nh</div>
		<div>
			<div id="attributetext" onClick="SHOW('attribute');">&#272;&#259;c t&#237;nh hi&#7875;n th&#7883;</div>
			<div id="attribute">
			<?php 
			foreach($this->a_ctrl as $ctl=>$text){
				echo '<div><input type="checkbox" value="'.$ctl.'" name="ctrl[]" ';
				if($this->ctrl & $ctl) echo ' checked';
				echo ' />&nbsp;'.$text.'</div>';
			}?>
				<div style="text-align:right; "><a href="#" onClick="SHOW('attribute');return false;">&#272;&#243;ng</a></div>
			</div>
		</div>
	</td>
	<td>
		<div class="title">T&#7915; g&#7907;i nh&#7899;</div>
		<div><input name="keyword" class="input" type="input" value="<?php echo $this->keyword ?>" style="width:100%;"/></div>
	</td>
	<td>
		<div class="title">Th&#7913; t&#7921; hi&#7875;n th&#7883;</div>
		<div><input type="text" size="2" name="view" class="input" value="<?php echo $this->view; ?>" style="width:98%;"/></div>
	</td>
</tr>
<tr>
	<td>		
		<div style="text-align:center;"><img src="../images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG1,$this->img1 ? $this->img1:URL_ADMIN.'images/noimage.gif'," id='idimgImg1' align='absmiddle'");?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" name="img1" class="input" value="<?php echo htmlspecialchars($this->img1); ?>" style="width:250px;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="../document-upload-one.php?fn=doSaveImg1"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" name="alt1" class="input" value="<?php echo htmlspecialchars($this->alt1); ?>"  style="width:99%;" /></div>
	</td>
</tr>
<tr>
	<td valign="middle">		
		<div style="text-align:center;"><img src="../images/picture2.gif" align="absmiddle">&nbsp;<?php htmlview(URL_PRODUCT_IMG2,$this->img2 ? $this->img2:URL_ADMIN.'images/noimage.gif'," id='idimgImg2' align='absmiddle'");?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" name="img2" class="input" value="<?php echo htmlspecialchars($this->img2); ?>" style="width:250px;" />&nbsp;<iframe height="25" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="../document-upload-one.php?fn=doSaveImg2"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" name="alt2" class="input" value="<?php echo htmlspecialchars($this->alt2); ?>"  style="width:99%;" /></div>
	</td>
</tr>
</table>
<input type="hidden" name="contentfile" value="<?php echo $this->contentfile; ?>">
</form>
<?php RTE::loadRTEDialog();?>	
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
function switchType(o){
	self.location.href="<?php echo URL_SELF.'?'.urlmodify('type','');?>" + o.value;
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
	switch(id){
	case '_summary':
		if(!rte_summary ) rte_summary_init();break;
	case '_cf0':
		if(!rte_cf0 ) rte_cf0_init();break;
	}
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
<script language="javascript" src="../js/item-script.js"></script>
<script language="javascript">var oRte=(!isIE?new RTE(window.frames['frmRte'],document.getElementById('idname'),document.getElementById('idtdContainFrameRte'),document.getElementById('idtdContainTextArea'),URL_BASE):new RTEie(window.frames['frmRte'],document.getElementById('idname'),document.getElementById('idtdContainFrameRte'),document.getElementById('idtdContainTextArea'),URL_BASE));</script>
<?php dbclose(); ?>