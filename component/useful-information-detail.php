<?php
$item = mysql_fetch_object(newsopen(@$NWid));
$cat = catnewsopen(@$CPid, $item->id);
?>
<div class="box-whyus">
    <div class="breadcrumbs clearfix">
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a  href="<?php echo URL_BASE ?>" itemprop="url">
                <span itemprop="title"><?php echo @T_HOME ?></span>
            </a>
        </div>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a  href="<?php echo urlBuild('useful-information.php') ?>" itemprop="url">
                <span itemprop="title"><?php echo @T_USEFUL_INFO ?></span>
            </a>
        </div>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a  href="<?php echo urlBuild('useful-information-list.php',array('url'=>$cat->urlrewrite)) ?>" itemprop="url">
                <span itemprop="title"><?php echo $cat->name ?></span>
            </a>
        </div>
    </div>
    <div class="box-title">
        <div class="box-outer-2 box-right">
            <h2 class="h2_detail"><?php echo $item->name ?></h2>
        <Div class="ct_tour_list_page_">
            <?php
            if($item->img2 || $item->img1){
                ?>
                <Div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?php
                        if(@$item->img2) htmlview(URL_NEWS_IMG2,$item->img2,'class="img_news_list" alt="'.$item->name.'"');
                        else if(@$item->img1) htmlview(URL_NEWS_IMG1,$item->img1,'class="img_news_list" alt="'.$item->name.'"');
                        ?>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?php
                        if(strip_tags($item->summary)){
                            ?>
                            <Div class="summart_ser">
                                <?php echo @$item->summary ?>
                            </Div>
                        <?php }?>
                        <div class="row">
                            <div class="col-xs-6">
                                <A class="send_friend" href="<?php echo urlBuild('send-email.php',array('name'=>$item->name,'link'=>curPageURL()))?>" onclick="return(openCenteredWindow3(this))" id="ctl27_ctl01_sendto" ><?php echo @T_SEND_FRIEND ?></A>
                            </div>
                            <div class="col-xs-6">
                                <a class="print_tour" onclick="return(openCenteredWindow2(this))" id="ctl27_ctl01_print" href="<?php echo urlBuild('news-print.php',array('CNname'=>$cat->urlrewrite,'url'=>$item->urlrewrite))?>"><?php echo @T_PRIN ?></a>
                            </div>
                        </div>
                    </Div>
                </Div>
            <?php } else {
                ?>
                <Div class="summart_ser">
                    <?php echo @$item->summary ?>
                </Div>
                <table class="opition_tour" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="29%">
                            <A class="send_friend" href="<?php echo urlBuild('send-email.php',array('name'=>$item->name,'link'=>curPageURL()))?>" onclick="return(openCenteredWindow3(this))" id="ctl27_ctl01_sendto" ><?php echo @T_SEND_FRIEND ?></A>
                        </td>
                        <td width="71%"><a class="print_tour" onclick="return(openCenteredWindow2(this))" id="ctl27_ctl01_print" href="<?php echo urlBuild('news-print.php',array('CNname'=>$cat->urlrewrite,'url'=>$item->urlrewrite))?>"><?php echo @T_PRIN ?></a></td>
                    </tr>
                </table>
            <?php
            } ?>
            <?php echo $item->content ?>
            <div class="end_entry">
                <div class="time_update_">
                    <?php echo @T_TIME_CREATED ?> : <span><?php echo date_format(date_create($item->created),'d-m-Y') ?></span>
                </div>
                <div align="right" class="nguon_tin">
                    <?php if($item->creator) echo @T_SOURCE.' : <span>'.$item->creator.'</span>'; ?>
                </div>
                <div class="clear_both"></div>
            </div>
        </Div>
        <Div class="other_tour_all">
        <h2 class="h3_similar"><?php echo @T_NEWS_EVENTS_SIMILAR ?></span></h2>
    <?php
    //$rs = newslistmore((int)$item->id,'',@N_TOUR_SIMILAR,$cat->id,NEWS_CTRL_SHOW);
    $rs = newslist((int)$cat->id,NEWS_CTRL_SHOW,@N_TOUR_SIMILAR);
    while ($row = mysql_fetch_object($rs)){
        if(($row->id!=$item->id)){
            $href = urlBuild('useful-information-detail.php',array('CNname'=>$cat->urlrewrite,'url'=>$row->urlrewrite));
            ?>
            <div class="item_other_tour">
                <div class="left_item_other">
                    <?php
                    echo '<a href="'.$href.'">';
                    htmlview(URL_NEWS_IMG1,$row->img1);
                    echo '</a>';
                    ?>
                </div>
                <Div class="right_item_other">
                    <h4>
                        <a href="<?php echo $href ?>">
                            <?php
                            echo $row->name
                            ?>
                        </a>
                    </h4>
                </Div>
                <div class="clear_left"></div>
            </div>
        <?php }} ?>
</Div>
    </div>
    </div>
</Div>