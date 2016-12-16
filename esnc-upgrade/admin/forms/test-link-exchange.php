<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<?php
require_once('../../config.php');
require_once('../inc/common.php');
require_once('../inc/session.php');
require_once(PATH_INC.'dbconguest.php');
require_once(PATH_COMPLS.'bannerlist.php');
function checker($mybanner){
		if (strpos($mybanner, 'http://')===false){
			return false;
		}
		$go = $_SERVER['HTTP_HOST'];
		$homepage = file_get_contents($mybanner);
		$pos = strpos($homepage,$go);
		if ($pos === false) { return false;} else return true;
	}

$i=0;
	$file= PATH_APPLICATION.'test_link.txt';
	$file1= PATH_APPLICATION.'test_link1.txt';
	$file2= PATH_APPLICATION.'test_link2.txt';
	
	
if (!isset($_GET['kq'])) 
{
	if (isset($_GET['i'])) 
	{
		$i = $_GET['i'];
		if($i==0)
		{
			$cont=fopen($file1,'w');
			//fwrite($cont,'0');
			fclose($cont);
			$cont=fopen($file2,'w');
			//fwrite($cont,'0');
			fclose($cont);
		}

		$value=file_get_contents($file);	
		$arrayid = explode(',',$value);
		$BNid =$arrayid[$i];
		$i2=$i+1;
		if($i < count($arrayid)) {
			echo '<META HTTP-EQUIV="refresh" CONTENT="22;url=test-link-exchange.php?i='.$i2.'">';
			echo '<table width="100%" height="100%"><tr><td><table align="center" bgcolor="#FF66CC"><tr><td>Dang test link thu &nbsp;'.$i2.'! Please wait...</td></tr></table></td></tr></table>';
			
			$rs = bannerlist(BANNER_CTRL_SHOW|BANNER_CTRL_LINK,(int)$BNid);
			$row=mysql_fetch_assoc($rs);
				$mybanner= $row['mybanner'];
				set_time_limit(20);
				if(checker($mybanner))
				{
					$incr=file_get_contents($file1);
					if($incr!=0) 
					{
						
						$incr= $incr.','.$BNid;
					}else
					{
						$incr=$BNid;
					}
					$cont=fopen($file1,'w');
					fwrite($cont,$incr);
					fclose($cont);
				} else
				{
					$incr=file_get_contents($file2);
					if($incr!=0) 
					{
						
						$incr= $incr.','.$BNid;
					}else
					{
						$incr=$BNid;
					}
					$cont=fopen($file2,'w');
					fwrite($cont,$incr);
					fclose($cont);
				}
			$i++;		
			header("Location: test-link-exchange.php?i={$i}");
			} else 
			{
				echo '<table  bgcolor="#FFCCFF" width ="100%" height ="100%"><tr><td><h3>Đã kiểm tra xong!</h3>';
				echo '<a href="test-link-exchange.php?kq=45">Nhấn vào đây để xem kết quả</a></td></tr></table>';
			}
	} 
	else 
		{
			$arrayBNid ='';
			if(isset($_GET['CBid'])) {
				$CBid = $_GET['CBid'];
				$rs = bannerlist(BANNER_CTRL_SHOW|BANNER_CTRL_LINK,(int)$CBid);
			}
			if(isset($_GET['CBid2'])) $rs = bannerlist(BANNER_CTRL_SHOW|BANNER_CTRL_LINK,NULL);

			//echo $CBid;
			while($row=mysql_fetch_assoc($rs)) 
			{
				if($arrayBNid=='') { $arrayBNid= $row['id']; } else { $arrayBNid= $arrayBNid.','.$row['id']; }
			}
			$cont=fopen($file,'w');
			fwrite($cont,$arrayBNid);
			fclose($cont);
			$i=0;
			echo '<table width="100%" height="100%"><tr><td><table align="center" bgcolor="#FF66CC" hspace="66"><tr><td>Đang kiểm tra! Xin hãy đợi...</td></tr></table></td></tr></table>';
			echo '<META HTTP-EQUIV="refresh" CONTENT="1;url=test-link-exchange.php?i='.$i.'&CBid='.$CBid.'">';
			
		}

} else
	{
				$tong=0;
				echo '<table  bgcolor="#FFCCFF" width ="100%" height ="100%"><tr><td><h3>Đã kiểm tra xong!</h3>';
								$incr3=file_get_contents($file);
				$t3 = explode(',',$incr3);
				$tong = count($t3); if(trim($incr3)=='') $tong=0;
				$incr=file_get_contents($file1);
				$t1 = explode(',',$incr);
				$ts1 = count($t1); if(trim($incr)=='') $ts1=0;
				$incr2=file_get_contents($file2);
				$t2 = explode(',',$incr2); 
				$ts2 = count($t2); if(trim($incr2)=='') $ts2=0;
				
				
				echo '<ul><li>Tổng số links đã kiểm tra: '.$tong.'</li>
				<li><a href ="item-list-banner2.php?dk=1">Tổng số links có link-back: &nbsp;</a>'.$ts1.'</li>
				<li><a href ="item-list-banner2.php?dk=2">Tổng số links chưa có link-back:&nbsp;</a>'.$ts2.'</li>
				</ul><br>';
				//$sql= 'select * from '.DB_TABLE_PREFIX.'banner where ID = 3';
				//$rs = mysql_query($sql);
				//while($row = mysql_fetch_assoc($rs))
				//{
					//echo $row['Name'];
					//echo '<br>';
				//}
				echo '</td></tr></table>';

	}
?>
