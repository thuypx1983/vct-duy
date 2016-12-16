<?php
function getWizardName($id){
	if (!is_int($id)) return;
	$sql = "SELECT `name` FROM `".DB_TABLE_PREFIX."wizard` WHERE `id`=".$id;
	if ($rs = mysql_query($sql)){
		$row = mysql_fetch_assoc($rs);
		return $row['name'];
	}
	return FALSE;
}
function wizardlist($ctrl = WIZARD_CTRL_SHOW){
	$sql = 'SELECT `id`,`name`,`ctrl`,`desc` FROM `'.DB_TABLE_PREFIX.'wizard` as `w` WHERE `ctrl`&'.$ctrl.'='.$ctrl.'  ORDER BY `w`.`view` ASC';
	if ($rs = mysql_query($sql)) return $rs;
	return FALSE;
}
function wizardshow($id){
	if (!is_int($id)) return FALSE;
	$sql = "SELECT `w`.`id`,`w`.`name` as `name`,`w`.`catid`  FROM `".DB_TABLE_PREFIX."wizarditem` as `w` WHERE `w`.`wid`= ".$id." ORDER BY `w`.`view` ASC";
	if ($rs = mysql_query($sql)) return $rs;
	return FALSE;		
}
function productwizardlist($catlist,$ctrl=PRODUCT_CTRL_SHOW){
	if (!preg_match('/^(\d+,)*\d+$/',$catlist)) return;
	$sql = "SELECT `p`.`id`,`p`.`name`,`p`.`ctrl`,`p`.`saleprice`,`c`.`catproductid` AS `catid` FROM `".DB_TABLE_PREFIX."product` AS `p` LEFT JOIN `".DB_TABLE_PREFIX."catproductproduct` AS `c` ON `p`.`id`=`c`.`productid` WHERE `c`.`catproductid` IN ($catlist) AND `p`.`ctrl`&$ctrl=$ctrl";
	if ($rs = mysql_query($sql)) return $rs;
	return FALSE;
}?>
