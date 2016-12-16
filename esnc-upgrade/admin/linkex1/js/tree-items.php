<?php require('../../config.php');
require('../inc/common.php');
require('../inc/session.php');
if(!$session->getaccess(SESSION_CTRL_ADMIN)){
//	echo 'window.top.location="../../";';
	//exit();
}
require	'../config.php';
require	'../inc/dbcon.php';
function loadtree(&$a,$item,$parentid=-1){
	static $DEEP=0;
	switch($item){
	case 'product':
	case 'news':
	case 'utility':
	case 'banner':
		break;//only for these module we use tree
	default:return FALSE;
	}
	$cat = "cat{$item}";
	$catitem = "cat{$item}{$item}";
	$cparentid = ($parentid <= 0 ? " -1 OR `c`.`parentid` IS NULL": $parentid);
	$sql = "SELECT DISTINCT `c`.`id`,`c`.`name`,`c`.`ctrl`,IF(`cc`.`id` IS NULL,IF(`ci`.`${item}id` IS NULL,0,-1),1) as `flag` FROM "
			."`".DB_TABLE_PREFIX."{$cat}` as `c` LEFT JOIN `".DB_TABLE_PREFIX."{$cat}` as `cc` ON `c`.`id`=`cc`.`parentid` LEFT JOIN `".DB_TABLE_PREFIX."{$catitem}` as `ci` ON `c`.`id` = `ci`.`{$cat}id` 
WHERE `c`.`parentid` = {$cparentid} ORDER BY `c`.`view` ASC,`c`.`id` ASC";
//	_trace($sql);
	$rs = mysql_query($sql);
	$i=0;
	while($rw = mysql_fetch_row($rs)){
		if((int)$rw[3] == 1 && $DEEP < 20){
			$a[$i] = array(0=>$rw[0],1=>$rw[1],2=>$rw[2],3=>$rw[3],4=>array());
			++$DEEP;
//			_trace('step down:'.$DEEP);
			loadtree($a[$i][4],$item,$rw[0]);//fetch children into sub-array
			--$DEEP;
//			_trace('step up:'.$DEEP);
		}
		else $a[$i] = array(0=>$rw[0],1=>$rw[1],2=>$rw[2],3=>$rw[3],NULL);
		++$i;
	}
	mysql_free_result($rs);
}
function showtree(&$b){
	global $FOLDER_LIST_PAGE,$FOLDER_ALIAS,$ITEM_LIST_PAGE,$FOLDER_EMPTY_PAGE,$namealias;
	static $DEEP=0;
	foreach($b as $a){
		$name_html=addslashes($a[1]);
		switch((int)$a[3]){
			case 1: //contain sub-folder
				echo "\r\n".'<DIV class="menu_tree_item"><span class="join_plus" onclick="showChildNodes(this);">&nbsp;</span><a href="'.$FOLDER_LIST_PAGE.$a[0].'" target="_content" class="menu_tree_link" onclick="openLink(this)">'.$name_html.'</a></DIV><DIV class="block">';
				if($DEEP < 20){
					++$DEEP;
					showtree($a[4]);
					--$DEEP;
				}
				echo '</DIV>';
				break;
			case -1: //contain items
				echo "\r\n".'<DIV class="menu_tree_item"><span class="join_item">&nbsp;</span><a href="'.$ITEM_LIST_PAGE.$a[0].'" target="_content" class="menu_tree_link">'.$name_html.'</a></DIV>';
				break;
			default:	//empty folder
				echo "\r\n".'<DIV class="menu_tree_item"><span class="join_item">&nbsp;</span><a href="'.$FOLDER_EMPTY_PAGE.$a[0].'" target="_content" class="menu_tree_link">'.$name_html.'</a></DIV>';
		}
	}
}
$ROOT_NAME=(string)$_GET['rootname'];
$FOLDER_LIST_PAGE=(string)$_GET['folderpage'];if(strpos($FOLDER_LIST_PAGE,'?') === FALSE) $FOLDER_LIST_PAGE .='?';
$FOLDER_EMPTY_PAGE=(string)$_GET['emptypage'];if(strpos($FOLDER_EMPTY_PAGE,'?') === FALSE && $FOLDER_EMPTY_PAGE != '') $FOLDER_EMPTY_PAGE .='?';
$ITEM_LIST_PAGE=(string)$_GET['itempage'];if(strpos($ITEM_LIST_PAGE,'?') === FALSE) $ITEM_LIST_PAGE .='?';
$module=(string)$_GET['module'];
$GLOBAL_DEEP_TREE = 0;
$tr=array();
loadtree($tr,$module);
header('Content-Type:text/html;charset=utf-8',TRUE);
?>
<html>
<base href="<?php echo URL_BASE_ADMIN ?>" />
<link href="images/style.css" type="text/css" rel="stylesheet"/>
<head>
<style>
DIV.block{margin:0px 0px 0px 15px;display:none;}
A:link,A:hover,A:visited{color:black;}
A{background-position:left center;background-repeat:no-repeat;}
DIV.menu_tree_item{margin:0px 0px 0px 12px;height:13px;padding:0px;}
A.menu_tree_link,A.menu_tree_link_minus{padding:0px 0px 0px 20px;text-decoration:none;}
A.menu_tree_link{background-image:url(images/folder.gif);}
A.menu_tree_link_minus{background-image:url(images/folderopen.gif);}
A.menu_tree_link_minus:hover,A.menu_tree_link:hover{text-decoration:underline;}
SPAN.join_plus{padding:0px 6px 0px 6px;height:13px;background-image:url(images/plus.gif);background-position:left bottom;cursor:default}
SPAN.join_minus{padding:0px 6px 0px 6px;height:13px;background-image:url(images/minus.gif);background-position:left bottom;cursor:default}
SPAN.join_item{padding:0px 6px 0px 6px;height:13px;background-image:url(images/joinbottom.gif);background-position:left bottom;cursor:default}
A.menu_tree_root{padding:0px 0px 0px 20px;text-decoration:none;background-image:url(images/base.gif);background-position:left bottom;}
</style>
</head>
<body>
<DIV class="menu_tree_root"><DIV class="menu_tree_item"><a href="#" class="menu_tree_root" onClick="return false;">Root</a></DIV>
<DIV class="menu_tree_item"><span class="join_plus" onclick="showChildNodes(this);">&nbsp;</span><a href="<?php echo $FOLDER_LIST_PAGE ?>-1" target="_content" class="menu_tree_link" onclick="openLink(this)"><?php echo $ROOT_NAME ?></a></DIV><DIV class="block">
<?php showTree($tr);?>
</div>
</body>
<script language="javascript">
function showChildNodes(o){
	if(o.className=='join_plus'){
		o.className='join_minus';
		o.parentNode.nextSibling.style.display='block';
	}else{
		o.className='join_plus';
		o.parentNode.nextSibling.style.display='none';
	}
}
function openLink(o){
	if(o.className=='menu_tree_link_minus') o.className='menu_tree_link';
	else o.className=='menu_tree_link';
}
</script>
</html>

<?php mysql_close(); ?>