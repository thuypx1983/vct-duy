<div class="box-whyus">
    <div class="breadcrumbs clearfix">
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <a  href="<?php echo URL_BASE ?>" itemprop="url">
                <span itemprop="title"><?php echo @T_HOME ?></span>
            </a>
        </div>
        <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
            <span itemprop="title"><?php echo T_TERM_CONDITION?></span>
        </div>
    </div>
    <div class="box-title">
        <div class="box-outer-2 box-right">
            <h2 class="h2_detail">
                <?php echo T_TERM_CONDITION ?>
            </h2>
            <div class="detail_guide">
                <?php @readfile(PATH_APPLICATION.'term-condition.htm')?>
            </div>
        </div>
    </div>
</div>