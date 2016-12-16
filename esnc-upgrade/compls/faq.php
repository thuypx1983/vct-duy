<?php /* vinhtx 22-Mar-2006 */
#require_once('../inc/dbconguest.php');
#require_once('../inc/commonguest.php');
function faqpagelist(&$page,&$pagesize,&$pagecount,$hint=NULL,$ctrl=1){
        global $sql;
        $sql = "SELECT `fa`.`id`,`fa`.`question`,`fa`.`ctrl` FROM `".DB_TABLE_PREFIX."faq` as `fa` WHERE `fa`.`ctrl` & {$ctrl} = {$ctrl}";
        $sql1 = "SELECT count(*) FROM `".DB_TABLE_PREFIX."faq` as `fa` WHERE `fa`.`ctrl` & {$ctrl} = {$ctrl}";
        if($hint != NULL && strlen($hint) > 3 && strpos($hint,"'") === FALSE){
                $sql .= " AND `fa`.`keyword` LIKE '%{$hint}%' OR `fa`.`question` LIKE '%{%hint}%'";
                $sql1 .= " AND `fa`.`keyword` LIKE '%{$hint}%' OR `fa`.`question` LIKE '%{%hint}%'";
        }
        if(is_int($page) && is_int($pagesize)){
                $rs = mysql_query($sql1);
                $rw = mysql_fetch_row($rs);
                $rcount = (int)$rw[0];
                mysql_free_result($rs);
                if($pagesize < 5) $pagesize = 5;
                $pagecount = ceil($rcount / $pagesize);
                if($page < 1) $page = $pagecount;
                if($page > $pagecount) $page = 1;
                if($pagecount > 1) {
                        $rcount=($page - 1) * $pagesize;
                        $sql .= " LIMIT {$rcount}, {$pagesize}";
                }
        }
        return mysql_query($sql);
}
function faqlist($num=NULL,$ctrl=FAQ_CTRL_SHOW){
        global $sql;
        $ctrl |= FAQ_CTRL_SHOW;
        $sql = "SELECT `fa`.`id`,`fa`.`question`,`fa`.`ctrl` FROM `".DB_TABLE_PREFIX."faq` as `fa` WHERE `fa`.`ctrl` & {$ctrl} = {$ctrl}";
        if($num != NULL) $sql .= " LIMIT {$num}";
        return mysql_query($sql);
}
function faqread($FAid,&$FAanswer,&$FAquestion){
        global $sql;
        $ctrl = FAQ_CTRL_SHOW;
        if($FAquestion === NULL){
                $sql = "SELECT `fa`.`answer` FROM `".DB_TABLE_PREFIX."faq` as `fa` WHERE `fa`.`id` = {$FAid} AND `fa`.`ctrl` & {$ctrl} = {$ctrl}";
                $rw=mysql_fetch_row($rs=mysql_query($sql));
                mysql_free_result($rs);
                $FAanswer = (string)$rw[0];
        }else{
                $sql = "SELECT `fa`.`answer`,`fa`.`question` FROM `".DB_TABLE_PREFIX."faq` as `fa` WHERE `fa`.`id` = {$FAid} AND `fa`.`ctrl` & {$ctrl} = {$ctrl}";
                $rw=mysql_fetch_row($rs=mysql_query($sql));
                mysql_free_result($rs);
                $FAanswer = (string)$rw[0];
                $FAquestion = (string)$rw[1];
        }
}
?>