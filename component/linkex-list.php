<?php
$CBid= @(int)$_GET['CBid'];
$o_cat=catlinkexchangeopen($CBid); 
$BNpage= @(int)$_GET['BNpage'];
if($CBid!=null){
	$page=1;$pagecount=0;
	if(!empty($_GET['BNpage']))$page=(int)$_GET['BNpage'];
	if(!empty($_GET['page']))$page=(int)$_GET['page'];	
	$rs=linkexchangepagelist($CBid,null,null,null,$page,$pagecount,LINKEX_PAGESIZE);
	?>
	<div class="title_country_ser_">
		<h3><?php echo $o_cat->name ;?></h3>
	</div>
	<div class="tour_detail_background link-exchange">
		<div class="tour_detail_content">
			<div class="tour_detail_corner1"><span/></div>
			<div class="tour_detail_corner2"><span/></div>
			<div class="tour_detail_corner3"><span/></div>
		<?php
			if($row=mysql_fetch_object($rs)){
				echo '<div class="link_exchange_list">';
				echo '<ul class="no_tag">';
				do{
					echo '<li class="hottour_li">';
					echo '<div class="title_linkexchange"><a href="'.$row->url.'" target="_blank">'.$row->title.'</a></div>';
					if($row->desc) echo '<div class="desc_linkexchange">'.$row->desc.'</div>';
					echo '</li';
				}while($row=mysql_fetch_object($rs));
				echo '</ul></div>';
			}
			mysql_free_result($rs);
			if($pagecount>1) paginglx($page,LINKEX_PAGESIZE,$pagecount);
			echo '<div class="sh_bound_all_pd" style="padding-top:2px;"></div>';
		?>
	</div>
	</div>
	<?php
}
?>