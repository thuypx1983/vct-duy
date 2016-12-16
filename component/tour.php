<div class="box-whyus">
    <div class="breadcrumbs clearfix">
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a  href="<?php echo URL_BASE ?>" itemprop="url">
                <span itemprop="title"><?php echo @T_HOME ?></span>
            </a>
        </div>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <span itemprop="title"><?php echo T_TOUR ?></span>
        </div>
    </div>
    <div class="box-title">
        <div class="box-outer-2 box-right">
				<?php 
					$rs = catproductlist(CATPRODUCT_CTRL_SHOW|CATPRODUCT_CTRL_TOUR,null,true,null,100);
					$cat = array();
					while ($row = mysql_fetch_object($rs))
						$cat[] = $row;
					$all = count($cat);
				?>
					<?php
					$end = 0;
					foreach ($cat as $row){
						$end++;
					?>
						<Div class="group_tour_top_pages<?php echo $end==$all?'_end':'';?>">
							<h2 class="h2_category">
								<?php echo @T_GROUP_TOUR.' '.$row->name?>
							</h2>
							<?php 
							$rscathot = catproductlist(CATPRODUCT_CTRL_SHOW,(int)$row->id,false,null,100);
                            ?>
                            <div class="row">
                                <?php
                                while ($temp = mysql_fetch_object($rscathot)){
                                    ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <h4 class="h2_hot_tour"><a class="a_hot_tour" href="<?php echo urlBuild('sub-tour-list.php',array('CPname'=>$row->urlrewrite,'url'=>$temp->urlrewrite))?>"><?php echo $temp->name?></a></h4>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
								</Div>
							<?php 
							}
							?>
				</div>

</div>
</div>