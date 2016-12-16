<script type="text/javascript" src="/js/html5lightbox.js"></script>
<div class="box_whys">
	<div class="title_support">
        <span>
        <?php echo T_VIDEO?>
        </span>
    </div>
    <div class="box_right_2">
        <div class="box-title">
			<Div class="box-outer-2 box-title-inner">
				<div class="has-feedback text-center">
                <?php readfile(PATH_APPLICATION.'box-video.htm')?>
				<div class="clearfix"></div>
				</div>
            </div>
        </div>
    </div>
</div>
<Div class="box_whys">
    <div class="title_support">
        <span>
        <?php echo T_BOX_SUPPORT?>
        </span>
    </div>
    <div class="box-title">
        <Div class="box-outer-2 box-title-inner">
            <?php @readfile(PATH_APPLICATION.'box-support.htm')?>
            <div class="clearfix"></div>
        </Div>
		</div>
</Div>
<?php           
require_once('linkmarket/lm_d81af49996.php');
$linkmarket=new LinkMarket();
echo $linkmarket->display();
?>