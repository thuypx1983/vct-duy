<Div class="box_hottour_all"  style="padding: 0">
    <div class="hotel_bar clearfix">
        <div class="col-md-5 col-sm-5 col-xs-12">
        <h4 class="h2_title"><?php echo @T_HOTEL_PREFERER ?></h4>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-12">
        <Div class="radio_hotel_index">
        <?php
            $rs = catproductlist(CATPRODUCT_CTRL_SHOW|CATPRODUCT_CTRL_HOTEL,null,true,null,100);
            $cat = array();
            while ($row = mysql_fetch_object($rs))
                $cat[] = $row;
            foreach ($cat as $row){
                echo '
                <input type="radio" onclick="showTabHotel(\''.$row->id.'\',\'hotel\');" id="'.$row->id.'" class="search_check" name="inputhotel"/>
                <div class="check_hotelindex">'.$row->name.'</div>';
            }
        ?>
        </Div>
        </Div>
    </div>

				<div class="padding_hotel_index">
					<!---------------  START VIETNAM HOTEL --------------->
					<?php 
					foreach ($cat as $row){ 
					?>
					<div class="tab_hotel_index_all" id="<?php echo $row->id ?>" name="hotel" style="display:none">
						<Div class="table_hotel">
							<Div class="table_top_hotel">
								<table id="table_top_hotel" width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td width="79%">
										<a href="<?php echo urlBuild('hotel.php').'#'.$row->id?>" class="contry_hotel"><?php echo $row->name ?></a>
									</td>
								  </tr>
								</table>
							</Div>
							<div class="padding_table_center">
								<Span></Span>
							</div>
							<div class="table_bot_hotel">
								<?php 
									$rs1 = catproductlist(CATPRODUCT_CTRL_SHOW,(int)$row->id,false,null,100);
									$hothotel = array();
									while ($catsub = mysql_fetch_object($rs1)){
										$rs2 = productlist((int)$catsub->id,null,PRODUCT_CTRL_HOT,null,PRODUCT_TYPE_HOTEL);
										while ($temp = mysql_fetch_object($rs2))
											$hothotel[] = $temp;
									}
                                if($hothotel){
                                ?>
                                    <div class="clearfix">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <?php if($row->img1){?>
                                                <img src="<?php echo URL_CATPRODUCT_IMG1.$row->img1 ?>" class="img_hotel_group">
                                            <?php }?>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <?php
                                            foreach($hothotel as $key=>$item){
                                                $cathotel = catproductread(@$CPid,$item->id);
                                                $hrefhotel = urlBuild('hotel-detail.php',array('CPname'=>$cathotel->urlrewrite,'url'=>$item->urlrewrite));
                                            ?>
                                            <div class="row row_hotel_index">
                                                <div class="col-md-9 col-sm-9 col-xs-9">
                                                    <h4 class="h4_hotel"><a class="f12 cgreen" href="<?php echo $hrefhotel?>" rel="nofollow"><?php echo $item->name ?></a></h4>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <?php
                                                    if($key%2==0)
                                                        htmlview(URL_IMAGES, @$item->manufacturer.'_star_white_.gif','class="img_star"');
                                                    else
                                                        htmlview(URL_IMAGES, @$item->manufacturer.'_star_blue_.gif', 'class="img_star"');
                                                    ?>
                                                </div>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <?php
                                }
									?>
							</div>
						</Div>
						<Div class="group_hotel_bot">
							<Div class="title_group_hotel_index">
								<h4><?php echo @T_TOP_GROUP_HOTEL.' '.$row->name?></h4>
							</Div>
                            <div class="row">
							<?php
                            $rscathot = catproductlist(CATPRODUCT_CTRL_SHOW,(int)$row->id,false,null,@N_TOP_GROUP_HOTEL);
                            $grouphotel = array();
                            while ($temp = mysql_fetch_object($rscathot)) $grouphotel[] = $temp;
							foreach($grouphotel as $row){
							?>
								<div class="col-md-3 col-sm-3 col-xs-6">
                                    <h4 class="h2_hot_tour"><a class="a_hot_tour" href="<?php echo urlBuild('hotel-list.php',array('url'=>$row->urlrewrite))?>"><?php echo $row->name?></a></h4>
                                </div>
							<?php
							}?>
                            </div>
						</Div>
					</div>	
					<?php 
					}
					?>
				</div>
</Div>
<script>
document.getElementById('<?php echo $cat[0]->id?>').checked=true;
showTabHotel('<?php echo $cat[0]->id?>','hotel');
</script>