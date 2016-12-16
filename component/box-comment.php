<div class="box-outer">
    <div class="box-outer-2" style="padding: 8px 10px 10px">
        <h3 class="h2_detail"><?php echo T_BOX_TESTIMONIAL?></h3>
        <?php @readfile(PATH_APPLICATION.'box-testimonial.htm')?>
        <div class="clearfix"></div>
        <div class="text-right" style="padding: 9px 0">
            <a href="<?php echo urlBuild('testimonial.php')?>" class="tred">
                <i class="fa fa-chevron-circle-right"></i> <?php echo T_VIEW_MORE?></a>
        </div>
    </div>
</div>