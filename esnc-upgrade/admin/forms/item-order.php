<?php 
function map($d){
	$d = (empty($d))?'&nbsp;NA':$d;
	return $d;
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title><?php echo $this->doctitle ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link type="text/css" rel="stylesheet" href="images/style.css" />
<script language="javascript" src="js/library.js"></script>
<script language="javascript" type="text/javascript" src="js.php"></script>
</script>
<style type="text/css">
table{
	border-top:1px solid #CCCCCC;
	border-left:1px solid #CCCCCC;
}

th.cell,td.cell{
	border-bottom:1px solid #CCCCCC;
	border-right:1px solid #CCCCCC;
}
tr.text *{
	border:0px;
}
div#tab_active{
	display:block;
}
#tab_0,#tab_1,#tab_2{
	display:none;
	clear:both;
}
div.tab{
	float:left;	
	width:89px;
	height:20px;
	padding:3px 0px 0px 2px;
	text-align:center;
	cursor:pointer;
	position:relative;
	z-index:2;
}
div.tab_container{
	background-color:#9DACBF;
	width:100%;
	height:22px;
	padding:5px 0px 0px 10px;
	position:relative;
	z-index:3;
}

</style>
<comment>
<style type="text/css">
div.tab{
	width:90px;
	height:15px;
}
div.tab_container{	
	height:17px;
}
</style>
</comment>
<script language="javascript" type="text/javascript">
function showtab(o){
	var d = document.getElementsByTagName('div');
	var len = d.length;
	$j=0;
	for(var i=0;i<len;i++){
		if (d[i].className == 'tabitem'){
			d[i].style.display="none";
			$j++;
		}
		//document.getElementById(($j-1)).style.backgroundImage ="";
	}
	for (var n=0;n<$j;n++){
		document.getElementById(n).style.backgroundImage = '';
	}
	var a = document.getElementById('tab_'+o.id);
	a.style.display="block";
	o.style.backgroundImage = 'url(images/tab.gif)';
	o.style.backgroundRepeat = 'no-repeat';
}
</script>
</head>
<body class="text" style="width:800px;overflow:hidden; ">
<form action="<?php echo URL_SELF.'?id='.$this->id.'&act='.ACT_SAVE; ?>" method="post" onSubmit="return checkForm(this);"  id="idfrmItem">
<h3 style="text-align:center">&#272;&#416;N H&#192;NG #<?php printf(FORMAT_ID_STRING,$this->id);?> [M&#227;:<?php echo $this->code;?>]</h3>
<div style="text-align:right;margin-bottom:3px;">
    <input type="button" value = "In &#273;&#417;n h&#224;ng" onClick="orderPrint(<?php echo $this->id ?>);" class="button" />
    <input type="button" value = "Xu&#7845;t ra file PDF" onClick="orderPDF(<?php echo $this->id ?>);" class="button" />
</div>
<div class="tab_container">
<div id="0" onClick="showtab(this)" class="tab" style="background:url(images/tab.gif) no-repeat;">Kh&aacute;ch h&agrave;ng</div>
<div id="1" class="tab" onClick="showtab(this)" >Chi ti&#7871;t</div>
<div id="2" onClick="showtab(this)" class="tab">Qu&#225; tr&#236;nh</div>
</div>
<div style="background:#ECE9D8 url(images/tab_bg.gif);width:100%;height:3px;z-index:1;position:relative;"></div>
<div id="tab_0" class="tabitem" style="display:block;">
<table class="text" width="800" cellspacing="0" cellpadding="3">
	<tbody>
	<tr><td class="cell" >&nbsp;</td><th class="cell" align="left" >Ng&#432;&#7901;i &#273;&#7863;t h&#224;ng</th>
		<th class="cell" align="left" >Th&ocirc;ng tin ng&#432;ời li&ecirc;n h&#7879;</th>
	</tr>
	<tr>
		<th class="cell" align="left" width="160">T&#234;n &#273;&#7847;y &#273;&#7911;</th>
		<td class="cell" ><?php echo $this->custfirstname.' '.$this->custlastname;?>&nbsp;</td>
		<td class="cell" ><?php echo $this->shiptofirstname.' '.$this->shiptolastname;?>&nbsp;</td>
	</tr>
	<tr>
		<th class="cell" align="left">Phone/Mobile/fax</th>
		<td class="cell" ><?php echo map($this->custphone).'/'.map($this->custmobile).'/ '.map($this->custfax);?></td>
		<td class="cell" ><?php echo map($this->shiptophone).'/'.map($this->shiptomobile).'/'.map($this->shiptofax);?></td>
	</tr>
	<tr>
		<th class="cell" align="left">Email</th>
		<td class="cell" ><?php echo map($this->custemail);?></td>
		<td class="cell" ><?php echo map($this->shiptoemail);?></td>
	</tr>
	<tr>
		<th class="cell" align="left">M&#227; &#273;&#7883;a ch&#7881;/m&#227; khu v&#7921;c</th>
		<td class="cell" ><?php echo map($this->custpostcode);?>/<?php echo map($this->custzonecode);?></td>
		<td class="cell" ><?php echo map($this->shiptopostcode);?>/<?php echo map($this->shiptozonecode);?></td>
	</tr>
	<tr>
		<th class="cell" align="left">Th&#224;nh ph&#7889;/t&#7881;nh/qu&#7889;c gia</th>
		<td class="cell" ><?php echo map($this->custcity);?>/<?php echo map($this->custprovince);?>/<?php echo map($this->custcountry);?></td>
		<td class="cell" ><?php echo map($this->shiptocity);?>/<?php echo map($this->shiptoprovince);?>/<?php echo map($this->shiptocountry);?></td>
	</tr>
	<tr>
		<th class="cell" align="left">Ngày b&#7855;t &#273;&#7847;u</th>
		<td class="cell" ><?php echo map($this->begindate);?></td>
		<td class="cell" >&nbsp;</td>
	</tr>
	<tr>
		<th class="cell" align="left">Ng&agrave;y h&#7871;t h&#7841;n</th>
		<td class="cell" ><?php echo map($this->expireddate);?></td>
		<td class="cell" >&nbsp;</td>
	</tr>
	<tr>
		<th class="cell" align="left">&#272;&#7883;a ch&#7881;</th>
		<td class="cell" ><?php echo map($this->custaddress);?></td>
		<td class="cell" ><?php echo map($this->shiptoaddress);?></td>
	</tr>
	<tr>
		<th class="cell" align="left">Ghi ch&uacute;</th>
		<td class="cell" ><?php echo map($this->summary);?></td>
		<td class="cell" >&nbsp;</td>
	</tr>	
	<tr><td class="cell"  colspan="3" align="center">&nbsp;</td></tr>
	<tr>
		<th class="cell" align="left">T&#7893;ng gi&#225; tr&#7883;</th>
		<td class="cell" ><?php echo currency_format($this->value);?></td>
		<td class="cell" >&nbsp;</td>
	</tr>
	<tr><th class="cell" align="left">Thanh to&#225;n</th>
		<td class="cell" ><?php echo map($this->paymethod);?>
		<td class="cell" ><?php echo map($this->payinfo);?></td>
	</tr>
	<tr><th class="cell" align="left">V&#7853;n chuy&#7875;n</th>
		<td class="cell" ><?php echo map($this->shipvia);?>
		<td class="cell" ><?php echo map($this->shipinfo);?></td>
	</tr>
<?php	if($this->promotioncode){?>
	<tr><th class="cell" align="left">M&#227; khuy&#7871;n m&#7841;i</th>
		<td class="cell" ><?php echo map($this->promotioncode);?>
		<td class="cell" >&nbsp;</td>
	</tr>
	
<?php	}?>
	</tbody>
</table>
</div>
<div id="tab_1" style="display:none; " class="tabitem">
<?php
$this->detailList();//list order detail rows: $this->aDetail containt array of rows, $this->rowcount containt number of row
?>
<table width="800" cellspacing="0" cellpadding="3">
	<tbody>
		<tr class="text">
			<th class="cell">T&#236;nh tr&#7841;ng</th><td class="cell" >&nbsp;<?php echo $ORDER_STATUS[$this->status];?></td>
			<th class="cell">Ng&#224;y nh&#7853;n</th><td class="cell" >&nbsp;<?php echo $this->created;?></td>
			<th class="cell">Th&#7901;i h&#7841;n</th><td class="cell" >&nbsp;<?php echo $this->expireddate;?></td>
		</tr>
	</tbody>
</table>
<table width="800" class="text" border="0" bordercolor="#CCCCCC" style="line-height:15px" cellspacing="0">
	<thead class="cell">
		<tr>
			<th class="cell">#</th>
			<th class="cell">M&#227;</th>
			<th class="cell">T&#234;n s&#7843;n ph&#7849;m</th>
			<th class="cell">&#272;&#417;n gi&#225;</th>
			<th class="cell">S&#7889; l&#432;&#7907;ng</th>
			<th class="cell">Ng&agrave;y b&#7855;t &#273;&#7847;u</th>
			<th class="cell">Ng&agrave;y k&#7871;t th&uacute;c</th>
			<th class="cell">Th&#224;nh ti&#7873;n</th>
			<th class="cell">Ghi ch&#250;</th>
			<th class="cell">&#272;&#7863;c t&#237;nh s&#7843;n ph&#7849;m</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($this->aDetail as $i=>$row){ 
/* below code displays each order row detail per line,
$this->rowcount containt number of row
row['productid'] = product id, 
row['productctrl'] = product ctrl, at the time of order
row['producttype'] = product type
row['code']=product code
we can use require PATH_COMPLS.'product.php' and call productRead((int)$row['productid']) to get full information on the product like....
row['qty'] = quantity, row['qty2']=quantity2,row['qty3']=quantity 3, row['qty4']=quantity 4
row['start'] = start of service/product, or check in
row['stop']=stop of service/product, or check out
row['subtotal']= value of row
*/
?>
		<tr>
			<td class="cell"  align="right"><?php echo $i ?></td>
			<td class="cell"  align="right"><?php echo printf(FORMAT_PRODUCT_CODE,$row['code']); ?></td>
			<td class="cell"  align="left"><?php echo map($row['name']); ?></td>
			<td class="cell"  align="right"><?php echo currency_format_number($row['saleprice']); ?></td>
			<td class="cell"  align="center"><?php echo $row['qty'] ?></td>
			<td class="cell"  ><?php echo $row['start'] ?></td>
			<td class="cell"  ><?php echo $row['stop'] ?></td>
			<td class="cell"  align="right"><?php echo currency_format_number($row['subtotal']); ?></td>
			<td class="cell"  ><?php echo $row['notes']; ?>&nbsp;</td>
			<td class="cell" ><?php echo ctrl_format($row['productctrl']) ?></td>
		</tr>
<?php } 
?>		
	</tbody>
	<tfoot>
		<tr>
			<th class="cell" align="right" colspan="7">T&#7893;ng</th>
			<td class="cell"  align="right" >&nbsp;<?php echo currency_format($this->value); ?></td>
			<td class="cell"  colspan="2">&nbsp;<?php echo $this->summary;?></td>
		</tr>
	</tfoot>
</table>
</div>
<div id="tab_2" style="display:none; " class="tabitem">
<table cellspacing="0" style="border:0px; ">
	<tbody><tr valign="top"><td class="cell" style="border:0px; ">
		<table class="text" border="0" cellspacing="0" bordercolor="#CCCCCC" style="line-height:15px">
			<thead class="cell">
			<tr><th class="cell" colspan="2">T&#243;m t&#7855;t</th></tr>
			</thead>
		<tbody>
<?php
	foreach($ORDER_CTRL as $ctl=>$text){
/* this code if to display short information of order history */	
	?>
		<tr><td class="cell" ><?php echo ctrl_format($ctl).'&nbsp;'.$text;?></td>
			<td class="cell" ><input type="checkbox" disabled="true" class="input input_mini" <?php if($this->ctrl & $ctl) echo 'checked';?> /></td>
		</tr>
<?php	}
?>		
		<tr><td colspan="2">
<?php
// the select box must named "status", this code is to allow user to update status of order 
		echo '<select class="input" name="status" >';
		echo '<option value="">Thi&#7871;t l&#7853;p tr&#7841;ng th&#225;i</option>';
		foreach($ORDER_STATUS as $status=>$statusname)
			echo '<option value="'.$status.'">'.$statusname.'</option>';
		echo '</select>';
?>		</td></tr>
		<tr><td colspan="2"><textarea name="data" class="input" style="width:250px;height:100px;" ></textarea></td></tr>
		<tr><td colspan="2"><input class="button" type="submit" value="C&#7853;p nh&#7853;t" /></td></tr>
		</tbody>
		</table>
	</tbody>
</table>
<table class="text" bordercolor="#CCCCCC" style="line-height:15px" cellspacing="0" width="100%">
	<thead class="cell">
		<tr><th class="cell">Ng&#224;y th&#225;ng</th>
			<th class="cell">Tr&#7841;ng th&#225;i</th>
			<th class="cell">Ghi ch&#250;</th>
			<th class="cell">Ng&#432;&#7901;i th&#7921;c hi&#7879;n</th>
		</tr>
	</thead>
<?php
	$this->historyList();//list history, $this->aHistory containt array of history, $this->historyLength containt length of history
	if($this->historyLength > 0){
		echo '<tbody>';
		foreach($this->aHistory as $row){?>
		<tr><td class="cell" ><?php echo $row['created'];?></td>
			<td class="cell" ><?php echo $ORDER_STATUS[(int)$row['status']];?></td>
			<td class="cell" >&nbsp;<?php echo $row['data']?></td>
			<td class="cell" >&nbsp;<?php echo $row['user'].'('.$row['useremail'].')';?></td>
		</tr>
<?php	}
		echo '</tbody>';
	}
?>		
</table>
</div>
</form>	
</body>
</html>
<script language="javascript" type="text/javascript">
window.top.document.title = self.document.title;
var self_id = '<?php echo $this->id;?>';
var self_type = '<?php echo $this->type;?>';
var frmItem   = document.getElementById("idfrmItem");
var url_self  = '<?php echo URL_SELF;?>';
var url_up    = "<?php echo dirname(URL_SELF) ?>/item-list.php?<?php echo urlchop('ORid','id'); ?>";
var url_newitem='#';
function checkForm(f){
	if(f.status.value == ''){
		parent.banner.setStatus('B&#7841;n c&#7847;n ch&#7885;n tr&#7841;ng th&#225;i &#273;&#417;n h&#224;ng');
		return false;
	}
	return true;
}
</script>
<script language="javascript" src="js/item-script.js"></script>
<script language="javascript" src="<?php echo URL_ROOT ?>js/admin_overload.js" type="text/javascript"></script>
<?php dbclose();?>