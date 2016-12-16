<Div class="box-outer">
    <div class="box-outer-2" style="padding: 8px 10px 10px">
        <h3 class="h2_detail">
            <?php echo T_BOX_GALLERY ?>
        </h3>
        <div>
            <?php
            $rs = catbannerlist(CATBANNER_CTRL_SHOW|CATBANNER_CTRL_GALLERY,null,1);
            $cat = mysql_fetch_object($rs);
            $rs_sub = catbannerlist(CATBANNER_CTRL_SHOW,(int)$cat->id,100);
            while ($row = mysql_fetch_object($rs_sub)){
                $rs_hot = bannerlist(BANNER_CTRL_SHOW|BANNER_CTRL_HOT,(int)$row->id);
                while ($item = mysql_fetch_object($rs_hot)){
                    ?>
                    <div class="col-md-4 col-sm-2 col-xs-4" style="padding:2px 5px 0 0">
                    <a onclick="return hs.expand(this,{captionId:'slide_show', slideshowGroup:'slide_show'});" class="highslide" href="<?php echo URL_BANNER_IMG.$item->img?>"  id="thumb0">
                        <?php htmlview(URL_BANNER_IMG,$item->img,'class="img_gallery_index" style="margin-right:7px;margin-bottom:3px" ');?>
                    </a>
                    </div>
                <?php
                }
            }?>
        </div>
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
            <div style="padding: 9px 0" class="text-right">
                <a class="tred" href="<?php echo urlBuild('gallery.php')?>">
                    <i class="fa fa-chevron-circle-right"></i> <?php echo @T_VIEW_MORE ?>
                </a>
            </div>
            </div>
</Div>
<script language="javascript" src="js/highslide-with-gallery.js"></script>
<script>
hs.graphicsDir = 'images/graphics/'; 
hs.showCredits = false;
hs.outlineType = 'rounded-white';
hs.loadingText = 'Loading...';
</script>