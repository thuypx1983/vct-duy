<?php 
	$item = productread(@$PDid);
	$cat = catproductread(@$CPid,$item->id);
	$parentcat = catproductread(@$cat->parentid);
	$arr = array();
	$photo = productphotolist($item->id,100);
	while ($temp = mysql_fetch_object($photo)) $arr[] = $temp;
	echo '
	<Div class="patch_all">
		<A class="patch_link" href="'.urlBuild('index.php').'">'.@T_HOME.'</A>>
		<A class="patch_link" href="'.urlBuild('hotel.php').'#'.$parentcat->id.'">'.@$parentcat->name.'</A>>
		<A class="patch_link" href="'.urlBuild('hotel-list.php',array('url'=>$cat->urlrewrite)).'">'.@$cat->name.'</A>>
		<span class="patch_active">'.$item->name.'</span>
	</Div>';
?>
<Div class="box_hottour_all" style="padding-left: 0;padding-right: 0;padding-bottom:0px">
				<div class="padding_hottour">
					<Div class="title_tour_dt">
						<h2>
							<?php 
								echo $item->name.' ';
								if(@$item->manufacturer) htmlview(URL_IMAGES,$item->manufacturer.'_star_white_.gif','align="absmiddle"');
							?>
						</h2>
					</Div>
					<Div class="ct_tour_list_page_">
						<Div>
                            <div class="row">
							<div class="col-md-4 col-sm-4 col-xs-12">
								<?php 
									if($item->img2) htmlview(URL_PRODUCT_IMG2,$item->img2,'class="img_hotel_detail" title="'.$item->name.'"');
									else if($item->img1) htmlview(URL_PRODUCT_IMG1,$item->img1,'class="img_hotel_detail" title="'.$item->name.'"');
								?>
							</div>
							<Div class="col-md-8 col-sm-8 col-xs-12">
								<div class="row">
                                    <div class="col-md-5 col-sm-4 col-xs-12" style="padding-bottom: 10px;padding-right: 0">
										<a class="book_tour_top" href="<?php echo urlBuild('hotel-book.php',array('CPname'=>$cat->urlrewrite,'url'=>$item->urlrewrite))?>"><?php echo @T_HOTEL_BOOK ?></a>
									</div>
                                    <div class="col-md-4 col-sm-4 col-xs-12" style="padding-bottom: 10px;padding-right: 0">
										<A class="send_friend" href="<?php echo urlBuild('send-email.php',array('name'=>$item->name,'link'=>curPageURL()))?>" onclick="return(openCenteredWindow3(this))" id="ctl27_ctl01_sendto" ><?php echo @T_SEND_FRIEND ?></A>
									</div>
                                    <div class="col-md-3 col-sm-4 col-xs-12" style="padding-bottom: 10px">
                                        <a class="print_tour" onclick="return(openCenteredWindow2(this))" id="ctl27_ctl01_print" href="<?php echo urlBuild('hotel-print.php',array('CPname'=>$cat->urlrewrite,'url'=>$item->urlrewrite))?>"><?php echo @T_PRIN ?></a>
                                    </div>
                                </div>
									<?php 
									if($arr){
										echo'
										<div class="highslide-gallery">
											<a id="thumb2" href="'.URL_MYIMAGES.$arr[0]->img.'" onclick="return hs.expand(this)" class="highslide gallery_tour">
												'.@T_GALLERY_PRODUCT.'
											</a>
											<div class="highslide-caption">
												'.@$arr[0]->name.'
											</div>
										</div>';
									}
									?>
								<?php 
								if($arr)
								{ 	echo '<div class="hidden-container">';
									for($i=1;$i<count($arr);$i++){
									echo '
										<a href="'.URL_MYIMAGES.$arr[$i]->img.'" class="index_photo" onclick="return hs.expand(this,{thumbnailId:\'thumb2\'})"></a>
										<div class="highslide-caption">
											'.@$arr[$i]->name.'
										</div>';
									}
									echo '</div>';
								} 
								?>
								<table class="infor_tour" width="100%" border="0" cellspacing="0" cellpadding="2">
								  <?php /*201208 <tr>
									<td width="66"><?php echo @T_FROM_PRICE ?></td>
									<td width="487" class="price_tour__">: From&nbsp;$<?php echo $item->price; if(@$item->warranty) echo ' to $'.$item->warranty ?></td>
								  </tr> 201208*/?>
								  <?php 
									if(@$item->unit)
										 echo '
										  <tr>
											<td>'.@T_ADDRESS.'</td>
											<td>: '.$item->unit.'</td>
										  </tr>';
									if(@$item->model)
										 echo '
										  <tr>
											<td>'.@T_CITY.'</td>
											<td>: '.$item->model.'</td>
										  </tr>';
									if(@$item->country)
										 echo '
										  <tr>
											<td>'.@T_COUNTRY.'</td>
											<td>: '.$item->country.'</td>
										  </tr>';
								  ?>
								</table>
							</Div>
                            </div>
							<Div class="summart_tour">
								<?php echo $item->summary ?>
							</Div>
						</Div>
						<Div class="data_tour">
							<h4>
							<?php echo @T_HOTEL_DETAIL ?>
							</h4><br />
							<?php echo $item->detail ?>
							<Div class="bot_tour_all" style="margin-top: 20px">
									<input class="book_tour_bot" onclick="parent.location='<?php echo urlBuild('hotel-book.php',array('CPname'=>$cat->urlrewrite,'url'=>$item->urlrewrite))?>'" value="" type="submit" />
								<Div class="clear_left"></Div>
							</Div>
						</Div>
					</Div>
				</div>
</Div>
<Div class="other_tour_all">
	<div class="title_other_tour_">
		<h2><?php echo @T_HOTEL_SIMILAR ?></span></h2>
	</div>
    <div class="row">
	<?php 
	$rs = productlist($cat->id,@N_TOUR_SIMILAR,PRODUCT_CTRL_SHOW,(int)$item->id,PRODUCT_TYPE_HOTEL); 
	while ($row = mysql_fetch_object($rs)){
		$href = urlBuild('hotel-detail.php',array('CPname'=>$cat->urlrewrite,'url'=>$row->urlrewrite));
	?>
        <div class="col-md-6 col-sm-6 col-xs-12 item_other_tour">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
			<?php 
				echo '<a href="'.$href.'" rel="nofollow">';
				htmlview(URL_PRODUCT_IMG1,$row->img1,'title="'.$row->name.'"');
				echo '</a>';
			?>
		    </div>
            <div class="col-md-8 col-sm-8 col-xs-8">
			<h4>
				<a href="<?php echo $href ?>" class="a_tour_similar">
					<?php 
						if(@$row->manufacturer) htmlview(URL_IMAGES,$row->manufacturer.'_star_white_.gif','class="img_star_2"');
						echo $row->name.' ';
					?>
				</a>
			</h4>
                </div>
		</Div>
	</div>
	<?php } ?>
    </div>
</Div>