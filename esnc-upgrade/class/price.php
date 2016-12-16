<?php //tienpd@esnadvanced.com
require(PATH_COMPLS.'price.php');
function pricesetup(){
	global $sql,$PRODUCT_PACKAGE_CLASS,$PRODUCT_PACKAGE_TYPE_ALIAS;
	$con = mysql_connect (DB_HOST,DB_USER_ADMIN,DB_PWD_ADMIN) or die (mysql_error());
	mysql_select_db(DB_NAME,$con) or die (mysql_error());
	$sql="SHOW TABLES LIKE '".DB_TABLE_PREFIX."productpackage'";
	$row=mysql_fetch_array(mysql_query($sql));
	if(($row[0]==null)||($row[0]=="")){
		$sql='DROP TABLE IF EXISTS `'.DB_TABLE_PREFIX.'productpackage`;';
		mysql_query($sql);
		$sql='CREATE TABLE `'.DB_TABLE_PREFIX.'productpackage` (
		  `ID` bigint(20) unsigned NOT NULL auto_increment,
		  `ProductID` bigint(20) unsigned ,
		  `Class` varchar(255) NOT NULL ,
		  `Name` varchar(255) NOT NULL ,
		  `Code` varchar(255) default NULL,
		  `Desc` text default NULL,
		  `Detail` text default NULL,
		  `Desc2` text default NULL,    
		  `Extra` varchar(255) default NULL,
		  `Img` varchar(255) default NULL,
		  `Alt` varchar(255) default NULL,
		  `Img1` varchar(255) default NULL,
		  `Alt1` varchar(255) default NULL,
		  `Rank` int(11) unsigned default \'0\',
		  `Rate` int(11) unsigned default \'0\',
		  `RateCount` int(11) unsigned default \'0\',
		  `PackageNo` int(11) unsigned default \'0\',
		  `Type` int(11) unsigned default \'0\',
		  `Status` int(11) unsigned default \'0\',
		  `Ctrl` bigint(20) unsigned zerofill NOT NULL default \'00000000000000000000\',
		  `View` int(11) default NULL,
		  PRIMARY KEY  (`ID`),
		  KEY `ProductID` (`ProductID`),
		  CONSTRAINT `'.DB_TABLE_PREFIX.'productpackage_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `'.DB_TABLE_PREFIX.'product` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
		if(mysql_query($sql)){
			$sql='DROP TABLE IF EXISTS `'.DB_TABLE_PREFIX.'quotation`;';
			mysql_query($sql);
			$sql='CREATE TABLE `'.DB_TABLE_PREFIX.'quotation` (
			  `ID` bigint(20) unsigned NOT NULL auto_increment,
			  `ProductID` bigint(20) unsigned default NULL,
			  `ProductPackageClass` varchar(255) NOT NULL ,  
			  `ProductPackageID` bigint(20) unsigned NOT NULL,
			  `Name` varchar(255) default NULL ,  
			  `StartDate` datetime default NULL ,
			  `Currency` varchar(11) default \'USD\',
			  `Qty1` int(11) unsigned default \'1\',
			  `Qty2` int(11) unsigned default \'1\',
			  `Qty3` int(11) unsigned default \'1\',
			  `Qty4` int(11) unsigned default \'1\',      
			  `Price` decimal(15,5) default \'0.00000\',
			  `Discount` decimal(15,5) default \'0.00000\',
			  `Tax` decimal(15,5) default \'0.00000\',
			  `Code` varchar(11) default NULL,
			  `Desc` varchar(255) default NULL ,
			  `Ctrl` bigint(20) unsigned zerofill default \'00000000000000000000\',
			  PRIMARY KEY  (`ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
			mysql_query($sql);		
			$sql='CREATE TABLE `'.DB_TABLE_PREFIX.'productlistcomfort` (
			  `Id` bigint(20) unsigned NOT NULL auto_increment,
			  `Name` text default NULL,				 				  
			  PRIMARY KEY  (`ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
			mysql_query($sql);				
			$sql='CREATE TABLE `'.DB_TABLE_PREFIX.'productcomfort` (
			  `Id` bigint(20) unsigned NOT NULL auto_increment,
			  `ProductID` bigint(20) unsigned default NULL,				 
			  `ProductPackageId` bigint(20) unsigned NOT NULL,
			  `ProductListComfortId` bigint(20) unsigned NOT NULL,  
			  PRIMARY KEY  (`ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
			mysql_query($sql);	
		}
	}
	$temp = $PRODUCT_PACKAGE_TYPE_ALIAS;
	/*while(list($i,$val) = each($temp )){
		if(is_int($i)){
			$temp1 = $PRODUCT_PACKAGE_CLASS[$i];		
			while(list($j,$val1) = each($temp1)){
				$sql="DELETE FROM `".DB_TABLE_PREFIX."productpackage` WHERE `class`='".$val1."' AND `type` >=".count($val[$j]);
				mysql_query($sql);					
				for($k=0;$k<count($val[$j]);$k++){
					$sql="SELECT `id` FROM `".DB_TABLE_PREFIX."productpackage` WHERE `class`='".$val1."' AND `name`='base' AND `type`=".$k." limit 1";
					$rs=mysql_query($sql);
					if(mysql_affected_rows()==0){
						$sql="INSERT INTO `".DB_TABLE_PREFIX."productpackage`(`Class`,`Name`,`Type`) VALUES ('".$val1."','base',".$k.")";
						mysql_query($sql);
					}
				}
			}
		}
	}*/
}
pricesetup();
/*function package_filter($tb_Alias,$filter_fields='',$productid=-1,$class='',$name='',$type=-1,$code='',$desc='',$rank=-1,$status=-1,$ctrl=-1,$top=-1,$sort=''){
	global $sql;
	if(!is_int($productid)) return FALSE;
	$wh = '';
	if	($productid >= 0){
		if	($filter_fields == '')
			$filter_fields = '`{0}`.`id`,`{0}`.`productid`,`{0}`.`class`,`{0}`.`name`,`{0}`.`code`,`{0}`.`desc`,`{0}`.`extra`,`{0}`.`img`,`{0}`.`alt`,`{0}`.`img1`,`{0}`.`alt1`,`{0}`.`rank`,`{0}`.`rate`,`{0}`.`ratecount`,`{0}`.`packageno`,`{0}`.`type`,`{0}`.`status`,`{0}`.`ctrl`,`{0}`.`view`';
		else 
			$filter_fields = '`{0}`.`productid`,`{0}`.`class`,'.$filter_fields;
		$wh .= "AND `{0}`.`productid` = {$productid} ";	
	}
	else{
		if	($filter_fields == '')
			$filter_fields = '`{0}`.`id`,`{0}`.`productid`,`{0}`.`class`,`{0}`.`name`,`{0}`.`code`,`{0}`.`desc`,`{0}`.`extra`,`{0}`.`img`,`{0}`.`alt`,`{0}`.`img1`,`{0}`.`alt1`,`{0}`.`rank`,`{0}`.`rate`,`{0}`.`ratecount`,`{0}`.`packageno`,`{0}`.`type`,`{0}`.`status`,`{0}`.`ctrl`,`{0}`.`view`';
		else 
			$filter_fields = '`{0}`.`class`,'.$filter_fields;
	}
	if	($class != '') {$wh .= "AND `{0}`.`class` = '{$class}' ";}
	if	($name != '') {$wh .= "AND `{0}`.`name` = '{$name}' ";}
	if	((is_int($type))&&($type >= 0)) {$wh .= "AND `{0}`.`type` = {$type} ";} 
	if	($code != '') {$wh .= "AND `{0}`.`code` = '{$code}' ";}
	if	($desc != '') {$wh .= "AND `{0}`.`desc` = '{$desc}' ";}
	if	((is_int($rank))&&($rank >= 0)) {$wh .= "AND `{0}`.`rank` = {$rank} ";} 
	if	((is_int($status))&&($status >= 0)) {$wh .= "AND `{0}`.`status` = {$status} ";} 
	if	((is_int($ctrl))&&($ctrl >= 0)) {$wh .= "AND `{0}`.`ctrl` & {$ctrl} = {$ctrl} ";}
	if	($wh!='')$wh = 'WHERE'.substr($wh,4);
	if	($top <= 0)$sql =  'SELECT DISTINCT '.$filter_fields." FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} ";
	else $sql =  'SELECT DISTINCT '.$filter_fields." FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} LIMIT {$top} ";
	if	($tb_Alias!=''){
		$sql = str_replace($tb_Alias,'{0}',$sql);
		$sql = str_replace('{0}','productpackage',$sql);
	}
	return mysql_query($sql);
}
function price_load_markers($PDid=-1,$PGClass='',$PGid=-1,$isASC=true){
	global $sql;
	if(!is_int($PDid)) return FALSE;
	if($PDid < 0)return FALSE;
	$wh = "WHERE `{0}`.`productid` = {$PDid} ";
	if ($PGClass != '') {$wh .= "AND `{0}`.`productpackageclass` = '{$PGClass}' ";}
	if ((is_int($PGid))&&($PGid >= 0)) {$wh .= "AND `{0}`.`productpackageid` = {$PGid} ";} 
	if($isASC==true)
		$sql ="SELECT DISTINCT `{0}`.`name`,DATE_FORMAT(`{0}`.`startdate`,'".FORMAT_DB_DATETIME."') as `startdate` FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} ORDER BY `{0}`.`startdate` asc";
	else
		$sql ="SELECT DISTINCT `{0}`.`name`,DATE_FORMAT(`{0}`.`startdate`,'".FORMAT_DB_DATETIME."') as `startdate` FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} ORDER BY `{0}`.`startdate` desc";
	$sql = str_replace('{0}','quotation',$sql);
	return mysql_query($sql);
}
function price_load_arr_markdates($PDid=-1,$PGClass='',$PGid=-1,$isASC=true,&$marknames){
	global $sql;
	if(!is_int($PDid)) return FALSE;
	if($PDid < 0)return FALSE;
	$wh = "WHERE `{0}`.`productid` = {$PDid} ";
	if ($PGClass != '') {$wh .= "AND `{0}`.`productpackageclass` = '{$PGClass}' ";}
	if ((is_int($PGid))&&($PGid >= 0)) {$wh .= "AND `{0}`.`productpackageid` = {$PGid} ";} 
	if($isASC==true)$sql ="SELECT DISTINCT `{0}`.`name`,DATE_FORMAT(`{0}`.`startdate`,'".FORMAT_DB_DATETIME."') as `startdate` FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} ORDER BY `{0}`.`startdate` asc";
	else $sql ="SELECT DISTINCT `{0}`.`name`,DATE_FORMAT(`{0}`.`startdate`,'".FORMAT_DB_DATETIME."') as `startdate` FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} ORDER BY `{0}`.`startdate` desc";
	$sql = str_replace('{0}','quotation',$sql);
	$rs = mysql_query($sql);
	$markdates = array();
	$marknames = array();
	while($row = mysql_fetch_assoc($rs)){
		$markdates[] = mysql_format_datetime($row['startdate']);
		$marknames[] =  $row['name'];
	}
	return $markdates;
}
function price_load($PDid=-1,$PGClass='',$PGid=-1,$startdate=null,$ctrl=-1){
	global $sql;
	if(!is_int($PDid)) return 0;
	if($PDid < 0)return 0;
	if(!is_int($PGid)) return 0;
	if($PGid < 0)return 0;
	if($PGClass == '')return 0;
	if ($startdate == null) $startdate = mysql_format_datetime(date(FORMAT_DB_DATETIME));
	$markdates = price_load_arr_markdates($PDid,$PGClass,$PGid,true,$marknames);
	if(count($markdates)<=0)return 0;
	$rs = min($markdates);
	for($i=0;$i<count($markdates);$i++){
		if((strtotime($startdate) - strtotime($markdates[$i])) < 0){
			$rs = min($markdates);
			if(($i+1)==count($markdates))break;
		}
		else{
			$rs = $markdates[$i];
			if(($i+1)==count($markdates))break;
			if((strtotime($startdate) - strtotime($markdates[$i+1])) < 0)break;
		}
	}
	$startdate = $rs;
	$wh = "WHERE `{0}`.`productid` = {$PDid} ";
	$wh .= "AND `{0}`.`productpackageclass` = '{$PGClass}' ";
	$wh .= "AND `{0}`.`productpackageid` = {$PGid} ";
	$wh .= "AND `{0}`.`startdate` = '{$startdate}' ";
	if ((is_int($ctrl))&&($ctrl >= 0)) {$wh .= "AND `{0}`.`ctrl` = {$ctrl} ";}
	$sql ="SELECT `{0}`.`price` FROM `".DB_TABLE_PREFIX."{0}` as `{0}` {$wh} ";
	$sql = str_replace('{0}','quotation',$sql);
	$row = mysql_fetch_row(mysql_query($sql));
	if($row){
		return $row[0];
	}else return 0;
}
*/
class price_group{
	var $productid,$productpackageclass,$startdate,$enddate,$name,$currency;
	var $o_startdate,$o_name,$o_currency;
	var $productpackageid,$price;
	function __construct(){}
	function save(){
		global $sql;
		_trace(__FUNCTION__);
		$this->productpackageid = explode(';',$this->productpackageid);
		$this->price = explode(';',$this->price);
		if(count($this->productpackageid) > 0){
			for($i=0;$i<count($this->productpackageid);++$i){
				if((int)($this->productpackageid[$i]) >= 0){
					$sql = 
						"SELECT * FROM `".DB_TABLE_PREFIX."quotation` ".
						"WHERE ".
						"`productid`='{$this->productid}' AND ".
						"`productpackageclass`='{$this->productpackageclass}' AND ";
					if($this->o_startdate!=null)$sql .= "`startdate`='{$this->o_startdate}' AND ";
					if($this->o_name!=null)$sql .= "`name`='{$this->o_name}' AND ";
					if($this->o_currency!=null)$sql .= "`currency`='{$this->o_currency}' AND ";
					$sql .= "`productpackageid`='{$this->productpackageid[$i]}'";
					//echo $sql.'<br/>';
					_trace($sql);
					$count=0;
					$rs = mysql_query($sql);
					if($rs){while(mysql_fetch_assoc($rs))$count++;}
					
					if(($this->o_startdate==null)||($count==0)){
						if($this->productpackageid[$i]!=''){
							$sql = "INSERT INTO `".DB_TABLE_PREFIX."quotation`(`productid`,`productpackageclass`,`name`,`startdate`,`productpackageid`,`price`)";
							$sql .= "VALUES (".
								"'".(int)$this->productid."',".
								"'".mysql_real_escape_string($this->productpackageclass)."',".
								"'".mysql_real_escape_string($this->name)."',".
								"'".$this->startdate."',";
							$sql .= "'".(int)$this->productpackageid[$i]."',".
								"'".$this->price[$i]."'".
								")";
							_trace($sql);
							//echo $sql.'<br/>';
							mysql_query($sql);
						}
					}else{
						if($this->productpackageid[$i]!=''){
							$sql = 
								"UPDATE `".DB_TABLE_PREFIX."quotation` SET ";
							if($this->name!=null)$sql .= "`name`='".mysql_real_escape_string($this->name)."',";
							if($this->startdate!=null)$sql .= "`startdate`='".mysql_real_escape_string($this->startdate)."',";
							if($this->currency!=null)$sql .= "`currency`='".mysql_real_escape_string($this->currency)."',";
							$sql.=	"`price`='".$this->price[$i]."' ".
								"WHERE ".
								"`productid`='{$this->productid}' AND ".
								"`productpackageclass`='{$this->productpackageclass}' AND ";
							if($this->o_startdate!=null)$sql .= "`startdate`='{$this->o_startdate}' AND ";
							if($this->o_name!=null)$sql .= "`name`='{$this->o_name}' AND ";
							if($this->o_currency!=null)$sql .= "`currency`='{$this->o_currency}' AND ";
							$sql .= "`productpackageid`='{$this->productpackageid[$i]}'";
							_trace($sql);
							//echo $sql.'<br/>';
							mysql_query($sql);
							
						}
					}
				}
			}
		}
	}
	function remove(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "DELETE FROM `".DB_TABLE_PREFIX."quotation` ".
			"WHERE ".
			"`productid`='{$this->productid}' AND ".
			"`productpackageclass`='{$this->productpackageclass}' AND ";
		if($this->o_startdate!=null)$sql .= "`startdate`='{$this->o_startdate}' AND ";
		if($this->o_name!=null)$sql .= "`name`='{$this->o_name}' AND ";
		if($this->o_currency!=null)$sql .= "`currency`='{$this->o_currency}' AND ";
		$sql = substr($sql,0,count($sql)-5);
		_trace($sql);
		//echo $sql.'<br/>';
		return mysql_query($sql);
	}
}
class package_group{
	var $productid,$class,$name,$code,$desc,$detail,$desc2,$extra,$img,$alt,$img1,$alt1;
	var $o_name,$o_code,$o_desc,$o_detail,$o_desc2,$o_extra,$o_img,$o_alt,$o_img1,$o_alt1;
	var $rank,$rate,$ratecount,$packageno,$type,$status,$ctrl,$view;
	var $l_type; //bien de add tien ich phong
	function __construct(){}
	function fetch(){
		_trace(__FUNCTION__);
		$this->productid=(int)$_POST['productid'];
		$this->class=(string)$_POST['class'];
		$this->name=(string)$_POST['name'];
		$this->code=(string)$_POST['code'];
		$this->desc=(string)$_POST['desc'];
		if($_POST['rte_word_autotag'] || $_POST['rte_tag_desc']) RTE::normalizeHTML($this->desc); 
		$this->detail=(string)$_POST['detail'];
		if($_POST['rte_word_autotag'] || $_POST['rte_tag_detail']) RTE::normalizeHTML($this->detail); 
		$this->desc2=(string)$_POST['desc2'];
		if($_POST['rte_word_autotag'] || $_POST['rte_tag_desc2']) RTE::normalizeHTML($this->desc2); 
		$this->extra=(string)$_POST['extra'];
		if($_POST['rte_word_autotag'] || $_POST['rte_tag_extra']) RTE::normalizeHTML($this->extra); 
		$this->img=(string)$_POST['img'];
		$this->alt=(string)$_POST['alt'];
		$this->img1=(string)$_POST['img1'];
		$this->alt1=(string)$_POST['alt1'];
		
		$this->o_name=(string)$_POST['o_name'];
		$this->o_code=(string)$_POST['o_code'];
		$this->o_desc=(string)$_POST['o_desc'];
		if($_POST['rte_word_autotag'] || $_POST['rte_tag_desc']) RTE::normalizeHTML($this->o_desc); 
		$this->o_detail=(string)$_POST['o_detail'];
		if($_POST['rte_word_autotag'] || $_POST['rte_tag_detail']) RTE::normalizeHTML($this->o_detail); 
		$this->o_desc2=(string)$_POST['o_desc2'];
		if($_POST['rte_word_autotag'] || $_POST['rte_tag_desc2']) RTE::normalizeHTML($this->o_desc2); 
		$this->o_extra=(string)$_POST['o_extra'];
		if($_POST['rte_word_autotag'] || $_POST['rte_tag_extra']) RTE::normalizeHTML($this->o_extra); 
		$this->o_img=(string)$_POST['o_img'];
		$this->o_alt=(string)$_POST['o_alt'];
		$this->o_img1=(string)$_POST['o_img1'];
		$this->o_alt1=(string)$_POST['o_alt1'];
		$this->type=(string)$_POST['type'];
		$this->l_type=@(int)$_POST['l_type'];
	}
	function save(){
		global $sql;
		_trace(__FUNCTION__);
		$this->type=explode(',',$this->type);
		if(count($this->type)>0){
			for($i=0;$i<count($this->type);++$i){
				if((int)($this->type[$i]) >= 0){
					$sql = 
						"SELECT * FROM `".DB_TABLE_PREFIX."productpackage` ".
						"WHERE ".
						"`productid`='{$this->productid}' AND ".
						"`class`='{$this->class}' AND ";
					if($this->name!=null)$sql .= "`name`='{$this->name}' AND ";
					if($this->code!=null)$sql .= "`code`='{$this->code}' AND ";					
					$sql .= "`type`='{$this->type[$i]}'";
					_trace($sql);
					$count=0;
					$rs = mysql_query($sql);
					if($rs){
						while(mysql_fetch_assoc($rs)) $count++;
					}
					//array_pop($this->type);
					if(($this->name==null)||($count==0)){						
						if($this->type[$i]!=''){
							$sql = "INSERT INTO `".DB_TABLE_PREFIX."productpackage`(`productid`,`class`,`name`,";
							if($this->code!=null) $sql .= "`code`,";
							if($this->desc!=null) $sql .= "`desc`,";
							if($this->detail!=null) $sql .= "`detail`,";
							if($this->desc2!=null) $sql .= "`desc2`,";							
							if($this->extra!=null) $sql .= "`extra`,";
							if($this->img!=null) $sql .= "`img`,";
							if($this->alt!=null) $sql .= "`alt`,";
							if($this->img1!=null) $sql .= "`img1`,";
							if($this->alt1!=null) $sql .= "`alt1`,";
							$sql .= '`type`,`ctrl`) '.
								"VALUES (".
								"'".(int)$this->productid."',".
								"'".mysql_real_escape_string($this->class)."',".
								"'".mysql_real_escape_string($this->name)."',";
							if($this->code!=null) $sql .= "'".mysql_real_escape_string($this->code)."',";
							if($this->desc!=null) $sql .= "'".mysql_real_escape_string($this->desc)."',";
							if($this->detail!=null) $sql .= "'".mysql_real_escape_string($this->detail)."',";
							if($this->desc2!=null) $sql .= "'".mysql_real_escape_string($this->desc2)."',";							
							if($this->extra!=null) $sql .= "'".mysql_real_escape_string($this->extra)."',";
							if($this->img!=null) $sql .= "'".mysql_real_escape_string($this->img)."',";
							if($this->alt!=null) $sql .= "'".mysql_real_escape_string($this->alt)."',";
							if($this->img1!=null) $sql .= "'".mysql_real_escape_string($this->img1)."',";
							if($this->alt1!=null) $sql .= "'".mysql_real_escape_string($this->alt1)."',";
							$sql .= "'".(int)$this->type[$i]."',".
								"'1'".
								")";
							_trace($sql);
							//echo $sql.'<br/>';
							mysql_query($sql);
						}
					}else{						
						if($this->type[$i]!=''){
							$sql = 
								"UPDATE `".DB_TABLE_PREFIX."productpackage` SET ";
							if($this->code!=null)$sql .= "`Code`='".mysql_real_escape_string($this->code)."',";
							if($this->desc!=null)$sql .= "`Desc`='".mysql_real_escape_string($this->desc)."',";
							if($this->detail!=null)$sql .= "`Detail`='".mysql_real_escape_string($this->detail)."',";
							if($this->img!=null)$sql .= "`Img`='".mysql_real_escape_string($this->img)."',";
							if($this->alt!=null)$sql .= "`Alt`='".mysql_real_escape_string($this->alt)."',";
							if($this->img1!=null)$sql .= "`Img1`='".mysql_real_escape_string($this->img1)."',";
							if($this->alt1!=null)$sql .= "`Alt1`='".mysql_real_escape_string($this->alt1)."',";
							$sql.=	"`Ctrl`='1' ".
								"WHERE ".								
								"`Name`='".mysql_real_escape_string($this->name)."' AND ".
								"`productid`='{$this->productid}' AND ".
								"`class`='{$this->class}' AND ";
							/*if($this->o_name!=null)$sql .= "`name`='{$this->o_name}' AND ";
							if($this->o_code!=null)$sql .= "`code`='{$this->o_code}' AND ";
							if($this->o_desc!=null)$sql .= "`desc`='{$this->o_desc}' AND ";
							if($this->o_detail!=null)$sql .= "`detail`='{$this->o_detail}' AND ";
							if($this->o_desc2!=null)$sql .= "`desc2`='{$this->o_desc2}' AND ";
							if($this->o_extra!=null)$sql .= "`extra`='{$this->o_extra}' AND ";
							if($this->o_img!=null)$sql .= "`img`='{$this->o_img}' AND ";
							if($this->o_alt!=null)$sql .= "`alt`='{$this->o_alt}' AND ";
							if($this->o_img1!=null)$sql .= "`img1`='{$this->o_img1}' AND ";
							if($this->o_alt1!=null)$sql .= "`alt1`='{$this->o_alt1}' AND ";*/
							$sql .= "`type`='{$this->type[$i]}'";
							_trace($sql);		
							//echo $sql.'<br/>';					
							mysql_query($sql);							
						}
					}
				}
			}	
		}
		_trace(mysql_error());
	}
	function remove(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "DELETE FROM `".DB_TABLE_PREFIX."quotation` USING `".DB_TABLE_PREFIX."productpackage`,`".DB_TABLE_PREFIX."quotation`".
			"WHERE `".DB_TABLE_PREFIX."quotation`.`productpackageid`=`".DB_TABLE_PREFIX."productpackage`.`id` AND".
			"`".DB_TABLE_PREFIX."productpackage`.`productid`='{$this->productid}' AND ".
			"`".DB_TABLE_PREFIX."productpackage`.`class`='{$this->class}' AND ";
		if($this->o_name!=null)$sql .= "`".DB_TABLE_PREFIX."productpackage`.`name`='{$this->o_name}' AND ";
		if($this->o_code!=null)$sql .= "`".DB_TABLE_PREFIX."productpackage`.`code`='{$this->o_code}' AND ";
		if($this->o_desc!=null)$sql .= "`".DB_TABLE_PREFIX."productpackage`.`desc`='{$this->o_desc}' AND ";
		if($this->o_detail!=null)$sql .= "`".DB_TABLE_PREFIX."productpackage`.`detail`='{$this->o_detail}' AND ";
		if($this->o_desc2!=null)$sql .= "`".DB_TABLE_PREFIX."productpackage`.`desc2`='{$this->o_desc2}' AND ";
		if($this->o_extra!=null)$sql .= "`".DB_TABLE_PREFIX."productpackage`.`extra`='{$this->o_extra}' AND ";
		if($this->o_img!=null)$sql .= "`".DB_TABLE_PREFIX."productpackage`.`img`='{$this->o_img}' AND ";
		if($this->o_alt!=null)$sql .= "`".DB_TABLE_PREFIX."productpackage`.`alt`='{$this->o_alt}' AND ";
		if($this->o_img1!=null)$sql .= "`".DB_TABLE_PREFIX."productpackage`.`img1`='{$this->o_img1}' AND ";
		if($this->o_alt1!=null)$sql .= "`".DB_TABLE_PREFIX."productpackage`.`alt1`='{$this->o_alt1}' AND ";
		$sql = substr($sql,0,count($sql)-5);
		_trace($sql);
		mysql_query($sql);
		$sql = "DELETE FROM `".DB_TABLE_PREFIX."productpackage` ".
			"WHERE ".
			"`productid`='{$this->productid}' AND ".
			"`class`='{$this->class}' AND ";
		if($this->o_name!=null)$sql .= "`name`='{$this->o_name}' AND ";
		if($this->o_code!=null)$sql .= "`code`='{$this->o_code}' AND ";
		if($this->o_desc!=null)$sql .= "`desc`='{$this->o_desc}' AND ";
		if($this->o_detail!=null)$sql .= "`detail`='{$this->o_detail}' AND ";
		if($this->o_desc2!=null)$sql .= "`desc2`='{$this->o_desc2}' AND ";
		if($this->o_extra!=null)$sql .= "`extra`='{$this->o_extra}' AND ";
		if($this->o_img!=null)$sql .= "`img`='{$this->o_img}' AND ";
		if($this->o_alt!=null)$sql .= "`alt`='{$this->o_alt}' AND ";
		if($this->o_img1!=null)$sql .= "`img1`='{$this->o_img1}' AND ";
		if($this->o_alt1!=null)$sql .= "`alt1`='{$this->o_alt1}' AND ";
		$sql = substr($sql,0,count($sql)-5);
		_trace($sql);
		return mysql_query($sql);
	}
	function setHideAll(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "UPDATE `".DB_TABLE_PREFIX."productpackage` ".
			"SET `Ctrl`='0' ".
			"WHERE ".
			"`productid`='{$this->productid}' AND ".
			"`class`='{$this->class}' AND ";
		if($this->o_name!=null)$sql .= "`name`='{$this->o_name}' AND ";
		if($this->o_code!=null)$sql .= "`code`='{$this->o_code}' AND ";
		if($this->o_desc!=null)$sql .= "`desc`='{$this->o_desc}' AND ";
		if($this->o_detail!=null)$sql .= "`detail`='{$this->o_detail}' AND ";
		if($this->o_desc2!=null)$sql .= "`desc2`='{$this->o_desc2}' AND ";
		if($this->o_extra!=null)$sql .= "`extra`='{$this->o_extra}' AND ";
		if($this->o_img!=null)$sql .= "`img`='{$this->o_img}' AND ";
		if($this->o_alt!=null)$sql .= "`alt`='{$this->o_alt}' AND ";
		if($this->o_img1!=null)$sql .= "`img1`='{$this->o_img1}' AND ";
		if($this->o_alt1!=null)$sql .= "`alt1`='{$this->o_alt1}' AND ";
		$sql = substr($sql,0,count($sql)-5);
		_trace($sql);
		return mysql_query($sql);
	}
	function setShowAll(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "UPDATE FROM `".DB_TABLE_PREFIX."productpackage` ".
			"SET `Ctrl`='1' ".
			"WHERE ".
			"`productid`='{$this->productid}' AND ".
			"`class`='{$this->class}' AND ";
		if($this->o_name!=null)$sql .= "`name`='{$this->o_name}' AND ";
		if($this->o_code!=null)$sql .= "`code`='{$this->o_code}' AND ";
		if($this->o_desc!=null)$sql .= "`desc`='{$this->o_desc}' AND ";
		if($this->o_detail!=null)$sql .= "`detail`='{$this->o_detail}' AND ";
		if($this->o_desc2!=null)$sql .= "`desc2`='{$this->o_desc2}' AND ";
		if($this->o_extra!=null)$sql .= "`extra`='{$this->o_extra}' AND ";
		if($this->o_img!=null)$sql .= "`img`='{$this->o_img}' AND ";
		if($this->o_alt!=null)$sql .= "`alt`='{$this->o_alt}' AND ";
		if($this->o_img1!=null)$sql .= "`img1`='{$this->o_img1}' AND ";
		if($this->o_alt1!=null)$sql .= "`alt1`='{$this->o_alt1}' AND ";
		$sql = substr($sql,0,count($sql)-5);
		_trace($sql);
		//echo $sql.'<br/>';
		return mysql_query($sql);
	}
	function loadonerow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `productid`, `class`, `name`, `code`, `desc`, `detail`, `extra`, `img`, `alt`, `img1`, `alt1`, `rank`, `rate`, `ratecount`, `packageno`, `type`, `status`, `ctrl`, `view` FROM `".DB_TABLE_PREFIX."productpackage` WHERE `id` = {$this->id}";
		$rs=mysql_query($sql);
		_trace(mysql_error());
		$row = mysql_fetch_assoc($rs);
		$this->productid = (int)$row['productid'];
		$this->class = (string)$row['class'];
		$this->name = (string)$row['name'];
		$this->code = (string)$row['code'];
		$this->desc = (string)$row['desc'];
		$this->detail = (string)$row['detail'];
		$this->extra = (string)$row['extra'];
		$this->img = (string)$row['img'];
		$this->alt = (string)$row['alt'];
		$this->img1 = (string)$row['img1'];
		$this->alt1 = (string)$row['alt1'];
		$this->rank = (int)$row['rank'];
		$this->rate = (int)$row['rate'];
		$this->ratecount = (int)$row['ratecount'];
		$this->packageno = (int)$row['packageno'];
		$this->type = (int)$row['type '];
		$this->status = (int)$row['status'];
		$this->ctrl = (int)$row['ctrl'];
		$this->view = (int)$row['view'];
		_trace($sql);
		mysql_free_result($rs);
		return TRUE;
	}
	function loadrow(){
		global $sql;
		_trace(__FUNCTION__);
		settype($this->id,'int');
		$sql = "SELECT `id`, `productid`, `class`, `name`, `code`, `desc`, `extra`, `img`, `alt`, `img1`, `alt1`, `rank`, `rate`, `ratecount`, `packageno`, `type`, `status`, `ctrl`, `view` FROM `".DB_TABLE_PREFIX."productpackage` WHERE `id` = {$this->id}";
		$o=mysql_fetch_object($rs=mysql_query($sql));
		mysql_free_result($rs);
		return $o;
	}
	
	function addcomfort(){
		global $sql;
		_trace(__FUNCTION__);
		$this->l_type=explode(',',$this->l_type);
		array_pop($this->l_type);
		array_pop($this->type);
		$a_id = array();
		$count=0;
		for($j=0;$j<count($this->type);++$j){
			$sql = "SELECT `id` FROM `".DB_TABLE_PREFIX."productpackage` WHERE ".
					"`productid`='{$this->productid}' AND `class`='{$this->class}' AND ";
			if($this->name!=null) $sql .= "`name`='{$this->name}' AND ";
			$sql .= "`type`='{$this->type[$j]}'";
			_trace($sql);						
			$rs = mysql_query($sql);			
			if($rs){
				while($row = mysql_fetch_assoc($rs)) array_push($a_id,$row['id']);
			}
		}
		foreach($a_id as $id){			
			for($i=0;$i<count($this->l_type);++$i){		
				$sql1 = "INSERT INTO `".DB_TABLE_PREFIX."roomcomfort`(`ProductId`,`ProductPackageId`,`ListComfortId`)";
				$sql1 .="VALUES (".(int)$this->productid.",".(int)$id.",".(int)$this->l_type[$i].")";
				_trace($sql1);
				//echo $sql1.'<br/>';
				mysql_query($sql1);
			}
		}
		_trace(mysql_error());
	}
}

class PackageView{
	var $ID;
	var $ProductID,$PackageClass;
	var $ArrayPackageTypesAlias=array();
	var $EnablePackageEdit,$EnablePackageSave,$EnablePackageDel;
	var $btnPackageEditID,$btnPackageSaveID,$btnPackageDeleteID;
	var $EnablePriceEdit,$EnablePriceSave,$EnablePriceDel;
	var $btnPriceEditID,$btnPriceSaveID,$btnPriceDeleteID;
	var $txtPriceName,$txtPriceStartDate,$txtPriceEndDate,$txtPriceOldName,$txtPriceOldStartDate,$txtPriceOldEndDate,$txtPriceValue;
	var $txtPriceNewName,$txtPriceNewStartDate,$txtPriceNewEndDate,$txtPriceNewValue;
	function __construct(){	}
	function load($PdId,$Class){	
		$this->ProductID = $PdId;
		$this->PackageClass = $Class;
		$this->initialize();
	}
	function initialize(){
		if(($this->ProductID < 0)||($this->PackageClass == '')){
			echo 'khong thanh cong trong viec khoi tao doi tuong';
			return false;
		}
		else{
			if((!is_array($this->ArrayPackageTypesAlias))||($this->ArrayPackageTypesAlias==null)){
				$this->ArrayPackageTypesAlias = array(0,1,2,3,4,5,6,7,8,9);
			}
			$this->btnPackageEditID = $this->ID.'_Package_Edit';
			$this->btnPackageSaveID = $this->ID.'_Package_Save';
			$this->btnPackageDeleteID = $this->ID.'_Package_Delete';
			$this->btnPriceEditID = $this->ID.'_Price_Edit';
			$this->btnPriceSaveID = $this->ID.'_Price_Save';
			$this->btnPriceDeleteID = $this->ID.'_Price_Delete';
			$this->txtPriceName = $this->ID.'_Price_Name';
			$this->txtPriceStartDate = $this->ID.'_Price_StartDate';
			$this->txtPriceEndDate = $this->ID.'_Price_EndDate';
			$this->txtPriceOldName = $this->ID.'_Price_Old_Name';
			$this->txtPriceOldStartDate = $this->ID.'_Price_Old_StartDate';
			$this->txtPriceOldEndDate = $this->ID.'_Price_Old_EndDate';
			$this->txtPriceValue = $this->ID.'_Price_Value';
			$this->txtPriceNewName = $this->ID.'_Price_New_Name';
			$this->txtPriceNewStartDate = $this->ID.'_Price_New_StartDate';
			$this->txtPriceNewEndDate = $this->ID.'_Price_New_EndDate';
			$this->txtPriceNewValue = $this->ID.'_Price_New_Value';
		}
	}
	function show(){		
		if($this->ProductID < 0)return false;
		if($this->PackageClass == '')return false;		
		$AllTypeColection = package_filter('PdPk','`PdPk`.`type`',-1,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
		echo '<input type="hidden" value="'.$this->PackageClass.'" name="PackageClass" />';
		echo '<input type="hidden" value="'.$this->ProductID.'" name="ProductID" />';
		echo '<table border="0" class="package" width="100%"><tr class="title"><th height="30px">Lo&#7841;i\Ki&#7875;u ph&ograve;ng</th>';
		while($tmp = mysql_fetch_assoc($AllTypeColection)) echo '<th height="30px">'.$this->ArrayPackageTypesAlias[(int)$tmp['type']].'</th>';
		echo '<th></th></tr>';
		$nameCollection = package_filter('PdPk','`PdPk`.`name`',$this->ProductID,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
		while($tmp = mysql_fetch_assoc($nameCollection)){
			echo '<tr height="30px"><td align="center">'.$tmp['name'].'</td>';
			$AllTypeColection = package_filter('PdPk','`PdPk`.`type`',-1,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
			$count = 0;
			while($tmp1 = mysql_fetch_assoc($AllTypeColection)){
				$list = package_filter('PdPk','',$this->ProductID,$this->PackageClass,(string)$tmp['name'],(int)$tmp1['type'],'','',-1,-1,-1,-1,'');
				echo '<td align="center"><input type="checkbox" name="'.$this->ID.'['.$tmp['name'].']['.$count.']" ';	
				while($tmp2 = mysql_fetch_assoc($list)){
					if($tmp2['ctrl']==1)
						echo 'checked="checked" ';
				}
				echo '/></td>';
				$count++;
			}
			echo '</td><td>';
			if($this->EnablePackageEdit==true){
				echo '<input type="submit" class="button" name="'.$this->btnPackageEditID.'['.$tmp['name'].']" value="s&#7917;a" />';	
			}
			if($this->EnablePackageSave==true){
				echo '<input type="submit" class="button" name="'.$this->btnPackageSaveID.'['.$tmp['name'].']" value="l&#432;u l&#7841;i" />';	
			}
			if($this->EnablePackageDel ==true){
				echo '<input type="submit" class="button" name="'.$this->btnPackageDeleteID.'['.$tmp['name'].']" value="lo&#7841;i b&#7887;" />';	
			}
			echo '</td></tr>';
		}
		echo '</table>';
	}
	function showPrice($date=null){
		if($this->ProductID<0)return false;
		if($this->PackageClass=='')return false;
		$datemarkers = price_load_markers($this->ProductID,$this->PackageClass,-1,true);
		$idx = 0;
		echo '<table border="0">';
		while($marker = mysql_fetch_assoc($datemarkers)){
			echo '<tr><td>T&ecirc;n b&#7843;ng gi&aacute;<input type="hidden" name="'.$this->txtPriceOldName.'['.$idx.']" value="'.$marker['name'].'" /></td><td><input type="text" style="width:250px;" class="textbox" name="'.$this->txtPriceName.'['.$idx.']" value="'.$marker['name'].'" /></td></tr>';
			echo '<tr><td>Ng&agrave;y b&#7855;t &#273;&#7847;u<input type="hidden" name="'.$this->txtPriceOldStartDate.'['.$idx.']" value="'.mysql_format_datetime($marker['startdate']).'" /></td><td><input type="text" style="width:250px;" class="textbox" name="'.$this->txtPriceStartDate.'['.$idx.']" value="'.mysql_format_datetime($marker['startdate']).'" /></td></tr>';
			echo '<tr><td>Ng&agrave;y k&#7871;t th&uacute;c<input type="hidden" name="'.$this->txtPriceOldEndDate.'['.$idx.']" value="'.mysql_format_datetime($marker['enddate']).'" /></td><td><input type="text" style="width:250px;" class="textbox" name="'.$this->txtPriceEndDate.'['.$idx.']" value="'.mysql_format_datetime($marker['enddate']).'" /></td></tr>';
			$AllTypeColection = package_filter('PdPk','`PdPk`.`type`',-1,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
			echo '<tr><td>';
				echo '<table cellpadding="3" class="packageprice"><tr><th>Name</th>';
				while($tmp = mysql_fetch_assoc($AllTypeColection)) echo '<th>'.$this->ArrayPackageTypesAlias[(int)$tmp['type']].'</th>';
				echo '<th></th></tr>';
				$nameCollection = package_filter('PdPk','`PdPk`.`name`',$this->ProductID,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
				while($tmp = mysql_fetch_assoc($nameCollection)){
					echo '<tr><td>'.$tmp['name'].'</td>';
					$AllTypeColection = package_filter('PdPk','`PdPk`.`type`',-1,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
					$count = 0;
					while($tmp1 = mysql_fetch_assoc($AllTypeColection)){
						$list = package_filter('PdPk','',$this->ProductID,$this->PackageClass,(string)$tmp['name'],(int)$tmp1['type'],'','',-1,-1,-1,-1,'');
						echo '<td>';
						while($tmp2 = mysql_fetch_assoc($list)){
							echo '<input type="text" name="'.$this->txtPriceValue.'['.$idx.']['.$tmp2['id'].']" value="'.price_load($this->ProductID,$this->PackageClass,(int)$tmp2['id'],mysql_format_datetime($marker['startdate'])).'" />';
						}
						echo '</td>';
						$count++;
					}
					echo '</td><td>';
					echo '</td></tr>';
				}
				echo '</table>';
			echo '</td></tr>';
			if($this->EnablePriceEdit==true){
				echo '<input type="submit" class="button" name="'.$this->btnPriceEditID.'['.$idx.']" value="s&#7917;a" /><br/>';	
			}
			if($this->EnablePriceSave==true){
				echo '<input type="submit" class="button" name="'.$this->btnPriceSaveID.'['.$idx.']" value="l&#432;u l&#7841;i" /><br/>';	
			}
			if($this->EnablePriceDel ==true){
				echo '<input type="submit" class="button" name="'.$this->btnPriceDeleteID.'['.$idx.']" value="lo&#7841;i b&#7887;" /><br/>';	
			}
			$idx++;
		}
		echo '</table>';
	}
	function showAddPackageForm(){
		if($this->ProductID<0)return false;
		if($this->PackageClass=='')return false;		
	//	$AllTypeColection = package_filter('PdPk','`PdPk`.`type`',-1,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
		echo '<input type="hidden" value="'.$this->PackageClass.'" name="PackageClass" />';
		echo '<table cellpadding="3" class="package">';
		echo '<tr><th>Name</th><td colspan="4"><input type="text" name="name" value="" /></td></tr>';
		echo '<tr><th>Type</th>';
		for($i=0;$i<count($this->ArrayPackageTypesAlias);$i++){
			echo '<td>'.$this->ArrayPackageTypesAlias[$i].'</td>';		
		}
		echo '</tr>';
		echo '<tr>';
	//	$AllTypeColection = package_filter('PdPk','`PdPk`.`type`',-1,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
		$count = 0;
		echo '<td></td>';
		while($tmp1 = mysql_fetch_assoc($AllTypeColection)){
			echo '<td><input type="checkbox" name="type['.$count.']" /></td>';
			$count++;
		}
		echo '</tr>';
		echo '<tr><th>Desc</th><td colspan="4"><input type="text" name="desc" /></td></tr>';
		echo '<tr><th>Detail</th><td colspan="4"><input type="text" name="detail" /></td></tr>';
		echo '<tr><th>Desc2</th><td colspan="4"><input type="text" name="desc2" /></td></tr>';
		echo '<tr><th>Extra</th><td colspan="4"><input type="text" name="extra" /></td></tr>';
		echo '<tr><th>Img</th><td colspan="4"><input type="text" name="img" /></td></tr>';
		echo '<tr><th>Alt</th><td colspan="4"><input type="text" name="alt" /></td></tr>';
		echo '<tr><th>Img1</th><td colspan="4"><input type="text" name="img1" /></td></tr>';
		echo '<tr><th>Alt1</th><td colspan="4"><input type="text" name="alt1" /></td></tr>';
		echo '</table>';
		if($this->EnableEdit==true)
			echo '<input type="submit" class="button" name="'.$this->ID.'_Edit" value="Edit" />';	
		if($this->EnableSave==true)
			echo '<input type="submit" class="button" name="'.$this->ID.'_Save" value="Save" />';	
		if($this->EnableDel ==true)
			echo '<input type="submit" class="button" name="'.$this->ID.'_Delete" value="Delete" />';	
	}
	function showEditPackageForm($PackageName){
		if($PackageName == '')return false;
		if($this->EnablePackageEdit==true){
			if($this->ProductID<0)return false;
			if($this->PackageClass=='')return false;
			$AllTypeColection = package_filter('PdPk','`PdPk`.`type`',-1,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
			echo '<table cellpadding="3" class="package">';
			echo '<tr><th>Name</th><td colspan="4"><input type="hidden" name="o_name" value="'.$PackageName.'" /><input type="text" name="name" value="'.$PackageName.'" /></td></tr>';
			echo '<tr><th>Type</th>';
			while($tmp = mysql_fetch_assoc($AllTypeColection)) echo '<td>'.$this->ArrayPackageTypesAlias[(int)$tmp['type']].'</td>';
			echo '</tr>';
			echo '<tr>';
			$AllTypeColection = package_filter('PdPk','`PdPk`.`type`',-1,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
			$count = 0;
			echo '<td></td>';
			while($tmp1 = mysql_fetch_assoc($AllTypeColection)){
				$list = package_filter('PdPk','',$this->ProductID,$this->PackageClass,(string)$tmp['name'],(int)$tmp1['type'],'','',-1,-1,-1,-1,'');
				echo '<td><input type="checkbox" name="type['.$count.']" ';
				while($tmp2 = mysql_fetch_assoc($list)){
					if($tmp2['ctrl']==1)
						echo 'checked="checked" ';
				}
				echo '/></td>';
				$count++;
			}
			echo '</tr>';
			$tmp = package_filter('PdPk','`PdPk`.`name`,`PdPk`.`Desc`,`PdPk`.`Detail`,`PdPk`.`Desc2`,`PdPk`.`Extra`,`PdPk`.`Img`,`PdPk`.`Alt`,`PdPk`.`Img1`,`PdPk`.`Alt1`',$this->ProductID,$this->PackageClass,$PackageName,-1,'','',-1,-1,-1,1,'');
			while($tmp1 = mysql_fetch_assoc($tmp)){ 
				echo '<tr><th>Desc</th><td colspan="4"><input type="hidden" name="o_desc" value="'.$tmp1['Desc'].'" /><input type="text" name="desc" value="'.$tmp1['Desc'].'" /></td></tr>';
				echo '<tr><th>Detail</th><td colspan="4"><input type="hidden" name="o_detail" value="'.$tmp1['Detail'].'" /><input type="text" name="detail" value="'.$tmp1['Detail'].'" /></td></tr>';
				echo '<tr><th>Desc2</th><td colspan="4"><input type="hidden" name="o_desc2" value="'.$tmp1['Desc2'].'" /><input type="text" name="desc2" value="'.$tmp1['Desc2'].'" /></td></tr>';
				echo '<tr><th>Extra</th><td colspan="4"><input type="hidden" name="o_extra" value="'.$tmp1['Extra'].'" /><input type="text" name="extra" value="'.$tmp1['Extra'].'" /></td></tr>';
				echo '<tr><th>Img</th><td colspan="4"><input type="hidden" name="o_img" value="'.$tmp1['Img'].'" /><input type="text" name="img" value="'.$tmp1['Img'].'" /></td></tr>';
				echo '<tr><th>Alt</th><td colspan="4"><input type="hidden" name="o_alt" value="'.$tmp1['Alt'].'" /><input type="text" name="alt" value="'.$tmp1['Alt'].'" /></td></tr>';
				echo '<tr><th>Img1</th><td colspan="4"><input type="hidden" name="o_img1" value="'.$tmp1['Img1'].'" /><input type="text" name="img1" value="'.$tmp1['Img1'].'" /></td></tr>';
				echo '<tr><th>Alt1</th><td colspan="4"><input type="hidden" name="o_alt1" value="'.$tmp1['Alt1'].'" /><input type="text" name="alt1" value="'.$tmp1['Alt1'].'" /></td></tr>';
			}			
			echo '</table>';				
		}
	}
	function showAddPriceForm(){
		if($this->ProductID<0)return false;
		if($this->PackageClass=='')return false;
		echo '<table border="0">';
		echo '<tr><td>T&ecirc;n b&#7843;ng gi&aacute;</td><td><input type="text" style="width:250px;" class="textbox" name="'.$this->txtPriceNewName.'" /></td></tr>';
		echo '<tr><td><label class="title">Ng&agrave;y b&#7855;t &#273;&#7847;u</label</td><td><input type="text" style="width:250px;" class="textbox" name="'.$this->txtPriceNewStartDate.'" /></td>';
		echo '<tr><td><label class="title">Ng&agrave;y k&#7871;t th&uacute;c</label></td><td><input type="text" style="width:250px;" class="textbox" name="'.$this->txtPriceNewEndDate.'" /></td>';
		$AllTypeColection = package_filter('PdPk','`PdPk`.`type`',-1,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
		echo '<tr><td colspan="2">';
		echo '<table cellpadding="3" class="packageprice"><tr><th>Lo&#7841;i ph&ograve;ng\Ki&#7875;u ph&ograve;ng</th>';
		while($tmp = mysql_fetch_assoc($AllTypeColection)) echo '<th>'.$this->ArrayPackageTypesAlias[(int)$tmp['type']].'</th>';
		echo '<th></th></tr>';
		$nameCollection = package_filter('PdPk','`PdPk`.`name`',$this->ProductID,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
		while($tmp = mysql_fetch_assoc($nameCollection)){
			echo '<tr><td>'.$tmp['name'].'</td>';
			$AllTypeColection = package_filter('PdPk','`PdPk`.`type`',-1,$this->PackageClass,'',-1,'','',-1,-1,-1,-1,'');
			$count = 0;
			while($tmp1 = mysql_fetch_assoc($AllTypeColection)){
				$list = package_filter('PdPk','',$this->ProductID,$this->PackageClass,(string)$tmp['name'],(int)$tmp1['type'],'','',-1,-1,-1,-1,'');
				echo '<td>';
				while($tmp2 = mysql_fetch_assoc($list)){
					echo '<input type="text" name="'.$this->txtPriceNewValue.'['.$tmp2['id'].']" value="'.currency_format(0).'" />';
				}
				echo '</td>';
				$count++;
			}
			echo '</td><td>';
			echo '</td></tr>';
		}
		echo '</table>';
		echo '</td></tr>';
		echo '</table>';
	}	
}
?>
