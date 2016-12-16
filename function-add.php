<?php 
	function getfooter($page=null){
		global $sql;
		$sql = 'SELECT `a`.`id`,`a`.`url`,`a`.`text` FROM `'.DB_TABLE_PREFIX.'footer'.'` AS `a` '; 
		$sql .= $page?' WHERE `url` = "'.$page.'" ':''; 
		$o = mysql_query($sql); 
		return $o;
	}
	function edittext($time){
		$date= explode(',',$time);
		$str =  '';
		for($i= 0; $i< count($date); $i++){
		   if($date[$i]!='')
				$str .= $date[$i].'<br/>';
		}	
		
		return $str;
	}
	function curPageURL() {
		 $pageURL = 'http';
		 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}
	function _getdetail($a){
	    $r= '';
	    foreach($a as $k=> $v){
	        $r.= $v.', ';
	    }
	   $r= substr($r, 0, -2);
	   return $r;
    }
	function getdistinctfield($fi, $ta, $ty){
	    $sql= 'SELECT DISTINCT `'.$fi.'` FROM `'.DB_TABLE_PREFIX.$ta.'` WHERE `type`='.$ty.' AND `ctrl`&1= 1';
	    return mysql_query($sql);
	}
	function searchhotel($type=null, $group= null, $country= null, $keyword= null){
	   	$sql= 'SELECT `a`.`urlrewrite`,`a`.`country`,`a`.`name`,`a`.`summary`,`a`.`id`,`a`.`img1`,`a`.`alt1`,`a`.`unit`, `a`.`model`, `a`.`manufacturer`, `a`.`keyword` FROM `'.DB_TABLE_PREFIX.'product` AS `a`';
		if($country)
			$sql.= ' INNER JOIN `'.DB_TABLE_PREFIX.'catproductproduct` AS `b` ON `a`.`id`=`b`.`productid` WHERE `b`.`catproductid` IN (SELECT `c`.`id` FROM `'.DB_TABLE_PREFIX.'catproduct` AS `c` WHERE `c`.`parentid`='.$country.')';
		if($group)
			$sql.= ' INNER JOIN `'.DB_TABLE_PREFIX.'catproductproduct` AS `b` ON `a`.`id`=`b`.`productid` WHERE `b`.`catproductid` ='.$group;
		if(!$group&&!$country)
			$sql .=' WHERE `a`.`type`='.$type.' AND `a`.`ctrl`&'.PRODUCT_CTRL_SHOW;
		else $sql .=' AND `a`.`type`='.$type.' AND `a`.`ctrl`&'.PRODUCT_CTRL_SHOW;
	    
	    $sql.= $keyword?' AND (`a`.`name` LIKE \'%'.$keyword.'%\' OR `a`.`keyword` LIKE \'%'.$keyword.'%\' OR `a`.`include` LIKE \'%'.$keyword.'%\' OR `a`.`model` LIKE \'%'.$keyword.'%\' 
	    OR `a`.`country` LIKE \'%'.$keyword.'%\' OR `a`.`summary` LIKE \'%'.$keyword.'%\'  )':'';
	    return mysql_query($sql);
	}
	function searchtour($type=null, $group= null, $country= null, $keyword= null){
	   	$sql= 'SELECT `a`.`urlrewrite`,`a`.`include`,`a`.`name`,`a`.`summary`,`a`.`id`,`a`.`img1`,`a`.`alt1`,`a`.`unit`, `a`.`model`, `a`.`country`, `a`.`keyword` FROM `'.DB_TABLE_PREFIX.'product` AS `a`';
		if($country)
			$sql.= ' INNER JOIN `'.DB_TABLE_PREFIX.'catproductproduct` AS `b` ON `a`.`id`=`b`.`productid` WHERE `b`.`catproductid` IN (SELECT `c`.`id` FROM `'.DB_TABLE_PREFIX.'catproduct` AS `c` WHERE `c`.`parentid`='.$country.')';
		if($group)
			$sql.= ' INNER JOIN `'.DB_TABLE_PREFIX.'catproductproduct` AS `b` ON `a`.`id`=`b`.`productid` WHERE `b`.`catproductid` ='.$group;
		if(!$group&&!$country)
			$sql .=' WHERE `a`.`type`='.$type.' AND `a`.`ctrl`&'.PRODUCT_CTRL_SHOW;
		else $sql .=' AND `a`.`type`='.$type.' AND `a`.`ctrl`&'.PRODUCT_CTRL_SHOW;
	    $sql.= $keyword?' AND (`a`.`name` LIKE \'%'.$keyword.'%\' OR `a`.`keyword` LIKE \'%'.$keyword.'%\' OR `a`.`include` LIKE \'%'.$keyword.'%\' OR `a`.`model` LIKE \'%'.$keyword.'%\' 
	    OR `a`.`country` LIKE \'%'.$keyword.'%\' OR `a`.`summary` LIKE \'%'.$keyword.'%\'  )':'';
	    return mysql_query($sql);
	}
	function paging($all,$page,$pagename,$catid,$catname){ 
		if($all==0) $page=0;
		$total = ($all%N_PRODUCT_PER_PAGE==0)?($all/N_PRODUCT_PER_PAGE):(ceil($all/N_PRODUCT_PER_PAGE));
	    $count= 0;
	    $str = '';
		if($page>1){
			$str .= '<a class="page_list_unselect_first"  href="'.urlBuild($pagename,array('url'=>$catname,'page'=>$page-1)).'">'.@T_PREVIOUS.'</a>';
		}
		//else 
			//echo '<a href="'.urlBuild('tour-list.php',array('CPid'=>$cat->id,'CPname'=>$cat->name,'page'=>1)).'" clas="page_list">'.$page.'</a>';	 
		if($total<=N_PAGE_PER_SEGMENT){
			for($i=1;$i<=$total;$i++){
				if($page==$i)
					$str .= '<a class="page_list_select">'.$i.'</a>';
				else 
					$str .= '<a class="page_list_unselect" href="'.urlBuild($pagename,array('url'=>$catname,'page'=>$i)).'">'.$i.'</a>';
			} 
		}else{
			if($page<= N_PAGE_PER_SEGMENT){
				$temp = (N_PAGE_PER_SEGMENT+ $page)<$total?(N_PAGE_PER_SEGMENT+ $page):$total; 
		        for($i= 1; $i<= $temp; $i++){
		            if($page== $i)
		                $str .= '<a class="page_list_select">'.$i.'</a>';
		            else
		                $str .= '<a  class="page_list_unselect" href="'.urlbuild($pagename, array('url'=> $catname, 'page'=> $i)).'">'.$i.'</a>';
		     	}
			}
	       else if($page> N_PAGE_PER_SEGMENT&& $page< $total- N_PAGE_PER_SEGMENT){
		        for($i= $page- N_PAGE_PER_SEGMENT; $i<= $page+ N_PAGE_PER_SEGMENT; $i++){ 
		            if($page== $i)
		                $str .= '<a class="page_list_select">'.$i.'</a>';
		            else
		                $str .= '<a class="page_list_unselect" href="'.urlbuild($pagename, array('url'=> $catname, 'page'=> $i)).'" title="'.$i.'">'.$i.'</a>';
		        }
	        }
	      else if($page>= $total- N_PAGE_PER_SEGMENT)
		        for($i= $page- N_PAGE_PER_SEGMENT; $i<= $total; $i++){ 
		            if($page== $i)
		                $str .= '<a class="page_list_select">'.$i.'</a>';
		            else{
		                $str .= '<a class="page_list_unselect" href="'.urlbuild($pagename, array('url'=> $catname, 'page'=> $i)).'">'.$i.'</a>';}
		        }
	       }
		
		if($page<$total){
			$str .= '<a class="page_list_next" href="'.urlBuild($pagename,array('url'=>$catname,'page'=>$page+1)).'">'.@T_NEXT.'</a>';
		}
		return $str;
	}
	// for news
	function paging2($all,$page,$pagename,$catid,$catname){ 
		if($all==0) $page=0;
		$total = ($all%N_PRODUCT_PER_PAGE==0)?($all/N_PRODUCT_PER_PAGE):(ceil($all/N_PRODUCT_PER_PAGE));
	    $count= 0;
	    $str = '';
		if($page>1){
			$str .= '<a class="page_list_unselect_first"  href="'.urlBuild($pagename,array('url'=>$catname,'page'=>$page-1)).'">'.@T_PREVIOUS.'</a>';
		}
		//else 
			//echo '<a href="'.urlBuild('tour-list.php',array('CNid'=>$cat->id,'CNname'=>$cat->name,'page'=>1)).'" clas="page_list">'.$page.'</a>';	 
		if($total<=N_PAGE_PER_SEGMENT){
			for($i=1;$i<=$total;$i++){
				if($page==$i)
					$str .= '<a class="page_list_select">'.$i.'</a>';
				else 
					$str .= '<a class="page_list_unselect" href="'.urlBuild($pagename,array('url'=>$catname,'page'=>$i)).'">'.$i.'</a>';
			} 
		}else{
			if($page<= N_PAGE_PER_SEGMENT){
				$temp = (N_PAGE_PER_SEGMENT+ $page)<$total?(N_PAGE_PER_SEGMENT+ $page):$total; 
		        for($i= 1; $i<= $temp; $i++){
		            if($page== $i)
		                $str .= '<a class="page_list_select">'.$i.'</a>';
		            else
		                $str .= '<a  class="page_list_unselect" href="'.urlbuild($pagename, array('url'=> $catname, 'page'=> $i)).'">'.$i.'</a>';
		     	}
			}
	       else if($page> N_PAGE_PER_SEGMENT&& $page< $total- N_PAGE_PER_SEGMENT){
		        for($i= $page- N_PAGE_PER_SEGMENT; $i<= $page+ N_PAGE_PER_SEGMENT; $i++){ 
		            if($page== $i)
		                $str .= '<a class="page_list_select">'.$i.'</a>';
		            else
		                $str .= '<a class="page_list_unselect" href="'.urlbuild($pagename, array('url'=> $catname, 'page'=> $i)).'" title="'.$i.'">'.$i.'</a>';
		        }
	        }
	      else if($page>= $total- N_PAGE_PER_SEGMENT)
		        for($i= $page- N_PAGE_PER_SEGMENT; $i<= $total; $i++){ 
		            if($page== $i)
		                $str .= '<a class="page_list_select">'.$i.'</a>';
		            else{
		                $str .= '<a class="page_list_unselect" href="'.urlbuild($pagename, array('url'=> $catname, 'page'=> $i)).'">'.$i.'</a>';}
		        }
	       }
		
		if($page<$total){
			$str .= '<a class="page_list_next" href="'.urlBuild($pagename,array('url'=>$catname,'page'=>$page+1)).'">'.@T_NEXT.'</a>';
		}
		return $str;
	}
	// for link exchange
	function paginglx($page,$pagesize, $pagecount,$class='paging',$t=FALSE){
		require_once(PATH_INC.'commonguest.php');
		$paging = "";	
		if ($pagecount>1){
			if (@$page>1) {
					$url = urlset(URL_SELF,array('page'=>($page-1),'pagesize'=>@$pagesize));
					$paging = '<a href="'.$url.'" class="page_list_unselect_first">&nbsp;'.@T_PREVIOUS.'&nbsp;&nbsp;</a>';					
			}
			if ($pagecount > N_PAGE_PER_SEGMENT) {
				$startpage = $page;
				$size = N_PAGE_PER_SEGMENT;
				//$debug->save('paging_size1='.$size);
				if ($page>1) $size = $size + ($page-1);//$debug->save('paging_size2='.$size); echo '';
				if ($size > $pagecount) $size = $pagecount; 
			}
			else {
				$startpage = 1;
				$size = $pagecount;//$debug->save('paging_size3='.$size);			
			}		
			//$debug->save('size='.$size);
			for($p = $startpage;$p<=$size;$p++){
				$pagenum = ($p==$page||(($p==1))&&empty($page))?'<strong class="'.$class.'_active">[&nbsp;'.$p.'&nbsp;]</strong>':$p;
				$href  = urlset(URL_SELF,array('page'=>$p ,'pagesize'=>$pagesize));					
				$paging .= '<a href="'.$href.'" class="about_item_1"">&nbsp;'.$pagenum.'</a>';							
			}
			if ($page<$pagecount) {
					$url = urlset(URL_SELF,array('page'=>($page+1),'pagesize'=>$pagesize));
					$paging .= '<a href="'.$url.'" class="page_list_next">&nbsp;&nbsp;'.@T_NEXT.'</a>';				
			}		
		}
		if (!$t) {	
			echo '<div class="paging" style="text-align:center;padding:20px 0px;font-weight:bold">'.$paging.'&nbsp;</div>';
			return;
		}
		return '<div style="float:center;">&nbsp;'.$paging.'</div>'; 
	}
	
?>