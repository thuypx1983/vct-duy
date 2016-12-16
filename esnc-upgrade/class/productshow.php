<?php
//tienpd@esnadvanced.com
//truoc khi include file nay phai include file PATH_COMPLS.'product.php'
function get_firstCP_ofRoot($cat_ctrl=CATPRODUCT_CTRL_SHOW){
	$field = '`a`.`id`,`a`.`name`,`a`.`ctrl`,`a`.`img1`,`a`.`alt1`,`a`.`desc`,`a`.`view`,`a`.`parentid`,`a`.`name` as `title`,`a`.`layout` ';
	$from = '`#catproduct` as `a`';
	$where = '`a`.`parentid` IS NULL and `a`.`ctrl`&'.((string)$cat_ctrl).' = '.((string)$cat_ctrl);
	$more = 'ORDER BY `a`.`parentid`,`a`.`view`,`a`.`id`';
	$rs = mysql_select($field,$from,$where,$more,0,1); 
	if(mysql_affected_rows()>0)
		return mysql_fetch_object($rs);
	else return null;
}
//end tienpd@esnadvanced.com
?>