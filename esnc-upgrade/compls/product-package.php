<?php //ngocdq
// functions support package price
//2 table for part comfort:productcomfort and productlistcomfort
//function support add,remove,modify list comfort in productlistcomfort table
function comfortlist(){
	_trace(__FUNCTION__);
	global $sql;
	$sql = "SELECT `id`,`name` FROM `".DB_TABLE_PREFIX."productlistcomfort`";
	_trace($sql);
	mysql_query($sql);		
}

function comfortadd($name,$id=NULL){
	_trace(__FUNCTION__);
	global $sql;
	if($id!=NULL){
		$sql = 'UPDATE `'.DB_TABLE_PREFIX.'productlistcomfort` SET `name`="'.$name.'" WHERE `id`='.(int)$id;
	}else{
		$sql = 'REPLACE INTO `'.DB_TABLE_PREFIX.'productlistcomfort`(`name`) VALUES ("'.$name.'")';
	}
	_trace($sql);			
//	echo $sql;
	mysql_query($sql);
}
function comfortremove($id){
	_trace(__FUNCTION__);
	global $sql;
	$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'productlistcomfort` WHERE `id`='.(int)$id;
	_trace($sql);			
//	echo $sql;
	mysql_query($sql);
}
function getcomfort($PDid,&$PGid){
	_trace(__FUNCTION__);
	global $sql;
	$sql = "SELECT DISTINCT `a`.`id`,`a`.`name` FROM `".DB_TABLE_PREFIX."productlistcomfort` as `a` LEFT JOIN `".DB_TABLE_PREFIX."productcomfort` as `b` ON ".
			"`a`.`id`=`b`.`ProductListComfortId` WHERE `b`.`ProductId`=".(int)$PDid." AND (";	
	$max = end($PGid);
	foreach($PGid as $key=>$arr){
		if(array_diff($max,$arr)!=NULL){
			foreach($arr as $id=>$value){
				$sql.="`b`.`ProductPackageId`=".(int)$value." OR ";
			}	
		}else{
			foreach($arr as $id=>$value){
				$sql.="`b`.`ProductPackageId`=".(int)$value."";
			}	
		}
	}		
	$sql.=")";
	_trace($sql);
	return mysql_query($sql);
}

function showcomfort($PDid,$PGname){
	_trace(__FUNCTION__);
	global $sql;
	$sql='SELECT DISTINCT `a`.`id`,`a`.`name` FROM `'.DB_TABLE_PREFIX.'productlistcomfort` as `a` LEFT JOIN `'.DB_TABLE_PREFIX.'productcomfort` as `b`'. 
	'ON `a`.`id`=`b`.`ProductListComfortId` LEFT JOIN `'.DB_TABLE_PREFIX.'productpackage` as `p` ON `b`.`ProductPackageId` = `p`.`id` WHERE `b`.`ProductId`='.(int)$PDid.' AND `p`.`name`="'.(string)$PGname.'"';
	_trace($sql);
	return mysql_query($sql);
}


?>