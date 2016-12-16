<Div class="box-whyus">
    <h4 class="h4-title">
        <a href="<?php echo urlBuild('useful-information.php')?>"><?php echo @T_USEFUL_INFO_HOT ?></a>
    </h4>
    <div class="box-title">
        <div class="box-outer-2 box-right">
            <div class="row">
            <?php
            $rs = catnewslist(CATNEWS_CTRL_SHOW|CATNEWS_CTRL_USEFUL_INFO,null,1);
            $cat = mysql_fetch_object($rs);
            $rs_sub = catnewslist(CATNEWS_CTRL_SHOW,(int)$cat->id,100);
            $hot = array();
            while ($row = mysql_fetch_object($rs_sub)){
                $rs_subsub = catnewslist(CATNEWS_CTRL_SHOW,(int)$row->id,100);
                while($item=mysql_fetch_object($rs_subsub)){
                    $rs_hot = newslist((int)$item->id,NEWS_CTRL_SHOW|NEWS_CTRL_HOT,1000);
                    while ($temp = mysql_fetch_object($rs_hot))
                        $hot[] = $temp;
                }
            }
            foreach($hot as $row){
                $cat = catnewsopen(@$CNid,$row->id);
                ?>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <h4 class="h4_item"><a rel="nofollow" href="<?php echo urlBuild('useful-information-detail.php',array('CNname'=>$cat->urlrewrite,'url'=>$row->urlrewrite))?>" title="<?php echo $row->alt1?$row->alt1:$row->name?>"><?php echo $row->name?></a></h4>
                </div>
                <?php
            }
            ?>
            </div>
        </div>

</Div>
</Div>