<?php 
$item = productread(@$PDid);
$cat = catproductread(@$CPid, $item->id);
echo '
<Div class="patch_all">
	<A class="patch_link" href="'.urlBuild('index.php').'">'.@T_HOME.'</A>>
	<A class="patch_link" href="'.urlBuild('service.php').'">'.@T_SERVICE.'</A>>
	<A class="patch_link" href="'.urlBuild('service-list.php',array('url'=>$cat->urlrewrite)).'">'.@$cat->name.'</A>>
	<span class="patch_active">'.$item->name.'</span>
</Div>';
?>
<div class="breadcrumbs clearfix">
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a  href="<?php echo URL_BASE ?>" itemprop="url">
            <span itemprop="title"><?php echo @T_HOME ?></span>
        </a>
    </div>
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a  href="<?php echo urlBuild('service') ?>" itemprop="url">
            <span itemprop="title"><?php echo @T_SERVICE ?></span>
        </a>
    </div>
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a href="<?php echo urlBuild('service-list.php',array('url'=>$cat->urlrewrite))?>" itemprop="url">
        <span itemprop="title"><?php echo $cat->name ?></span>
        </a>
    </div>
</div>
<div class="box-title">
    <div class="box-outer-2 box-right">
			<h2 class="h2_category"><?php echo $item->name ?></h2>
			<Div class="ct_tour_list_page_">
						<Div class="top_tour_dt">
							<div class="left_ser_dt">
								<?php if($item->img1) htmlview(URL_PRODUCT_IMG1,$item->img1);?>
							</div>
							<Div class="right_ser_dt">
								<Div class="summart_ser">
									<?php echo @$item->summary ?>
								</Div>
								<table class="opition_tour" width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td width="29%">
										<a class="book_tour_top" href="<?php echo urlBuild('service-book.php',array('CPname'=>$cat->urlrewrite,'url'=>$item->urlrewrite))?>"><?php echo @T_SERVICE_BOOK ?></a>
									</td>
									<td width="29%">
										<A class="send_friend" href="<?php echo urlBuild('send-email.php',array('name'=>$item->name,'link'=>curPageURL()))?>" onclick="return(openCenteredWindow3(this))" id="ctl27_ctl01_sendto" ><?php echo @T_SEND_FRIEND ?></A>
									</td>	
									<td width="42%"><a class="print_tour" onclick="return(openCenteredWindow2(this))" id="ctl27_ctl01_print" href="<?php echo urlBuild('service-print.php',array('CPname'=>$cat->urlrewrite,'url'=>$item->urlrewrite))?>"><?php echo @T_PRIN ?></a></td>
								  </tr>
								</table>
							</Div>
							<Div class="clear_left"></Div>
						</Div>
						<Div class="data_service">
							<?php echo @$item->detail ?>
							<Div class="bot_tour_all">
									<input class="book_ser_bot" onclick="parent.location='<?php echo urlBuild('service-book.php',array('CPname'=>$cat->urlrewrite,'url'=>$item->urlrewrite))?>'" value="" type="submit" />
								<Div class="clear_left"></Div>
							</Div>
						</Div>
					</Div>
    </div>
</Div>

<Div class="other_tour_all">
		<h2 class="h3_similar"><?php echo @T_SERVICE_SIMILAR ?></span></h2>
	<?php 
	$rs = productlist($cat->id,@N_TOUR_SIMILAR,PRODUCT_CTRL_SHOW,(int)$item->id,PRODUCT_TYPE_SERVICE); 
	while ($row = mysql_fetch_object($rs)){
		$href = urlBuild('service-detail.php',array('CPname'=>$cat->urlrewrite,'url'=>$row->urlrewrite));
	?>
	<div class="item_other_tour">
		<div class="left_item_other">
			<?php 
				echo '<a href="'.$href.'">';
				htmlview(URL_PRODUCT_IMG1,$row->img1);
				echo '</a>';
			?>
		</div>
		<Div class="right_item_other">
			<h4>
				<a href="<?php echo $href ?>">
					<?php 
						echo $row->name
					?>
				</a>
				<?php //201208 if($row->price) echo '<Span>$'.$row->price.'</Span>'?>
			</h4>
		</Div>
		<div class="clear_left"></div>
	</div>
	<?php } ?>
</Div>