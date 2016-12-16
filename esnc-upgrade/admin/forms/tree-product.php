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
<?php
if(MODULE_WIZARD){
echo '<DIV class="menu_tree_item"><DIV><DIV class="join_plus" onclick="showChildNodes(this);">&nbsp;</DIV><a href="wizard/index.php" target="'.$this->target.'" class="menu_tree_link" onclick="openLink(this)">X&acirc;y d&#7921;ng s&#7843;n ph&#7849;m</a></DIV></DIV><DIV class="tree_block">';	
	foreach($a_wz as $row){
		echo '<div class="menu_tree_item"><div>';
			echo '<div class="join_item">&nbsp;</div>';
			echo '<a href="'.URL_ADMIN.'wizard/item-list.php?WDid='.$row['id'].'" target="content" class="menu_tree_link" onclick="openLink(this)">'.$row['name'].'</a>';
		echo '</div></div>';
		
	}
echo '</DIV>';
}
?>
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
