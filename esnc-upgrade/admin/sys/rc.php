<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
require(PATH_INC.'dbconguest.php');
require(PATH_COMPLS.'product-package.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN)){
	echo "<script language='javascript'>window.top.location='../';</script>";
	exit();
}
require '../config.php';
if($act == 'save'){
	while(list($j,$va) = each($_POST['names'])){
		$upname .= $va.',';
	}	
	$upname = explode(',',$upname);
	if($_POST['name']!=NULL && $_POST['id']!=NULL){
		while(list($key,$value) = each($_POST['name'])){
			$name .= $value.',';
		}
		while(list($k,$val) = each($_POST['id'])){
			$id .= $val.',';
		}
		$id = explode(',',$id);
		$name = explode(',',$name);
		$n = count($name);
	}else{	
		$n = count($upname);
	}
	for($i=0;$i<$n;++$i){
		if($upname[$i]!=""){		
			comfortadd($upname[$i],NULL);
		}elseif($name[$i]!='' && $id[$i]!=0){
			comfortadd($upname[$i],$id[$i]);
		}elseif(($name[$i]=='' || $name[$i]==NULL) && $id[$i]!=0){			
			comfortremove($id[$i]);
		}
	}
	redirect(URL_SELF);
	exit();	
}
define('MAX_ADD_CONSTANT',12);
dbclose();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Danh s&aacute;ch ti&ecirc;n nghi ph&ograve;ng c&#7911;a kh&aacute;ch s&#7841;n</title>
<base href="<?php echo URL_BASE_ADMIN; ?>" />
<style>
th{font-size:11px;}
.tab{display:none;}
.tabactive{display:table-header-group;}
textarea{width:95%;height:100%;}
.tabhead{cursor:pointer;font-size:11px;font-weight:normal;color:black;}
.tabheadactive{cursor:pointer;font-size:11px;font-weight:bold;color:green;}
TEXTAREA.input{height:15px;}
</style>
<link rel="stylesheet" type="text/css" href="images/style.css"/>
</head>
<body class="text">
<form action="<?php echo URL_SELF; ?>?act=save" method="post" enctype="multipart/form-data">
<table  width="700px" border="0" cellspacing="2" cellpadding="2" align="center" >
<thead>
	<tr height="23" style="background-image:url(images/bg-product.gif);"><td colspan="2" align="center">
		<span name="tabhead" class="tabheadactive" onClick="showTab(0,this);">Danh s&aacute;ch</span>
		<strong> | </strong><span name="tabhead" class="tabhead" onClick="showTab(1,this);">Th&ecirc;m m&#7899;i</span>
		</td>
	</tr>
</thead>
<tbody id="tab0" class="tabactive" name="tab">
<?php	
	$i=0;$j=0;
	$rs = comfortlist();
	if($rs){
		while($row = mysql_fetch_assoc($rs)){
			echo '<tr>';
				echo '<input type="hidden" name="id['.++$i.']" value="'.$row['Id'].'" style="width:100px;" />';	
				echo '<td><input class="input" type="text" name="name['.++$j.']" value="'.$row['Name'].'" style="width:500px;"/></td>';
			echo '</tr>';		
		}
		
	}else{?>
		<tr>
			<td>Hay them cac tien nghi cho phong cua cac khach san</td>
		</tr>
<?php	mysql_free_result($rs);
	}
?>
</tbody>
<tbody id="tab1" class="tab" name="tab">
<?php for($k=0;$k < MAX_ADD_CONSTANT;++$k){?>
<tr>
	<td ><input class="input" type="text" name="names[<?php echo $k; ?>]" value="" onFocus="this.select();" style="width:500px;"/></td>
</tr>
<?php } ?>
</tbody>
</table>
</form>
</body>
<script language="javascript">
function htmlencode(o){
	document.body.style.visibility='hidden';
	var s,ss,i,n;
	s=String(o.value).replace('>>','&gt;&gt;').replace('<<','&lt;&lt;');
	ss="";
	n=s.length;
	for(i=0;i<n;++i){
 		if((code=Number(s.charCodeAt(i))) > 128)
			ss += "&#" + code + ";";
		else{
			switch(c = s.charAt(i)){
			default:		 ss += c;
			}
		}
	}
	o.value=ss;
}
function checkForm(f){
	var i,n;
	n = f.elements.length;
	for(i=0;i<n;++i){
		htmlencode(f.elements[i]);
	}
	return true;
}
function showTab(id,o){
	a = document.getElementsByTagName('tbody');
	n = a.length;
	for(i=0;i < n; ++i){
		if(a.item(i).className == 'tabactive'){			
			a.item(i).className='tab';
			a.item(i).style.display='none';
		}else{
			a.item(i).style.display='table';
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
}
function doSave(){
	if(checkForm(f=document.getElementsByTagName('form').item(0))) f.submit();
}
function doUp(){
	self.location.href = '<?php echo URL_CWD ?>index.php';
}
function doNewItem(){
	showTab(3,document.getElementById('tabhead_new'));
}
var MAX_ADD_CONSTANT = <?php echo MAX_ADD_CONSTANT; ?>;
//window.top.document.title=self.document.title;
</script>
</html>
