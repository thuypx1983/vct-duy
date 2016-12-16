<?php 
class Tree{
	var $folder,$item,$empty,$a,$table,$catalias,$rootname,$target;
}
function loadtree(&$a,$parentid=-1){
	global $tree;
	static $DEEP=0;
	$cat = "cat{$tree->table}";
	$catitem = "cat{$tree->table}{$tree->table}";
	$cparentid = ($parentid <= 0 ? " -1 OR `c`.`parentid` IS NULL": $parentid);
	$sql = "SELECT DISTINCT `c`.`id`,`c`.`name`,`c`.`ctrl`,IF(`cc`.`id` IS NULL,IF(`ci`.`{$tree->table}id` IS NULL,0,-1),1) as `flag` FROM "
			."`".DB_TABLE_PREFIX."{$cat}` as `c` LEFT JOIN `".DB_TABLE_PREFIX."{$cat}` as `cc` ON `c`.`id`=`cc`.`parentid` LEFT JOIN `".DB_TABLE_PREFIX."{$catitem}` as `ci` ON `c`.`id` = `ci`.`{$cat}id` 
WHERE `c`.`parentid` = {$cparentid} ORDER BY `c`.`view` ASC,`c`.`id` ASC";
	_trace(__LINE__.$sql);
	$rs = mysql_query($sql);
	$i=0;
	while($rw = mysql_fetch_row($rs)){
		if((int)$rw[3] == 1 && $DEEP < 20){
			$a[$i] = array(0=>$rw[0],1=>$rw[1],2=>$rw[2],3=>$rw[3],4=>array());
			++$DEEP;
//			_trace('step down:'.$DEEP);
			loadtree($a[$i][4],$rw[0]);//fetch children into sub-array
			--$DEEP;
//			_trace('step up:'.$DEEP);
		}
		else $a[$i] = array(0=>$rw[0],1=>$rw[1],2=>$rw[2],3=>$rw[3],NULL);
		++$i;
	}
	mysql_free_result($rs);
}
function showtree(&$b){
	global $tree;
	static $DEEP=0;
	$i=0;
	foreach($b as $a){
		$name_html=$a[1];
		if($a[2] & 1) $style='';
		else $style=' style="color:#CCCCCC"';
		switch((int)$a[3]){
			case 1: //contain sub-folder
				echo '<DIV class="menu_tree_item"><DIV><DIV class="join_plus" onclick="showChildNodes(this);">&nbsp;</DIV><a href="'.$tree->folder.$a[0].'" target="content" class="menu_tree_link" onclick="openLink(this)" '.$style.'>'.$name_html.'</a></DIV></DIV><DIV class="tree_block">';
				if($DEEP < 20){
					++$DEEP;
					showtree($a[4]);
					--$DEEP;
				}
				echo '</DIV>';
				break;
			case -1: //contain items
				if($b[$i + 1]) $css = 'join_item';//preview next item
				else $css = 'join_end';
				echo '<DIV class="menu_tree_item"><DIV><DIV class="'.$css.'">&nbsp;</DIV><a href="'.$tree->item.$a[0].'" target="content" class="menu_tree_link" onclick="openLink(this)"'.$style.'>'.$name_html.'</a></DIV></DIV>';
				++$i;
				break;
			default:	//empty folder
				if($b[$i + 1]) $css = 'join_item';
				else $css = 'join_end';
				echo '<DIV class="menu_tree_item"><DIV><DIV class="'.$css.'">&nbsp;</DIV><a href="'.$tree->empty.$a[0].'" target="content" class="menu_tree_link" onclick="openLink(this)"'.$style.'>'.$name_html.'</a></DIV></DIV>';
				++$i;
		}
	}
}