<?php //ngocdq@esnadvanced.com
// class relate for news-news, news-product.
class relate{
	var $id,$newsid,$linkid,$productid,$ctrl,$tag,$arrlinkid,$type,$from;
	/*
		from = 1: link duoc them tu quan tri tin tuc
		from = 2: link duoc them tu quan tri san pham
	*/
	function save(){
		global $sql;
		settype($newsid,'int');
		settype($linkid,'int');
		settype($productid,'int');		
		if($this->type=='news'){
			$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'newslink`(`newsid`,`linkid`,`ctrl`) VALUES('.$this->newsid.','.$this->linkid.','.$this->ctrl.')';			
		}else{
			$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'productnewslink`(`productid`,`newsid`,`ctrl`,`from`) VALUES('.$this->productid.','.$this->newsid.','.$this->ctrl.','.$this->from.')';
		}		
		_trace($sql);			
		mysql_query($sql);
	}	
	function update(){
		global $sql;
		if(($this->tag==NULL) || ($this->tag=='')){		
			$sql = 'SELECT `linkid` FROM `'.DB_TABLE_PREFIX.'newslink` WHERE `newsid`='.$this->newsid.' AND `ctrl`=1';		
		}else{
			$sql = 'SELECT `a`.`linkid` FROM `'.DB_TABLE_PREFIX.'newslink` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'news` as `b` ON `a`.`newsid`=`b`.`id` WHERE `a`.`newsid`='.$this->newsid.' AND `a`.`ctrl`=1 AND `b`.`tag` LIKE "%'.htmlspecialchars($this->tag).'%"';		
		}
		_trace($sql);			
		$rs = mysql_query($sql);
		while($row = mysql_fetch_assoc($rs)){
			$str.=$row['linkid'].',';
		}
		mysql_free_result($sql);
		$arr = explode(',',$str);		
		array_pop($arr);	
		//compare two array to view need update or delete
		if(count($arr) < count($this->arrlinkid)){							
			$a_update = array_diff($this->arrlinkid,$arr);					
			foreach($a_update as $linkid){
				$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'newslink`(`newsid`,`linkid`,`ctrl`) VALUES ('.$this->newsid.','.$linkid.',1)';
				_trace($sql);				
				mysql_query($sql);
			}
		}elseif(count($arr) > count($this->arrlinkid)){
			$a_update = array_diff($arr,$this->arrlinkid);					
			foreach($a_update as $linkid){			
				$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'newslink` WHERE `newsid`='.$this->newsid.' AND `linkid`='.$linkid;
				_trace($sql);
				mysql_query($sql);
			}
		}else{
			$a_update = array_diff($arr,$this->arrlinkid);
			$a_insert = array_diff($this->arrlinkid,$arr);
			foreach($a_update as $linkid){
				$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'newslink` WHERE `newsid`='.$this->newsid.' AND `linkid`='.$linkid;
				_trace($sql);
				mysql_query($sql);				
			}
			foreach($a_insert as $linkid){
				$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'newslink`(`newsid`,`linkid`,`ctrl`) VALUES ('.$this->newsid.','.$linkid.',1)';
				_trace($sql);				
				mysql_query($sql);
			}
		}
	}
	//function update product link from management module news in 'Noi dung'
	function updatefromnews(){
		global $sql;		
		if(($this->tag==NULL) || ($this->tag=='')){		
			$sql = 'SELECT `productid` FROM `'.DB_TABLE_PREFIX.'productnewslink` WHERE `newsid`='.$this->newsid.' AND `ctrl`=1 AND `from`='.$this->from;		
		}else{
			$sql = 'SELECT `a`.`productid` FROM `'.DB_TABLE_PREFIX.'productnewslink` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'product` as `b` ON `a`.`newsid`=`b`.`id` WHERE `a`.`newsid`='.$this->newsid.' AND `a`.`ctrl`=1 AND `a`.`from`='.$this->from.' AND `b`.`tag` LIKE "%'.htmlspecialchars($this->tag).'%"';		
		}
		_trace($sql);			
		$rs = mysql_query($sql);
		while($row = mysql_fetch_assoc($rs)){
			$str.=$row['productid'].',';
		}
		mysql_free_result($sql);
		$arr = explode(',',$str);		
		array_pop($arr);	
		if(count($arr) < count($this->arrlinkid)){							
			$a_update = array_diff($this->arrlinkid,$arr);					
			foreach($a_update as $linkid){
				$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'productnewslink`(`productid`,`newsid`,`ctrl`,`from`) VALUES ('.$linkid.','.$this->newsid.',1,'.$this->from.')';
				_trace($sql);
//				echo $sql;								
				mysql_query($sql);
			}
		}elseif(count($arr) > count($this->arrlinkid)){
			$a_update = array_diff($arr,$this->arrlinkid);					
			foreach($a_update as $linkid){			
				$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'productnewslink` WHERE `newsid`='.$this->newsid.' AND `productid`='.$linkid.' AND `from`='.$this->from;
				_trace($sql);
//				echo $sql;
				mysql_query($sql);
			}
		}else{
			$a_update = array_diff($arr,$this->arrlinkid);
			$a_insert = array_diff($this->arrlinkid,$arr);
			foreach($a_update as $linkid){
				$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'productnewslink` WHERE `newsid`='.$this->newsid.' AND `productid`='.$linkid.' AND `from`='.$this->from;
				_trace($sql);
//				echo $sql;
				mysql_query($sql);				
			}
			foreach($a_insert as $linkid){
				$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'productnewslink`(`productid`,`newsid`,`ctrl`,`from`) VALUES ('.$linkid.','.$this->newsid.',1,'.$this->from.')';
				_trace($sql);				
//				echo $sql;
				mysql_query($sql);
			}
		}
	}
	//function update newslink from management module product in 'San pham'
	function updatefromproduct(){
		global $sql;		
		if(($this->tag==NULL) || ($this->tag=='')){		
			$sql = 'SELECT `newsid` FROM `'.DB_TABLE_PREFIX.'productnewslink` WHERE `productid`='.$this->productid.' AND `ctrl`=1 AND `from`='.$this->from;		
		}else{
			$sql = 'SELECT `a`.`newsid` FROM `'.DB_TABLE_PREFIX.'productnewslink` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'newsid` as `b` ON `a`.`newsid`=`b`.`id` WHERE `a`.`productid`='.$this->productid.' AND `a`.`ctrl`=1 AND `a`.`from`='.$this->from.' AND `b`.`tag` LIKE "%'.htmlspecialchars($this->tag).'%"';		
		}
		_trace($sql);			
		$rs = mysql_query($sql);
		while($row = mysql_fetch_assoc($rs)){
			$str.=$row['newsid'].',';
		}
		mysql_free_result($sql);
		$arr = explode(',',$str);		
		array_pop($arr);
		if(count($arr) < count($this->arrlinkid)){	
			$a_update = array_diff($this->arrlinkid,$arr);					
			foreach($a_update as $linkid){
				$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'productnewslink`(`productid`,`newsid`,`ctrl`,`from`) VALUES ('.$this->productid.','.$linkid.',1,'.$this->from.')';
				_trace($sql);		
				mysql_query($sql);
			}
		}elseif(count($arr) > count($this->arrlinkid)){		
			$a_update = array_diff($arr,$this->arrlinkid);					
			foreach($a_update as $linkid){			
				$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'productnewslink` WHERE `newsid`='.$linkid.' AND `productid`='.$this->productid.' AND `from`='.$this->from;
				_trace($sql);
				mysql_query($sql);
			}
		}else{
			$a_update = array_diff($arr,$this->arrlinkid);
			$a_insert = array_diff($this->arrlinkid,$arr);
			foreach($a_update as $linkid){
				$sql = 'DELETE FROM `'.DB_TABLE_PREFIX.'productnewslink` WHERE `newsid`='.$linkid.' AND `productid`='.$this->productid.' AND `from`='.$this->from;
				_trace($sql);
				mysql_query($sql);				
			}
			foreach($a_insert as $linkid){
				$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'productnewslink`(`productid`,`newsid`,`ctrl`,`from`) VALUES ('.$this->productid.','.$linkid.',1,'.$this->from.')';
				_trace($sql);	
				mysql_query($sql);
			}
		}		
	}	
	// get list news or product have relate 
	function getlistlink(){			
		if($this->type=='news'){
			$sql = 'SELECT `a`.`id`,`a`.`name`,`b`.`ctrl` FROM `'.DB_TABLE_PREFIX.'news` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'newslink` as `b` ON `a`.`id`=`b`.`linkid` WHERE `b`.`newsid`='.$this->newsid.' AND `b`.`ctrl`='.$this->ctrl;
		}elseif($this->type=='product'){
			$sql = 'SELECT `a`.`id`,`a`.`name`,`b`.`ctrl` FROM `'.DB_TABLE_PREFIX.'product` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'productnewslink` as `b` ON `a`.`id`=`b`.`productid` WHERE `b`.`newsid`='.$this->newsid.' AND `b`.`ctrl`='.$this->ctrl.' AND `b`.`from`='.$this->from;		
		}
		_trace($sql);
		$rs = mysql_query($sql);
		$this->a_link = array();
		while($this->a_link[] = mysql_fetch_assoc($rs));
		array_pop($this->a_link);			
		mysql_free_result($rs);	
	}
	//get news in category have relate .have search tag if have tag.
	function getnews($catid,$tag){	
		$sql = 'SELECT `a`.`id`,`a`.`name`,`a`.`tag` FROM `'.DB_TABLE_PREFIX.'news` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'catnewsnews` as `b` ON `a`.`id`=`b`.`newsid` WHERE `b`.`catnewsid`='.$catid.' AND `a`.`id`!='.$this->newsid;		
		if($tag!=NULL){
			$sql.=' AND `a`.`tag` LIKE "%'.$tag.'%"';			
		}
		_trace($sql);
		return mysql_query($sql);		
	}
	//get product in category have relate .have search tag if have tag.
	function getproduct($catid,$tag){	
		$sql = 'SELECT `a`.`id`,`a`.`name`,`a`.`tag` FROM `'.DB_TABLE_PREFIX.'product` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'catproductproduct` as `b` ON `a`.`id`=`b`.`productid` WHERE `b`.`catproductid`='.$catid;		
		if($tag!=NULL){
			$sql.=' AND `a`.`tag` LIKE "%'.$tag.'%"';			
		}
		_trace($sql);
		return mysql_query($sql);		
	}
	//get ctrl of links view status (relate or not relate).
	function getctrl($linkid){
		if($this->type=='news'){		
			$sql = 'SELECT COUNT(*) as `count`,`linkid`,`ctrl` FROM `'.DB_TABLE_PREFIX.'newslink` WHERE `newsid`='.$this->newsid.' AND `linkid`='.$linkid;		
		}elseif($this->type=='product'){
			$sql = 'SELECT COUNT(*) as `count`,`productid`,`ctrl` FROM `'.DB_TABLE_PREFIX.'productnewslink` WHERE `newsid`='.$this->newsid.' AND `productid`='.$linkid.' AND `ctrl`=1 AND `from`='.$this->from;		
		}
		_trace($sql);		
		return mysql_query($sql);		
	}
	
/*cac ham cho phan tao lien ket tu phan quan tri san pham product-news*/	
	function savelink(){
		global $sql;
		settype($newsid,'int');
		settype($linkid,'int');
		settype($productid,'int');				
		$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'productnewslink`(`productid`,`newsid`,`ctrl`,`from`) VALUES('.$this->productid.','.$this->newsid.','.$this->ctrl.','.$this->from.')';		
		_trace($sql);				
		mysql_query($sql);
	}
	function getnewsfromproduct($catid,$tag){	
		$sql = 'SELECT `a`.`id`,`a`.`name`,`a`.`tag` FROM `'.DB_TABLE_PREFIX.'news` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'catnewsnews` as `b` ON `a`.`id`=`b`.`newsid` WHERE `b`.`catnewsid`='.$catid;
		if($tag!=NULL){
			$sql.=' AND `a`.`tag` LIKE "%'.$tag.'%"';
		}
		_trace($sql);
		return mysql_query($sql);
	}
	function getlistlinkfromproduct(){			
		$sql = 'SELECT `a`.`id`,`a`.`name`,`b`.`ctrl` FROM `'.DB_TABLE_PREFIX.'news` as `a` INNER JOIN `'.DB_TABLE_PREFIX.'productnewslink` as `b` ON `a`.`id`=`b`.`newsid` WHERE `b`.`productid`='.$this->productid.' AND `b`.`ctrl`='.$this->ctrl;		
		_trace($sql);					
		$rs = mysql_query($sql);
		$this->a_link = array();
		while($this->a_link[] = mysql_fetch_assoc($rs));
		array_pop($this->a_link);			
		mysql_free_result($rs);	
	}
	function getctrlfromproduct($linkid){		
		$sql = 'SELECT COUNT(*) as `count`,`productid`,`ctrl` FROM `'.DB_TABLE_PREFIX.'productnewslink` WHERE `newsid`='.$linkid.' AND `productid`='.$this->productid.' AND `from`='.$this->from;				
		_trace($sql);		
		return mysql_query($sql);		
	}
}
?>