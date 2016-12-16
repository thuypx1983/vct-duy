<?php
$cat = catnewsopen(@$CNid);
$page = isset($_GET['page'])?(int)$_GET['page']:1;
$rs = newspagelist($page,N_PRODUCT_PER_PAGE,$pagecount,null,(int)$cat->id,NEWS_CTRL_SHOW);
$count = 0;
?>
<div class="box-whyus">
    <div class="breadcrumbs clearfix">
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a  href="<?php echo URL_BASE ?>" itemprop="url">
                <span itemprop="title"><?php echo @T_HOME ?></span>
            </a>
        </div>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a  href="<?php echo urlBuild('useful-information.php') ?>" itemprop="url">
                <span itemprop="title"><?php echo @T_USEFUL_INFO ?></span>
            </a>
        </div>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <span itemprop="title"><?php echo $cat->name?></span>
        </div>
    </div>
    <div class="box-title">
        <div class="box-outer-2 box-right">
            <h2 class="h2_category"><?php echo $cat->name ?></h2>
						<?php 
						if(strlen(strip_tags($cat->desc))>0)
						 echo '<div class="summary_ser___">'.$cat->desc.'</div>';
						?>
						<?php 
						while ($item = mysql_fetch_object($rs)){
							$href = urlBuild('useful-information-detail.php',array('CNname'=>$cat->urlrewrite,'url'=>$item->urlrewrite));
						?>
							<Div class="row_ser_list">
                                <?php
                                if($item->img1){
                                    ?>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <A href="<?php echo $href ?>"><?php htmlview(URL_NEWS_IMG1,$item->img1,'alt="'.$item->name.'" class="img_news_list"');?></A>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <Div class="title_sr_detail">
                                                <h4><a href="<?php echo $href?>"><?php echo $item->name?></a></h4>
                                            </Div>
                                            <?php
                                            if(strlen(strip_tags($item->summary))>0)
                                                echo '<Div class="sm_ser_dt">'.strleft($item->summary,270,'...').'</Div>';
                                            else if(strlen(strip_tags($item->content))>0)
                                                echo '<Div class="sm_ser_dt">'.strleft($item->content,270,'...').'</Div>'
                                            ?>
                                            <div align="right" class="more_ser__">
                                                <A href="<?php echo $href ?>">
                                                    <?php echo @T_VIEW_MORE ?>
                                                </A>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }else {
                                    ?>
                                    <Div class="title_sr_detail">
                                        <h4><a href="<?php echo $href?>"><?php echo $item->name?></a></h4>
                                    </Div>
                                    <?php
                                    if(strlen(strip_tags($item->summary))>0)
                                        echo '<Div class="sm_ser_dt">'.strleft($item->summary,270,'...').'</Div>';
                                    else if(strlen(strip_tags($item->content))>0)
                                        echo '<Div class="sm_ser_dt">'.strleft($item->content,270,'...').'</Div>'
                                    ?>
                                    <div align="right" class="more_ser__">
                                        <A href="<?php echo $href ?>">
                                            <?php echo @T_VIEW_MORE ?>
                                        </A>
                                    </div>
                                <?php
                                }
                                ?>
							</Div>
						<?php }
						 if($pagecount>1){?>
						<Div class="page_next_tour_" align="right">
							<form method="get" action="useful-information-list.php">
							<?php
								if($page<=$pagecount&&$page>1)
									echo '<A href="'.urlBuild('useful-information-list.php',array('url'=>$cat->urlrewrite,'page'=>$page-1)).'"><<</A>';
								else if($page==1)	echo '<A href="'.urlBuild('useful-information-list.php',array('url'=>$cat->urlrewrite,'page'=>$pagecount)).'"><<</A>';
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
									echo '<A href="'.urlBuild('useful-information-list.php',array('url'=>$cat->urlrewrite,'page'=>$page+1)).'">>></A>';
								else if($page==$pagecount)
									echo '<A href="'.urlBuild('useful-information-list.php',array('url'=>$cat->urlrewrite,'page'=>1)).'">>></A>';
							?>
							</form>
						</Div>
						<?php }?>
				</div>
</Div>
</div>