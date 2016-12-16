<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link href="images/style.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>
<body class="text" style="height:500px">
<DIV class="menu_tree_root"><DIV class="menu_tree_item"><a href="#" class="menu_tree_root" onClick="return false;">Root</a></DIV>
<DIV class="menu_tree_item"><DIV><DIV class="join_plus" onclick="showChildNodes(this);">&nbsp;</DIV><a href="<?php echo $this->folder ?>-1" target="<?php echo $this->target ?>" class="menu_tree_link" onclick="openLink(this)"><?php echo $this->rootname; ?></a></DIV></DIV><DIV class="tree_block">
<?php showTree($this->a);?>
</div>
</body>
<script language="javascript">
function showChildNodes(o){
	if(o.className=='join_plus'){
		o.className='join_minus';
		o.parentNode.parentNode.nextSibling.style.display='block';
	}else{
		o.className='join_plus';
		o.parentNode.parentNode.nextSibling.style.display='none';
	}
}
activeLink=new Object;
activeLink.style=new Object;
activeLink.style.fontWeight='bold';
function openLink(o){
	activeLink.style.fontWeight='normal';
	o.style.fontWeight='bold';
	activeLink=o;
}
</script>
</html>
