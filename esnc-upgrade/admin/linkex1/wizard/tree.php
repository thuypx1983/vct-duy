<?php
require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
require('../inc/config.php');
if (!$session->getaccess(SESSION_CTRL_ADMIN,MODULE_WIZARD)){
	exit('<script language="javascript">window.top.location="../../";</script>');
}
require('../inc/dbcon.php');
require(PATH_CLASS.'product.php');
require(PATH_COMPLS.'product.php');
require_once(PATH_CLASS.'cache.php');
require_once(PATH_CLASS.'wizard.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Tree</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" type="text/javascript" src="../inc/library.js"></script>
<script language="javascript" type="text/javascript">
function showMenuNode(o){
	var u,v,w,i=0,j=0,k=0;
	v = o.nextSibling;
	if(v.style.display=='list-item') v.style.display='none';
	else v.style.display  ='list-item';
	return false;
}
function save(name,obj){
	//if (!warning()) return;
	var v = getChecked(name);
	var o = new ajax();
	var file = "handle.php?WIid=<?php echo $_GET['WIid']; ?>&ids="+v;
	obj.value = "Đang xử lý...";
	obj.disabled = true;
	o.open('GET',file,true);
	o.onreadystatechange = function (){
		if (o.readyState == 4){
			if (o.status == 200){
				if (o.responseText != 'FALSE') {
					alert('Cập nhật thành công');
					changecolor();
					setTimeout('self.close();',1000);
				}
				else{ alert('Remove failed! ' + o.responseText);}
			}
		}
	}
	o.send(null);	
}
function changecolor(){
try{
	var a = window.opener.document.getElementById('N<?php echo $_GET['WIid']; ?>');
	//var o = a.parentNode.previousSibling.previousSibling;	
	a.style.color = '#000000';	
}catch(e){alert(e.description);}
}
function warning(){
	var ids = document.getElementsByName('id[]');
	var len = ids.length;
	var v = '';
	for (var i=0;i<len;i++){
		v += ids[i].value;
	}
	if ((v=='')||(v==null)){
		document.getElementById('warning').innerHTML = 'Vẫn chưa có nhóm nào được chọn';
		return false;
	}
	return true;
}
</script>
<style type="text/css">
body,input{
	font-family:Tahoma,verdana;
	font-size:11px;
	margin:0px;
}
input{margin-right:3px;}
ul.menu_tree{
  background-color: #EDF1F2;
  margin: 0px ;
  padding: 0px ;
  list-style-type: none;
}
ul.menu_tree li{
  border-bottom:1px solid #CCCCCC;
  line-height: 25px;
  padding: 0px 0px 0px 25px;
  background-repeat: no-repeat;
  font-weight:bold;
}
ul.menu_tree li a:link,ul.menu_tree li a:visited{
  text-decoration: none;
  color:#000000;
}
ul.ul_level_0,ul.ul_level_1{
  display: none;
  padding:0px;
  margin:0px;
  list-style-type: none;    
}
ul.ul_level_0 li{
  font-weight:normal;
  background: transparent;
  border:0px;
  margin:0px;
  padding:3px 3px 0px 10px;
  font-size:11px;
  line-height: 12px;
  background-image: url(list.gif);
  background-repeat: no-repeat;
}
ul.ul_level_1 li{
  background: transparent;
  border:0px;
  margin:0px;
  padding:3px 3px 0px 10px;
  font-size:11px;
  line-height: 15px;  
}
#warning{color:#FF0000;text-align:center;}
</style>
</head>
<body>
<div style="overflow-y:scroll;height:400px; padding:3px 0px 3px 0px ">
<div id="warning"></div>
<?php
$id = (int)$_GET['WIid'];
$w = new wizarditem();
$w->id = $id;
$rs = $w->loadonerow();
$arr = mysql_fetch_assoc($rs);
$cat = explode(',',$arr['catid']);
$c = count($cat);
if(cache::get($a_tree,'component-menu-tree')){
//	echo '<!--CACHED-->';
	$n = count($a_tree);
}else{
//	echo '<!--NOCACHE-->';
	$rs = catproductlist(CATPRODUCT_CTRL_MENU|CATPRODUCT_CTRL_SHOW,NULL,FALSE,CAT_FLAG_ITEM,100,NULL);
	for($n=0;$a_tree[]=mysql_fetch_array($rs);++$n);
	array_pop($a_tree);
	mysql_free_result($rs);
	cache::put($a_tree,'component-menu-tree');
}
echo '<ul class="menu_tree">';
function showTree($i){//Ham tao tree
	//$i: So thu tu phan tu mang dang xu ly
	global $n,$a_tree,$activeid,$cat,$c;// $n: Kich thuoc mang, $a_tree: Mang cac phan tu can tao tree;
	static $deep=0; //$deep: Do sau de quy
	if($deep > 5 || $a_tree[$i]['name'] == '*') return;
	if($a_tree[$i]['cnt'] > 0) { // Node cuoi 
		for($l=0;$l<$c;$l++){
			if ((int)$cat[$l]==$a_tree[$i]['id']) $check='checked';
		}
		echo '<li class="li_level_'.$deep.'"><input type="checkbox" name="id[]" value="'.$a_tree[$i]['id'].'" '.$check.'/>'.$a_tree[$i]['name'].'('.$a_tree[$i]['cnt'].')</li>';
		$a_tree[$i]['name'] = '*'; // Danh dau node da xu ly
	}	
	else{ // Node co chua node con
		echo '<li class="li_level_'.$deep.'"><a href="#" onclick="return showMenuNode(this);">'.$a_tree[$i]['name'].'</a>';
		$a_tree[$i]['name'] = '*'; // Danh dau node da xu ly
		echo '<ul class="ul_level_'.$deep.'">';
			for($j=0;$j<$n;++$j){
				if($a_tree[$i]['id'] == $a_tree[$j]['parentid']){
					++$deep; // Xuong mot muc 
					showTree($j);
					--$deep; // Len mot muc 
				}
			}
		echo '</ul></li>';
	}
}

for($i = 0; $i < $n; ++$i) showTree($i); // Goi ham tao tree
echo '</ul>'; ?>
</div>
<div style="text-align:center;margin-top:3px; "><input type="button" value="L&#432;u l&#7841;i" onClick="save('id[]',this);"/>&nbsp;<input type="button" value="B&#7887; qua" onClick="self.close();"/></div>
</body>
<script language="javascript" type="text/javascript">
warning();
</script>
</html>