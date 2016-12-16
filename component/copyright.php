<div class="row copyright">
    <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="clearfix">
        <?php
        $rs = bannerlist(BANNER_CTRL_LOGO|BANNER_CTRL_SHOW,null,1);
        $banner = mysql_fetch_object($rs);
        if(@$banner)
            bannershow($banner,'class="img_logo_footer pull-left"');
        ?>
        <h2 class="h1_title_footer h1_title pull-left">
            <?php echo T_H1_TITLE_SITE?>
        </h2>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <?php readfile(PATH_APPLICATION.'copyright.htm')?>
    </div>
</div>