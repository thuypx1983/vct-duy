<?php
$keyword = @(string)(trim($_GET['keyword']));
$country = @(int)$_GET['group'];
$parent = 0; $sub = 0;
if($country) {
	$catparent = catproductread($country);
	if($catparent->ctrl&CATPRODUCT_CTRL_TOUR)
		$parent = $catparent->id;
	else $sub = $catparent->id;
}
$rs = searchtour(PRODUCT_TYPE_TOUR,$sub,$parent,$keyword);
$str = '';
$all = mysql_num_rows($rs);
$page = $_GET['page']?$_GET['page']:1;
$start =  N_PRODUCT_PER_PAGE* ($page- 1)+ 1;
$end= N_PRODUCT_PER_PAGE* $page;
$total = ($all%N_PRODUCT_PER_PAGE==0)?($all/N_PRODUCT_PER_PAGE):(ceil($all/N_PRODUCT_PER_PAGE));
$count =0;
?>
<Div class="box_hottour_all">
						<h3 class="h3_title"><?php echo @T_SEARCH_RESULT_TOUR ?></h3>
					<div class="title_hot_tour_all_">
						<div class="search_title_result">
							<?php echo @T_KEYWORD ?>: <span class="search_key_result"><?php echo $keyword?$keyword:@T_ALL ?></span>
							<?php echo @T_TYPE_TOUR ?> : <span class="search_key_result"><?php echo $catparent?$catparent->name:@T_ALL ?></span>
							<h1 class="search_request">
								<?php echo @T_HAVE_RESULT.' <span class="price_tour_hot">'.$all.'</span>'?>
							</h1>
						</div>
					</div>
					<?php if($total>1){?>
					<Div class="page_next_tour_" align="right">
						<form method="get" action="search-result-tour.php">
							<input type="hidden" name="keyword" value="<?php echo $keyword ?>">
							<input type="hidden" name="group" value="<?php echo $country ?>">
						<?php
							if($page<=$total&&$page>1)
								echo '<A href="'.urlBuild('search-result-tour.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>$page-1)).'"><<</A>';
							else if($page==1)	echo '<A href="'.urlBuild('search-result-tour.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>$total)).'"><<</A>';
							echo @T_SELECT_PAGE;
						?>	
							<select name="page" class="page_next_tour_" onchange="this.form.submit();return true;">
								<?php 
									for($i=1;$i<=$total;$i++){
										echo '<option '.($page==$i?'selected="selected"':'').'value="'.$i.'">'.$i.'</option>';
									}
								?>
							</select>
						<?php 
							if($page<$total)
								echo '<A href="'.urlBuild('search-result-tour.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>$page+1)).'">>></A>';
							else if($page==$total)
								echo '<A href="'.urlBuild('search-result-tour.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>1)).'">>></A>';
						?>
						</form>
					</Div>
					<?php }?>
					<Div class="clear_left"><span></span></Div>
					<Div class="ct_tour_list_page_">
					<?php
					while ($item = mysql_fetch_object($rs)){
						$count++;
						if($count>= $start&& $count<= $end){
			    		$cat = catproductread(@$CPid,$item->id);
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
						<?php } }
						 if($total>1){?>
						<Div class="page_next_tour_" align="right">
							<form method="get" action="search-result-tour.php">
							<input type="hidden" name="keyword" value="<?php echo $keyword ?>">
							<input type="hidden" name="group" value="<?php echo $country ?>">
							<?php
								if($page<=$total&&$page>1)
									echo '<A href="'.urlBuild('search-result-tour.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>$page-1)).'"><<</A>';
								else if($page==1)	echo '<A href="'.urlBuild('search-result-tour.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>$total)).'"><<</A>';
								echo @T_SELECT_PAGE;
							?>	
								<select name="page" class="page_next_tour_" onchange="this.form.submit();return true;">
									<?php 
										for($i=1;$i<=$total;$i++){
											echo '<option '.($page==$i?'selected="selected"':'').'value="'.$i.'">'.$i.'</option>';
										}
									?>
								</select>
							<?php 
								if($page<$total)
									echo '<A href="'.urlBuild('search-result-tour.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>$page+1)).'">>></A>';
								else if($page==$total)
									echo '<A href="'.urlBuild('search-result-tour.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>1)).'">>></A>';
							?>
							</form>
						</Div>
						<?php }?>
					</Div>
</Div>