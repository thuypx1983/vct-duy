<!DOCTYPE html>
<html lang="en">
<head><base href="http://www.vietnam-cambodia-tours.com/" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/images/bootstrap.css" />
    <link href="/images/jquery.mmenu.all.css" type="text/css" rel="stylesheet" />
    <link href="/images/style.css" type="text/css" rel="stylesheet" />
    <link href="/images/font-awesome.css" type="text/css" rel="stylesheet" />
    <link href="/images/promotion-box.css" type="text/css" rel="stylesheet" />
    <link href="/images/stylemenu.css" type="text/css" rel="stylesheet"  >
    <script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="/js/jcarousellite.js"></script>
    <script type="text/javascript" src="/js/jquery.cycle.js"></script>
    <script language="javascript" src="js/jquery.mmenu.min.all.js"></script>
    <script language="javascript" src="js/lib.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <link rel="stylesheet" media="only screen and (max-width: 1024px) and (min-width: 769px)" href="/images/1024.css">
    <link rel="stylesheet" media="only screen and (max-width: 991px) and (min-width: 768px)" href="/images/768.css">
    <link rel="stylesheet" media="only screen and (max-width: 767px)" href="/images/480.css">

<?php 
if(!isset($title)) $title=TEXT_SITE_TITLE;
if(!isset($keyword)) $keyword = TEXT_KEYWORD;
if(!isset($description)) $description = TEXT_DESCRIPTION;
$xtitle=str_replace('"','&quot;',$title);
$keyword = str_replace('"','&quot;',$keyword);
$description = str_replace('"','&quot;',$description);
@define('METADATA','/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/galatouristen-images/meta/service-list.html');
if($s=@fileread(METADATA) or $s=@fileread(dirname(METADATA).'/default.html') or $s = @fileread(PATH_META.'/default.html'));
else $s = '<title>{{TITLE}}</title><meta name="keywords" content="{{KEYWORD}}" /><meta name="description" content="{{DESCRIPTION}}" />';
echo strtr($s,array('{{TITLE}}'=>$xtitle,'{{KEYWORD}}'=>$keyword,'{{DESCRIPTION}}'=>$description));
unset($xtitle,$description,$keyword,$active_meta,$default_meta,$default_meta_db,$row);?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49138928-1', 'vietnam-cambodia-tours.com');
  ga('send', 'pageview');

</script>

<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
  _fbq.push(['addPixelId', '1075020319180354']);
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', 'PixelInitialized', {}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=1075020319180354&amp;ev=PixelInitialized" /></noscript>

<style type="text/css">@import url("/galatouristen-images/application/style.css");</style>
<script src="/galatouristen-images/application/config.js" language="JavaScript" type="text/javascript"></script>
</head>
<?php include PATH_COMPONENT.'box-flash.php' ?><body id="service_list">
<div class="container">
    <div id="wrapper">
        <div class="top_content">
            <?php include '/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/component/banner.php';include '/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/component/main-menu.php' ?>
            <div class="clearfix" id="content">
                <div id="left_content">
                    <?php include '/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/component/service-list.php';include '/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/component/box-social2.php' ?>
                </div>
                <div id="right_content">
                    <?php include '/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/component/box-new.php';include '/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/component/box-about-us.php';include '/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/component/box-comment.php';include '/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/component/box-gallery.php';include '/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/component/box-support.php' ?>
                </div>
                <div class="clear"><span></span></div>
            </div>
        </div>
        <div id="footer">
            <?php include '/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/component/footer-menu.php' ?>
        </div>
    </div><?php include '/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/component/copyright.php' ?>
</div>
<?php 
foreach(Esnc::$x_append as $value) echo $value;
?><script src="/js/library.js" language="javascript" type="text/javascript"></script>

<script src="/galatouristen-images/application/lang.js" language="javascript" type="text/javascript"></script>
<script src="/js/init.js" language="javascript" type="text/javascript"></script>
</body>
</html>