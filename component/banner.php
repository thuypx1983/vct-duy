<header>
<Div class="clearfix">
	<Div class="div_logo">
	<?php 
		$rs = bannerlist(BANNER_CTRL_LOGO|BANNER_CTRL_SHOW,null,1);
		$banner = mysql_fetch_object($rs);
		if(@$banner)
			bannershow($banner,'class="img_logo"');
	?>
    </div>
	<div class="right_banner">
		<div class="link_language">
			<A class="link_top_" href="/testimonial.html">
				<?php echo @T_ABOUT_US ?>
			</A>|    
			<A class="link_top_" href="<?php echo urlBuild('news-events.php')?>">
				<?php echo @T_NEWS_EVENTS ?>
			</A>|
			<A class="language_top" href="http://www.galatouriste.com/" rel="nofollow">
				French
			</A>
		</div>
        <div class="clearfix"></div>
        <div class="clearfix">
            <h1 class="h1_title">
                <?php echo T_H1_TITLE_SITE?>
            </h1>
            <div class="fb_tw_gg">

                <div class="facebooklike_">
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s); js.id = id;
                            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));
                    </script>
                    <div class="fb-like" data-href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" data-send="false" data-layout="button_count" data-width="88" data-show-faces="true"></div>
                </div>
                <div class="twitterlike_">
                    <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                </div>
                <div class="googlelike_">
                    <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
                    <g:plusone size="medium"></g:plusone>
                </div>
                <div style="clear:both"><span></span></div>
            </div>
        </div>
        <div style="clear:both"><span></span></div>
        </div>
</Div>
    <div class="navbar-default clearfix">
        <a class="language_top" href="http://www.galatouriste.com/">
            <img src="/images/France16x16.png" />
        </a>
        <a class="a_home" href="<?php echo urlBuild('index.php')?>"><?php echo T_HOME?></a>
        <a  class="navbar-toggle"  href="#menu">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <span class="span_menu"><?php echo T_MENU ?></span>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery("#menu").mmenu({
                "offCanvas": {
                    "zposition": "front"
                },
                "footer": {
                    "add": true,
                    "title": "galatouriste.com"
                },
                "slidingSubmenus": false
            }, {
            });
            jQuery("nav#menu").find( ".mm-subopen" ).addClass( "mm-fullsubopen " );
        });


    </script>
</header>