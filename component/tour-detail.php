<?php 
	$item = productread(@$PDid);
	$cat = catproductread(@$CPid,$item->id);
	$parentcat = catproductread(@$cat->parentid);
	$cf = productcf($item->id,'`a`.`cf0`,`a`.`cf1`,`a`.`cf2`');
	$rs = productphotolist((int)$item->id,30);
	$arr = array();
	$all = 0;
	while ($row = mysql_fetch_object($rs)){
		$arr[] = $row;
		$all++;
	}
	$hotel = productlinklist($item->id,20,PDLINK_CTRL_LINK,PRODUCT_TYPE_HOTEL,'`a`.`id`');
	$hotels = array();
	while ($row = mysql_fetch_object($hotel)) $hotels[] = $row;
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
        <a  href="<?php echo urlBuild('tour-list.php',array('url'=>$parentcat->urlrewrite)) ?>" itemprop="url">
            <span itemprop="title"><?php echo $parentcat->name ?></span>
        </a>
    </div>
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a  href="<?php echo urlBuild('sub-tour-list.php',array('CPname'=>$parentcat->urlrewrite,'url'=>$cat->urlrewrite)) ?>" itemprop="url">
            <span itemprop="title"><?php echo $cat->name?></span>
        </a>
    </div>
</div>
<div class="box-title">
<div class="box-outer-2 box-right">
        <h2 class="h2_detail">
            <?php
                echo $item->name.' ';
                if(@$item->quantity) echo $item->quantity.' '.@T_DAYS;
                if(@$item->unit) echo ' / '.$item->unit.' '.@T_NIGHTS;
            ?>
			 <?php
			if($item->ctrl&PRODUCT_CTRL_NEW2) echo '<img src="/images/new.png" style="margin: 0"> ';
			if($item->ctrl&PRODUCT_CTRL_HOT2) echo '<img src="/images/hot.png" style="margin: 0"> ';
			if($item->ctrl&PRODUCT_CTRL_SALE) echo '<img src="/images/promotion.png" style="margin: 0">';
			?>
        </h2>
					<Div class="">
						<Div class="">
						<?php 
							if($arr){
								?>
							<div class="box_gallery_tour">
							<div class="top_gallery">
							<div id="description" class="description"><?php echo $item->name?></div>
							<?php htmlview(URL_MYIMAGES,$arr[0]->img,'class="img_tour_detail" id="photo" alt="'.$arr[0]->name.'"');?>
							</div>
								<script language="javascript" src="/js/slide.js"></script>
								<script type="text/javascript">var num_image = <?php echo $all; ?></script>
								<div class="div_ul_gallery">
									<ul id="thumbs">
										<?php 
											for($i=0;$i<$all;$i++){
											echo '
												<li class="li_thumbs"><A title="'.($arr[$i]->name?$arr[$i]->name:$item->name).'" name="'.URL_MYIMAGES.$arr[$i]->img.'" onmouseover="changeImage(this.name,this.title, this.title); return false; ">
												<img alt="'.$arr[$i]->name.'" src="'.URL_MYIMAGES.$arr[$i]->img.'" /></A></li>
											';
											}
										?>
									</ul>
									<div class="clr"></div>
								</div>
							</div>
							<?php
							}
							?>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12" style="padding-bottom: 10px">
                                    <a class="book_tour_top" href="<?php echo urlBuild('tour-book.php',array('CPname'=>$cat->urlrewrite,'url'=>$item->urlrewrite))?>"><?php echo @T_TOUR_BOOK ?></a>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12" style="padding-bottom: 10px">
                                    <A class="send_friend" href="/<?php echo urlBuild('send-email.php',array('name'=>$item->name,'link'=>curPageURL()))?>" onclick="return(openCenteredWindow3(this))" id="ctl27_ctl01_sendto" ><?php echo @T_SEND_FRIEND ?></A>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12" style="padding-bottom: 10px">
                                    <a class="print_tour" onclick="return(openCenteredWindow2(this))" id="ctl27_ctl01_print" href="/<?php echo urlBuild('tour-print.php',array('CPname'=>$cat->urlrewrite,'url'=>$item->urlrewrite))?>"><?php echo @T_PRIN ?></a>
                                </div>
                            </div>
								<table class="infor_tour" width="100%" border="0" cellspacing="0" cellpadding="2">
								  <?php 
								  	if(@$item->code)
									  echo '
									  <tr>
										<td width="20%">'.@T_TOUR_CODE.'</td>
										<td>: '.$item->code.'</td>
									  </tr>';
									if(@$item->model)
										 echo '
										  <tr>
											<td width="20%">'.@T_TOUR_FROM.'</td>
											<td>: '.$item->model.'</td>
										  </tr>';
									if(@$item->country)
										 echo '
										  <tr>
											<td width="20%">'.@T_TOUR_STOP.'</td>
											<td>: '.$item->country.'</td>
										  </tr>';
									if(@$item->include)
										echo '
										<tr>
											<td colspan="2" class="destion">'.@T_DESTINATION.': '.$item->include.'</td>
										 </tr>'	
								  ?>
								</table>
							<?php if(strip_tags($item->summary)){?>
							<Div class="summart_tour">
								<?php echo $item->summary ?>
							</Div>
							<?php }?>
						</Div>
						<!-- tab tour -->
						<div class="tab_tour_detail"  id="tabtourfirst">
							<ul class="none_tag ul_tab_tour">
							<?php 
							if(strip_tags($cf[2])){
							?>
								<li class="tab_unselect" id="overview" name="tabli">
									<span><?php echo @T_OVERVIEW_TOUR ?></span>
								</li>
							<?php }?>
							<?php if(strip_tags($item->detail)){ ?>
								<li class="tab_unselect" id="detail" name="tabli">
									<span><?php echo T_DETAIL_TOUR ?></span>
								</li>
							<?php }?>
							<?php if(strip_tags($cf[1]) || strip_tags($cf[0])){?>
								<li class="tab_unselect" id="price" name="tabli">
									<span><?php echo @T_TOUR_PRICE ?></span>
								</li>
							<?php }?>
							<?php if($hotels){?>
								<li class="tab_unselect" id="hotel" name="tabli">
									<span><?php echo @T_HOTEL_TOUR ?></span>
								</li>
							<?php }?>
							</ul>
							<div class="clr"><span></span></div>
						</div>
						<div class="cruise_info">
						<?php 
						if(strip_tags($cf[2])){
						?>
						<div class="tour_detail_tab" id="item_overview" style="display:none" name="tabcontent">
							<?php echo $cf[2] ?>
							<div class="clr"></div>
						</div>
						<?php }?>
						<?php 
						if(strip_tags($item->detail)){
						?>
						<div class="tour_detail_tab" id="item_detail" style="display:none" name="tabcontent">
							<?php echo $item->detail ?>
							<div class="clr"></div>
						</div>
						<?php }?>
						<?php 
						if(strip_tags($cf[1]) || strip_tags($cf[0])){
						?>
						<div class="tour_detail_tab" id="item_price" style="display:none" name="tabcontent">
							<?php if(strlen(strip_tags($cf[0]))>0) echo '<h4>'.@T_TOUR_INCLUDE.'</h4>'.$cf[0]?>
							<?php if(strlen(strip_tags($cf[1]))>0) echo '<br><h4>'.@T_TOUR_EXCLUDE.'</h4>'.$cf[1]?>
							<div class="clr"></div>
						</div>
						<?php }?>
						<?php if($hotels){?>
						<div class="tour_detail_tab" id="item_hotel" style="display:none" name="tabcontent">
							<?php 
							foreach ($hotels as $row){
								$itemhotel = productread($row->id);
								$href = urlBuild('hotel-detail.php',array('CPname'=>$itemhotel->caturlrewrite,'url'=>$itemhotel->urlrewrite));
								?>
								<Div class="row_tour_hot">
									<div class="left_tour_hot_">
									<?php 
										echo '<a href="'.$href.'" rel="nofollow">';
										htmlview(URL_PRODUCT_IMG1,$itemhotel->img1,'title="'.($itemhotel->alt1?$itemhotel->alt1:$itemhotel->name).'"');
										echo '</a>';
									?>
									</div>
									<Div class="right_tour_hot_">
										<div class="name_tour_hot_">
										<h4>
										<?php
											if(@$itemhotel->manufacturer)
												htmlview(URL_IMAGES,$itemhotel->manufacturer.'star.png','align="absmiddle"');
											echo '<a href="'.$href.'">'.$itemhotel->name.' ';										
											echo '</a>';
										?>
										</h4>
										</div>
										<Div class="destination_tour_hot">
										<?php if(@$itemhotel->unit) echo @T_ADDRESS.': '.$itemhotel->unit?>
										</Div>
										<Div class="text_tour_hot">
										<?php echo strleft($itemhotel->summary,220,'...')?>
										</Div>
									</Div>
									<div class="clear_left"><Span></Span></div>
								</Div>
								<?php
							}
							?>
							<div class="clr"></div>
						</div>
						<?php }?>
					</Div>
					   <!-- tab tour 2 -->
                        <div class="tab_tour_detail" id="tabtourbottom">
                            <ul class="none_tag ul_tab_tour">
                                <?php
                                if(strip_tags($cf[2])){
                                    ?>
                                    <li class="tab_unselect" id="overview" name="tabli">
                                        <span><?php echo @T_OVERVIEW_TOUR ?></span>
                                    </li>
                                <?php }?>
                                <?php if(strip_tags($item->detail)){ ?>
                                    <li class="tab_unselect" id="detail" name="tabli">
                                        <span><?php echo T_DETAIL_TOUR ?></span>
                                    </li>
                                <?php }?>
                                <?php if(strip_tags($cf[1]) || strip_tags($cf[0])){?>
                                    <li class="tab_unselect" id="price" name="tabli">
                                        <span><?php echo @T_TOUR_PRICE ?></span>
                                    </li>
                                <?php }?>
                                <?php if($hotels){?>
                                    <li class="tab_unselect" id="hotel" name="tabli">
                                        <span><?php echo @T_HOTEL_TOUR ?></span>
                                    </li>
                                <?php }?>
                            </ul>
                            <div class="clr"><span></span></div>
                        </div>
                        <!-- tab tour 2-->
					<Div class="bot_tour_all">
							<input class="book_tour_bot" onclick="parent.location='/<?php echo urlBuild('tour-book.php',array('CPname'=>$cat->urlrewrite,'url'=>$item->urlrewrite))?>'" value="" type="submit" />
							<input class="cus_tour_bot" onclick="parent.location='/<?php echo urlBuild('tour-customize.php')?>'" value="" type="submit" />
						<Div class="clear_left"></Div>
					</Div>
				</div>
<?php include(PATH_COMPONENT.'tour-feedback.php');?>
<Div class="other_tour_all">
    <h2 class="h3_similar"><?php echo @T_TOUR_SIMILAR ?></span></h2>
    <div class="row">
	<?php 
	$rs = productlist($cat->id,@N_TOUR_SIMILAR,PRODUCT_CTRL_SHOW,(int)$item->id,PRODUCT_TYPE_TOUR); 
	while ($row = mysql_fetch_object($rs)){
		$href = urlBuild('tour-detail.php',array('CPname'=>$cat->urlrewrite,'url'=>$row->urlrewrite));
	?>
    <div class="col-md-6 col-sm-6 col-xs-12 item_other_tour">
        <div class="row">
		<div class="col-md-4 col-sm-4 col-xs-4">
			<?php 
				echo '<a href="'.$href.'">';
				htmlview(URL_PRODUCT_IMG1,$row->img1,'class="img_tour_similar" title="'.($row->alt1?$row->alt1:$row->name).'"');
				echo '</a>';
			?>
		</div>
            <div class="col-md-8 col-sm-8 col-xs-8">
			<h4>
				<a href="<?php echo $href ?>" class="a_tour_similar">
					<?php 
						echo $row->name.' ';
						if(@$row->quantity) echo $row->quantity.' '.@T_DAYS;
						if(@$row->unit) echo ' | '.$row->unit.' '.@T_NIGHTS;
					?>
				</a>
				<?php
			if($row->ctrl&PRODUCT_CTRL_NEW2) echo '<img src="/images/new.png" style="margin: 0"> ';
			if($row->ctrl&PRODUCT_CTRL_HOT2) echo '<img src="/images/hot.png" style="margin: 0"> ';
			if($row->ctrl&PRODUCT_CTRL_SALE) echo '<img src="/images/promotion.png" style="margin: 0">';
			?>
			</h4>
		</Div>
        </div>
	</div>
	<?php } ?>
    </div>
</Div>
<script type="text/javascript">
jQuery( document ).ready(function() {
	jQuery("li[name='tabli']").click(function(){
        var idli = jQuery(this).attr("id");
		jQuery("li[name='tabli']").removeClass("tab_selected").addClass("tab_unselected");
		jQuery("#tabtourfirst #"+idli).removeClass("tab_unselected").addClass("tab_selected");
		jQuery("#tabtourbottom #"+idli).removeClass("tab_unselected").addClass("tab_selected");
		var contentid = jQuery(this).attr("id");
		jQuery("div[name='tabcontent']").hide();
		/* jQuery("#item_"+contentid).show();*/
		jQuery("#item_"+contentid).fadeIn();
        jQuery("html,body").stop().animate({scrollTop:jQuery("#tabtourfirst").offset().top},500)
	});
	jQuery("#tabtourfirst li[name='tabli']").first().removeClass("tab_unselected").addClass("tab_selected");
	jQuery("#tabtourbottom li[name='tabli']").first().removeClass("tab_unselected").addClass("tab_selected");
	jQuery("div[name='tabcontent']").first().show();
});
</script>
</div>
</Div>