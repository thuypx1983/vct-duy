    <h3 class="h3_similar">
        <?php echo T_TOUR_FEEDBACK ?>
    </h3>
        <?php
        $rs = reviewList($item->id);
        while($row = mysql_fetch_object($rs)){
            ?>
            <div class="row_review clearfix" id="feedback<?php echo $row->id?>">
                <div class="left_review"><img src="images/feedback.png"></div>
                <div class="right_review">
                    <div class="right_review_inner">
                        <div class="name_review"><?php echo $row->custName?></div>
                        <div class="content_review"><?php echo $row->content?></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        <?php
        }
        ?>
        <div class="pull-right">
            <a class="book_tour_top" onclick="return(openCenteredWindow3('<?php echo urlBuild('send-review.php',array('PDid'=>$item->id))?>'))">
                <?php echo T_SEND_FEEDBACK?>
            </a>
        </div>
        <div class="clearfix"></div>