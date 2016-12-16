<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->doctitle;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link type="text/css" rel="stylesheet" href="images/style.css" />
<link type="text/css" rel="stylesheet" href="forms/style.css">
<script language="javascript" src="js/library.js"></script>
<script language="javascript" src="js.php"></script>
<script language="javascript" type="text/javascript">
function createXmlObject(){
    var xmlobj = null;
    try{
        if (window.ActiveXObject){
            xmlobj = new ActiveXObject("Microsoft.XMLHTTP");
        }else{
            xmlobj = new XMLHttpRequest(); 
        }
		return xmlobj;
    }
    catch(e){
        alert("Your browser did not support Ajax");
        return false;
    }    
}
function posX(obj){
	var vX=0;
	if(obj.x)vX=obj.x;
	else if(obj.offsetParent)
		while(obj.offsetParent){
			vX+=obj.offsetLeft;
			obj=obj.offsetParent;
		}
	return vX;
}
function posY(obj){
	var vX=0;
	if(obj.y)vX=obj.y;
	else if(obj.offsetParent)
		while(obj.offsetParent){
			vX+=obj.offsetTop;
			obj=obj.offsetParent;
		}
	return vX;
}
function showInput(obj,url,title,type){
	if (document.getElementById('note')) document.body.removeChild(document.getElementById('note'));	
	var d        = document.createElement('div');
	var textbox  = document.createElement('input');
	var d1       = document.createElement('div');
	var c        = document.createElement('span');
	c.innerHTML  = '<img src="images/close_box.gif" class = "closebutton" align="absmiddle"/>';
	c.onclick    = function (){
		document.body.removeChild(document.getElementById('note'));
	}
	d.className  = 'note';
	d.setAttribute ('id','note');
	d1.className = 'notetitle';
	d1.innerHTML = title;
	textbox.setAttribute('type','text');
	textbox.onfocus = function (){
		this.select();
	};	
	textbox.className='notevalue';
	d.appendChild(d1);
	d1.appendChild(c);
	d.appendChild(textbox);
	d.style.position = 'absolute';
	d.style.top  = (posY(obj)+15)+'px';
	d.style.left = posX(obj)+'px';	
	document.body.appendChild(d);
	var o = new createXmlObject();
	o.open('GET',url,true);
	o.onreadystatechange = function (){
		if (o.readyState == 4){
			if (o.status == 200){
				var value    = linkExchangeRewrite(o.responseText);
				if ((type!=null)&&(type=='normal')){
					var cont = document.createElement('div');
					cont.className = "notecontent";
					cont.innerHTML = value;
					d.removeChild(textbox);					
					d.appendChild(cont);					
				}
				else{
				value        = (value=='')?'Sorry, it\'s unavailable':value;
				textbox.setAttribute('value',value);
				textbox.setAttribute('title',value);
				}
			}
		}
		else textbox.setAttribute('value','Loading...');
	}
	o.send(null);
}
</script>
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
div.note{
	
	border    :1px solid #999999;
	background    :#FFFFFF;
	z-index:1;
	width:300px;
	height:50px;
	overflow:hidden;	
}
div.notetitle{
	border-bottom:1px solid #CCCCCC;
	background:#EFEDDE;
	font-weight:bold;
	padding:3px;
}
img.closebutton{
	margin:0px 0px 0px 207px;
	cursor:pointer;
}
input.notevalue{
	width:290px;
	border:0px;
	margin:5px 3px 5px 3px;
	text-align:left;
}
div.notecontent{
	margin:5px 0px 0px 3px;
}
</style>
<script language="javascript" type="text/javascript">
function showSelected(child,parent){
	var v =  document.getElementById(child.value);
	if (child.checked){
		parent.style.backgroundColor = "#A9D2EB";		
		v.style.backgroundColor = "#A9D2EB";
		v.style.border = "2px solid #A9D2EB";
	}else{
		parent.style.backgroundColor = "#FFFFFF";
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
</head>
<body style="margin: 0px 0px 0px 0px" class="text"><table id="item-list" width="100%" cellpadding="0" cellspacing="0"  onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
	<thead>
	<tr>
		<th><input type="checkbox" onClick="javascript:setAll('id',this.checked);"></th>		
		<th width="<?php echo COL2_WIDTH ?>" colspan="2"><?php echo COL2_NAME ?></th>
		<th width="<?php echo COL3_WIDTH ?>"><a href="<?php echo $this->url.'?'.urlformat($this->q,$this->alias.'sortby',($this->sortby == SORTBY_CREATED_ASC ? SORTBY_CREATED_DESC : SORTBY_CREATED_ASC)) ?>" class="search"><?php echo COL3_NAME ?></a></th>
		<th width="<?php echo COL4_WIDTH ?>"><?php echo COL4_NAME ?></th>
		<th width="<?php echo COL5_WIDTH ?>"><a href="<?php echo $this->url.'?'.urlformat($this->q,$this->alias.'sortby',($this->sortby == SORTBY_VIEW_ASC ? SORTBY_VIEW_DESC : SORTBY_VIEW_ASC)) ?>" class="search"><?php echo COL5_NAME ?></a></th>
		<th ><?php echo COL6_NAME ?></th>	</tr>
	</thead>
	<tbody>
	<?php 
		$itemurl=URL_CWD.'item.php?'.urlformat($this->q,$this->alias.'id','');
	while ($row = mysql_fetch_array($this->rs)){ //begin row scan
		$ctrl_text = "";
		foreach($this->a_ctrl as $ctl => $text) if($row['ctrl'] & $ctl) $ctrl_text .= $text."|";
	?>
	<tr>
		<td align="center" style="background-color:#EFEDDE;">
			<input type="checkbox" name="id" value="<?php echo $row[0]; ?>" onClick="showSelected(this,this.parentNode.parentNode);">
		</td>
		<td align="left" style="border-right:0px; ">
			<span onClick="urlgo('<?php echo $itemurl.$row[0] ?>');" style="margin:0px 0px 0px 5px;cursor:pointer;<?php if (($row['ctrl']&1)==0) echo "color:#CCCCCC"; ?>">
				<?php echo $row[1] ? $row[1]: '(none)'; ?>
			</span>
		</td>
		<td align="right" style="border-left:0px; ">
			<?php 
			@$k=$row['ctrl'];
				echo (($row['ctrl']&BANNER_CTRL_LINK)==BANNER_CTRL_LINK)?'<a href="#" class="b_lookupbanner" onClick="showInput(this,\''.URL_CWD.'lookupbanner.php?BNid='.$row['id'].'\',\'V&#7883; tr&iacute; li&ecirc;n k&#7871;t\');return false;" >&nbsp;</a>':'&nbsp;'; 
				echo (($row['ctrl']&BANNER_CTRL_LINK)==BANNER_CTRL_LINK)?'<a href="#" class="b_checkbanner" onClick="showInput(this,\''.URL_CWD.'checker.php?BNid='.$row['id'].'\',\'Ki&#7875;m tra link\',\'normal\');return false;">&nbsp;</a>':'&nbsp;';
			?>
		</td>
		<td align="center" title="<?php echo $row[2]; ?>"><?php echo $row[2]; ?></td>
		<td align="left" >
			<div style="width:190px;overflow:hidden;white-space:nowrap;">
				<?php 
					if(preg_match(REGEX_HREF,$row[3],$match)) 
						echo 'href='.$match[2]; 
					else 
						echo htmlspecialchars($row[3]); 
				?>
			</div>
		</td>
		<td align="center">
			<input type="text" style="width:auto;border:2px solid #FFFFFF;text-align:right;" onMouseOver="hover(this);" onFocus="hover(this);" onMouseOut="out(this);" size="5" id="<?php echo $row['id']; ?>" class="input" value="<?php echo $row[4]; ?>" name="view" />
		</td>
		<td align="lefl" style="cursor:help" title="<?php echo $ctrl_text ?>">
			<?php echo ctrl_format($row['ctrl']) ?>&nbsp;
			<?php echo status_format($row['status'],$this->a_status); ?>
		</td>		
	</tr>	
	<?php }//end row scan ?>
	</tbody>
	<tfoot>
	<tr>		
        <td align="center"><a href="<?php echo URL_CWD ?>index.php?<?php echo $this->catalias."parentid={$this->catid}" ?>" class="item item_icon">&nbsp;</a></td>
		<td colspan="4">
<?php 
	ctrl_setbox($this->a_ctrl,$this->a_status);
	if($this->pagecount > 1){
		echo '<span class="text" >::</span>';
		$q=urlformat($this->q,$this->alias.'page','');
		for($p = 1; $p <= $this->pagecount; ++$p){ 
			if($p != $this->page)
				echo '<a href="',$this->url,'?',$q,$p,'"" class="search">',$p,'</a>';
			else
				echo '<span class="text" >',$p,'</span>';
		}
	}
	echo '<span>::</span>('.$this->rowcount.' records)';
?>		
		</td>
		<td align="center" ><div id="bnSave" class="imgbutton" style="width:22px;height:22px;" onClick="doSave();" title="Ghi l&#7841;i thay &#273;&#7893;i th&#7913; t&#7921;">&nbsp;</div></td>
		<td colspan="2"><?php ctrl_filterbox($this->a_ctrl,$this->ctrl)?></td>
	</tr>
	</tfoot>
</table>

<?php $CBid = $_GET['CBid'];
if(($k&BANNER_CTRL_LINK)==BANNER_CTRL_LINK) echo '<table align="right" bgcolor="#CCCCCC"><tr><td><a href="forms/test-link-exchange.php?CBid='.$CBid.'">Kiểm tra liên kết ngược</a>&nbsp;|&nbsp;<a href="forms/test-link-exchange.php?CBid1='.$CBid.'"></a>&nbsp;</td></tr></table>';
?>
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
	<tr><td nowrap>Tr&#7841;ng th&aacute;i</td>
		<td><?php foreach($this->a_status as $ctl => $text){?>
		<div class="ctrl_list"><input type="checkbox" class="input input_mini" value="<?php echo $ctl ?>" <?php if($this->ctrl & $ctl) echo checked ?> name="<?php echo ALIAS ?>status[]" /><?php echo $text ?></div>
		<?php }?>
		</td></tr>
	<tr><td nowrap>Ng&agrave;y s&#7917;a</td><td><input type="text" class="input" name="<?php echo ALIAS ?>created1" size="15" value="<?php echo $_GET[ALIAS.'created1']; ?>"  />
	- <input type="text" class="input" name="<?php echo ALIAS ?>created2" size="15" value="<?php echo $_GET[ALIAS.'created2']; ?>"  />
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
var url_up = url_self + '?<?php echo $this->catalias.'parentid='.$this->grandparentid; ?>';
var url_ctrl = url_self + '<?php echo '?'.urlmodify('ctrl','','nctrl',''); ?>';
var url_rename = url_self + '?<?php echo urlmodify('id',NULL,'name',NULL,'act','');?>';
var url_filter = url_self + '?<?php echo urlmodify('act',ACT_SEARCH,$this->alias.'ctrl',''); ?>';
var url_save = url_self + '?<?php echo urlmodify('act',ACT_REORDER,'idvalue','') ?>';
var url_del = url_self + '?<?php echo urlmodify('catid',$this->catid,'act',ACT_REMOVE,'id',''); ?>';
var url_move = url_self + '?<?php echo urlmodify('act',ACT_MOVE,'catid',$this->catid,'id',''); ?>';
var url_copy = url_self + '?<?php echo urlmodify('act',ACT_COPY,'catid',$this->catid,'id',''); ?>';
var frmSearch = document.getElementById('idfrmSearch');
</script>
<script language="javascript" src="js/item-list.js"></script>
<script language="javascript" type="text/javascript">
<?php if($this->catid) echo 'var url_newitem="'.dirname(URL_SELF).'/item.php?'.urlmodify('catid',$this->catid,$this->alias.'id',NULL).'";'; 
else echo 'function doNewItem(){window.alert("Day la mot ket qua tim kiem khong thuoc nhom nao.\nBan phai chon mot nhom o cay ben trai\nroi moi tao doi tuong duoc");}' ;?>;
</script>
<script language="javascript" src="<?php echo URL_BASE ?>js/admin_overload.js" type="text/javascript"></script>
<?php dbclose(); ?>
