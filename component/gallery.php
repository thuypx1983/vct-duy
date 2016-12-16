<div class="breadcrumbs clearfix">
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a  href="<?php echo URL_BASE ?>" itemprop="url">
            <span itemprop="title"><?php echo @T_HOME ?></span>
        </a>
    </div>
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <span itemprop="title">Photo Gallery</span>
    </div>
</div>
<div class="box-title">
    <div class="box-outer-2 box-right">
						<h3 class="h2_category">Photo <Span>Gallery</Span> </h3>
					<Div class="content_about_index">
					<?php 
					$rs = catbannerlist(CATBANNER_CTRL_SHOW|CATBANNER_CTRL_GALLERY,null,1);
					$cat = mysql_fetch_object($rs);
					$rs = catbannerlist(CATBANNER_CTRL_SHOW,(int)$cat->id,100);
					while ($row = mysql_fetch_object($rs)){
					?>
						<Div class="title_gallery_1">
							<?php echo $row->name ?>
						</Div>
						<div class="row_gallery_page row">
						<?php 
							$rs_sub = bannerlist(BANNER_CTRL_SHOW,(int)$row->id);
							while ($item = mysql_fetch_object($rs_sub)){
						?>
                           <div class="col-md-2 col-sm-2 col-xs-4" style="padding: 0 6px">
							<a onclick="return hs.expand(this,{captionId:'slide_show', slideshowGroup:'slide_show'});" class="highslide" href="<?php echo URL_BANNER_IMG.$item->img?>"  id="thumb0">
								<?php htmlview(URL_BANNER_IMG,$item->img,'class="img_gallery_page" ');?>
							</a>
                           </div>
						<?php } ?>
						</div>
					<?php } ?>
						<!--control gallery-->
						<div id="slide_show" class="highslide-caption">
							<a style="float: left; display: block;" class="control" onclick="return hs.previous(this); return false;" href="#">
								<?php echo @T_PREVIOUS ?>
								<br>
								<small style="font-weight: normal; text-transform: none;"><?php echo @T_LEFT_ARROW_KEY ?></small>
							</a>
							<a style="float: left; display: block; text-align: right; margin-left: 30px;" class="control" onclick="return hs.next(this); return false;" href="#">
								<?php echo @T_NEXT ?>
								<br>
								<small style="font-weight: normal; text-transform: none;"><?php echo @T_RIGHT_ARROW_KEY ?></small>
							</a>
							<a class="control" onclick="return hs.close(this); return false;" href="#"><?php echo @T_CLOSE ?></a>
							<a class="highslide-move control" onclick="return false" href="#"><?php echo @T_MOVE ?></a>
							<div style="clear: both;"></div>
						</div>
						<!--end control gallery-->
					</Div>
				</div>

</Div>