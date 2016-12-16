<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Trang chu</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<?php

	
	require('../../config.php');
	require("../inc/common.php");
	require('../inc/session.php');
	//require_once('../../../thuexetructuyen/config.php');
   require_once(PATH_COMPLS.'user.php');
   require_once(PATH_APPLICATION.'lang.php');
   require_once(PATH_COMPLS.'product.php');
   //require_once(PATH_COMPLS.'news.php');
   //echo PATH_COMPLS;
	require_once(PATH_INC.'dbconguest.php');
	include_once(PATH_CLASS.'sessiondata.php');
	//include_once(PATH_INC.'session.php');
	$visited = 0;
	$visitedc = 0;
	$news= 0;
	$product = 0;
	$newsc= 0;
	$productc = 0;
	$contact=0;
	$order=0;
	$contactc=0;
	$year = strftime("%Y");
	$month = strftime("%m");
	
	//$orderc=0;
	if (isset($_POST["year"])) 
	{
		$year = $_POST["year"];
		$month = $_POST["month"];
	} 

		$sql5='select * from '.DB_TABLE_PREFIX.'product where (YEAR(Created)='.$year.' and MONTH(Created)='.$month.' );';
		$rs5 = mysql_query($sql5);
		while(mysql_fetch_assoc($rs5))
		{
			$product++;
		}
		$sql5a='select * from '.DB_TABLE_PREFIX.'product;';
		$rs5a = mysql_query($sql5a);
		while(mysql_fetch_assoc($rs5a))
		{
			$productc++;
		}
		$sql6='select * from '.DB_TABLE_PREFIX.'news where (YEAR(Created)='.$year.' and MONTH(Created)='.$month.' );';
		$rs6 = mysql_query($sql6);
		while(mysql_fetch_assoc($rs6))
		{
			$news++;
		}
		
		$sql6a='select * from '.DB_TABLE_PREFIX.'news;';
		$rs6a = mysql_query($sql6a);
		while(mysql_fetch_assoc($rs6a))
		{
			$newsc++;
		}
		
		$sql7a='select * from '.DB_TABLE_PREFIX.'report where (YEAR(lastrun)='.$year.' and MONTH(lastrun)='.$month.' );';
		$rs7a = mysql_query($sql7a);
		while($row7 = mysql_fetch_assoc($rs7a))
		{
			if($row7['type']==1111) $visited++;
			if($row7['type']==2222) $contact++;
			//$order++;
		}
		
		$sql7='select * from '.DB_TABLE_PREFIX.'report;';
		$rs7 = mysql_query($sql7);
		while($row7 = mysql_fetch_assoc($rs7))
		{
			if($row7['type']==1111) $visitedc++;
			//$order++;
			if($row7['type']==2222) $contactc++;
		}
	?>
<table width="70%"  border="0"  cellpadding="1" cellspacing="8" align="lelf">
  <tr>
    <td colspan="2" bgcolor="#CCCCCC" align="center"><strong>Thống Kê Hệ Thống</strong></td>
  </tr>
    <tr>
    <td colspan="2"><a href="http://www.google.com/analytics/" target="">Google Analytics</a></td>
  </tr>
      <tr>
    <td colspan="2"><fieldset>
    <legend style="font-weight:bold">Quản Trị</legend>
<?php
	$sql222='select * from '.DB_TABLE_PREFIX.'user where Ctrl=33';
	$rs222 = mysql_query($sql222);
	while($row2=mysql_fetch_assoc($rs222)){
	echo '<b>- '.$row2['Email'].'</b>: <span style="color:#FF3333">'.$row2['Visited'].'</span> lần';
	echo '<br>';
	}

	?>
    </fieldset>
	  </td>
  </tr>
  <tr>

    <td><fieldset><legend style="font-weight:bold">Khách Hàng</legend>
	Số lần ghé thăm/tháng: &nbsp;<span style="color:#FF3333"><?php echo $visited;?></span> &nbsp;lần
    <br />
    Tổng số lần ghé thăm : &nbsp;<span style="color:#FF3333"><?php echo $visitedc;?></span>&nbsp;lần
	</fieldset>
	</td>
  </tr>
  <tr>
    <td width="50%" valign="top" colspan="2"><fieldset>
   <legend style="font-weight:bold"> Sản phẩm/Nội dung </legend>
   <?php 

   ?> 
   
    +) Tổng số sản phẩm: <span style="color:#FF3333">	
	<?php 
	
echo $product.'/'.$productc.'</span> sản phẩm<br />';
 ?>
	+) Tổng số tin : <span style="color:#FF3333">
	<?php 
	
echo $news.'/'.$newsc.'</span> tin<br />';
 ?>
    </fieldset></td> 
   <tr>
  <td width="50%" colspan="2" valign="top"><fieldset><legend style="font-weight:bold">Liên hệ & đặt hàng </legend>
	+) Tổng số email liên hệ và đặt hàng: &nbsp;<span style="color:#FF3333"><?php echo $contact.'/'.$contactc;?></span><br /> 
	<!-- ) Tổng số email order &nbsp;&nbsp;: &nbsp; -->
	<?php //echo $order;
	?>
  </fieldset>
  
	</td>
  </tr>
  <tr><td colspan="1" align="right">
  <?php
	echo ' <form method="post"><select name="month">';
	echo '<option>'.strftime("%m").'</option>';
		echo '<option>01</option>';
		echo '<option>02</option>';
		echo '<option>03</option>';
		echo '<option>04</option>';
		echo '<option>05</option>';
		echo '<option>06</option>';
		echo '<option>07</option>';
		echo '<option>08</option>';
		echo '<option>09</option>';
		echo '<option>10</option>';
		echo '<option>11</option>';
		echo '<option>12</option>';

	echo '<select name="year">';
	echo '<option>'.strftime("%Y").'</option>';
	for($i=2000;$i<(strftime("%Y"));$i++)
		{
			echo '<option>'.$i.'</option>';
		}

	echo '</select><input type="submit" value="Chọn"></form>';
?>
  </td></tr>

</table>

</body>
</html>