<?php
$cat = catproductread(@$CPid);
?>
<div class="box-whyus">
    <div class="breadcrumbs clearfix">
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a  href="<?php echo URL_BASE ?>" itemprop="url">
                <span itemprop="title"><?php echo @T_HOME ?></span>
            </a>
        </div>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a  href="<?php echo urlBuild('tour.php') ?>" itemprop="url">
                <span itemprop="title"><?php echo @T_TOUR ?></span>
            </a>
        </div>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <span itemprop="title"><?php echo $cat->name?></span>
        </div>
    </div>
    <div class="box-title">
        <div class="box-outer-2 box-right">
				<?php 
				$rs = catproductlist(CATPRODUCT_CTRL_SHOW,(int)$cat->id,true,null,100);
				while ($row = mysql_fetch_object($rs)){
				?>
					<Div class="">
                        <div class="title_hot_tour_all_">
                            <Div class="title_tour_list_new">
                                <a href="<?php echo urlBuild('sub-tour-list.php',array('CPname'=>$cat->urlrewrite,'url'=>$row->urlrewrite))?>"><h3><?php echo $row->name.' ' ?></h3></a>
                            </Div>
                            <Div class="more_hot_tour_">
                                <a href="<?php echo urlBuild('sub-tour-list.php',array('CPname'=>$cat->urlrewrite,'url'=>$row->urlrewrite))?>"><i class="fa fa-chevron-circle-right"></i>  <?php echo @T_VIEW_MORE ?></a>
                            </Div>
                            <Div class="clear_left"><span></span></Div>
                        </div>
						<?php
						$rs_sub = productlist((int)$row->id,@N_TOUR_PER_GROUP,PRODUCT_CTRL_SHOW|PRODUCT_CTRL_SPECIAL,null,PRODUCT_TYPE_TOUR);
						while ($item = mysql_fetch_object($rs_sub)){
							$href = urlBuild('tour-detail.php',array('CPname'=>$row->urlrewrite,'url'=>$item->urlrewrite));
						?>
                            <Div class="row_tour_hot">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <a href="<?php echo $href ?>">
                                            <?php if($item->img1) htmlview(URL_PRODUCT_IMG1,$item->img1,'title="'.($item->alt1?$item->alt1:$item->name).'" class="img_tour_index"')?>
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <div class="name_tour_hot_">
                                            <h4>
                                                <a href="<?php echo $href ?>">
                                                    <?php
                                                    echo $item->name.' ';
                                                    if($item->quantity) echo $item->quantity.' '.@T_DAYS;
                                                    if($item->unit) echo ' | '.$item->unit.' '.@T_NIGHTS;
                                                    ?>
                                                </a>
												 <?php
                                    if($item->ctrl&PRODUCT_CTRL_NEW2) echo '<img src="/images/new.png" style="margin: 0"> ';
                                    if($item->ctrl&PRODUCT_CTRL_HOT2) echo '<img src="/images/hot.png" style="margin: 0"> ';
                                    if($item->ctrl&PRODUCT_CTRL_SALE) echo '<img src="/images/promotion.png" style="margin: 0">';
                                    ?>
                                            </h4>
                                        </div>
                                        <Div class="destination_tour_hot">
                                            <?php if($item->include) echo @T_DESTINATION.': '.$item->include ?>
                                        </Div>
                                        <Div class="text_tour_hot">
                                            <?php if(strlen(strip_tags($item->summary))) echo strleft($item->summary,200,'...') ?>
                                        </Div>
                                    </Div>
                                </Div>
                            </div>
						<?php } ?>
					</Div>
				<?php } ?>
</Div>
    </div>
    </div>