<style>
	div.desc_linkexchange{
	text-align:justify;
	color:#000}
	div.desc_linkexchange a{color:#000}
}
</style>
<?php 
$rs = mysql_select('`a`.`name`','`#catbanner` as `a`','`a`.`id`='.$CBid);
$row = mysql_fetch_row($rs);
$CBname=$row[0];
mysql_free_result($rs); 
if(!empty($_GET['BNpage']))$page=(int)$_GET['BNpage'];
if(!empty($_GET['page']))$page=(int)$_GET['page'];
$rs=bannerpagelist($page,$pagecount,BANNER_PAGESIZE_LINKEXCHANGE,$CBid,0);
?>
<Div class="box_hottour_all">
	<Div class="title_about_">
		<Div class="left_title_tour_">
			<Div class="right_title_tour_">
				<Div class="middle_title_tour_">
					<span></span>
				</Div>
			</Div>
		</Div>
	</Div>
	<div class="left_x_useful">
		<Div class="right_x_useful">
			<div class="ct_tourpage_">
				<div class="padding_hottour">
				<div class="title_country_ser_">
					<h3><?php echo $row[0];?></h3>
				</div>
				<?php 
					echo '<div class="tour_detail_background link-exchange">
					    	<div class="tour_detail_content">
					        	<div class="tour_detail_corner1"><span/></div>
					            <div class="tour_detail_corner2"><span/></div>
					            <div class="tour_detail_corner3"><span/></div>';
					if($item=mysql_fetch_object($rs)){
						echo '<div class="link_exchange_list">';
						echo '<ul>';
						do{
							if(($item->ctrl & BANNER_CTRL_SHOW) && ($item->status != 5)){
								$item->target='_blank';
								echo '<li class="hottour_li">';
								if($item->url) bannershow($item);
								if($item->desc) echo '<div class="desc_linkexchange">'.$item->desc.'</div>';
								echo '</li>';
							}
						}while($item=mysql_fetch_object($rs));
						echo '</ul>';
						echo '</div>';
					}
					//if($pagecount>1) paginglx($page,1,$pagecount);
					echo '<div class="form-link-formadd">';
					include PATH_COMPONENT.'link-formadd.php';
					echo '</div></div></div>';
				?>
				</div>
			</div>
		</div>
	</div>
	<div class="end_about_">
		<Div class="left_end_hottour">
			<Div class="right_end_hottour">
				<Div class="middle_end_hottour"><span></span>
				</Div>
			</Div>
		</Div>
	</div>
</div>
