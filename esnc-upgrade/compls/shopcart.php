<?php
//function add_shopcart_item($pdid,$pid,$rowid,$colid) thêm một sản phẩm vào giỏ hàng $pdid: id của sản phẩm,$pid: id của bảng giá, $rowid: id của dòng, $colid: id của cột.
@session_start();
$sess=session_id();
$tb=DB_TABLE_PREFIX;
function add_shopcart_item($pdid,$pk)  
{	
	global $tb;
	global $sess;
	$o = productread($pdid);
	$soluong =1;$adults=1;$childover=0;$childunder=0;$childoverprice=0;$extranumber=0;
	$rs = show_price_detail($pk);
	$row = mysql_fetch_assoc($rs);
	$pid=$row['nameid'] ;$rowid= $row['rowid']; $colid=$row['colid'];
	$rs2= show_col($pdid);
	while($row2= mysql_fetch_assoc($rs2)) { if($row2['id']==$colid) $soluong= $row2['min'];}
	$startdate=date('Y-m-d');
	$enddate= date('Y-m-d', strtotime('+1 day'));
	$rs6= show_price($pid,$rowid,$colid);
	$row6= mysql_fetch_assoc($rs6);
	$pr=$row6['price'];
	if(($o->type==1700) && ($o->ctrl&PRODUCT_CTRL_FREE==PRODUCT_CTRL_FREE)) $pr=$pr*(100-$o->weight)/100;
	$pricesum=$pr*$soluong;
	$adults=$soluong;
	$sql = "INSERT INTO {$tb}shopcarttemp(sess,productid,colid,rowid,quantity,start,stop,subtotal,adults,childover,childunder,extranumber) VALUES ('$sess','$pdid','$colid','$rowid','$soluong','$startdate','$enddate','$pricesum','$adults','$childover','$childunder','$extranumber');";
	mysql_query($sql);
	return mysql_insert_id();
}


// function remove_shopcart_item($id) Xoa  gio hang có id giỏ hàng là $id
function remove_shopcart_item($id)
{
	global $tb;
	global $sess;
	$sql = 'DELETE FROM '.$tb.'shopcarttemp where ((id="'.$id.'") and (sess="'.$sess.'"))';
	mysql_query($sql);
	return true;
}

//update gio hang cho hotel, resort
//$extranumber,$extranumbernumber,
function update_shopcart_hotel($shopcartid,$pdid,$startdate,$enddate,$soluong,$rowid,$colid,$extranumber=0,$notes='')
{	
	$count=0;
	$price=0;
	global $tb;
	$datediff=0;
	$datediff1=0;
	$startdate2=$startdate;	
	$sql = 'select * from '.$tb.'nameprice where (((startdate <= "'.$startdate.'" and enddate >= "'.$enddate.'") or (startdate >= "'.$startdate.'" and startdate <= "'.$enddate.'") or (enddate >= "'.$startdate.'" and enddate <= "'.$enddate.'") ) and pdid ="'.$pdid.'") ORDER BY startdate ASC';
	$rs = mysql_query($sql);
	$sql8='SELECT DATEDIFF("'.$enddate.'","'.$startdate.'") AS DiffDate';
	$rs8 = mysql_query($sql8);
	$row8= mysql_fetch_assoc($rs8);
	$datediff= $row8['DiffDate'];
	$i=0;
	$array= array();
	while($row=mysql_fetch_assoc($rs))
	{
		$i++;
		$array[]=$row;
		
	}
	
	if($i==1) 
	{
		$a = show_price($array[0]['id'],$rowid,$colid);
		$ra = mysql_fetch_assoc($a);
		$p = $ra['price'];
		$count = $count+ $datediff * $p * $soluong+ $datediff*$extranumber*$ra['extra'];
	} else
	{
	if($i>1)
		{
		for($t=0;$t<$i;$t++)
		{
			$a = show_price($array[$t]['id'],$rowid,$colid);
			$ra = mysql_fetch_assoc($a);
			$p = $ra['price'];
			if($t!=($i-1))
			{
				if($t==0) 
				{
					$sql7='SELECT DATEDIFF("'.$array[$t][enddate].'","'.$startdate.'") AS DiffDate';
				} else $sql7='SELECT DATEDIFF("'.$array[$t][enddate].'","'.$array[$t][enddate].'") AS DiffDate';
			} else $sql7='SELECT DATEDIFF("'.$enddate.'","'.$array[$t-1][enddate].'") AS DiffDate';
			$rs7 = mysql_query($sql7);
			$row7= mysql_fetch_assoc($rs7);
			$datediff1= $row7['DiffDate'];
			$count = $count + $datediff1 * $p * $soluong + $datediff1*$extranumber*$ra['extra'];
		}
		}
	}
	
	if($i==0)
	{
		$sql = 'select * from '.$tb.'nameprice where pdid ="'.$pdid.'" ORDER BY startdate ASC';
		$rs = mysql_query($sql);
		$row = mysql_fetch_assoc($rs);
		$a = show_price($row['id'],$rowid,$colid);
		$ra = mysql_fetch_assoc($a);
		$p = $ra['price'];
		$count = $count+ $datediff * $p * $soluong + $datediff*$extranumber*$ra['extra'];	
	}
	//$count= $count + ($datediff*$extranumber*$soluong);
	$sql = 'update '.$tb.'shopcarttemp set colid="'.$colid.'", rowid ="'.$rowid.'", quantity ="'.$soluong.'", extranumber ="'.$extranumber.'", subtotal ="'.$count.'", start = "'.$startdate.'", stop= "'.$enddate.'", notes= "'.$notes.'" where id="'.$shopcartid.'"';
	mysql_query($sql);
	return true;	
}



//update gio hang cho tour

function update_shopcart_tour($shopcartid,$pdid,$startdate,$enddate,$rowid,$adults,$childover,$childunder,$childoverprice=50,$notes='')
{
		$count=0;
		$price=0;
		global $tb;
		$datediff=0;
		$datediff1=0;
		$startdate2=$startdate;
		$numb= ($childover*$childoverprice)/100;
		$soluong2= $adults + $numb;
		$numb=(int)$numb;
		$soluong= $adults + $numb;
		$sql = 'select * from '.$tb.'nameprice where ((startdate <= "'.$startdate.'" and enddate >= "'.$startdate.'") and pdid ="'.$pdid.'") ORDER BY startdate ASC';
		$rs = mysql_query($sql);
		$row = mysql_fetch_assoc($rs);
		$pid = $row['id'];
		if ($pid==NULL) return false;
		$sql2 = 'select * from '.$tb.'colprice where ((pdid='.$pdid.') and (min<='.$soluong.') and (max>='.$soluong.'))';
		$rs2 = mysql_query($sql2);
		$row2= mysql_fetch_assoc($rs2);
		$sql3 = 'select * from '.$tb.'pricedetail where ((nameid='.$pid.') and (colid='.$row2['id'].') and (rowid='.$rowid.'))';
		$rs3 = mysql_query($sql3);
		$row3= mysql_fetch_assoc($rs3);
		$p= (int)$row3['price'];
		$o = productread($pdid);
		if(($o->ctrl&PRODUCT_CTRL_INSTOCK==PRODUCT_CTRL_INSTOCK) && (datediff($startdate)<=$o->mincartqty) && (datediff($startdate)>=0)) $p=$p*(100-$o->weight)/100;
		$count = $p * $soluong2;
		$sql4 = 'update '.$tb.'shopcarttemp set colid="'.$row2['id'].'", rowid ="'.$rowid.'", quantity ="'.$soluong.'",  adults ="'.$adults.'", childover ="'.$childover.'", childunder ="'.$childunder.'",subtotal ="'.$count.'", start = "'.$startdate.'" , stop = "'.$enddate.'" '.($notes!=NULL?', notes = "'.$notes.'"':'').' where id="'.$shopcartid.'"';
		if(mysql_query($sql4))
		return true;
}

// add by thoht for flight and train ticket

function datediff($date1,$date2=NULL)
{
	$sql='SELECT DATEDIFF("'.$date1.'",now()) as datediff';
	if($date2!=NULL) $sql='SELECT DATEDIFF("'.$date1.'","'.$date2.'") as datediff';
	$time=mysql_fetch_assoc(mysql_query($sql));
	return $time['datediff'];
	//them cac tham so order by
}

function update_shopcart_item($shopcartid,$pdid,$soluong,$startdate,$stoptime,$rowid,$colid,$extranumber=1,$notes='')
{	
	$count=0;
	$price=0;
	global $tb;
	$sql = 'select * from '.$tb.'nameprice where ( pdid ="'.$pdid.'") ORDER BY startdate ASC';
	$rs = mysql_query($sql);
	$row = mysql_fetch_assoc($rs);
	$pid = $row['id']; // return id tableprice
	if ($pid==NULL) return false;
	$sql2 = 'select id from '.$tb.'colprice where (pdid='.$pdid.') and id = "'.$colid.'"';
	$rs= mysql_fetch_object( mysql_query($sql2));
	$coltb = $rs->id; 
	$sql2 = 'select id from '.$tb.'rowprice where (pdid='.$pdid.') and id = "'.$rowid.'"';
	$rs= mysql_fetch_object( mysql_query($sql2));
	$rowtb= $rs->id;
	$sql3 = 'select * from '.$tb.'pricedetail where ((nameid='.$pid.') and (colid='.$coltb.') and (rowid='.$rowtb.'))'; 
	$rs3 = mysql_query($sql3);
	$row3= mysql_fetch_assoc($rs3);
	$p= (int)$row3['price'];
	$count = $p * $soluong; 
	$sql4 = 'update '.$tb.'shopcarttemp set colid="'.$colid.'", rowid ="'.$rowid.'", start = "'.$startdate.'", stop="'.$stoptime.'" ,quantity ="'.$soluong.'", notes="'.$notes.'",subtotal ="'.$count.'" where id="'.$shopcartid.'"';
	mysql_query($sql4);	
	return true;
}
// for tourduvietnam, remove enddate, add by thoht
function update_shopcart_tourdu($shopcartid,$pdid,$startdate,$enddate,$rowid,$adults,$childover,$childunder,$childoverprice=50,$notes='')
{
		$count=0;
		$price=0;
		global $tb;
		$datediff=0; 
		$datediff1=0;
		$startdate2=$startdate;
		$numb= ($childover*$childoverprice)/100;
		$soluong2= $adults + $numb;
		$numb=(int)$numb;
		$soluong= $adults + $numb;
		$sql = 'select * from '.$tb.'nameprice where ((startdate <= "'.$startdate.'" and enddate >= "'.$startdate.'") and pdid ="'.$pdid.'") ORDER BY startdate ASC';
		$rs = mysql_query($sql); 
		$row = mysql_fetch_assoc($rs);
		$pid = $row['id']; 
		if ($pid==NULL) return false;
		$sql2 = 'select * from '.$tb.'colprice where ((pdid='.$pdid.') and (min<='.$soluong.') and (max>='.$soluong.'))';
		$rs2 = mysql_query($sql2);
		$row2= mysql_fetch_assoc($rs2);
		$sql3 = 'select * from '.$tb.'pricedetail where ((nameid='.$pid.') and (colid='.$row2['id'].') and (rowid='.$rowid.'))';
		$rs3 = mysql_query($sql3);
		$row3= mysql_fetch_assoc($rs3);
		$p= (int)$row3['price']; 
		$count = $p * $soluong2; 
		$sql4 = 'update '.$tb.'shopcarttemp set  rowid ="'.$rowid.'", quantity ="'.$soluong.'",  adults ="'.$adults.'", childover ="'.$childover.'", childunder ="'.$childunder.'",subtotal ="'.$count.'", start = "'.$startdate.'"';
		$sql4 .= $enddate?', stop = "'.$enddate.'"':'';
		$sql4 .= ' where id="'.$shopcartid.'"'; 
		if(mysql_query($sql4))
		return true;
}
// end thoht
//Trả ra các sản phẩm của giỏ hàng
// add by thoht: parameter $id
function get_shopcart($id=false)  
{
	global $sess;
	global $tb; 
	$sql = "select * from {$tb}shopcarttemp where sess='{$sess}' "; // add by thoht : order by id desc
	$sql .= $id?' and id ="'.$id.'"' : '';
	$sql .= " ORDER BY id DESC "; 
	$rs = mysql_query($sql);
	return  $rs;
}

function read_shopcartitem($id)  
{
	//session_start();
	//session_unregister('book');
	//$sess = $_SESSION['book'];	
	global $tb; 
	$sql = 'select * from '.$tb.'shopcarttemp where id="'.$id.'"';
	$row = mysql_fetch_assoc(mysql_query($sql));
	return  $row;
}
function send_shopcart()   //Xóa giỏ hàng sau khi đã gửi đơn hàng đi.
{
	global $tb;
	//session_start();
	//$sess = $_SESSION['book'];	
	global $sess;
	//$date=date('Y-m-d');
	if($sess!=NULL) 
	{	
	$sql4="select * from {$tb}shopcartuser;";
	$rs4=mysql_query($sql4);
	$row4 = mysql_fetch_assoc($rs4);
	$idorder= $row4['ID'];
	$rs2=get_shopcart();
	while($row= mysql_fetch_assoc($rs2))
	{
		$sql2 = 'INSERT INTO '.$tb.'shopcartdetail(idorder,sess,productid,colid,rowid,quantity,start,stop,subtotal) VALUES ("'.$idorder.'","'.$row['sess'].'","'.$row['productid'].'","'.$row['colid'].'","'.$row['rowid'].'","'.$row['quantity'].'","'.$row['start'].'","'.$row['stop'].'","'.$row['subtotal'].'")';
		if(!mysql_query($sql2)) return false;
	}
	$sql = "delete from {$tb}shopcarttemp where sess='{$sess}';";
	if(!mysql_query($sql)) return false;
	}
	//session_unregister('book'); 
	//setcookie("book","", time()-5600);
	return  true;
}




//Them thong tin thong khach hang
function add_customer_info($CustID=0,$CustTitle='',$CustName='',$CustCompany='',$CustAddress='',$CustGender='',$CustCity='',$CustCountry='',$CustPhone='',$CustMobile='',$CustFax='',$CustEmail='',$Summary='')
{
	global $tb;
	global $sess;
	$sql3 = 'INSERT INTO '.$tb.'shopcartuser(CustID,sess,CustTitle,CustName,CustCompany,CustAddress,CustGender,CustCity,CustCountry,CustPhone,CustMobile,CustFax,CustEmail,Summary) VALUES ("'.$CustID.'","'.$sess.'","'.$CustTitle.'","'.$CustName.'","'.$CustCompany.'","'.$CustAddress.'","'.$CustGender.'","'.$CustCity.'","'.$CustCountry.'","'.$CustPhone.'","'.$CustMobile.'","'.$CustFax.'","'.$CustEmail.'","'.$Summary.'")';
	if(!mysql_query($sql3)) return false;
	
}

//Update thong tin thong khach hang
function update_customer_info($CustID=0,$CustTitle='',$CustName='',$CustCompany='',$CustAddress='',$CustGender='',$CustCity='',$CustCountry='',$CustPhone='',$CustMobile='',$CustFax='',$CustEmail='',$Summary='')
{
	global $tb;
	global $sess;
	$sql3 = 'UPDATE '.$tb.'shopcartuser set CustID="'.$CustID.'", CustTitle ="'.$CustTitle.'", CustName ="'.$CustName.'",  CustCompany ="'.$CustCompany.'", CustAddress ="'.$CustAddress.'", CustGender ="'.$CustGender.'",CustCity ="'.$CustCity.'", CustCountry = "'.$CustCountry.'",  CustPhone = "'.$CustPhone.'", CustMobile = "'.$CustMobile.'", CustFax = "'.$CustFax.'", CustEmail = "'.$CustEmail.'", Summary = "'.$Summary.'"  where sess="'.$sess.'"';
	if(!mysql_query($sql3)) return false;
}


//Them thong tin thong tin nguoi dai dien
function add_user_info($UserNameContact='',$EmailContact='',$PhoneContact='',$NationalContact='',$Aldult,$OverChild='', $UnderChild='')
{
	global $tb;
	global $sess;
	$sql = 'INSERT INTO '.$tb.'shopcartuser(sess,UserNameContact,EmailContact,PhoneContact,NationalContact,Aldult,OverChild,UnderChild) VALUES ("'.$sess.'","'.$UserNameContact.'","'.$EmailContact.'","'.$PhoneContact.'","'.$NationalContact.'","'.$Aldult.'","'.$OverChild.'","'.$UnderChild.'")';
	if(!mysql_query($sql)) return false;	
}

//update thong tin thong tin nguoi dai dien
function update_user_info($UserNameContact='',$EmailContact='',$PhoneContact='',$NationalContact='',$Aldult,$OverChild='', $UnderChild='')
{
	global $tb;
	global $sess;
	$sql3 = 'UPDATE '.$tb.'shopcartuser set UserNameContact="'.$UserNameContact.'", EmailContact ="'.$EmailContact.'", PhoneContact ="'.$PhoneContact.'",  NationalContact ="'.$NationalContact.'", Aldult ="'.$Aldult.'", OverChild ="'.$OverChild.'", UnderChild = "'.$UnderChild.'"  where sess="'.$sess.'"';
	if(!mysql_query($sql3)) return false ;
}

//lay thong tin thong tin nguoi dai dien va khach hang
function get_customer_info()
{
	global $sess;
	global $tb;
	$sql = 'select * from '.$tb.'shopcartuser where sess="'.$sess.'"';
	$rs = mysql_query($sql);
	//echo $sql;
	return $rs;
}


// Hien thi gio hang (tham khao)
function show_shopcart()
{
	$rs=get_shopcart();
?>
<?php 
while ($row = mysql_fetch_assoc($rs))
{
//print_r($row);
$o = productread((int)$row['productid']);
if ($o->type!=44) 
{
 echo '<form method="post" action="process1.php?act=update&PDid='.$o->id.'"><div><div class="book_hotel">';
 ?>
        	<strong><?php echo $o->name;?></strong>
            <table width="100%" border="0"><tr><td><table width="100%" border="0"><tr>
                        <td width="18%" valign="top"><?php echo T_ROOM_NUMBER;?>:</td>
                        <?php echo '<td width="9%" valign="top"><input name="soluong" type="text" value='.$row['quantity'].' class="number_room" /></td>';?>
                        <td width="14%" valign="top"><?php echo T_ROOM_TYPE;?>:</td>
                        <td width="28%" valign="top">
                        	<select name="rowid" class="room_class">
                            	<?php
								$t1='';
								$t2='';
								$rs2=show_row($row['productid']);
							while ($row2= mysql_fetch_assoc($rs2))
								{
									if ($row2['id']==$row['rowid']) { $t1= '<option value='.$row2['id'].'>'.$row2['name'].'</option>';} else $t2= $t2.'<option value='.$row2['id'].'>'.$row2['name'].'</option>';
									
								}
								echo $t1.$t2;
						?>
                            </select></td>
                        <td width="14%" valign="top"><?php echo T_ROOM_LEVEL;?>:</td>
                        <td width="16%" valign="top">
                        	<select name="colid" class="room_type">
                            	<?php
								$k1='';
								$k2='';
								$rs4= show_col($row['productid']);
								while ($row3= mysql_fetch_assoc($rs4))
								{
									if ($row3['id']==$row['colid']) { $k1= '<option value='.$row3['id'].'>'.$row3['name'].'</option>';} else $k2 = $k2.'<option value='.$row3['id'].'>'.$row3['name'].'</option>';
								}
								echo $k1.$k2;
                            
						?>
                            </select></td></tr></table></td></tr><tr><td>
<table width="100%" border="0"><tr><td width="16%"><?php echo T_DATE_FROM;?>:</td><td width="25%" align="left">
                        	<?php echo '<input type="text" value="'.$row['start'].'" class="book_date" id="departdate_in'.$dt.'" name="startdate" align="top"/>';
							
                			//echo '<img src="images/calendar.gif" width="18" height="19" align="absmiddle" id="ORdepartdate_in'.$dt.'"/>';
                       echo '<input type="hidden" name="k" value="1"><input type="hidden" name="idshopcart" value="'.$row['id'].'">';?>
					   </td><td><?php echo T_DATE_TO;?>:</td><td>
                        	<?php
                        	echo '<input type="text" value="'.$row['stop'].'" class="book_date" id="departdate_out'.$dt.'" name="enddate" align="top"/>';
                        ?>
                        </td><td><div class="book_flight_2">
                               <?php 
							   echo $row['subtotal'];
							   ?>
                            </div></td><td>
                            <div class="book_flight_3">
                                <input type="submit" name="submit" value="<?php echo T_UPDATE;?>" />
                            </div>
</td><td><input type="submit" name="submit2" value="<?php echo T_DELETE;?>" /</td></tr></table></td></tr></table></div></div>
	
	<?php 
	echo '</form>';
	}
if ($o->type==44)  
{
echo '<form method="post" action="process1.php?act=update2&PDid='.$o->id.'"><div><div class="book_hotel">';	
	 echo '<div><div class="book_flight"><strong>'.$o->name.' - '.$o->unit.'</strong><table width="100%" border="0">';
         // print_r($o);
		  echo '<tr><td>Ng&agrave;y kh&#7903;i h&agrave;nh: </td>';
           echo ' <td><input type="text" value="'.$row['start'].'" class="book_date" id="departdate_in'.$dt.'" name="startdate" align="top"/></td>';
		   
		   echo '<select name="rowid" class="room_class">';
                            
								$t1='';
								$t2='';
								$rs2=show_row($row['productid']);
							while ($row2= mysql_fetch_assoc($rs2))
								{
									if ($row2['id']==$row['rowid']) { $t1= '<option value='.$row2['id'].'>'.$row2['name'].'</option>';} else $t2= $t2.'<option value='.$row2['id'].'>'.$row2['name'].'</option>';
									
								}
								echo $t1.$t2;			
                           echo ' </select>';
			echo '<input type="hidden" name="colid" value="1"><input type="hidden" name="enddate" value="2009-04-21">';	
			echo '<input type="hidden" name="k" value="2"><input type="hidden" name="idshopcart" value="'.$row['id'].'">';		   
			echo '<td>&nbsp; &nbsp; S&#7889; l&#432;&#7907;ng v&eacute;:</td>';
           echo ' <td><input name="soluong" type="text" value='.$row['quantity'].' class="book_persons" /></td><td><div class="book_flight_2">$'.$row['subtotal'].'</div></td>';
           echo ' <td><div class="book_flight_3"><input type="submit" name="submit" value="C&#7853;p nh&#7853;t" /></div></td><td><div class="book_flight_3"><input type="submit" name="submit2" value="B&#7887;" /></div></td></tr></table></div></div></form>';
		   }
	}
}



?>