<?php 
//tienpd@esnadvanced.com
//these are misc class
//class tab_object use to make tab
class tab_object{
	var $ID;
	var $cssClass;
	var $arr_tab_name;
	var $arr_tab_content;
	var $arr_tab_script_handle;
	function tab_objcet(){}
	private	function validData(){
		//if($this->ID == null) return false;
		if($this->ID == null) $this->ID='tab_object1';
		if((!is_array($this->arr_tab_name))||(count($this->arr_tab_name) == 0)){echo "arr_tab_name chua khoi tao"; return false;}
		if((!is_array($this->arr_tab_content))||(count($this->arr_tab_content) == 0)) {$this->arr_tab_content = array();}
		if(count($this->arr_tab_name) > count($this->arr_tab_content)){
			for($i=count($this->arr_tab_content);$i<count($this->arr_tab_name);$i++){
				$this->arr_tab_content[$i] = "&nbsp;";
			}
		}
		if((!is_array($this->arr_tab_script_handle))||(count($this->arr_tab_script_handle) == 0)){
			$this->arr_tab_script_handle=array();
			for($i=0;$i<count($this->arr_tab_name);$i++){
				$this->arr_tab_script_handle[$i] = $this->ID."_tab_click(".$i.",this)";
			}
		}
		if(count($this->arr_tab_name) > count($this->arr_tab_script_handle)){
			for($i=count($this->arr_tab_script_handle);$i<count($this->arr_tab_name);$i++){
				$this->arr_tab_script_handle[$i] = $this->ID."_tab_click(".$i.",this)";
			}
		}
		if(($this->cssClass == null)||($this->cssClass==''))$this->cssClass = 'tab_object';
		return true;
	}
	function show(){
		if(!$this->validData()) return;
		echo '<div class="'.$this->cssClass.'" id="'.$this->ID.'">';
		echo '<div class="tab_name">';
		echo '<div class="tab_name_item_0 tab_name_item_first tab_name_item_active" name="tab_name_item" id="tab_name_item_0">';
		echo '<div class="tab_name_item_left" name="tab_name_item_left" id="tab_name_item_left_0">';
		echo '<div class="tab_name_item_right" name="tab_name_item_right" id="tab_name_item_right_0">';
		echo '<div class="tab_name_item_middle" name="tab_name_item_middle" id="tab_name_item_middle_0" onClick="'.$this->arr_tab_script_handle[0].'">';
		echo $this->arr_tab_name[0];
		echo '</div>';
		echo '</div>';		
		echo '</div>';
		echo '</div>';
		$i=0;
		for($i=1;$i<count($this->arr_tab_name)-1;$i++){
			echo '<div class="tab_name_item_'.$i.' tab_name_item" name="tab_name_item" id="tab_name_item_'.$i.'">';
			echo '<div class="tab_name_item_left'.$i.' tab_name_item_left" name="tab_name_item_left" id="tab_name_item_left_'.$i.'">';
			echo '<div class="tab_name_item_right'.$i.' tab_name_item_right" name="tab_name_item_right" id="tab_name_item_right_'.$i.'">';
			echo '<div class="tab_name_item_middle'.$i.' tab_name_item_middle" name="tab_name_item_middle" id="tab_name_item_middle_'.$i.'" onclick="'.$this->arr_tab_script_handle[$i].'">';
			echo $this->arr_tab_name[$i];
			echo '</div>';
			echo '</div>';		
			echo '</div>';
			echo '</div>';
		}
		echo '<div class="tab_name_item_'.$i.' tab_name_item_last tab_name_item" name="tab_name_item" id="tab_name_item_'.$i.'">';
		echo '<div class="tab_name_item_left'.$i.' tab_name_item_left" name="tab_name_item_left" id="tab_name_item_left_'.$i.'">';
		echo '<div class="tab_name_item_right'.$i.' tab_name_item_right" name="tab_name_item_right" id="tab_name_item_right_'.$i.'">';
		echo '<div class="tab_name_item_middle'.$i.' tab_name_item_middle" name="tab_name_item_middle" id="tab_name_item_middle_'.$i.'" onclick="'.$this->arr_tab_script_handle[$i].'">';
		echo $this->arr_tab_name[$i];
		echo '</div>';
		echo '</div>';		
		echo '</div>';
		echo '</div>';
		echo '<div class="tab_name_item_notuse tab_name_item">&nbsp;</div>';
		echo '</div>';
		echo '<div class="tab_content">';
		echo '<div class="tab_content_item_0 tab_content_item_first tab_content_item_active" name="tab_content_item"  id="tab_content_item_0">'.$this->arr_tab_content[0].'</div>';
		$i=0;
		for($i=1;$i<count($this->arr_tab_content)-1;$i++){
			echo '<div class="tab_content_item_'.$i.' tab_content_item" name="tab_content_item"  id="tab_content_item_'.$i.'">'.$this->arr_tab_content[$i].'</div>';
		}
		echo '<div class="tab_content_item_'.$i.' tab_content_item_last tab_content_item" name="tab_content_item"  id="tab_content_item_'.$i.'">'.$this->arr_tab_content[$i].'</div>';		
		echo '</div>';
		echo '</div>';
	}
}
//class tabl_package use to view table package of product
class table_package{
	var $productid;
	var $PGClass;
	var $cssClass;
	var $text_package_name;
	var $arr_type_alias;

	private	function filter($filter_fields='',$productid=-1,$name='',$type=-1,$code='',$desc='',$rank=-1,$status=-1,$ctrl=-1){
		global $sql;
		if	($filter_fields == '')
			$filter_fields = '`#`.`id`,`#`.`productid`,`#`.`class`,`#`.`name`,`#`.`code`,`#`.`desc`,`#`.`extra`,`#`.`img`,`#`.`alt`,`#`.`img1`,`#`.`alt1`,`#`.`rank`,`#`.`rate`,`#`.`ratecount`,`#`.`packageno`,`#`.`type`,`#`.`status`,`#`.`ctrl`,`#`.`view`';
		else 
			$filter_fields = '`#`.`class`,'.$filter_fields;
		$wh = '';
		if	((is_int($productid))&&($productid >= 0)) {$wh .= "AND `#`.`productid` = {$this->productid} ";}
		if	($this->PGClass != '') {$wh .= "AND `#`.`class` like '{$this->PGClass}' ";}
		if	($name != '') {$wh .= "AND `#`.`name` like '{$name}' ";}
		if	((is_int($type))&&($type >= 0)) {$wh .= "AND `#`.`type` = {$type} ";} 
		if	($code != '') {$wh .= "AND `#`.`code` like '{$code}' ";}
		if	($desc != '') {$wh .= "AND `#`.`desc` like '{$desc}' ";}
		if	((is_int($rank))&&($rank >= 0)) {$wh .= "AND `#`.`rank` = {$rank} ";} 
		if	((is_int($status))&&($status >= 0)) {$wh .= "AND `#`.`status` = {$status} ";} 
		if	((is_int($ctrl))&&($ctrl >= 0)) {$wh .= "AND `#`.`ctrl` & {$ctrl} = {$ctrl} ";}
		if	($wh!='')$wh = 'WHERE'.substr($wh,4);
		$sql =  'SELECT DISTINCT '.$filter_fields." FROM `".DB_TABLE_PREFIX."#` as `#` ".$wh;
		$sql = str_replace('#','productpackage',$sql);
//		echo $sql;
		return mysql_query($sql);
	}
	function table_package(){}
	function validData(){
		if(($this->productid==null)&&(!is_int($this->productid)))return false;
		else{
			global $sql;
			$rs = mysql_select('`a`.`id`','`#product` as `a`','`a`.`id`='.$this->productid);
			if(mysql_affected_rows()<=0)return false;
		}
		if(($this->PGClass==null)&&($this->PGClass==''))return false;
		else{
			global $sql;
			$rs = mysql_select('`a`.`class`','`#productpackage` as `a`',"`a`.`class` like '{$this->PGClass}'");
			if(mysql_affected_rows()<=0)return false;
		}
		$rs = $this->filter('`#`.`type`');
		if(mysql_affected_rows()<=0)return false;
		if((($this->arr_type_alias==null)&&(!is_array($this->arr_type_alias)))||(mysql_affected_rows()>count($this->arr_type_alias))){
			if(mysql_affected_rows()>0){
				$i = 0;
				$this->arr_type_alias = array();
				while($row = mysql_fetch_assoc($rs)){
					$this->arr_type_alias[$i] = (int)$row["type"];
					$i++;
				}
			}
		}
		$rs = $this->filter('`#`.`productid`,`#`.`name`',$this->productid);
		if(mysql_affected_rows()<=0)return false;
		if(($this->cssClass==null)&&($this->cssClass==''))$this->cssClass='table_package';
		if(($this->text_package_name==null)&&($this->text_package_name==''))$this->text_package_name='package name';
		return true;
	}
	function show(){
		if($this->validData()==false){echo 'dont have price table';return;}
		$rs = $this->filter('`#`.`productid`,`#`.`name`',$this->productid);
		echo '<div><table>';
		echo '<tr>';
		echo '<th>'.$this->text_package_name.'</th>';
		for($i=0;$i<count($this->arr_type_alias);$i++){
			echo '<th>'.$this->arr_type_alias[$i].'</th>';
		}
		echo '<th></th>';
		echo '</tr>';
		while($row = mysql_fetch_assoc($rs)){
			echo '<td>'.$row['name'].'</td>';
			for($i=0;$i<count($this->arr_type_alias);$i++){
				echo '<td>gia phong</td>';
			}
			echo '<td></td>';
			echo '</tr>';
		}
		echo '</table></div>';
	}
}
//class table_package_price use to view table price of product in a date
class table_package_price{
	var $productid;
	var $PGClass;
	var $startDate;
	var $cssClass;
	var $text_package_name;
	var $arr_type_alias;
	var $showBookAll;
	var $text_bookall;
	var $process_page;
	var $title;
	var $table_price_name;

	private	function filter($filter_fields='',$productid=-1,$name='',$type=-1,$code='',$desc='',$rank=-1,$status=-1,$ctrl=-1){
		global $sql;
		if	($filter_fields == '')
			$filter_fields = '`#`.`id`,`#`.`productid`,`#`.`class`,`#`.`name`,`#`.`code`,`#`.`desc`,`#`.`extra`,`#`.`img`,`#`.`alt`,`#`.`img1`,`#`.`alt1`,`#`.`rank`,`#`.`rate`,`#`.`ratecount`,`#`.`packageno`,`#`.`type`,`#`.`status`,`#`.`ctrl`,`#`.`view`';
		else 
			$filter_fields = '`#`.`class`,'.$filter_fields;
		$wh = '';
		if	((is_int($productid))&&($productid >= 0)) {$wh .= "AND `#`.`productid` = {$this->productid} ";}
		if	($this->PGClass != '') {$wh .= "AND `#`.`class` like '{$this->PGClass}' ";}
		if	($name != '') {$wh .= "AND `#`.`name` like '{$name}' ";}
		if	((is_int($type))&&($type >= 0)) {$wh .= "AND `#`.`type` = {$type} ";} 
		if	($code != '') {$wh .= "AND `#`.`code` like '{$code}' ";}
		if	($desc != '') {$wh .= "AND `#`.`desc` like '{$desc}' ";}
		if	((is_int($rank))&&($rank >= 0)) {$wh .= "AND `#`.`rank` = {$rank} ";} 
		if	((is_int($status))&&($status >= 0)) {$wh .= "AND `#`.`status` = {$status} ";} 
		if	((is_int($ctrl))&&($ctrl >= 0)) {$wh .= "AND `#`.`ctrl` & {$ctrl} = {$ctrl} ";}
		if	($wh!='')$wh = 'WHERE'.substr($wh,4);
		$sql =  'SELECT DISTINCT '.$filter_fields." FROM `".DB_TABLE_PREFIX."#` as `#` ".$wh;
		$sql = str_replace('#','productpackage',$sql);
		return mysql_query($sql);
	}
	function table_package(){}
	function validData(){
		global $sql;
		if(($this->productid==null)||(!is_int($this->productid)))return false;
		else{
			$rs = mysql_select('`a`.`id`','`#product` as `a`','`a`.`id`='.$this->productid);
			if(mysql_affected_rows()<=0)return false;
		}
		if(($this->PGClass==null)||($this->PGClass==''))return false;
		else{
			global $sql;
			$rs = mysql_select('`a`.`class`','`#productpackage` as `a`',"`a`.`class` like '{$this->PGClass}'");
			if(mysql_affected_rows()<=0)return false;
		}
		$rs = $this->filter('`#`.`type`');
		if(mysql_affected_rows()<=0)return false;
		if((($this->arr_type_alias==null)||(!is_array($this->arr_type_alias)))||(mysql_affected_rows()>count($this->arr_type_alias))){
			if(mysql_affected_rows()>0){
				$i = 0;
				$this->arr_type_alias = array();
				while($row = mysql_fetch_assoc($rs)){
					$this->arr_type_alias[$i] = (int)$row["type"];
					$i++;
				}
			}
		}
		$rs = $this->filter('`#`.`productid`,`#`.`name`',$this->productid);
		if(mysql_affected_rows()<=0)return false;
		$sql = 'SELECT distinct `#`.`name`,`#`.`startdate` FROM `'.DB_TABLE_PREFIX.'#` as `#` ';
		$sql .= "WHERE `#`.`productid` = {$this->productid} ";
		$sql .= "AND `#`.`productpackageclass` like '{$this->PGClass}' ";
		$sql = str_replace('#','quotation',$sql);
		$rs = mysql_query($sql);
		if(mysql_affected_rows()<=0)return false;

		if($this->startDate==null)$this->startDate=date("Y-m-d");
		$all_date = array();
		$all_name = array();
		$i = 0;
		while($row = mysql_fetch_assoc($rs)){
			$all_date[$i] = $row['startdate'];
			$all_name[$i] = $row['name'];
			$i++;
		}
		$temp = min($all_date);
		for($i=0;$i<count($all_date);$i++){
			if((strtotime($this->startDate) - strtotime($all_date[$i])) < 0){
				$temp = min($all_date);
				if(($i+1)==count($all_date))break;
			}else{
				$temp = $all_date[$i];
				if(($i+1)==count($all_date))break;
				if((strtotime($this->startDate) - strtotime($all_date[$i+1])) < 0)break;
			}
		}
		$this->startDate = $temp;
		if(($this->cssClass==null)||($this->cssClass==''))$this->cssClass='table_package_price';
		if(($this->text_package_name==null)||($this->text_package_name==''))$this->text_package_name='package name';
		if($this->showBookAll==null)$this->showBookAll=true;
		if(($this->text_bookall==null)||($this->text_bookall==''))$this->text_bookall='booking';
		if(($this->process_page==null)||($this->process_page==''))$this->process_page='booking.php';
		if(($this->table_price_name==null)||($this->table_price_name==''))$this->table_price_name = '*Update';
		return true;
	}
	function load_price($productpackageid){
		if(!is_int($productpackageid))return 0;
		$sql = 'SELECT distinct `#`.`price` FROM `'.DB_TABLE_PREFIX.'#` as `#` ';
		$sql .= "WHERE `#`.`productid` = {$this->productid} ";
		$sql .= "AND `#`.`productpackageclass` like '{$this->PGClass}' ";
		$sql .= "AND `#`.`startdate` like '{$this->startDate}' ";
		$sql .= "AND `#`.`productpackageid` like '{$productpackageid}' ";
		$sql = str_replace('#','quotation',$sql);
		$rs = mysql_query($sql);
		if(mysql_affected_rows()<=0)return 0;
		$row = mysql_fetch_assoc($rs);
		return $row['price'];
	}
	function show(){
		if($this->validData()==false){echo 'don\'t have price table';return;}
		if (!defined('CURENCY_ID')) {define('CURENCY_ID',0);}
		$rs = $this->filter('`#`.`productid`,`#`.`name`',$this->productid);
		echo '<div class="'.$this->cssClass.'"><table border="1" cellspacing="0px">';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="col0">'.$this->text_package_name.'</th>';
		for($i=0;$i<count($this->arr_type_alias);$i++){
			echo '<th class="colprice col'.($i+1).'">'.$this->arr_type_alias[$i].'</th>';
		}
		echo '<th class="colbookall col'.($i+1).'">&nbsp;</th>';
		echo '</tr>';
		echo '</thead>';		
		while($row = mysql_fetch_assoc($rs)){
			echo '<td class="col0">'.$row['name'].'</td>';
			$last_id= -1;
			for($i=0;$i<count($this->arr_type_alias);$i++){
				$rs1 = $this->filter('',$this->productid,$row['name'],$i);
				if($tmp = mysql_fetch_assoc($rs1)){
					if((int)$tmp['ctrl']==1){
						$last_id = (int)$tmp['id'];
						$href = $this->process_page.'?PDid='.$this->productid.'&PGClass='.$this->PGClass.'&PGid='.$tmp['id'].'&price='.$this->load_price((int)$tmp['id']);
						echo '<td class="colprice col'.($i+1).'"><a href="'.$href.'" title="'.$this->title.'">'.currency_format($this->load_price((int)$tmp['id']),CURENCY_ID).'</a></td>';
					}else
						echo '<td class="colprice col'.($i+1).'">&nbsp;</td>';
				}else{
					echo '<td class="colprice col'.($i+1).'">&nbsp;</td>';
				}
			}
			if(($this->showBookAll==true)&&($last_id != -1)){
				$href = $this->process_page.'?PDid='.$this->productid.'&PGClass='.$this->PGClass.'&PGid='.$last_id.'&price='.$this->load_price($last_id);
				echo '<td class="colbookall col'.($i+1).'"><a href="'.$href.'" title="'.$this->title.'">'.$this->text_bookall.'</a></td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		echo '</div>';
	}
	function showTablePriceName(){
		if($this->validData()==false){return;}
		echo '<div class="'.$this->cssClass.'"><div class="table_price_name">'.$this->table_price_name.': '.date('d-m-Y',strtotime($this->startDate)).'</div></div>';
	}
}

?>