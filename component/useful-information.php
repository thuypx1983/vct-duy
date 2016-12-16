<div class="box-whyus">
    <div class="breadcrumbs clearfix">
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a  href="<?php echo URL_BASE ?>" itemprop="url">
                <span itemprop="title"><?php echo @T_HOME ?></span>
            </a>
        </div>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <span itemprop="title"><?php echo T_USEFUL_INFO?></span>
        </div>
    </div>
    <div class="box-title">
        <div class="box-outer-2 box-right">
					<?php 
					$rs = catnewslist(CATNEWS_CTRL_SHOW|CATNEWS_CTRL_USEFUL_INFO,null,1);
					$cat = mysql_fetch_object($rs);
					$rs = catnewslist(CATNEWS_CTRL_SHOW,(int)$cat->id,100);
					$all = mysql_num_rows($rs);
					$count=0;
					while ($row = mysql_fetch_object($rs)){
						$count++;						
					?>
						<Div class="title_country_ser_" id="<?php echo $row->id ?>">
							<h3><?php echo $row->name.' ' ?></h3>
						</Div>
						<?php 
						if(strlen(strip_tags($row->desc))>0)
							echo '<div class="summary_ser___">'.strleft($row->desc,500,'...').'</div>';
						?>
						<Div class="row_ser_list<?php echo $count==$all?'_end':''?>">
                            <?php
                            if($row->img1){
                                ?>
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <?php htmlview(URL_CATNEWS_IMG1,$row->img1,'class="img_cat_attraction" alt="'.$row->name.'"'); ?>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <ul class="no_tag ul_att">
                                            <?php
                                            $rs_sub = catnewslist(CATNEWS_CTRL_SHOW,(int)$row->id,100);
                                            while($item = mysql_fetch_object($rs_sub))
                                                echo '
								<li>
									<a href="'.urlBuild('useful-information-list.php',array('url'=>$item->urlrewrite)).'">
									 '.$item->name.'
									</a>
								</li>'
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php
                            }else {
                                ?>
                                <ul class="no_tag">
                                    <?php
                                    $rs_sub = catnewslist(CATNEWS_CTRL_SHOW,(int)$row->id,100);
                                    while($item = mysql_fetch_object($rs_sub))
                                        echo '
								<li>
									<a href="'.urlBuild('useful-information-list.php',array('url'=>$item->urlrewrite)).'">
									 '.$item->name.'
									</a>
								</li>'
                                    ?>
                                </ul>
                            <?php
                            }
                            ?>
						</div>
					<?php 
					}?>
					</div>
</Div>
    </div>