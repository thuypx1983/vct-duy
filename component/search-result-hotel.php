<?php
$keyword = @(string)(trim($_GET['keyword']));
$country = @(int)$_GET['group'];
$parent = 0; $sub = 0;
if($country) {
	$catparent = catproductread($country);
	if($catparent->ctrl&CATPRODUCT_CTRL_HOTEL)
		$parent = $catparent->id;
	else $sub = $catparent->id;
}
$rs = searchtour(PRODUCT_TYPE_HOTEL,$sub,$parent,$keyword);
$str = '';
$all = mysql_num_rows($rs);
$page = $_GET['page']?$_GET['page']:1;
$start =  N_PRODUCT_PER_PAGE* ($page- 1)+ 1;
$end= N_PRODUCT_PER_PAGE* $page;
$total = ($all%N_PRODUCT_PER_PAGE==0)?($all/N_PRODUCT_PER_PAGE):(ceil($all/N_PRODUCT_PER_PAGE));
$count =0;
?>
<Div class="box_hottour_all">

							<h3 class="h3_title"><?php echo @T_SEARCH_RESULT_HOTEL ?></h3>
						<div class="title_hot_tour_all_">
						<div class="search_title_result">
							<?php echo @T_KEYWORD ?>: <span class="search_key_result"><?php echo $keyword?$keyword:@T_ALL ?></span>
							<?php echo @T_TYPE_HOTEL ?> : <span class="search_key_result"><?php echo $catparent?$catparent->name:@T_ALL ?></span>
							<h1 class="search_request">
								<?php echo @T_HAVE_RESULT.' <span class="price_tour_hot">'.$all.'</span>'?>
							</h1>
						</div>
						<?php if($total>1){?>
						<Div class="page_next_tour_" align="right">
							<form method="get" action="search-result-hotel.php">
							<input type="hidden" name="keyword" value="<?php echo $keyword ?>">
							<input type="hidden" name="group" value="<?php echo $country ?>">
							<?php
								if($page<=$total&&$page>1)
									echo '<A href="'.urlBuild('search-result-hotel.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>$page-1)).'"><<</A>';
								else if($page==1)	echo '<A href="'.urlBuild('search-result-hotel.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>$total)).'"><<</A>';
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
									echo '<A href="'.urlBuild('search-result-hotel.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>$page+1)).'">>></A>';
								else if($page==$total)
									echo '<A href="'.urlBuild('search-result-hotel.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>1)).'">>></A>';
							?>
							</form>
						</Div>
						<?php }?>
						<Div class="clear_left"><span></span></Div>
					</div>
					<Div class="ct_tour_list_page_">
					<?php
					while ($item = mysql_fetch_object($rs)){
						$count++;
						if($count>= $start&& $count<= $end){
			    		$cat = catproductread(@$CPid,$item->id);
						$href = urlBuild('hotel-detail.php',array('CPname'=>$cat->urlrewrite,'url'=>$item->urlrewrite));
					?>
                            <Div class="row_tour_hot">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <?php
                                        echo '<a href="'.$href.'" rel="nofollow">';
                                        htmlview(URL_PRODUCT_IMG1,$item->img1,'class="img_tour_index" title="'.($item->alt1?$item->alt1:$item->name).'"');
                                        echo '</a>';
                                        ?>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <div class="name_tour_hot_">
                                            <h4>
                                                <?php
                                                if(@$item->manufacturer)
                                                    htmlview(URL_IMAGES,$item->manufacturer.'_star_white_.gif','align="absmiddle"');
                                                echo '<a href="'.$href.'">'.$item->name.' ';
                                                //201208 if(@$item->price) echo '<Span class="price_tour_hot">From $'.$item->price.'</Span>';
                                                //201208 if(@$item->warranty) echo '<Span class="price_tour_hot"> to $'.$item->warranty.'</Span>';
                                                echo '</a>';
                                                ?>
                                            </h4>
                                        </div>
                                        <Div class="destination_tour_hot">
                                            <?php if(@$item->unit) echo @T_ADDRESS.': '.$item->unit?>
                                        </Div>
                                        <Div class="text_tour_hot">
                                            <?php echo strleft($item->summary,220,'...')?>
                                        </Div>
                                    </Div>
                                </div>
                            </Div>
						<?php } }
						 if($total>1){?>
						<Div class="page_next_tour_" align="right">
							<form method="get" action="search-result-hotel.php">
							<input type="hidden" name="keyword" value="<?php echo $keyword ?>">
							<input type="hidden" name="group" value="<?php echo $country ?>">
							<?php
								if($page<=$total&&$page>1)
									echo '<A href="'.urlBuild('search-result-hotel.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>$page-1)).'"><<</A>';
								else if($page==1)	echo '<A href="'.urlBuild('search-result-hotel.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>$total)).'"><<</A>';
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
									echo '<A href="'.urlBuild('search-result-hotel.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>$page+1)).'">>></A>';
								else if($page==$total)
									echo '<A href="'.urlBuild('search-result-hotel.php',array('keyword'=>$keyword,'group'=>$catparent->id,'page'=>1)).'">>></A>';
							?>
							</form>
						</Div>
						<?php }?>
					</Div>
</Div>