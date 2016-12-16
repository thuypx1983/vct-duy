<?php 
require('../../config.php');
require('../inc/common.php');
require('../config.php');
require('../inc/dbcon.php');
require('modulelinkexchange.php');
require('../inc/session-linkex.php');?>
<?php
$act=0;
if($_GET['act'])$act = (int)$_GET['act'];
switch($act){
	case 0:
		$LXid=NULL;
		if($_GET['LXid']){
			$LXid = (int)$_GET['LXid'];
			$item = new linkexchange();
			$item->id = $LXid;
			$item->loadonerow();
			$catid = (int)linkexchange::getcatfield($item->id,'id');
			$ctrl = NULL;
			$page=1;$pagecount=0;$pagesize=15;$stop=false;
			do{
				$rs = linkexchange::pagelist($page,$pagecount,$pagesize,$catid,$ctrl);
				if($row = mysql_fetch_assoc($rs)){
					do{
						if($row['id'] == $item->id){
							$stop = true;
							break;
						}
					}while($row = mysql_fetch_assoc($rs));
				}
				if($stop)break;
				$page = $page + 1;
				mysql_free_result($rs);
			}while(!$stop);
			echo "?CLid=".linkexchange::getcatfield($item->id,'name')."&page=".$page."&LXid=".$item->id;
		}
		break;
	case 1:
		$LXid=NULL;
		if($_GET['LXid']){
			$LXid = (int)$_GET['LXid'];
			$item = new linkexchange();
			$item->id = $LXid;
			$item->loadonerow();
		}
		break;
	default:
		break;
}
?>
<?php dbclose();?>