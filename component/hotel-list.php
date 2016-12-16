<?php
$cat = catproductread(@$CPid);
$parent = catproductread(@$cat->parentid);
$page = isset($_GET['page'])?(int)$_GET['page']:1;
$rs = productpagelist($page,$pagecount,N_PRODUCT_PER_PAGE,(int)$cat->id,PRODUCT_CTRL_SHOW,NULL, NULL, NULL,NULL, TRUE,PRODUCT_TYPE_HOTEL,null);
$alltour = mysql_num_rows($rs);
$all = N_PRODUCT_PER_PAGE<$alltour?N_PRODUCT_PER_PAGE:$alltour;
$count = 0;
echo '
<Div class="patch_all">
	<A class="patch_link" href="'.urlBuild('index.php').'">'.@T_HOME.'</A>>
	<A class="patch_link" href="'.urlBuild('hotel.php').'#'.$parent->id.'">'.$parent->name.'</A>>
	<span class="patch_active">'.$cat->name.'</span>
</Div>';
?>
<Div class="box_hottour_all">
					<h3 class="h3_title"><?php echo $cat->name ?></h3>
						<?php if($pagecount>1){?>
						<Div class="page_next_tour_" align="right">
							<form method="get" action="hotel-list.php">
							<?php
								if($page<=$pagecount&&$page>1)
									echo '<A href="'.urlBuild('hotel-list.php',array('url'=>$cat->urlrewrite,'page'=>$page-1)).'"><<</A>';
								else if($page==1)	echo '<A href="'.urlBuild('hotel-list.php',array('url'=>$cat->urlrewrite,'page'=>$pagecount)).'"><<</A>';
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
									echo '<A href="'.urlBuild('hotel-list.php',array('url'=>$cat->urlrewrite,'page'=>$page+1)).'">>></A>';
								else if($page==$pagecount)
									echo '<A href="'.urlBuild('hotel-list.php',array('url'=>$cat->urlrewrite,'page'=>1)).'">>></A>';
							?>
							</form>
						</Div>
						<?php }?>
						<Div class="clear_left"><span></span></Div>
					<Div class="ct_tour_list_page_">
					<?php
					while ($item = mysql_fetch_object($rs)){
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
						<?php }
						 if($pagecount>1){?>
						<Div class="page_next_tour_" align="right">
							<form method="get" action="hotel-list.php">
							<?php
								if($page<=$pagecount&&$page>1)
									echo '<A href="'.urlBuild('hotel-list.php',array('url'=>$cat->urlrewrite,'page'=>$page-1)).'"><<</A>';
								else if($page==1)	echo '<A href="'.urlBuild('hotel-list.php',array('url'=>$cat->urlrewrite,'page'=>$pagecount)).'"><<</A>';
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
									echo '<A href="'.urlBuild('hotel-list.php',array('url'=>$cat->urlrewrite,'page'=>$page+1)).'">>></A>';
								else if($page==$pagecount)
									echo '<A href="'.urlBuild('hotel-list.php',array('url'=>$cat->urlrewrite,'page'=>1)).'">>></A>';
							?>
							</form>
						</Div>
						<?php }?>
					</Div>
</Div>