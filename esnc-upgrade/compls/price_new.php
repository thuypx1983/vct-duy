<?php
$tb=DB_TABLE_PREFIX;
//function show_price($nameid,$rowid,$colid) trả ra giá của bảng giá có id là $nameid, id của cột và dòng là : $rowid và $colid;
function show_price($nameid,$rowid,$colid=NULL)
{	
	global $tb;
	if($colid!=NULL) { $sql = "select * from {$tb}pricedetail where (nameid={$nameid} and rowid={$rowid} and colid={$colid});"; } else {
						$sql = "select * from {$tb}pricedetail where (nameid={$nameid} and rowid={$rowid} );"; }
	$rs = mysql_query($sql);
	return $rs;
}
//function show_price_detail($pkid) trả ra các bản ghi của bang chi tiết giá có id =$pkid;
function show_price_detail($pkid)
{	
	global $tb;
	$sql = "select * from {$tb}pricedetail where id={$pkid};";
	$rs = mysql_query($sql);
	return $rs;
}


function show_price_name($pdid,$status=false) //trả ra các tên bảng giá của sản phẩm có id= $pdid;
{	
	$d=date('Y-m-d');
	global $tb;
	$sql3 = "select * from {$tb}nameprice where ((pdid={$pdid}) and (status=1 ) and (enddate >={$d}));";
	if($status==true) $sql3 = "select * from {$tb}nameprice where pdid={$pdid};";
	$rs3= mysql_query($sql3);
	return  $rs3;
} 
function show_row($pdid)  //lấy ra các dòng của bảng giá của sản phẩm có id = $pdid;
{
	global $tb;
	$sql = "select * from {$tb}rowprice where pdid={$pdid} order by id;";
	$rs= mysql_query($sql);
	return $rs;
}

//Them 
function readrow($id)  //lấy ra các dòng của bảng giá của sản phẩm có id = $pdid;
{
	global $tb;
	$sql = "select * from {$tb}rowprice where id={$id} order by id;";
	$rs= mysql_query($sql);
	return mysql_fetch_assoc($rs);
}


function show_col($pdid) //lấy ra các cột của bảng giá của sản phẩm có id = $pdid;
{
	global $tb;
	$sql = "select * from {$tb}colprice where pdid={$pdid} order by id;";
	$rs= mysql_query($sql);
	return $rs;
}

// Cac ham hien thi
# Cac ham hien thi
# edited by Thoht
# content: add a parameter $currency (ex: '.000 VND', '$') 
function show_pricetable($pdid,$class,$typeroom,$number=null,$currency='$',$showtitle=1)
{
		$rs3= show_price_name($pdid);
		while($row = mysql_fetch_assoc($rs3))
		{
			$pid = $row['id'];
			//echo '<b>'.$row['name'].'</b><br><br>';
			$rs= show_row($pdid);
			$rs1= show_col($pdid);
			$arow= array();
			$acol= array();
			$i=0; $i1=0;
		   
			while ($arow[]= mysql_fetch_assoc($rs)) {$i++;};
			while ($acol[]= mysql_fetch_assoc($rs1)) {$i1++;};
			if($showtitle==1) echo $row['name'].', update: '.$row['lastupdate'].', valid from '.$row['startdate'].' to '.$row['enddate'];
			echo '<table cellspacing="0" cellpadding="0" class = "table_'.$class.'">';

			echo '<tr>';
				echo '<td class = "'.$class.'_0 '.$class.'_0_0">'.$typeroom.'</td>';
				for($t=0;$t<$i1;$t++)
				{
					$a =$t+1;
					echo '<td class = "'.$class.'_0 '.$class.'_0_'.$a.'">'.$acol[$t]['name'].'</td>';
				}
			echo '</tr>';
		   
		   
			for($t2=0;$t2<$i;$t2++)
			{
			$a2 =$t2+1;
			echo '<tr>';
					echo '<td class = "'.$class.'_'.$a2.' '.$class.'_'.$a2.'_0">'.$arow[$t2]['name'].'</td>';
			for($t=0;$t<$i1;$t++)
			{
			   
				$pr= 0;
				$rowid=$arow[$t2]['id'];
				$colid=$acol[$t]['id'];
				$rs2= show_price($pid,$rowid,$colid);
				$row2= mysql_fetch_assoc($rs2);
				if ($row2['price']!=null)
				{
					$pr= $row2['price'];
				}
				$a =$t+1;
				echo '<td class = "'.$class.'_'.$a2.' '.$class.'_'.$a2.'_'.$a.'"><a class="link_addshopcart" href ="process.php?act=addshopcart&PDid='.$pdid.'&PKid='.$row2['id'].'">'.$pr.$currency.'</a></td>';
			   
			}
				echo '</tr>';
			}
			echo '</table>';
			if($number==null) break;
		}
	return true;
}


// Cac ham hien thi
function show_pricetablewayto_tour($pdid,$class,$typeroom,$number=null)
{
		$rs3= show_price_name($pdid);
		while($row = mysql_fetch_assoc($rs3))
		{
			$pid = $row['id'];
			//echo '<b>'.$row['name'].'</b><br><br>';
			echo '<h4 class="none_tag tblue s14">'.$row['name'].'</h4>';
			//echo '<div class="hotel_detail_price_date1"><strong>'.$row['name'].' valid from '.$row['startdate'].' to '.$row['enddate'].'</strong></div>';
			$rs= show_row($pdid);
			$rs1= show_col($pdid);
			$arow= array();
			$acol= array();
			$i=0; $i1=0; $ml=0;
		   
			while ($arow[]= mysql_fetch_assoc($rs)) {$i++;};
			while ($acol[]= mysql_fetch_assoc($rs1)) {$i1++;};
			//echo $row['name'].', update: '.$row['lastupdate'].', valid from '.$row['startdate'].' to '.$row['enddate'];
			echo '<table cellpadding="0" cellspacing="1" border="0" bgcolor="#e6e6e6" class="tour_detail_tabel">';
			echo '<tr>
                    <td class="tour_detail_tabel_th tour_detail_tabel_th1">'.$typeroom.'</td>';
				for($t=0;$t<$i1;$t++)
				{
					$a =$t+1;
					echo '<td class="tour_detail_tabel_th">'.$acol[$t]['name'].'</td>';
				}
                echo '</tr>';		   
		   
			for($t2=0;$t2<$i;$t2++)
			{
			$a2 =$t2+1;
			echo '<tr>';
					echo '<td class="tour_detail_tabel_td tour_detail_tabel_th1">'.$arow[$t2]['name'].'</td>';
			for($t=0;$t<$i1;$t++)
			{
			   
				$pr= 0;
				$rowid=$arow[$t2]['id'];
				$colid=$acol[$t]['id'];
				$rs2= show_price($pid,$rowid,$colid);
				$row2= mysql_fetch_assoc($rs2);
				if ($row2['price']!=null)
				{
					$pr= $row2['price'];
				}
				$a =$t+1;
				echo '<td class="tour_detail_tabel_td"><a class="torange" href ="process.php?act=addshopcart&PDid='.$pdid.'&PKid='.$row2['id'].'">$'.$pr.'</a></td>';
			   
			}
				 echo '</tr>';
			}
			echo '</table><br>';
			if($number==null) break;
		}
	return true;
}
// Cac ham hien thi
function show_pricetablehalong_tour($pdid,$class,$typeroom,$number=null,&$book)
{
		$book='';
		$rs3= show_price_name($pdid);
		while($row = mysql_fetch_assoc($rs3))
		{
			$pid = $row['id'];
			//echo '<b>'.$row['name'].'</b><br><br>';
			echo '<span style="padding-left:5px; padding-bottom:5px; display:block;">'.$row['name'].'</span>';
			//echo '<div class="hotel_detail_price_date1"><strong>'.$row['name'].' valid from '.$row['startdate'].' to '.$row['enddate'].'</strong></div>';
			$rs= show_row($pdid);
			$rs1= show_col($pdid);
			$arow= array();
			$acol= array();
			$i=0; $i1=0;
		   
			while ($arow[]= mysql_fetch_assoc($rs)) {$i++;};
			while ($acol[]= mysql_fetch_assoc($rs1)) {$i1++;};
			//echo $row['name'].', update: '.$row['lastupdate'].', valid from '.$row['startdate'].' to '.$row['enddate'];
			echo '<table cellpadding="0" cellspacing="1" border="0" bgcolor="#e6e6e6" class="td_table">';
			echo '<tr>
                 <td class="td_01_title td_first">'.$typeroom.'</td>';
				for($t=0;$t<$i1;$t++)
				{
					$a =$t+1;
					echo '<td class="td_01_title">'.$acol[$t]['name'].'</td>';
				}
                echo '<td class="td_01_title td_transfer_title">Transfer</td><td class="td_01_title"></td></tr>';		   
		   
			for($t2=0;$t2<$i;$t2++)
			{
				$a2 =$t2+1;
				echo '<tr>';
						echo '<td class="td_02 td_first">'.$arow[$t2]['name'].'</td>';
				for($t=0;$t<$i1;$t++)
				{
				   
					$pr= 0;
					$rowid=$arow[$t2]['id'];
					$colid=$acol[$t]['id'];
					$rs2= show_price($pid,$rowid,$colid);
					$row2= mysql_fetch_assoc($rs2);
					if ($row2['price']!=null)
					{
						$pr= $row2['price'];
					}
					$a =$t+1;
					echo '<td class="td_02"><a class="torange";' ?> href="#" onclick="sendtoform2('<?php echo 'process.php?act=addshopcart&PDid='.$pdid.'&PKid='.$row2['id']; ?>'); return false;"  <?php echo '>$'.$pr.'</a></td>';
					if($t==0) $tt='process.php?act=addshopcart&PDid='.$pdid.'&PKid='.$row2['id'];
				   
				}
				if($t2==0) {
					echo '<td rowspan="'.$i.'" class="td_02 td_transfer">
						<input name="ex" type="radio" value="1" checked="checked" class="input_td_1"  onclick="sendtoform(1);"/> <span class="transfer_content">'.T_PRICE1.'</span>
						<div class="clr_left"><span></span></div>
						<input name="ex" type="radio" value="2" class="input_td_1" onclick="sendtoform(2);"/> <span class="transfer_content">'.T_PRICE2.'</span>
						<div class="clr_left"><span></span></div>
						<input name="ex" type="radio" value="3" class="input_td_1"  onclick="sendtoform(3);" /> <span class="transfer_content">'.T_PRICE3.'</span>
						<div class="clr_left"><span></span></div>
					</td>';
					}
					if($book=='') $book=$tt;
					echo '<td class="td_02 td_book"><a href="#"'; ?> href="#" onclick="sendtoform2('<?php echo $tt; ?>'); return false;"  <?php echo ' class="tred" >Book now!</a></td></tr>';
			}
			echo '</table><br>';
			if($number==null) break;
		}
	return true;
}


// Hien thi bang gia trang waytovietnam2009
function show_pricetablewayto_visa($pdid,$class,$typeroom,$number=null,$price1='',$price2='')
{
		$rs3= show_price_name($pdid);
		while($row = mysql_fetch_assoc($rs3))
		{
			$pid = $row['id'];
			//echo '<b>'.$row['name'].'</b><br><br>';
			$rs= show_row($pdid);
			$rs1= show_col($pdid);
			$arow= array();
			$acol= array();
			$i=0; $i1=0;
		   
			while ($arow[]= mysql_fetch_assoc($rs)) {$i++;};
			while ($acol[]= mysql_fetch_assoc($rs1)) {$i1++;};
			?>
			<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tour_detail_tab_price_new_visa">
			  <tr>
				<th width="22%" rowspan="2" class="title_table_visa"><?php echo T_VISA_TITTEL1;?></th>
				<th width="29%" rowspan="2" class="title_table_visa"><?php echo T_VISA_TITTEL2;?></th>
				<th width="13%" rowspan="2" class="title_table_visa_2"><?php echo T_VISA_TITTEL3;?></th>
				<th width="13%" rowspan="2" class="title_table_visa_2"><?php echo T_VISA_TITTEL4;?></th>
				<th colspan="2" class="title_table_visa_2"><?php echo T_VISA_TITTEL5;?></th>
			  </tr>
			   <tr>
			<th width="11%" class="title_table_visa_2"><?php echo T_VISA_TITTEL6;?></th>
			<th class="title_table_visa_2"><?php echo T_VISA_TITTEL7;?></th>
			</tr>
			
			
			<?php

				for($t1=0;$t1<$i;$t1++)
				{
				
					for($t=0;$t<$i1;$t++)
					{
						echo '<tr>';
								if($t==0) echo '<td rowspan="'.$i1.'" class="routes_table_4">'.$arow[$t1]['name'].'</td>';
								$rs2= show_price($pid,$arow[$t1]['id'],$acol[$t]['id']);
								$row2= mysql_fetch_assoc($rs2);
							echo '<td class="routes_table_4_2">'.$acol[$t]['name'].'</td>
								<td class="routes_table_4_new">$'.$row2['price'].'</a></td>
								<td class="routes_table_4_new_4"><a href="visa-book.php?act=addshopcart&PDid='.$pdid.'&PKid='.$row2['id'].'&rid='.$arow[$t1]['id'].'">'.T_BOOK_NOW.'</a></td>
								<td class="routes_table_4_new">'.$price1.'</a></td>';
								
								if($t==0) echo '<td width="12%" rowspan="'.$i1.'" class="routes_table_4_new_2">'.$price2.'</td>';
							echo '</tr>';
					}
				}
				echo '<tr>';

							echo '<td class="routes_table_4">Note</td>
									<td class="routes_table_4_new" colspan="5">'.T_NOTE.'</td>';

							echo '</tr>';
			echo '</table>';
		}
		return true;
}

function show_pricetablexgk($pdid, $class, $typeroom, $number= null){
    $rs3= show_price_name($pdid);
	$show= '';
	while($row= mysql_fetch_assoc($rs3)){
	    $pid= $row['id'];
		$rs= show_row($pdid);
		$rs1= show_col($pdid);
		$arow= array();
		$acol= array();
		$i= 0; $i1= 0;
		while($arow[]= mysql_fetch_assoc($rs)){$i++;};
		while($acol[]= mysql_fetch_assoc($rs1)){$i1++;};
		$show.= '<table cellspacing="0" cellpadding="0" class = "table_'.$class.'">';
		$show.= '<tr>';
		$show.= '<td class = "'.$class.'_0 '.$class.'_0_0">'.$typeroom.'</td>';
		for($t= 0; $t< $i1; $t++){
		    $a= $t+ 1;
			$show.= '<td class = "'.$class.'_0 '.$class.'_0_'.$a.'">'.$acol[$t]['name'].'</td>';
        }
		$show.= '</tr>';
		for($t2= 0; $t2< $i; $t2++){
		    $a2= $t2+ 1;
			$show.= '<tr>';
            $show.= '<td class = "'.$class.'_'.$a2.' '.$class.'_'.$a2.'_0">'.$arow[$t2]['name'].'</td>';
			for($t= 0; $t< $i1; $t++){
			    $pr= 0;
				$rowid= $arow[$t2]['id'];
				$colid= $acol[$t]['id'];
				$rs2= show_price($pid, $rowid, $colid);
				$row2= mysql_fetch_assoc($rs2);
				if($row2['price']!= null){
				    $pr= $row2['price'];
                }
                $a= $t+ 1;
				$show.= '<td class = "'.$class.'_'.$a2.' '.$class.'_'.$a2.'_'.$a.'"><a href ="process.php?act=addshopcart&PDid='.$pdid.'&PKid='.$row2['id'].'">$'.$pr.'</a></td>';
            }
            $show.= '</tr>';
        }
    	$show.= '</table><br>';
    	if($number== null) break;
    }
	return $show;
}

//bo xung ham get_price_tour (tinh gia book tour)
function get_price_tour($pdid,$startdate,$rowid,$adults,$childover,$childunder,$childoverprice=50,$priceunit=NULL)
{
		$count=0;
		$price=0;
		global $tb;
		$numb= ($childover*$childoverprice)/100;
		$soluong2= $adults + $numb;
		$numb=(int)$numb;
		$soluong= $adults + $numb;
		$sql = 'select * from '.$tb.'nameprice where ((startdate <= "'.$startdate.'" and enddate >= "'.$startdate.'") and pdid ="'.$pdid.'") ORDER BY startdate ASC';
		$rs = mysql_query($sql);
		$row = mysql_fetch_assoc($rs); //print_R($row);
		$pid = $row['id'];
		if ($pid==NULL) return false;
		$sql2 = 'select * from '.$tb.'colprice where ((pdid='.$pdid.') and (min<='.$soluong.') and (max>='.$soluong.'))';
		$rs2 = mysql_query($sql2);
		$row2= mysql_fetch_assoc($rs2);
		$sql3 = 'select * from '.$tb.'pricedetail where ((nameid='.$pid.') and (colid='.$row2['id'].') and (rowid='.$rowid.'))';
		$rs3 = mysql_query($sql3);
		$row3= mysql_fetch_assoc($rs3);
		$p= (int)$row3['price'];
		$priceunit=$p;
		$count = $p * $soluong2;
		return $count;
}
?>
