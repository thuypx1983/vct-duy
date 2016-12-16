<?php
$cat = catnewsopen(@$CNid);
$page = isset($_GET['page'])?(int)$_GET['page']:1;
$rs = newspagelist($page,N_PRODUCT_PER_PAGE,$pagecount,null,(int)$cat->id,NEWS_CTRL_SHOW);
$count = 0;
echo '
<Div class="patch_all">
	<A class="patch_link" href="'.urlBuild('index.php').'">'.@T_HOME.'</A>>
	<A class="patch_link" href="'.urlBuild('attraction.php').'">'.@T_ATTRACTION.'</A>>
	<span class="patch_active">'.$cat->name.'</span>
</Div>';
?>
<Div class="box_hottour_all" style="padding: 0">
				<div class="padding_hottour">
					<Div class="ct_tour_list_page_">
						<Div class="title_country_ser_">
							<h3><?php echo $cat->name ?></h3>
						</Div>
						<?php 
						if(strlen(strip_tags($cat->desc))>0)
						 echo '<div class="summary_ser___">'.$cat->desc.'</div>';
						?>
						<?php 
						while ($item = mysql_fetch_object($rs)){
							$href = urlBuild('attraction-detail.php',array('CNname'=>$cat->urlrewrite,'url'=>$item->urlrewrite));
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
							<form method="get" action="<?php echo urlBuild('attraction-list.php')?>">
							<?php
								if($page<=$pagecount&&$page>1)
									echo '<A href="'.urlBuild('attraction-list.php',array('url'=>$cat->urlrewrite,'page'=>$page-1)).'"><<</A>';
								else if($page==1)	echo '<A href="'.urlBuild('attraction-list.php',array('url'=>$cat->urlrewrite,'page'=>$pagecount)).'"><<</A>';
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
									echo '<A href="'.urlBuild('attraction-list.php',array('url'=>$cat->urlrewrite,'page'=>$page+1)).'">>></A>';
								else if($page==$pagecount)
									echo '<A href="'.urlBuild('attraction-list.php',array('url'=>$cat->urlrewrite,'page'=>1)).'">>></A>';
							?>
							</form>
						</Div>
						<?php }?>
				</div>
				</div>
</Div>
