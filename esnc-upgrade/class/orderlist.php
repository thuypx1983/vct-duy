<?php /* vinhtx@esnadvanced.com 11-Apr-2006 */
#require(PATH_CLASS.'esnc.php');
#require(PATH_COMPLS.'user.php');
#require(PATH_CLASS.'mailer.php');
class orderlist extends order{
	function alert($orderid=NULL,$form='form_ordernotify.htm'){

		global $ORDER_CTRL;
		$ordernotifytags=array('{{ORDER_CODE}}','{{ORDER_ID}}','{{ORDER_CREATED}}','{{CUSTOMER_FIRSTNAME}}','{{CUSTOMER_LASTNAME}}','{{CUSTOMER_ADDRESS}}','{{CUSTOMER_EMAIL}}','{{CUSTOMER_PHONE}}','{{ORDER_SUBTOTAL}}','{{ORDER_NOTE}}','{{ORDER_CURRENCY}}','{{SUBMIT_INFO}}','{{URL_SITE}}');
		$rs = userlist(USER_ALERT_ORDER);
		for($c=EMAIL_SALES;$rw=mysql_fetch_row($rs);$c .= ','.$rw[0]);
		mysql_free_result($rs);
		$sql = 'SELECT `code`,`id`,`created`,`custfirstname`,`custlastname`,`custaddress`,`custemail`,`custphone`,`value`,`summary`,`currency`,`currencyid` FROM `'.DB_TABLE_PREFIX.'order` WHERE `ctrl` ='.ORDER_CTRL_RECEIVED;
		_trace($sql);
		$rs = mysql_query($sql);
		$a_o=array();
		for($n = 0;$a_o[]=mysql_fetch_row($rs);++$n);
		array_pop($a_o);
		reset($a_o);
		if($row=current($a_o)){
			$cur=(int)$row[11];
			$row[8] = currency_format($row[8],$cur);
			$row[11] = $all_header = print_r(getallheaders(),TRUE);
			$row[12] = URL_BASE;
			$mr = new mailer(PATH_APPLICATION.$form,$ordernotifytags,$row);
			$mr->cc = $mr->sender=$row[6];
			esnc::parse('{{ITEM_NAME}}',$mr->body,$part,$line);
			$linetag=array('{{ITEM_NAME}}','{{ITEM_CODE}}','{{ITEM_QTY}}','{{ITEM_PRICE}}','{{ITEM_TOTAL}}','{{ITEM_NOTE}}','{{LINE_ID}}');
			$sql = 'SELECT `name`,`code`,`qty`,`saleprice`,`subtotal`,`notes` FROM `'.DB_TABLE_PREFIX.'orderdetail` WHERE `orderid`='.$row[1];
			_trace($sql);
			$rsd = mysql_query($sql);
			for($line_id=1,$line_value='';$rwd=mysql_fetch_row($rsd);++$line_id){
				$rwd[3]=currency_format_number($rwd[3],$cur);
				$rwd[4]=currency_format_number($rwd[4],$cur);
				$rwd[]=$line_id;
				$line_value .=str_replace($linetag,$rwd,$line);
			}			
			mysql_free_result($rsd);
			$mr->body = $part[0].$line_value.$part[1];
			$mr->send();
			$sqlu = 'UPDATE `'.DB_TABLE_PREFIX.'order` SET `ctrl`=`ctrl` | '.(ORDER_CTRL_ALERT_CUSTOMER|ORDER_CTRL_ALERT_SALES).' WHERE `ID`='.$row[1];
			_trace($sqlu);
			mysql_query($sqlu);
		}
		while($row = next($a_o)){//process next row
			$cur=(int)$row[11];
			$row[8] = currency_format($row[8],$cur);
			$row[11] = $all_header;
			$row[12] = URL_BASE;
			$mr = new mailer(PATH_APPLICATION.'form_ordernotify.htm',$ordernotifytags,$row);
			$mr->cc = $mr->sender=$rw['custemail'];
			$rsd = mysql_query($sql);//continue previos sql (select from orderdetail)
			for($line_id=1,$line_value='';$rwd=mysql_fetch_row($rsd);++$line_id){
				$rwd[3]=currency_format_number($rwd[3],$cur);
				$rwd[4]=currency_format_number($rwd[4],$cur);
				$rwd[]=$line_id;
				$line_value .=str_replace($linetag,$rwd,$line);
			}			
			mysql_free_result($rsd);
			$mr->body = $part[0].$line_value.$part[1];
			$mr->send();
			$sqlu = 'UPDATE `'.DB_TABLE_PREFIX.'order` SET `ctrl`=`ctrl` | '.(ORDER_CTRL_ALERT_CUSTOMER|ORDER_CTRL_ALERT_SALES).' WHERE `ID`='.$row[1];
			_trace($sqlu);
			mysql_query($sqlu);
		}
	}
	function post(&$cart){
	/* post shopcart into order queue and empty shopcart 
		$or: order object filled with user information
		return the order id if successful, NULL if failed
	*/
		global $ORDER_CURRENCY;
		$cart->getinfo();
		$uid=getuniquename();
		$sql = 'UPDATE `shopcart` SET `'.DB_TABLE_PREFIX.'subtotal` = `qty` * `saleprice` WHERE `sess` = \''.$cart->sid.'\'';
		_trace($sql);
		mysql_query($sql);
		$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'orderdetail`(`orderid`,`productid`,`name`,`code`,`qty`,`qty2`,`qty3`,`qty4`,`class`,`saleprice`,`subtotal`,`notes`,`ordercode`,`start`,`stop`)
				SELECT NULL,`objectid`,`name`,`code`,`qty`,`qty2`,`qty3`,`qty4`,`class`,`saleprice`,`subtotal`,`notes`,\''.$uid.'\',`start`,`stop` FROM `'.DB_TABLE_PREFIX.'shopcart` WHERE `sess`=\''.$cart->sid.'\'';
		_trace($sql);
		if(mysql_query($sql)){
			$this->code=$uid;
			$this->value=$cart->value;
			$this->ctrl=ORDER_CTRL_RECEIVED;
			$this->currency = $ORDER_CURRENCY[CURRENCY];//currency name
			$this->currencyid = CURRENCY;
			if($this->addrow()){
				$sql = "UPDATE `".DB_TABLE_PREFIX."orderdetail` SET `orderid` = {$this->id} WHERE `orderid` IS NULL AND `ordercode` = '{$uid}'";
				_trace($sql);
				if(mysql_query($sql) !== FALSE){
					$sql = "DELETE FROM `".DB_TABLE_PREFIX."shopcart` WHERE `sess`='{$cart->sid}'";
					_trace($sql);
					mysql_query($sql);
					$cart->count = -1;
					$cart->getinfo();
					return TRUE;
				}
			}
		}else _trace(mysql_error());
		return FALSE;
	}
	function setctrl(){
		$this->status=$this->ctrl;
		return $this->setstatus();
	}
	function unsetctrl(){
	}
	function setstatus(){
		global $ORDER_CTRL,$ORDER_STATUS,$sql,$session;
		settype($this->id,'int');
		settype($this->status,'int');
		if(isset($ORDER_CTRL[$this->status])){
			$sql = 'UPDATE `'.DB_TABLE_PREFIX.'order` SET `ctrl` = `ctrl` |'.$this->status.',`status`='.$this->status.' WHERE `id`='.$this->id;
		}else
			$sql = 'UPDATE `'.DB_TABLE_PREFIX.'order` SET `status`='.$this->status.' WHERE `id`='.$this->id;		
		mysql_query($sql);
		$sql = 'INSERT INTO `'.DB_TABLE_PREFIX.'orderhistory`(`userid`,`orderid`,`status`,`data`,`created`) VALUES('
			.($session->id ? $session->id:'NULL')
			.','.$this->id
			.','.$this->status
			.",'".mysql_real_escape_string($this->statusdata)."'"
			.','.SQL_NOW.')';
		mysql_query($sql);
	}
}?>
