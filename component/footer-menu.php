<Div class="box_menufooter_all">
        <div class="top_footer">
            <Div class="link_footer">
                <A href="<?php echo urlBuild('tour.php')?>" class="frist_link"><?php echo @T_TOUR ?></A>|
                <A href="<?php echo urlBuild('policy.php')?>" class="frist_link_2"><?php echo @T_POLICY ?></A>|
                <A href="<?php echo urlBuild('faq.php')?>" class="frist_link_2"><?php echo @T_FAQ ?></A>|
                <A href="<?php echo urlBuild('service.php')?>" class="frist_link_2"><?php echo @T_SERVICE ?></A>
            </Div>
            <div class="clear_both"></div>
        </div>
        <?php readfile(PATH_APPLICATION.'footer.htm')?>
        <Div class="clear_both"></Div>
        <?php include('footer-link.php') ?>
        <Div class="clear_both"></Div>

</Div>
<div id="dvBackToTop" class="backtotop" style="display: block;">
    <img src="/images/backtotop.png" alt="<?php echo T_ON_TOP?>">
</div>
<script type="text/javascript">
    jQuery(document).ready(function()
    {
        jQuery('#dvBackToTop').hide();
        jQuery(window).scroll(function(){
            currentScrollTop = jQuery(window).scrollTop();
            if(currentScrollTop>0)jQuery('#dvBackToTop').show();
            else jQuery('#dvBackToTop').hide();
        });
        jQuery('#dvBackToTop').click(function () {
            jQuery('html, body').animate({scrollTop:0}, 'slow');
        });
    });
</script>