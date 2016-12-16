<div class="box-whyus">
<?php
$cat = catproductread(@$CPid);
$parent = catproductread(@$cat->parentid);
$page = isset($_GET['page'])?(int)$_GET['page']:1;
$rs = productpagelist($page,$pagecount,N_PRODUCT_PER_PAGE,(int)$cat->id,PRODUCT_CTRL_SHOW,NULL, NULL, NULL,NULL, TRUE,PRODUCT_TYPE_TOUR,null);
$alltour = mysql_num_rows($rs);
$all = N_PRODUCT_PER_PAGE<$alltour?N_PRODUCT_PER_PAGE:$alltour;
$count = 0;
?>
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
            <a  href="<?php echo urlBuild('tour-list.php',array('url'=>$parent->urlrewrite)) ?>" itemprop="url">
                <span itemprop="title"><?php echo $parent->name ?></span>
            </a>
        </div>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <span itemprop="title"><?php echo $cat->name?></span>
        </div>
    </div>
    <div class="box-title">
        <div class="box-outer-2 box-right">
            <h2 class="h2_category"><?php echo $cat->name ?></h2>
						<?php if($pagecount>1){?>
						<Div class="page_next_tour_" align="right">
							<form method="get" action="sub-tour-list.php">
							<?php
								if($page<=$pagecount&&$page>1)
									echo '<A href="'.urlBuild('sub-tour-list.php',array('CPname'=>$parent->urlrewrite,'url'=>$cat->urlrewrite,'page'=>$page-1)).'"><<</A>';
								else if($page==1)	echo '<A href="'.urlBuild('sub-tour-list.php',array('CPname'=>$parent->urlrewrite,'url'=>$cat->urlrewrite,'page'=>$pagecount)).'"><<</A>';
								echo @T_SELECT_PAGE;
							?>
								<input type="hidden" name="url" value="<?php echo $cat->urlrewrite ?>">
								<select name="page" class="page_next_tour_" onchange="this.form.submit();return true;">
									<?php
										for($i=1;$i<=$pagecount;$i++){
											echo '<option '.($page==$i?'selected="selected"':'').'value="'.$i.'">'.$i.'</option>';
										}
									?>
								</select>
							<?php
								if($page<$pagecount)
									echo '<A href="'.urlBuild('sub-tour-list.php',array('CPname'=>$parent->urlrewrite,'url'=>$cat->urlrewrite,'page'=>$page+1)).'">>></A>';
								else if($page==$pagecount)
									echo '<A href="'.urlBuild('sub-tour-list.php',array('CPname'=>$parent->urlrewrite,'url'=>$cat->urlrewrite,'page'=>1)).'">>></A>';
							?>
							</form>
						</Div>
						<?php }?>
						<Div class="clear_left"><span></span></Div>
					<Div class="ct_tour_list_page_">
					<?php
					while ($item = mysql_fetch_object($rs)){
						$href = urlBuild('tour-detail.php',array('CPname'=>$cat->urlrewrite,'url'=>$item->urlrewrite));
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
						<?php }
						 if($pagecount>1){?>
						<Div class="page_next_tour_" align="right">
							<form method="get" action="sub-tour-list.php">
							<?php
								if($page<=$pagecount&&$page>1)
									echo '<A href="'.urlBuild('sub-tour-list.php',array('CPname'=>$parent->urlrewrite,'url'=>$cat->urlrewrite,'page'=>$page-1)).'"><<</A>';
								else if($page==1)	echo '<A href="'.urlBuild('sub-tour-list.php',array('CPname'=>$parent->urlrewrite,'url'=>$cat->urlrewrite,'page'=>$pagecount)).'"><<</A>';
								echo @T_SELECT_PAGE;
							?>
								<input type="hidden" name="url" value="<?php echo $cat->urlrewrite ?>">
								<select name="page" class="page_next_tour_" onchange="this.form.submit();return true;">
									<?php
										for($i=1;$i<=$pagecount;$i++){
											echo '<option '.($page==$i?'selected="selected"':'').'value="'.$i.'">'.$i.'</option>';
										}
									?>
								</select>
							<?php
								if($page<$pagecount)
									echo '<A href="'.urlBuild('sub-tour-list.php',array('CPname'=>$parent->urlrewrite,'url'=>$cat->urlrewrite,'page'=>$page+1)).'">>></A>';
								else if($page==$pagecount)
									echo '<A href="'.urlBuild('sub-tour-list.php',array('CPname'=>$parent->urlrewrite,'url'=>$cat->urlrewrite,'page'=>1)).'">>></A>';
							?>
							</form>
						</Div>
						<?php }?>
					</Div>
</Div>
</div>
</div>