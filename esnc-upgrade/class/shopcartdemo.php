<?php /* vinhtx@esnadvanced.com 07-May-2006 */
require_once('D:/WWWROOT/esncconsole_new/compls/price.php');
class shopcartdemo{
	var $line,$sid,$value,$count;
	function shopcartdemo(){
		$this->sid=session_id();//get session id
		$this->line = array();
		$this->value=0;
		$this->count=0;
	}
	function open(){ /*list content of shopcart into an array:line
										$line[]['id'] = object database id
										$line[]['code'] = object code
										$line[]['name'] = object name
										$line[]['class'] = object class, default=SALES_CLASS_PRODUCT
										$line[]['parentid'] = parent object id, may be null
										$line[]['parentname'] = parent object name
										$line[]['qty'] = quantity
										$line[]['qty2'] = quantity 2
										$line[]['qty3'] = quantity 3
										$line[]['qty4'] = quantity 4
										$line[]['price'] = unit price
										$line[]['saleprice'] = effective price
										$line[]['subtotal'] = sub total of this item
										$line[]['start'] = start of use
										$line[]['stop'] = stop of use
										$line[]['notes'] = notes
									*/
		
		$this->getinfo();
		$sql = "SELECT `s`.*,`p`.`price` FROM `".DB_TABLE_PREFIX."shopcart` as `s` INNER JOIN `".DB_TABLE_PREFIX."product` as `p` ON `s`.`objectid` = `p`.`id` AND `s`.`sess`='{$this->sid}' ";		_trace($sql);
		$rs = mysql_query($sql);
		$this->line=array();
		while($rw = mysql_fetch_assoc($rs)){
			$this->line[(int)$rw['id']]=array('id' => $rw['objectid'],
					'code' => $rw['code'],
					'name'=>$rw['name'],
					'class'=>$rw['class'],
					'unit'=>'',
					'parentid'=>$rw['parentid'],
					'parentname'=>NULL,
					'qty'=>$rw['qty'],
					'qty2'=>$rw['qty2'],
					'qty3'=>$rw['qty3'],
					'qty4'=>$rw['qty4'], 
					'price'=>$rw['price'],
					'saleprice'=>$rw['saleprice'],
					'subtotal'=>$rw['subtotal'],
					'start'=>$rw['start'],
					'stop'=>$rw['stop'],
					'notes'=>$rw['notes']
					);
		};
		_trace($this->line);
		mysql_free_result($rs);
	}
	function save(&$line){
		/* save shopcart information contained in $line array
			$line[line_id]['qty']=qty
			$line[line_id]['qty2']=qty2
			$line[line_id]['qty3']=qty3
			$line[line_id]['qty4']=qty4
			$line[line_id]['start']=start
			$line[line_id]['stop']=stop */
		
		foreach($line as $lid => $o){
			$sql = "UPDATE `".DB_TABLE_PREFIX."shopcart` SET `subtotal` = {$o['qty']} * `saleprice`,`qty` = {$o['qty']},`notes`='".mysql_real_escape_string(@$o['notes'])."'  WHERE `sess`='{$this->sid}' AND `id`={$lid}";/*,`qty2`={$o['qty2']},`qty3`={$o['qty3']},`qty4`={$o['qty4']},`start`={$o['start']},`stop`={$o['stop']} */
			_trace($sql);
			mysql_query($sql);
		}
		$this->count=-1;
		$this->getinfo();
		return TRUE;
	}
	function remove($line_id){
		/* remove list of line in array
			$line_id[] = line_id to delete (notes: this is line is not the object id
		*/
		
		$lid = (int)$line_id;//convert to int
		$sql = "DELETE FROM `".DB_TABLE_PREFIX."shopcart` WHERE `sess`='{$this->sid}' AND `id`={$lid}  ";
		_trace($sql);
		mysql_query($sql);
		$this->count=-1;
		$this->getinfo();
	}
	function add($objectid,$qty=1,$class=SALES_CLASS_PRODUCT,$notes=NULL,$start='0000/00/00 00:00:00',$stop='0000/00/00 00:00:00',$qty2=1,$qty3=1,$qty4=1,$PGid=null,$PGClass='',$datemarker=null){
		/* add a line into shopcart 
			$objectid = product id
			$qty= quantity
			$notes = line notes
			$class = SALES_CLASS_PRODUCT|SALES_CLASS_SERVICE|SALES_CLASS_.... available sale class defined in config.php
		*/
		$objectid = (int)$objectid; //cast to type
		$qty = (int)$qty;
		$notes = mysql_real_escape_string($notes);
		$class = (int)$class;
		$qty2 = (int)$qty2;
		$qty3 = (int)$qty3;
		$qty4 = (int)$qty4;
		$start = mysql_format_datetime($start);
		$stop = mysql_format_datetime($stop);
		if($PGid==null){
			$sql = "UPDATE `".DB_TABLE_PREFIX."shopcart` SET `subtotal` = (`qty` + {$qty}) * `saleprice`,`qty` = `qty` + {$qty} ,`qty2`=`qty2` + {$qty2},`qty3`=`qty3` + {$qty3},`qty4`=`qty4` + {$qty4} WHERE `objectid`={$objectid} AND `class`={$class} AND `sess`='{$this->sid}'";// try to update product
		}
		else{
			$sql = "UPDATE `".DB_TABLE_PREFIX."shopcart` SET `subtotal` = (`qty` + {$qty}) * `saleprice`,`qty` = `qty` + {$qty} ,`qty2`=`qty2` + {$qty2},`qty3`=`qty3` + {$qty3},`qty4`=`qty4` + {$qty4} WHERE `objectid`={$objectid} AND `class`={$class} AND `sess`='{$this->sid}' AND `parentid`='{$PGid}'";// try to update product
		}
		_trace($sql);mysql_query($sql);
		_trace(mysql_error());
		if(mysql_affected_rows()<=0){
			if($PGid==null){
				$sql = "INSERT INTO `".DB_TABLE_PREFIX."shopcart`(`sess`,`objectid`,`name`,`class`,`code`,`qty`,`qty2`,`qty3`,`qty4`,`saleprice`,`start`,`stop`,`notes`,`subtotal`)
						SELECT '{$this->sid}',{$objectid},`p`.`name`,{$class},`p`.`code`,{$qty},{$qty2},{$qty3},{$qty4},`p`.`saleprice`,'{$start}','{$stop}','{$notes}',{$qty} * `p`.`saleprice`
						FROM `".DB_TABLE_PREFIX."product` as `p` WHERE `p`.`id` = {$objectid}";
			}
			else{
				$PGid = (int)$PGid;
				$saleprice = price_load($objectid,$PGClass,$PGid,$datemarker);
				$sql = "INSERT INTO `".DB_TABLE_PREFIX."shopcart`(`sess`,`objectid`,`name`,`class`,`code`,`qty`,`qty2`,`qty3`,`qty4`,`saleprice`,`start`,`stop`,`notes`,`subtotal`,`parentid`)
						SELECT '{$this->sid}',{$objectid},`p`.`name`,{$class},`p`.`code`,{$qty},{$qty2},{$qty3},{$qty4},'{$saleprice}','{$start}','{$stop}','{$notes}',{$qty} * {$saleprice},'{$PGid}' 
						FROM `".DB_TABLE_PREFIX."product` as `p` WHERE `p`.`id` = {$objectid}";
			}
			_trace($sql);
			mysql_query($sql);
			_trace(mysql_error());
		}
		return (bool)mysql_affected_rows();
		$this->count=-1;
		$this->getinfo();
	}
	function newline($objectid,$qty=1,$class=SALES_CLASS_PRODUCT,$notes=NULL,$start='0000/00/00 00:00:00',$stop='0000/00/00 00:00:00',$qty2=1,$qty3=1,$qty4=1,$PGid=null,$PGClass='',$datemarker=null){
		$objectid = (int)$objectid; //cast to type
		$qty = (int)$qty;
		$notes = mysql_real_escape_string($notes);
		$class = (int)$class;
		$qty2 = (int)$qty2;
		$qty3 = (int)$qty3;
		$qty4 = (int)$qty4;
		$start = mysql_format_datetime($start);
		$stop = mysql_format_datetime($stop);
		if($PGid==null){
			$sql = "INSERT INTO `".DB_TABLE_PREFIX."shopcart`(`sess`,`objectid`,`name`,`class`,`code`,`qty`,`qty2`,`qty3`,`qty4`,`saleprice`,`start`,`stop`,`notes`,`subtotal`)
					SELECT '{$this->sid}',{$objectid},`p`.`name`,{$class},`p`.`code`,{$qty},{$qty2},{$qty3},{$qty4},`p`.`saleprice`,'{$start}','{$stop}','{$notes}',{$qty} * `p`.`saleprice`
					FROM `".DB_TABLE_PREFIX."product` as `p` WHERE `p`.`id` = {$objectid}";
		}
		else{
			$PGid = (int)$PGid;
			$saleprice = price_load($objectid,$PGClass,$PGid,$datemarker);
			$sql = "INSERT INTO `".DB_TABLE_PREFIX."shopcart`(`sess`,`objectid`,`name`,`class`,`code`,`qty`,`qty2`,`qty3`,`qty4`,`saleprice`,`start`,`stop`,`notes`,`subtotal`,`parentid`)
					SELECT '{$this->sid}',{$objectid},`p`.`name`,{$class},`p`.`code`,{$qty},{$qty2},{$qty3},{$qty4},'{$saleprice}','{$start}','{$stop}','{$notes}',{$qty} * {$saleprice},'{$PGid}' 
					FROM `".DB_TABLE_PREFIX."product` as `p` WHERE `p`.`id` = {$objectid}";
		}
		_trace($sql);
		mysql_query($sql);
		$this->count=-1;
		$this->getinfo();
	}
	function getinfo(){
		/* get quick information on shopcart without open it */
		
		//		if($this->count == -1){
		$sql = "SELECT count(*),sum(`subtotal`) FROM `".DB_TABLE_PREFIX."shopcart` WHERE `sess` = '{$this->sid}'";
		_trace($sql);
		if($rw = mysql_fetch_row($rs = mysql_query($sql))){
			$this->count = $_SESSION['cartcount'] = (int)$rw[0];//row count
			$this->value = $_SESSION['cartvalue']= (float)$rw[1];//total value
			mysql_free_result($rs);
		}else{
			$this->count = $_SESSION['cartcount'] = 0;
			$this->value = $_SESSION['cartvalue']= 0;
		}
		//		}else{
		//			$this->count = (int)$_SESSION['cartcount'];
		//			$this->value = (int)$_SESSION['cartvalue'];
		//		}
	}
	function removeall(){
		global $sql;
		$sql = "DELETE FROM `".DB_TABLE_PREFIX."shopcart` WHERE `sess`='{$this->sid}'";
		_trace($sql);
		mysql_query($sql);
		$this->count=0;
		$this->value=0;
	}	
	
//ham dung cap nhat gia cho du an giatriviet
	function updateprice(&$line=NULL,$type,$style,$PDid,$PGid,$PGClass,$date){
//		$rs = mysql_query("select `a`.`price` from `".DB_TABLE_PREFIX."quotation` as `a` left join `".DB_TABLE_PREFIX."productpackage` as `b` on `b`.`id`=`a`.`productpackageid` where `a`.`StartDate`='".$date."' AND `a`.`productid`=".(int)$_GET['PDid']." AND `b`.`name`='".$type."' AND `b`.`type`=".$style." AND `b`.`class`='".$PGClass."'");		
		foreach($line as $lid => $o){
			//cap nhat truong salprice
			$query= "UPDATE `".DB_TABLE_PREFIX."shopcart` SET `saleprice` = (SELECT `a`.`price` FROM `".DB_TABLE_PREFIX."quotation` AS `a` LEFT JOIN `".DB_TABLE_PREFIX."productpackage` AS `b` ON `b`.`id`=`a`.`productpackageid` WHERE `a`.`StartDate`='".$date."' AND `a`.`productid`=".$PDid." AND `b`.`name`='".$type."' AND `b`.`type`=".$style." AND `b`.`class`='".$PGClass."') WHERE `sess`='{$this->sid}' AND `id`={$lid}";
			_trace($query);			
			mysql_query($query);
			//cap nhat gia tong
			$sql = "UPDATE `".DB_TABLE_PREFIX."shopcart` SET `subtotal` = {$o['qty']} * `saleprice`,`qty` = {$o['qty']},`notes`='".mysql_real_escape_string(@$o['notes'])."'  WHERE `sess`='{$this->sid}' AND `id`={$lid}";/*,`qty2`={$o['qty2']},`qty3`={$o['qty3']},`qty4`={$o['qty4']},`start`={$o['start']},`stop`={$o['stop']} */
			_trace($sql);
			mysql_query($sql);
		}

		$this->count=-1;
		$this->getinfo();
		return TRUE;	
	}
}
?>
