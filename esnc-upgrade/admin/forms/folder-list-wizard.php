<?php
$switch='&nbsp;';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->doctitle ?></title>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="images/style.css"/>
<comment>
<link type="text/css" rel="stylesheet" href="images/style-nonie.css" />
</comment>
<link type="text/css" rel="stylesheet" href="forms/style.css"/>
<script language="javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript">
function showSelected(child,parent){
	var n =  document.getElementById('name'+child.value);
	var v =  document.getElementById(child.value);
	if (child.checked){
		parent.style.backgroundColor = "#A9D2EB";		
		n.style.backgroundColor = "#A9D2EB";
		n.style.border = "1px solid #A9D2EB";
		v.style.backgroundColor = "#A9D2EB";
		v.style.border = "2px solid #A9D2EB";
	}else{
		parent.style.backgroundColor = "#FFFFFF";
		n.style.backgroundColor = "#FFFFFF";
		n.style.border = "1px solid #FFFFFF";
		v.style.backgroundColor = "#FFFFFF";
		v.style.border = "2px solid #FFFFFF";
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
<style type="text/css">
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
	border-top:0px;
	border-right:1px solid #ACA899;
	border-bottom:1px solid #ACA899;
	vertical-align:middle;
}
td.attribute{
	background:#FFFFFF;
}
</style>
</head>
<body style="margin:0px;" class="text">
<table style="margin:0px 0px 0px 0px;" width="100%" cellpadding="0" cellspacing="0"  onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
<thead>
        <tr>
                <th align="center" width="3%" ><input type="checkbox" onClick="javascript:setAll('id',this.checked);"></th>
                <th style="width:10px;">&nbsp;</th>
                <th width="30%"><a href="<?php echo $this->url.'?'.urlformat($this->q,$this->alias.'sortby',($this->sortby == SORTBY_NAME_ASC ? SORTBY_NAME_DESC : SORTBY_NAME_ASC)) ?>" class="search">T&ecirc;n</a></th>
                <th align="center" width="16%">Thay &#273;&#7893;i</th>
                <th align="center" width="12%">N&#7897;i dung</th>
                <th align="center" width="8%" nowrap><a href="<?php echo $this->url.'?'.urlformat($this->q,$this->alias.'sortby',($this->sortby == SORTBY_VIEW_ASC ? SORTBY_VIEW_DESC : SORTBY_VIEW_ASC)) ?>" class="search">Th&#7913; t&#7921;&nbsp;</a></th>
                <th >&#272;&#7863;c t&iacute;nh</th>
        </tr>
</thead>
<tbody>
       <tr id="iddlgNewGroup" style="display:none" height="24px">
				<form action="<?php echo URL_SELF ?>" id="idfrmNewGroup" target="content" onSubmit="return checkForm(this);">
                <td align="center">&nbsp;</td>
                <td class="folder_icon">&nbsp;</td>
                <td >
				<input type="hidden" name="act" value="<?php echo ACT_ADD ?>" />
				<input type="hidden" name="<?php echo $this->alias; ?>parentid" value="<?php echo $this->parentid ?>" />
				<input type="hidden" name="parentid" value="<?php echo $this->parentid ?>" />
				<input type="text" class="text" name="name" size="40" style="border:1px solid #000000;width:auto" value="M&#7899;i..." onFocus="clearTextBox(this);"  onClick="clearTextBox(this);"/>
                </td>
                <td align="center"><span onClick="submitNewGroup();" class="textbutton">T&#7841;o</span><strong>|</strong><span class="textbutton" onClick="doCancel();">Ng&#7915;ng</span></td>
                <td align="center" ><input type="image" src="images/save.gif" class="imgbutton"/></td>
				<td align="center" ><input type="text" size="2" name="view" class="input"/></td>
				<td align="center" title="N&#7871;u &#273;&aacute;nh d&#7845;u th&igrave; nh&oacute;m s&#7869; hi&#7875;n th&#7883;, n&#7871;u kh&ocirc;ng nh&oacute;m s&#7869; &#7849;n" style="cursor:help "><input type="checkbox" class="input" name="ctrl" value="1" checked/> <label for="ctrl">Hi&#7875;n th&#7883;</label><input type="image" src="images/save.gif" class="imgbutton"/></td>
				</form>
        </tr>
        <?php while($row = mysql_fetch_array($this->rs)){//begin row scan
                $ctrl_text = "";
                foreach($this->a_ctrl as $ctl => $text) if($row['ctrl'] & $ctl) $ctrl_text .= $text."|";
        ?>
        <tr>
                <td align="center" style="background-color:#EFEDDE;"><input type="checkbox" name="id" value="<?php echo $row['id']; ?>"  onClick="showSelected(this,this.parentNode.parentNode);"></td>
                <td class="folder_icon" onClick="self.location.href=&quot;<?php echo URL_CWD."item-list.php?{$this->alias}id={$row['id']}" ?>&quot;">&nbsp;</td>
                <td >
				<input type="text" size="40" class="text" id="<?php echo "name{$row['id']}" ?>" style="border:1px solid #FFFFFF; width:auto; cursor:pointer<?php if (($row['ctrl']&1)==0) echo ";color:#CCCCCC"?>" value="<?php echo $row['name']; ?>" readonly="yes" onDblClick="self.location.href=&quot;<?php echo URL_CWD."item-list.php?{$this->alias}id={$row['id']}" ?>&quot;" title="Nh&#225;y &#273;&#250;p chu&#7897;t &#273;&#7875; m&#7903;"/>
                </td>
                <td align="center" nowrap><span onClick="<?php echo "rename({$row['id']},this)"; ?>;" class="textbutton">T&ecirc;n</span><strong>|</strong><span <?php if($row['flag']==0) echo 'class="textbutton" style="color:#FF0000 " onClick="doDelGroup('.$row['id'].','.CAT_FLAG_EMPTY.');return false;"'; else echo 'class="text" style="color:#CCCCCC" ';?>>Xo&aacute;</span></td>
                <td align="center" style="cursor:pointer">
					<a href="<?php echo URL_CWD."item-list.php?{$this->alias}id={$row['id']}" ?>" class="item item_icon">&nbsp;</a>
				</td>
                <td align="center"><input type="text" size="2" id="<?php echo $row['id']; ?>" class="input" value="<?php echo $row['view']; ?>" name="view" style="width:auto;border:2px solid #FFFFFF;" onMouseOver="hover(this);" onMouseOut="out(this);"></td>
                <td align="left" style="cursor:help" title="<?php echo $ctrl_text; ?>"><?php echo ctrl_format($row['ctrl']);?></td>
        </tr>
        <?php } //end row scan?>
</tbody>
<tfoot>
        <tr>
			<td >&nbsp;</td>
			<td align="center" ><?php echo $switch; ?></td>
		  <td colspan="3">			
<?php ctrl_setbox($this->a_ctrl,$this->status);
	if($this->pagecount > 1){echo '<span class="text" >::</span>';
	$q=urlformat($this->q,$this->alias.'page','');
	for($p = 1; $p <= $this->pagecount; ++$p){ if($p != $this->page) {?>
		<a href="<?php echo URL_CWD."{$this->url}?{$q}{$p}" ?>" class="search">[<?php echo $p ?>]</a>
	<?php }else{ ?><span class="text" ><?php echo $p ?></span>
	<?php }
	 }
}
?>	</td>
			<td align="center" ><div class="imgbutton" id="bnSave" style="width:22px;height:22px;" onClick="doSave();" title="Ghi l&#7841;i thay &#273;&#7893;i th&#7913; t&#7921;">&nbsp;</div></td>
			<td><?php ctrl_filterbox($this->a_ctrl,$this->ctrl)?></td>
        </tr>
</tfoot>
</table>
<form action="<?php echo URL_CWD.'item-list.php' ?>" method="get" id="idfrmSearch">
<input type="hidden" value="<?php echo ACT_SEARCH ?>" name="act" />
<table width="350px">
	<tr><th colspan="2">T&igrave;m ki&#7871;m</th></tr>
	<tr><td>T&#7915; kho&aacute;</td><td><input type="text" class="input search_hint" name="q" value="<?php echo $_GET['q']; ?>"  /></td></tr>
	<tr><td align="center" colspan="2"><input type="submit" value="Th&#7921;c hi&#7879;n" class="button" />&nbsp;<input type="button" value="&#272;&oacute;ng" class="button" onclick="noSearch();"/></td></tr>
</table>
</form></body>
</html>
<script language="javascript" type="text/javascript">
window.top.document.title=self.document.title;//set title for window
var url_self = '<?php echo URL_SELF;?>';
var url_cwd = '<?php echo URL_CWD;?>';
var url_ctrl = url_self + '?' + '<?php echo urlmodify('id',NULL,'ctrl',''); ?>';
var url_filter = url_self + '?' + '<?php echo urlmodify('act',ACT_SEARCH,$this->alias.'ctrl',''); ?>';
var url_sort = url_self + '?' + '<?php echo urlmodify('act',ACT_REORDER,'idvalue',''); ?>';
var url_remove = url_self + '?' + '<?php echo urlmodify('act',ACT_REMOVE,'id','') ?>';
var url_move = url_self + '?' + '<?php echo urlmodify('act',ACT_MOVE,'id','') ?>';
var self_type='<?php echo $this->type ?>';
var grandparentid = '<?php echo $this->grandparentid;?>';
var catalias='<?php echo $this->alias ?>';
var itemalias='<?php echo $this->itemalias ?>';
var dlgNewGroup=document.getElementById('iddlgNewGroup');
var frmNewGroup=document.getElementById('idfrmNewGroup');
var frmSearch = document.getElementById('idfrmSearch');
</script>
<script language="javascript" src="js.php"></script>
<script language="javascript" src="js/folderlist.js"></script>
<script language="javascript" type="text/javascript">
url_newitem='#';
function doNewItem(){
	parent.banner.setStatus('L&#7895;i,nh&oacute;m &#273;&atilde; c&oacute; nh&oacute;m con, nh&oacute;m l&agrave; g&#7889;c,<br />&#273;ang &#7903; trong m&#7885;i nh&oacute;m,ho&#7863;c nh&oacute;m &#273;&atilde; b&#7883; xo&aacute;.');
	return false;
}
</script>
