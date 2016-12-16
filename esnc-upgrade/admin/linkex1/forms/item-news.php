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
<link type="text/css" rel="stylesheet" href="images/rtestyle.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
<script language="javascript" src="js/tooltip.js" type="text/javascript"></script>
<script language="javascript" src="js/tip.js" type="text/javascript"></script>
<script language="javascript" src="js/rte.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var activetab=null;
function showTab(id,o){
	if(activetab==id) return;
	document.getElementById('tab' + id).className='tab_active';
	if(activetab){
		document.getElementById('tab' + activetab).className='tab';
		document.getElementById('tabhead' + activetab).className='tabhead';
	}
	o.className='tabhead_active';
	activetab=id;
	if(id=='_content'){
		if(!rte_content) rte_content_init();
	}else if(id=='_summary'){
		if(!rte_summary) rte_summary_init();	
	}
}
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
<form action="<?php echo "{$this->url}?act=".ACT_SAVE."&id={$this->id}&catid={$this->catid}" ?>" method="post" onSubmit="return checkForm(this);" enctype="application/x-www-form-urlencoded" id="idfrmItem">	
<input name="type" type="hidden" value="<?php echo $this->type; ?>">
<table width="100%" border="0" onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
<tr>
	<td width="15%">
	<div class="title">Ng&#224;y t&#7841;o&nbsp;<?php showhelp('newstip[0]',800,30);?></div>
	<div><input type="text" name="created" value="<?php echo $this->created; ?>"  style="width:150px;" onfocus="this.select();" /></div>
	</td>
	<td width="60%">
	<div class="title">Ti&#234;u &#273;&#7873;<?php showhelp('newstip[1]',800,30);?></div>
	<div>
		  <input type="text" onFocus="HIDE('attribute');" name="name" value="<?php echo $this->name; ?>" style="width:100%;" />
	</div></td>
	<td>
		<div class="title">Ngu&#7891;n/t&#225;c gi&#7843;<?php showhelp('newstip[2]',800,30);?></div>
		<div><input type="text" onFocus="HIDE('attribute');" name="creator"  class="input" style="width:97%;"  value="<?php echo htmlspecialchars($this->creator); ?>" title="Gi&aacute; l&agrave; m&#7897;t x&acirc;u k&yacute; t&#7921; bao g&#7891;m c&#7843; &#273;&#417;n v&#7883; ti&#7873;n t&#7879;"/></div>
	</td>
</tr>
<tr><td colspan="3">
	<div class="title"><span onclick="showTab('_summary',this)" class="tabhead" id="tabhead_summary">M&#244; t&#7843; t&#243;m t&#7855;t</span><?php showhelp('newstip[6]',800,30);?>&nbsp;|&nbsp;<span onclick="showTab('_content',this);" class="tabhead" id="tabhead_content">M&#244; t&#7843; chi ti&#7871;t</span><?php showhelp('newstip[7]',800,40);?></div>
	<div style="width:100%; clear:both" id="tab_summary" class="tab"><?php
	$rte = new RTE(NULL,NULL,RTE_B_ALL);
	$rte->rename('rte_summary');
	$rte->show('summary',$this->summary,'120px');
	$rte->initRteObjectScript(FALSE);
	?></div>
	<div style="width:100%; clear:both" id="tab_content" class="tab"><?php
	$rte->rename('rte_content');
	$rte->show('content',$this->content,'120px');
	$rte->initRteObjectScript(FALSE);
	?></div>
</td></tr>
<tr>
	<td>
		<div class="title">&#272;&#7863;c t&#237;nh<?php showhelp('newstip[3]',800,30);?></div>
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
		<div class="title">T&#7915; g&#7907;i nh&#7899;<?php showhelp('newstip[4]',800,30);?></div>
		<div><input type="text" onFocus="HIDE('attribute');" name="keyword" class="input" value="<?php echo $this->keyword ?>" style="width:100%;"/>
		</div>
	</td>
	<td>
		<div class="title">Th&#7913; t&#7921; hi&#7875;n th&#7883;<?php showhelp('newstip[5]',800,30);?></div>
		<div><input type="text" onFocus="HIDE('attribute');" size="2" name="view" class="input" value="<?php echo $this->view; ?>" style="width:98%;"/></div>
	</td>
</tr>
<tr>
	<td>		
		<div style="text-align:center;"><img src="images/picture1.gif" align="absmiddle">&nbsp;<?php htmlview(URL_NEWS_IMG1,$this->img1 ? $this->img1:URL_ADMIN.'images/noimage.gif'," id='idimgImg1' align='absmiddle'");?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" onFocus="HIDE('attribute');" name="img1" class="input" value="<?php echo htmlspecialchars($this->img1); ?>" style="width:250px;margin-bottom:5px;" />&nbsp;
		<iframe height="30" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg1"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt1" class="input" value="<?php echo htmlspecialchars($this->alt1); ?>"  style="width:99%;" /></div>
	</td>
</tr>
<tr>
	<td valign="middle">		
		<div style="text-align:center;"><img src="images/picture2.gif" align="absmiddle">&nbsp;<?php htmlview(URL_NEWS_IMG2,$this->img2 ? $this->img2:URL_ADMIN.'images/noimage.gif'," id='idimgImg2' align='absmiddle'");?></div>
	</td>
	<td colspan="2">		
		<div><input type="text" onFocus="HIDE('attribute');" name="img2" class="input" value="<?php echo htmlspecialchars($this->img2); ?>" style="width:250px;margin-bottom:5px;" /><iframe height="30" style="padding-top:5px; " width="340" frameborder="0" scrolling="no" src="document-upload-one.php?fn=doSaveImg2"></iframe></div>
		<div class="title">Ch&#250; th&#237;ch </div>
		<div><input type="text" onFocus="HIDE('attribute');" name="alt2" class="input" value="<?php echo htmlspecialchars($this->alt2); ?>"  style="width:99%;" /></div>
	</td>
</tr>
</table>
<input type="hidden" name="lastcreated" value="<?php echo $this->created ?>" />
</form>
<?php RTE::loadRTEDialog();?>
</body>
</html>
<script language="javascript" type="text/javascript" defer>
window.top.document.title = self.document.title;
var self_id = '<?php echo $this->id;?>';
var self_type = '<?php echo $this->type;?>';
var frmItem = document.getElementById("idfrmItem");
var imgImg1 = document.getElementById('idimgImg1');
var imgImg2 = document.getElementById('idimgImg2');
var imgImg = document.getElementById('idimgImg');
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo dirname(URL_SELF) ?>/item-list.php?<?php echo urlmodify($this->alias.'id',NULL,$this->catalias.'id',$this->catid); ?>';
var url_newitem=url_self + '?<?php echo urlmodify('catid',$this->catid,$this->alias.'id',0,'id',0); ?>';
function checkForm(f){
	if(f.name.value == ''){
		parent.banner.setStatus("B&#7841;n ph&#7843;i nh&#7853;p ti&ecirc;u &#273;&#7873;");
		f.name.focus();return false;
	}
	if(rte_summary) rte_summary.rteToInput();
	if(rte_content) rte_content.rteToInput();
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
</script>
<script language="javascript" src="js/item-script.js"></script>