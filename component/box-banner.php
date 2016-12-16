<script type="text/javascript">jQuery(document).ready(function(){jQuery('#slideshow').cycle({pager:  '#slide_nav',cleartype:1,fx: 'fade'});jQuery('#pauseButton').click(function() {jQuery('#slideshow').cycle('pause');jQuery(this).hide();jQuery('#resumeButton').show();});jQuery('#resumeButton').click(function() {jQuery('#slideshow').cycle('resume');jQuery(this).hide();jQuery('#pauseButton').show();});});</script>
<Div class="box-outer box-outer-banner">
    <div class="box-outer-2">
        <div class="box_banner">
        <div id="slide_nav">
            <span title="Pause" id="pauseButton">||</span>
            <span style="display:none" id="resumeButton" title="Play">›</span>
        </div>
        <div style="z-index:0" id="slideshow" class="slide">
            <?php
            $rs = bannerlist(BANNER_CTRL_BANNER|BANNER_CTRL_SHOW);
            while ($row = mysql_fetch_object($rs)){
                ?>
                <div style="display:none" class="item_slide">
                    <div class="tour">
                        <h3>
                            <a <?php if($row->url) echo ' href="'.$row->url.'"'?> target="_blank"><?php echo $row->name?></a>
                        </h3>
                        <div class="desc"><?php echo $row->desc?></div>
                    </div>
                    <div class="opacity"></div>
                    <?php if($row->url) echo '<a href="'.$row->url.'" target="_blank">';?>
                    <img class="img_slide" alt="<?php echo $row->name?>" src="<?php echo URL_BANNER_IMG.$row->img?>">
                    <?php if($row->url) echo '</a>';?>
                </div>
            <?php }?>
        </div>
        </div>
    </div>
</div>