<link href="../images/calendar-win2k-cold-2.css" rel="stylesheet" type="text/css" />
<table>
<tr><td>
<?php
require_once(PATH_COMPLS.'price_new_admin.php');
require_once(PATH_COMPLS.'price_new.php');
$k=1;
$d= date('Y-m-d');
$d1= date('Y-m-d', strtotime('+1 day')) ;
$d2= '2999-01-01';
$act= 'show_add';
if (isset($_POST['act'])) $act=$_POST['act'];
if (isset($_GET['act'])) $act=$_GET['act'];
//$pdid= 18;
if (isset($_POST['pdid'])) {$pdid= $_POST['pdid'];}
if (isset($_POST['Pdid'])) {$pdid= $_POST['Pdid'];}
if (isset($_POST['rid'])) {$rid= $_POST['rid'];}
if (isset($_POST['cid'])) {$cid= $_POST['cid'];}
if (isset($_POST['pid'])) {$pid= $_POST['pid'];}
if (isset($_POST['min'])) {$min= $_POST['min'];}
if (isset($_POST['max'])) {$max= $_POST['max'];}
if (isset($_GET['CPid'])) $CPid= $_GET['CPid'];
if (isset($_POST['namep'])) $namep= $_POST['namep'];
if (isset($_GET['PDpage'])) { $PDpage= $_GET['PDpage'];} else {$PDpage =1; }
$pdid = (int)$pdid;
$o1=productread(@$pdid);
$o2=catproductread($CPid);
echo '<a href="../product/item-list.php?CPid='.$CPid.'&PDpage='.$PDpage.'">'.$o2->name.'</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="../product/item.php?PDid='.$pdid.'">'.$o1->name.'</a>';
$startdate= $_POST['startdate'];
$enddate= $_POST['enddate'];
$status= 0;
$extra=0; if(isset($_POST['extra'])) { $extra= $_POST['extra']; }
if(isset($_POST['status'])) $status = 1;
if($act== 'add_new_tb2'){
	add_price_name($namep, $pdid, '2', $startdate, $enddate, $status, '');
}
if($act== 'add_row_name'){
	add_row_price($namep, $pdid);
}
if($act== 'add_col_name'){
	add_col_price($namep, $min, $max, $pdid);
}
if($act== 'update_new_tb2'){
	update_price_name($pid, $namep, $startdate, $enddate, '', $status, $d, $extra);
}
if($act== 'add_col_row'){
	if (isset($_POST['update'])) 
	{
		@$rid = $_POST["rid"];
		for($i=0;$i<count($rid);$i++)
		{
			$namep = $_POST[$rid[$i]];
			update_row_price($rid[$i],$namep);
		}
	}
	if (isset($_POST['delete'])) 
	{
		@$rid = $_POST["rid"];
		//print_R($rid);
		for($i=0;$i<count($rid);$i++)
		{
			remove_row_price($rid[$i]);
		}
	}
}
if($act=='add_col_row1'){
	//if(isset($_POST['update'])) update_col_price($cid, $namep, $min, $max);
	//if(isset($_POST['delete'])) remove_col_price($cid);
	if (isset($_POST['update']))
	{
		@$cid = $_POST["cid"];
		for($i=0;$i<count($cid);$i++)
		{
			$namep = $_POST[$cid[$i]];
			$min = $_POST['min'.$cid[$i]];
			$max = $_POST['max'.$cid[$i]];
			update_col_price($cid[$i],$namep,(int)$min,(int)$max);
		}
	}
	if (isset($_POST['delete']))
	{
		@$cid = $_POST["cid"];
		for($i=0;$i<count($cid);$i++)
		{
			remove_col_price($cid[$i]);
		}
	}
}
if($act== 'del_new_tb'){
	remove_price_name($pid);
	remove_price($pid);
}

// price home
if($act=='show_add'||$act=='del_new_tb'||$act=='add_new_tb2') 
{
	echo '<br><br><table><tr>';
	echo '<td><form method="post"><input type ="hidden" name ="act" value="add_new_tb"><input type ="submit" value="Th&#234;m B&#7843;ng Gi&#225;"></form></td>';
	echo '<td><form method="post"><input type ="hidden" name ="act" value="add_col_row"><input type ="submit" value="Th&#234;m D&#242;ng"></form></td>';
	echo '<td><form method="post"><input type ="hidden" name ="act" value="add_col_row1"><input type ="submit" value="Th&#234;m C&#7897;t"></form></td>';
	echo '</tr></table>';
	echo '<hr size="3">';
	$rs= show_price_name($pdid,true);
	echo '<table>';
	while ($row = mysql_fetch_assoc($rs)){
		$st = explode('-', $row['startdate']);
		$st1 = explode('-', $row['enddate']);
		echo '<tr>';
		echo '<td><form ><b>'.$row['name'].'</b> ('.$st[2].'/'.$st[1].'/'.$st[0].' &#272;&#7871;n '.$st1[2].'/'.$st1[1].'/'.$st1[0].')</form></td>';
		echo '<td><form method="post"><input type ="hidden" name ="act" value="edit_new_tb"><input type ="hidden" name ="pid" value="'.$row['id'].'"><input type ="submit" value="S&#7917;a"></form></td>';
		//echo '<td><form method="post"><input type ="hidden" name ="act" value="input_new_tb"><input type ="hidden" name ="pid" value="'.$row['id'].'"><input type ="submit" value="Nh&#7853;p"></form></td>';
		echo '<td><form method="post"><input type ="hidden" name ="act" value="del_new_tb"><input type ="hidden" name ="pid" value="'.$row['id'].'"><input type ="submit" value="X&#243;a"></form></td>';
		echo '</tr>';
	}
	echo '</table>';
}


// form them bang gia

if($act=='add_new_tb')
{
	echo '<fieldset><legend style="color:#FF00FF; font-size:36px">Thêm b?ng giá</legend> <br><form method="post">';
	echo '<input type ="hidden" name ="act" value="add_new_tb2">';
	echo 'Ten&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name = "namep" value="Nhap ten">';
	echo '<br>';
	echo 'Ngay bat dau: <input type="text" name="startdate" value="'.$d.'"><br>';
	echo 'Ngay ket thuc: <input type="text" name="enddate" value="'.$d2.'"><br>';
	echo 'Trang thai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="checkbox" checked="checked" name="status" value="1"><br>';
	echo '<input type="submit" name="addtable" value="Thêm"></form>';
	echo '<form method="post"><input type ="hidden" name ="act" value="show_add"><input type="submit" name="cancel" value="Thoát">';
	echo '</form>';
	echo '</fieldset>';
}


// form s?a b?ng giá
if($act=='edit_new_tb' || $act == 'update_new_tb2')
{
	$rs= show_price_name($pdid,true);;
	while($a= mysql_fetch_assoc($rs)) { if($a['id']==$pid) $row = $a;}
	echo '<fieldset><legend style="color:#FF00FF; font-size:36px">B&#7843;ng gi&#225;</legend> <br><form method="post">';
	echo '<input type ="hidden" name ="act" value="update_new_tb2">';
	echo '
	<table>
		<tr>
			<td>T&#234;n</td>
			<td><input type="text" name = "namep" value="'.$row['name'].'"></td>
		</tr>
		<tr>
			<td>Ng&#224;y b&#7855;t &#273;&#7847;u</td>
			<td><input type="text" id="Istartdate" name="startdate" value="'.$row['startdate'].'">
			<img class="tour_detail_celender" src="../images/calendar.jpg" id="Bstartdate"/></td>
		</tr>
		<tr>
			<td>Ng&#224;y h&#7871;t hi&#7879;u l&#7921;c</td>
			<td><input type="text" name="enddate" id="Ienddate" value="'.$row['enddate'].'">
			<img class="tour_detail_celender" src="../images/calendar.jpg" id="Benddate"/></td>
		</tr>
		<tr>
			<td>Private Car</td>
			<td><input type="text" name="extra" value="'.$row['extra'].'"></td>
		</tr>
		<tr>
			<td>Tr&#7841;ng th&#225;i</td>
			<td><input type="checkbox" ';
				if ($row['status']==1) { echo 'checked="checked" '; }
				echo 'name="status" value="1"></td>
			</tr>
	</table>';
	?>
		<script language="javascript" src="../js/calendar.js"></script>
		<script language="javascript" src="../js/calendar-setup.js"></script>
		<script language="javascript" src="../js/calendar-en.js"></script>
		<script language="javascript">
			Calendar.setup(
				{
					inputField : "IstartDate",
					ifFormat : '%Y-%m-%d',
					button : "Bstartdate"
				}	
			)
			Calendar.setup(
				{
					inputField : "Ienddate",
					ifFormat : '%Y-%m-%d',
					button : "Benddate"
				}	
			)
		</script>
<?php
	/*echo 'Ten&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name = "namep" value="'.$row['name'].'">';
	echo '<br>';
	echo 'Ngay bat dau: <input type="text" name="startdate" value="'.$row['startdate'].'"><br>';
	echo 'Ngay ket thuc: <input type="text" name="enddate" value="'.$row['enddate'].'"><br>';
	echo 'Private Car: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="extra" value="'.$row['extra'].'"><br>';
	echo 'Trang thai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="checkbox" ';
	if ($row['status']==1) { echo 'checked="checked" '; }
	echo 'name="status" value="1"><br>';*/
	echo '<br><b>Nh&#7853;p gi&#225;:<b><br><br>';
	$rs= show_row($pdid);
	$rs1= show_col($pdid);	
	$arow= array();
	$acol= array();
	$i=0; $i1=0;
	while ($arow[]= mysql_fetch_assoc($rs)) {$i++;};
	while ($acol[]= mysql_fetch_assoc($rs1)) {$i1++;};
	//echo '<input type ="hidden" name ="act" value="input_new_tb">';
	echo '<input type ="hidden" name ="pid" value="'.$pid.'">';
	echo '<table>';
	echo '<tr>';
		echo '<td align="center">T/R</td>';
		for($t=0;$t<$i1;$t++)
		{
			echo '<td align="center">'.$acol[$t]['name'].'</td>';
		}
	echo '</tr>';	
	for($t2=0;$t2<$i;$t2++)
	{
	echo '<tr>';
			echo '<td align="center">'.$arow[$t2]['name'].'</td>';
	for($t=0;$t<$i1;$t++)
	{
		
		$pr= 0;
		$rowid=$arow[$t2]['id'];
		$colid=$acol[$t]['id'];
		$rs2= show_price($pid,$rowid,$colid);
		$row2= mysql_fetch_assoc($rs2); 
		//print_r($row2);
		$test= $row2['id'];
		if(isset($_POST[$test]))
		{
			$test2= $_POST[$test];
			update_price($test,$test2,$extra);
		}
		if ($row2['price']==NULL)
		{
			add_price($pid,0,$rowid,$colid);
		}
		$rs2= show_price($pid,$rowid,$colid);
		$row2= mysql_fetch_assoc($rs2);
		if ($row2['price']!=NULL)
		{
			$pr= $row2['price']; 
		}		
		echo '<td><input name="'.$row2['id'].'" value="'.$pr.'" /></td>';
		
	}
		echo '</tr>';
	}
	echo '</table>';
	echo '<input type="hidden" name="pid" value="'.$pid.'"><input type="submit" value="S&#7917;a" name="update"></form>';
	echo '<form method="post"><input type ="hidden" name ="act" value="show_add"><input type="submit" name="cancel" value="Tho&#225;t">';
	echo '</form>';
	echo '</fieldset>';
}



////////////////////////

if($act=='add_col_row1'||$act=='add_col_name') 
{
	echo '<fieldset><legend style="color:#FF00FF; font-size:36px">Thêm c?t</legend>';
	echo '<form method="post">';
	echo '<input type ="hidden" name ="act" value="add_col_name">';
	echo '<input type="hidden" name="pdid" value="'.$pdid.'">';
	echo 'Ten: <input type="text" value="new name" name ="namep">';
	if($k!=2)
	{
		echo 'min: <input type="text" value="1" name ="min">max: <input type="text" value="2" name ="max" >';
	} else echo '<input type="hidden" value="1" name ="min"><input type="hidden" value="2" name ="max" >';
	echo '<input type="submit" value="Thêm" name="new"><br /><hr /></form><br />';
	$rs1= show_col($pdid);
	echo '<form method="post">';
	echo '<input type ="hidden" name ="act" value="add_col_row1">';
		echo '<input type="hidden" name="pdid" value="'.$pdid.'">';
	while ($row = mysql_fetch_assoc($rs1))
	{
	echo '<input type="checkbox" '; echo "name='cid[]'";  echo 'value="'.$row['id'].'">';
	echo 'Ten: <input type="text" value="'.$row['name'].'" name ="'.$row['id'].'">';
	if($k!=2)
	{	
		echo 'min: <input type="text" value="'.$row['min'].'" name = "min'.$row['id'].'">max: <input type="text" value="'.$row['max'].'"  name = "max'.$row['id'].'">';
	} else echo '<input type="hidden" value="'.$row['min'].'" name = "min"><input type="hidden" value="'.$row['max'].'"  name = "max">';
	
	echo '<br>';
	}
	echo '<input type="submit" value="S?a" name="update"><input type="submit" name="delete" value="Xóa"> <input type="hidden" name="id" value="id"></form>';
	echo '</fieldset>';
	echo '<form method="post"><input type ="hidden" name ="act" value="show_add"><input type= "submit" name ="cancel" value="Thoát"></form>';
}

//////////////////

if($act=='add_col_row'||$act=='add_row_name')
{
	echo '<fieldset><legend style="color:#FF00FF; font-size:36px">Thêm dòng</legend>';
	echo '<form method="post">';
	echo '<input type ="hidden" name ="act" value="add_row_name">';
	echo '<input type="hidden" name="pdid" value="'.$pdid.'">';
	echo 'Ten: <input type="text" value="new name" name ="namep"><input type="submit" value="Thêm" name="new"><br /><hr /></form>';
	$rs= show_row($pdid);
	echo '<form method="post">';
	//echo '<input type="hidden" name="rid" value="'.$row['id'].'">';
	echo '<input type="hidden" name="pdid" value="'.$pdid.'">';
	echo '<input type ="hidden" name ="act" value="add_col_row">';
	while ($row = mysql_fetch_assoc($rs))
	{
		echo '<input type="checkbox" '; echo "name='rid[]'";  echo 'value="'.$row['id'].'">';
		echo 'Ten: <input type="text" value="'.$row['name'].'" name ="'.$row['id'].'"><br>';
	}	
		echo '<input type="submit" value="S?a" name="update"><input type="submit" name="delete" value="delete"> <input type="hidden" name="id" value="id"></form>';
	echo '</fieldset>';
	echo '<form method="post"><input type ="hidden" name ="act" value="show_add"><input type="submit" name="cancel" value="Thoát">';	
}
if($act=='input_new_tb')
{
	
	$rs= show_row($pdid);
	$rs1= show_col($pdid);	
	$arow= array();
	$acol= array();
	$i=0; $i1=0;
	while ($arow[]= mysql_fetch_assoc($rs)) {$i++;};
	while ($acol[]= mysql_fetch_assoc($rs1)) {$i1++;};
	echo '<form method="post">';
	echo '<input type ="hidden" name ="act" value="input_new_tb">';
	echo '<input type ="hidden" name ="pid" value="'.$pid.'">';
	echo '<table>';
	echo '<tr>';
		echo '<td align="center">T/R</td>';
		for($t=0;$t<$i1;$t++)
		{
			echo '<td align="center">'.$acol[$t]['name'].'</td>';
		}
	echo '</tr>';	
	for($t2=0;$t2<$i;$t2++)
	{
	echo '<tr>';
			echo '<td align="center">'.$arow[$t2]['name'].'</td>';
	for($t=0;$t<$i1;$t++)
	{
		
		$pr= 0;
		$rowid=$arow[$t2]['id'];
		$colid=$acol[$t]['id'];
		$rs2= show_price($pid,$rowid,$colid);
		$row2= mysql_fetch_assoc($rs2); 
		
		$test= $row2['id'];
		if(isset($_POST[$test])) 
		{
			$test2= $_POST[$test];
			update_price($test,$test2,$extra);
		}
		if ($row2['price']==NULL)
		{
			add_price($pid,0,$rowid,$colid);
		}
		$rs2= show_price($pid,$rowid,$colid);
		$row2= mysql_fetch_assoc($rs2);
		if ($row2['price']!=NULL)
		{
			$pr= $row2['price']; 
		}		
		echo '<td><input name="'.$row2['id'].'" value="'.$pr.'" /></td>';
		
	}
		echo '</tr>';
	}
	echo '</table>';
	echo '<input type="submit" name="" value="S?a" align="middle" />';
	echo '</form>';
	echo '<form method="post"><input type ="hidden" name ="act" value="show_add"><input type="submit" name="cancel" value="Thoát">';
}
?>
</tr></td></table>
