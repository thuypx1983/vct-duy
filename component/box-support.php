<Div class="box-whyus">
    <div class="title_support">
        <?php echo T_TOUR_FEEDBACK ?>
    </div>
    <Div class="box-title">
        <Div class="box-outer-2 box-title-inner">
            <?php
            require_once PATH_COMPLS.'product-detail.php';
            $rs = reviewList(null,5);
            $count = 0;
            while ($row = mysql_fetch_object($rs)){
                $count++;
                $tour = productread($row->productID);
                ?>
                <div class="row_box_feedback">
                    <a href="<?php echo urlBuild('tour-detail.php',array('CPname'=>$tour->caturlrewrite,'url'=>$tour->urlrewrite)).'#feedback'.$row->id?>"><?php echo strleft(@$row->content,80,'...')?></a>
                </div>
            <?php } ?>

        </Div>
    </div>
</Div>
<Div class="box-whyus">
    <div class="title_support">
        <?php echo T_NEWS_EVENTS ?>
    </div>
    <Div class="box-title">
        <Div class="box-outer-2 box-title-inner">
        <?php
        $rs = catnewslist(CATNEWS_CTRL_SHOW|CATNEWS_CTRL_NEWS,null,1);
        $cat = mysql_fetch_object($rs);
        $rs = newslist($cat->id,NEWS_CTRL_SHOW,3);
        while ($row = mysql_fetch_object($rs)){
            ?>
            <div class="row_box_feedback">
                <a href="<?php echo urlBuild('news-events-detail.php',array('url'=>$row->urlrewrite)) ?>" class="a_news_"><?php echo $row->name?></a><br>
                <?php echo strleft($row->content,120,'...')?>
            </div>
        <?php } ?>
            </Div>
    </div>
</Div>
<div style="padding-bottom: 15px">
<?php @readfile(PATH_APPLICATION.'box-map.htm')?>
</div>