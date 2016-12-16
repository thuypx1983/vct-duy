<?php
// Them bang gia
$tb=DB_TABLE_PREFIX;
//global $tb;
function add_price_name($name,$pdid,$type,$startdate,$enddate,$status,$summary='')
{
	global $tb;
	$sql = "INSERT INTO {$tb}nameprice(name,pdid,type,startdate,enddate,status,summary) VALUES ('$name','$pdid','$type','$startdate','$enddate','$status','$summary');";
	mysql_query($sql);
return true;
}

//them cot gia

function add_col_price($name='',$min,$max,$pdid)
{
	global $tb;
	$sql = "INSERT INTO {$tb}colprice(name,min,max,pdid) VALUES ('$name','$min','$max','$pdid');";
	mysql_query($sql);
	return true;
}

//them hang gia

function add_row_price($name='',$pdid)
{
	global $tb;
	$sql = "INSERT INTO {$tb}rowprice(name,pdid) VALUES ('$name','$pdid');";
	mysql_query($sql);
	return true;
}

// Nhap gia
function add_price($nameid,$price,$rowid,$colid)
{
	global $tb;
	$sql = "INSERT INTO {$tb}pricedetail(nameid,price,rowid,colid) VALUES ('$nameid','$price','$rowid','$colid');";
	mysql_query($sql);
	return true;
}


// Xoa bang gia
function remove_price_name($id)
{
	global $tb;
	$sql = "DELETE FROM {$tb}nameprice where id={$id};";
	mysql_query($sql);
	return true;
}

//Xoa cot gia

function remove_col_price($id)
{
	global $tb;
	$sql = "DELETE FROM {$tb}colprice where id={$id};";
	mysql_query($sql);
	return true;
}

//Xoa hang gia
function remove_row_price($id)
{
	global $tb;
	$sql = "DELETE FROM {$tb}rowprice where id={$id};";
	mysql_query($sql);
	return true;
}

// Xoa  gia
function remove_price($nameid)
{
	global $tb;
	$sql = "DELETE FROM {$tb}pricedetail where nameid={$nameid};";
	mysql_query($sql);
	return true;
}


/// phan update

function update_price_name($id,$name,$startdate,$enddate,$summary,$status,$lastupdate,$extra=0)
{
	global $tb;
	$sql = "UPDATE {$tb}nameprice SET name='$name', startdate='$startdate', enddate='$enddate', summary='$summary',status='$status',lastupdate='$lastupdate', extra='$extra' where id={$id};";
	mysql_query($sql);
	return true;
}

//

function update_col_price($id,$name,$min,$max)
{
	global $tb;
	$sql = "UPDATE {$tb}colprice SET name='$name', min='$min',max='$max' where id={$id};";
	mysql_query($sql);
	return true;
}

//

function update_row_price($id,$name)
{
	global $tb;
	$sql = "UPDATE {$tb}rowprice SET name='$name' where id={$id};";
	mysql_query($sql);
	return true;
}

// 
function update_price($id,$price, $extra=0)
{
	global $tb;
	$sql = "UPDATE {$tb}pricedetail SET price='$price', extra='$extra' where id={$id};";
	mysql_query($sql);
	return true;
}
///////////////////////////////////////////////////////////////


?>
