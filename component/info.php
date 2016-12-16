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
        <span itemprop="title"><?php echo $item->name?></span>
    </div>
</div>
    <div class="box-title">
        <div class="box-outer-2 box-right">
            <h2 class="h2_detail"><?php echo $item->name ?></h2>
					<Div class="ct_tour_list_page_">
						<div class="data_service">
						<?php echo $item->content ?>
						</div>
					</Div>

<style type="text/css">
.data_service span{
	text-transform:none!important;
}
</style>
<Div class="other_tour_all">
	<h3 class="h3_similar">
		<?php echo @T_INFO_SIMILAR ?>
    </h3>
    <div class="row">
	<?php 
	//$rs = newslistmore((int)$item->id,'',@N_TOUR_SIMILAR,$cat->id,NEWS_CTRL_SHOW);
	$rs = newslist((int)$cat->id,NEWS_CTRL_SHOW,@N_TOUR_SIMILAR);
	while ($row = mysql_fetch_object($rs)){
		if(($row->id!=$item->id)){
		$href = urlBuild('info.php',array('CNname'=>$row->caturlrewrite, 'url'=>$row->urlrewrite));
	?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <h4 class="h2_hot_tour">
                    <a href="<?php echo $href ?>" class="a_hot_tour">
                        <?php
                        echo $row->name
                        ?>
                    </a>
                </h4>
            </div>
	<?php } }?>
    </div>
</Div>
    </div>
    </div>
</Div>