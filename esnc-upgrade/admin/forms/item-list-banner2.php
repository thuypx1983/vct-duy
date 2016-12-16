<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
require_once('../../config.php');
require_once('../inc/common.php');
require_once('../inc/session.php');
require_once(PATH_INC.'dbconguest.php');
require_once(PATH_COMPLS.'bannerlist.php');
?>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link type="text/css" rel="stylesheet" href="images/style.css" />
<link type="text/css" rel="stylesheet" href="forms/style.css">

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
<body style="margin: 0px 0px 0px 0px" class="text">
<?php
	$file1= PATH_APPLICATION.'test_link1.txt';
	$name= 'đã có link-back';
	$dk= @$_GET['dk'];
	if($dk==2) 
	{
		$file1= PATH_APPLICATION.'test_link2.txt';
		$name='chưa có link-back';
		echo '<table id="item-list" width="100%" cellpadding="0" cellspacing="0" ><thead><tr><th><b>Danh sách các item chưa có link-back!</b></th>	<th colspan="2"><a href ="item-list-banner2.php?dk=1">Danh sách các item có link-back!</a></th></tr></thead></table>';
	} else {
			echo '<table id="item-list" width="100%" cellpadding="0" cellspacing="0" ><thead><tr><th><b>Danh sách các item đã có link-back!</b></th><th colspan="2"><a href ="item-list-banner2.php?dk=2">Danh sách các item chưa có link-back!</a></th></tr></thead></table>';
	}
?>
<table id="item-list" width="100%" cellpadding="0" cellspacing="0"  onClick="parent.document.getElementById('newitemmenu').style.visibility='hidden';">
	<thead>
	<tr>	
		<th>#</th>	
		<th colspan="2">Tên</th>
		<th>link-back</th>
		<th>url</th>
		<th>thứ tự</th>
		<th >đặc tính</th></tr>
	</thead>
	<tbody>
	<?php 
		//$itemurl=URL_CWD.'item.php?'.urlformat($this->q,$this->alias.'id','');
		$value=file_get_contents($file1);
		$arrayid = explode(',',$value);
		$array=array();
		for($i=0;$i<count($arrayid);$i++)
		{
			$BNid =$arrayid[$i];			
			//$rs = bannerlist(BANNER_CTRL_SHOW|BANNER_CTRL_LINK,(int)$BNid);
			$rs =
			$row = bannerread((int)$BNid);
			$array[]= $row;
		}
	for($i=0;$i<count($array);$i++)
		{
		//print_r($array[$i]);
	?>
	<tr><td><?php echo ($i+1);?></td>	
		<td align="left" style="border-right:0px; ">
			<a href ="/esnc/banner/item.php?CBid=9&BNid=<?php echo $array[$i]->id;?>"><?php echo $array[$i]->name; ?></a>
		</td>
		<td align="right" style="border-left:0px; ">
			
		</td>
		<td align="center" title=""><?php echo $name;?></td>
		<td align="left" >
			<div style="width:190px;overflow:hidden;white-space:nowrap;">
				<?php echo $array[$i]->url;?>
			</div>
		</td>
		<td align="center">
			<?php echo $array[$i]->view;?>
		</td>
		<td align="lefl" style="cursor:help" title="">
			<?php echo ctrl_format($array[$i]->ctrl) ?>
		</td>		
	</tr>	
	<?php }//end row scan ?>
	</tbody>
</table>
</body>
</html>
