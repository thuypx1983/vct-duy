<Div class="box-outer">
    <div class="box-right box-outer-2">
    <h2 class="h2_title"><?php echo @T_GROUP_TOUR_HOME ?></h2>
    <Div>
        <Div class="row">
        <?php
        $rs = catproductlist(CATPRODUCT_CTRL_SHOW|CATPRODUCT_CTRL_TOUR,null,false,null,100);
        $arr  = array();
        while ($row = mysql_fetch_object($rs)){
            $rs_sub = catproductlist(CATPRODUCT_CTRL_SHOW|CATPRODUCT_CTRL_HOME,(int)$row->id,true,null,100);
            while ($item = mysql_fetch_object($rs_sub))
                $arr[] = $item;
        }
        foreach($arr as $row){
            $cat = catproductread((int)$row->parentid);
            $href = urlBuild('sub-tour-list.php',array('CPname'=>$cat->urlrewrite,'url'=>$row->urlrewrite));
            ?>
            <div class="col-md-6 com-sm-6 col-xs-12">
                <h2 class="h2_hot_tour"><a class="a_hot_tour" href="<?php echo $href ?>"><?php echo $row->name?></a></h2>
            </div>
            <?php
        }
        ?>
        </Div>
    </Div>
    <Div class="item_tour_hot_all">
        <div class="title_hot_tour_all_">
            <Div class="left_title_hot_tour">
                <h4><?php echo @T_TOUR_PREFERER ?></h4>
            </Div>
            <Div class="clear_both"><span></span></Div>
        </div>
        <Div class="ct_tour_hot_">
            <?php
                $rs = productlist(0,null,PRODUCT_CTRL_HOT|PRODUCT_CTRL_SHOW,null,PRODUCT_TYPE_TOUR);
                $count=0;
                while ($row = mysql_fetch_object($rs)){
                    $count++;
                    if($count<=@N_HOT_TOUR){
                        $cattour = catproductread(@$CPid,$row->id);
                        $hreftour = urlBuild('tour-detail.php',array('CPname'=>$cattour->urlrewrite,'url'=>$row->urlrewrite));
            ?>
                    <Div class="row_tour_hot">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <a href="<?php echo $hreftour ?>">
                                    <?php if($row->img1) htmlview(URL_PRODUCT_IMG1,$row->img1,'title="'.($row->alt1?$row->alt1:$row->name).'" class="img_tour_index"')?>
                                </a>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="name_tour_hot_">
                                <h4>
                                    <a href="<?php echo $hreftour ?>">
                                        <?php
                                            echo $row->name.' ';
                                            if($row->quantity) echo $row->quantity.' '.@T_DAYS;
                                            if($row->unit) echo ' | '.$row->unit.' '.@T_NIGHTS;
                                        ?>
                                    </a>
									 <?php
                                    if($row->ctrl&PRODUCT_CTRL_NEW2) echo '<img src="/images/new.png" style="margin: 0"> ';
                                    if($row->ctrl&PRODUCT_CTRL_HOT2) echo '<img src="/images/hot.png" style="margin: 0"> ';
                                    if($row->ctrl&PRODUCT_CTRL_SALE) echo '<img src="/images/promotion.png" style="margin: 0">';
                                    ?>
                                </h4>
                                </div>
                                <Div class="destination_tour_hot">
                                    <?php if($row->include) echo @T_DESTINATION.': '.$row->include ?>
                                </Div>
                                <Div class="text_tour_hot">
                                    <?php if(strlen(strip_tags($row->summary))) echo strleft($row->summary,200,'...') ?>
                                </Div>
                            </Div>
                        </Div>
                    </div>
            <?php
                }
            }?>
            <Div class="more_hot_tour_">
                <a href="<?php echo urlBuild('tour.php')?>"><i class="fa fa-chevron-circle-right"></i> <?php echo @T_MORE_TOUR ?></a>
            </Div>
        </Div>
    </Div>

</Div>
</div>
<Div class="box-outer">
    <div class="box-right box-outer-2">
        <Div class="">
            <div class="title_hot_tour_all_">
                <Div class="left_title_hot_tour">
                    <h4><?php echo @T_TOUR_NEW ?></h4>
                </Div>
                <Div class="clear_both"><span></span></Div>
            </div>
            <Div class="ct_tour_hot_">
                <?php
                $rs = productlist(0,null,PRODUCT_CTRL_NEW|PRODUCT_CTRL_SHOW,null,PRODUCT_TYPE_TOUR);
                $count=0;
                while ($row = mysql_fetch_object($rs)){
                    $count++;
                    $cattour = catproductread(@$CPid,$row->id);
                    $hreftour = urlBuild('tour-detail.php',array('CPname'=>$cattour->urlrewrite,'url'=>$row->urlrewrite));
                    ?>
                    <Div class="row_tour_hot">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <a href="<?php echo $hreftour ?>">
                                    <?php if($row->img1) htmlview(URL_PRODUCT_IMG1,$row->img1,'title="'.($row->alt1?$row->alt1:$row->name).'" class="img_tour_index"')?>
                                </a>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="name_tour_hot_">
                                    <h4>
                                        <a href="<?php echo $hreftour ?>">
                                            <?php
                                            echo $row->name.' ';
                                            if($row->quantity) echo $row->quantity.' '.@T_DAYS;
                                            if($row->unit) echo ' | '.$row->unit.' '.@T_NIGHTS;
                                            ?>
                                        </a>
                                        <?php
                                        if($row->ctrl&PRODUCT_CTRL_NEW2) echo '<img src="/images/new.png" style="margin: 0"> ';
                                        if($row->ctrl&PRODUCT_CTRL_HOT2) echo '<img src="/images/hot.png" style="margin: 0"> ';
                                        if($row->ctrl&PRODUCT_CTRL_SALE) echo '<img src="/images/promotion.png" style="margin: 0">';
                                        ?>
                                    </h4>
                                </div>
                                <Div class="destination_tour_hot">
                                    <?php if($row->include) echo @T_DESTINATION.': '.$row->include ?>
                                </Div>
                                <Div class="text_tour_hot">
                                    <?php if(strlen(strip_tags($row->summary))) echo strleft($row->summary,200,'...') ?>
                                </Div>
                            </Div>
                        </Div>
                    </div>
                <?php

                }?>
            </Div>
        </Div>
    </div>
</Div>