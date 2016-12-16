<div class="breadcrumbs clearfix">
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a  href="<?php echo URL_BASE ?>" itemprop="url">
            <span itemprop="title"><?php echo @T_HOME ?></span>
        </a>
    </div>
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <span itemprop="title"><?php echo T_SERVICE ?></span>
    </div>
</div>
<div class="box-title">
    <div class="box-outer-2 box-right">
					<Div class="ct_tour_list_page_">
					<?php 
					$rs = catproductlist(CATPRODUCT_CTRL_SHOW|CATPRODUCT_CTRL_SERVICE,null,false,null,1);
					$cat = mysql_fetch_object($rs);
					$rs = catproductlist(CATPRODUCT_CTRL_SHOW,(int)$cat->id,true,null,100);
					$all = mysql_num_rows($rs);
					$count=0;
					while ($row = mysql_fetch_object($rs)){
						$count++;
						$href = urlBuild('service-list.php',array('url'=>$row->urlrewrite));
					?>
						<Div class="title_country_ser_">
							<a href="<?php echo $href ?>"><h3><?php echo $row->name ?></h3></a>
						</Div>
						<?php 
						if(@$row->desc)
							echo '<div class="summary_ser___">'.strleft($row->desc,500,'...').'</div>';
						?>
						<Div class="row_ser_list<?php echo $count==$all?'_end':''?>">
						<?php 
						if(@$row->img1){
							echo '<div class="left_ser_list">';
							htmlview(URL_CATPRODUCT_IMG1,$row->img1);
							echo '</div>';
						}
						?>
						<Div class="right_ser_list">
							<ul class="no_tag">
							<?php
							$rs2 = productlist((int)$row->id,@N_SERVICE_GROUP,PRODUCT_CTRL_SHOW,null,PRODUCT_TYPE_SERVICE);
							while ($item = mysql_fetch_object($rs2))
								echo '
								<li>
									<a href="'.urlBuild('service-detail.php',array('CPname'=>$row->urlrewrite,'url'=>$item->urlrewrite)).'">
									 '.$item->name.'
									</a>
								</li>'
							?>
							</ul>
							<div align="right" class="more_ser__">
								<A href="<?php echo $href?>">
									<?php echo @T_VIEW_MORE ?>
								</A>
							</div>
						</Div>
						<div class="clear_left"></div>
						</div>
					<?php } ?>
					</div>		
				</div>
</Div>