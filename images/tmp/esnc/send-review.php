<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esnc="http://www.esnc.net/xhtml">
<head><base href="http://www.vietnam-cambodia-tours.com/" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/images/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/library.js"></script>
<?php 
if(!isset($title)) $title=TEXT_SITE_TITLE;
if(!isset($keyword)) $keyword = TEXT_KEYWORD;
if(!isset($description)) $description = TEXT_DESCRIPTION;
$xtitle=str_replace('"','&quot;',$title);
$keyword = str_replace('"','&quot;',$keyword);
$description = str_replace('"','&quot;',$description);
@define('METADATA','/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/galatouristen-images/meta/send-review.html');
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
<body class="send_email_bd">
<?php include '/hsphere/local/home/aaalqze/vietnam-cambodia-tours.com/component/review.php';foreach(Esnc::$x_append as $value) echo $value;
?><script src="/js/library.js" language="javascript" type="text/javascript"></script>

<script src="/galatouristen-images/application/lang.js" language="javascript" type="text/javascript"></script>
<script src="/js/init.js" language="javascript" type="text/javascript"></script>
</body>
</html>