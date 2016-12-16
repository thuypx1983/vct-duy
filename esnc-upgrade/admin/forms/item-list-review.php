<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $this->doctitle;?></title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css">
<link type="text/css" rel="stylesheet" href="forms/style.css">
<comment>
<link type="text/css" rel="stylesheet" href="images/style-nonie.css" />
</comment>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>

<style>
thead tr{height:15px;background-color:#EFEDDE;}
thead tr th{
	font-weight:normal;
	border-right:1px solid #ACA899;
	border-bottom:1px solid #ACA899;
}
tbody tr td{
	padding:1px;
	border-right:1px solid #C0C0C0;
	border-bottom:1px solid #C0C0C0;
}
tfoot tr{height:15px; background-color:#EFEDDE;}
tfoot tr td{
	border-right:1px solid #ACA899;
	border-bottom:1px solid #ACA899;
	vertical-align:middle;
}
td.attribute{
	background:#FFFFFF;
}
DIV.review_summary{
	cursor:default;
	width:100%;
	overflow:hidden;
}
TR.review_line DIV.review_summary{
	line-height:14px;
}
TR.review_line-hover DIV.review_summary{
	height:auto;
}
TR.review_line:hover DIV.review_summary{
	height:auto;
}
</style>
<!--[if lte IE 6]>
<style type="text/css">
TR.review_line,TR.review_line-hover{
	behavior:url(<?php echo URL_ADMIN ?>js/IEhover.htc);
}
</style>
<![endif]-->
<script language="javascript" type="text/javascript">
function showSelected(child,parent){
	var v =  document.getElementById(child.value);
	if (child.checked){
		parent.style.backgroundColor = "#A9D2EB";		
//		v.style.backgroundColor = "#A9D2EB";
//		v.style.border = "2px solid #A9D2EB";
	}else{
		parent.style.backgroundColor = "#FFFFFF";
//		v.style.backgroundColor = "#FFFFFF";
//		v.style.border = "2px solid #FFFFFF";
	}
}
function hover(o){
	var c = document.getElementsByName('id');
	var l = c.length;
	for (var i = 0; i<l;i++){
		if ((c[i].checked) &&(o.id == c[i].value)){
			o.style.border='2px solid #FFFFFF';
			return;
		}
	}
	o.style.border='2px solid #000000';
}
function out(o){
	var c = document.getElementsByName('id');
	var l = c.length;
	for (var i = 0; i<l;i++){
		if ((c[i].checked) &&(o.id == c[i].value)){
			o.style.border='2px solid #A9D2EB';
			return;
		}
	}	
	o.style.border='2px solid #FFFFFF';
}

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
</head>
<body style="margin: 0px 0px 0px 0px" class="text"><table id="item-list" width="100%" cellpadding="0" cellspacing="0"  onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
<form name="form" method="post" action="<?php echo URL_SELF.'?act='.ACT_ADD.'&PDid='.$this->productid.'&CPid='.$this->catproductid ?>" class="head"></form>
	<thead>
	<tr>
		<th><input type="checkbox" onClick="javascript:setAll('id',this.checked);"></th>		
		<th width="50%"><?php echo COL2_NAME;echo '<b>'.$this->productname.'</b>' ?></th>
		<th width="10%"><a href="<?php echo URL_SELF.'?'.urlmodify($this->alias.'sortby',($this->sortby == SORTBY_ID_ASC ? SORTBY_ID_DESC : SORTBY_ID_ASC)) ?>" class="search"><?php echo COL3_NAME ?></a></th>
		<th width="10%"><?php echo COL4_NAME ?></th>
		<th width="10%"><?php echo COL6_NAME ?></th>
		<th width="10%">Điểm</th>
		<th width="10%">Đánh giá</th>
	</tr>
	</thead>
	<tbody>
	<?php 
		$itemurl=URL_CWD.'item.php?'.urlformat($this->q,$this->alias.'id','');
	while ($row = mysql_fetch_array($this->rs)){  //begin row scan
		$ctrl_text = "";
		foreach($this->a_ctrl as $ctl => $text) if($row['ctrl'] & $ctl) $ctrl_text .= $text."|";
	?>
	<tr class="review_line">
		<td align="center" style="background-color:#EFEDDE;"><input type="checkbox" name="id" value="<?php echo $row[0]; ?>" onClick="showSelected(this,this.parentNode.parentNode);" /></td>
		<td align="left">
			<div class="review_summary">
				<a  style="<?php if (($row['ctrl']&1)==0) echo "color:#CCCCCC"; ?>" href="<?php echo URL_ADMIN.'product/review.php?act='.ACT_EDIT?>&PDid=<?php echo $this->productid?>&CPid=<?php echo $this->catproductid?>&id=<?php echo $row['id']?>"><?php echo $row['content']; ?></a>
			</div>
		</td>
		<td align="center"><?php echo (empty($row[2]))?'(none)':$row[2]; ?></td>
		<td ><div style="width:250px;height:14px;overflow:hidden "><?php echo $row[3] ?>-<?php echo $row[4] ?></div></td>
		<td align="lefl" style="cursor:help" title="<?php echo $ctrl_text ?>"><?php echo ctrl_format($row['ctrl']) ?>&nbsp;</td>
		<td><?php echo $row['summary']?></td>
		<td><?php echo $row['extra']?></td>
	</tr>	
	<?php } //end row scan ?>
	</tbody>
	<tfoot>
	<tr>		
        <td align="center">&nbsp;</td>
		<td colspan="3">
			<div id="attributetext" style="margin:1px 0px 1px 5px; " onClick="SHOW('attribute');HIDE('filter');"><span>Thi&#7871;t l&#7853;p &#273;&#7863;c t&#237;nh</span></div>
				<div id="attribute" style="margin:1px 0px 1px 5px; border-top:1px solid #96969D;border-right:0px;border-bottom:0px;">
				<table width="250" cellspacing="0" cellpadding="0" border="0"><tbody>
				<tr><td class="attribute">&nbsp;</td><td class="attribute" align="center">Thi&#7871;t l&#7853;p</td><td class="attribute" align="center">Hu&#7927; b&#7887;</td></tr>
			<?php
			$i=1; 
			foreach($this->a_ctrl as $ctl=>$text){
			echo '<tr><td class="attribute">&nbsp;&nbsp;'.ctrl_format($ctl).$text.'</td>
				<td class="attribute" align="center"><input  type="checkbox" name="setctrl" value="'.$ctl.'" onClick="exclusiveCheck(this,this.parentNode.nextSibling.firstChild)"></td>'
				.'<td class="attribute" align="center"><input  type="checkbox" name="unsetctrl" value="'.$ctl.'" onClick="exclusiveCheck(this,this.parentNode.previousSibling.firstChild)"></td></tr>';				
			}
			if(is_array($this->a_status)){
				foreach($this->a_status as $ctl=>$text){
				echo '<tr><td class="attribute">&nbsp;&nbsp;'.$text.'</td>
					<td class="attribute" align="center"><input  type="radio" name="status" value="'.$ctl.'" ></td>
					<td class="attribute">&nbsp;</td>
					</tr>';								
				$i=$i+1;	
				}
			}
			?>
				<tr><td colspan="3" align="center"><input onClick="setCtrl(ACT_SETCTRL);" type="button" value="Th&#7921;c hi&#7879;n" class="button"><input class="button" onClick="HIDE('attribute')" type="button" value="B&#7887; qua"></td></tr>
				</tbody></table>				
			</div>
<?php if($this->pagecount > 1){echo '<span class="text" >::</span>';
	for($p = 1; $p <= $this->pagecount; ++$p){ if($p != $this->page) {?>
		<a href="<?php echo URL_SELF.'?'.urlmodify('RVpage',$p,'RVpagesize',$this->pagesize); ?>" class="search">[<?php echo $p ?>]</a>
	<?php }else{ ?><span class="text" ><?php echo $p ?></span>
	<?php }
	 }
}
?>		
		</td>
		<td><?php ctrl_filterbox($this->a_ctrl,$this->ctrl)?></td>
		</tr>
	</tfoot>
</table>
<form action="<?php echo URL_SELF ?>" method="get" id="idfrmSearch">
<input type="hidden" value="<?php echo ACT_SEARCH ?>" name="act" />
<table width="350px" style="line-height:20px ">
	<tr><th colspan="2" style="line-height:20px; ">T&igrave;m ki&#7871;m</th></tr>
	<tr><td nowrap>T&#7915; kho&aacute;</td><td><input type="text" class="input search_hint" name="q" value="<?php echo $_GET['q']; ?>"  /></td></tr>
	<tr><td nowrap>&#272;&#7863;c t&iacute;nh</td>
		<td><?php foreach($this->a_ctrl as $ctl => $text){?>
		<div class="ctrl_list"><input type="checkbox" class="input input_mini" value="<?php echo $ctl ?>" <?php if($this->ctrl & $ctl) echo checked ?> name="<?php echo ALIAS ?>ctrl[]" /><?php echo $text ?></div>
		<?php }?>
		</td></tr>
	<tr><td nowrap>T&igrave;m theo ID</td><td><input type="text" class="input search_hint" name="<?php echo ALIAS ?>id" value="<?php echo $_REQUEST[ALIAS.'id'] ?>" /> </td></tr>
	<tr><td align="center" colspan="2"><input type="submit" value="Th&#7921;c hi&#7879;n" class="button" />&nbsp;<input type="button" value="&#272;&oacute;ng" class="button" onclick="noSearch();"/></td></tr>
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript" defer>
window.top.document.title = self.document.title;
var self_type='<?php echo $this->type ?>';
var url_self = '<?php echo URL_SELF;?>';
var url_up = '<?php echo URL_CWD ?>item-list.php?CPid=<?php echo $this->catproductid ?>&PDpage=<?php echo $PDpage ?>&PDpagesize=<?php echo $PDpagesize ?>';
var url_ctrl = '<?php echo URL_SELF.'?'.urlmodify('act',ACT_SETCTRL,'ctrl',NULL,'nctrl',NULL); ?>';
var url_rename = '#';
var url_filter = '<?php echo URL_SELF.'?'.urlmodify('act',ACT_SEARCH,$this->alias.'ctrl',''); ?>';
var url_save = '#';
var url_del = '<?php echo URL_SELF.'?'.urlmodify('act',ACT_REMOVE,'id',''); ?>';
var url_move = '#';
var url_copy = '#';
var frmSearch = document.getElementById('idfrmSearch');
</script>
<script language="javascript" type="text/javascript">
function doUp(){
	self.location.href=url_up;
}
function setCtrl(act){
	v = getChecked('id');
	if(v==''){
		parent.banner.setStatus("Ch&#432;a c&oacute; &#273;&#7889;i t&#432;&#7907;ng n&agrave;o &#273;&#7921;oc ch&#7885;n");
		return;
	}
	var nctrl=getChecked('unsetctrl');
	var ctrl = getChecked('setctrl');
	self.location.href=url_ctrl + '&ctrl=' + ctrl + '&nctrl=' + nctrl + '&id=' + encodeURIComponent(v);
}
function filterFeature(name){
	v = document.getElementsByName(name);
	var t=0;
	for(i=0;i<v.length;++i)
		if(v.item(i).checked) t |= v.item(i).value;
	self.location.href = url_filter + t;
}
function exclusiveCheck(o,ex){
	if(o.checked) ex.checked=false;
}
function doDel(){
	var v = getChecked('id');
	if(v != '' && parent.banner.ask("Ban co thuc su muon xoa khong?")) {
		//alert(url_del + v);
		self.location.href = url_del + encodeURIComponent(v);//only remove empty
	}else
		parent.banner.setStatus("Ch&#432;a c&oacute; &#273;&#7889;i t&#432;&#7907;ng n&agrave;o &#273;&#7921;oc ch&#7885;n");
}
function doNewItem(){
	document.form.submit();
}
</script>
