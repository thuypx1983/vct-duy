<?php                              
function viewcaptcha(){
    $r = rand(11,99);
    $js = '
    <script>
    function refreshCoolCaptcha(){
        jQuery("#cool-captcha-'.$r.'").attr("src","'.URL_ROOT.'captcha/lib/show.php?sid="+Math.random());    
    }
    jQuery(document).ready(function(){
        jQuery("#acool-captcha-'.$r.'").click(function(){
            jQuery("#cool-captcha-'.$r.'").attr("src","'.URL_ROOT.'captcha/lib/show.php?sid="+Math.random());
        });
    });
    </script>
    ';
    return $js.'
    <div class="cool_captcha">
        <div class="cool_captcha_img"><img id="cool-captcha-'.$r.'" src="'.URL_ROOT.'captcha/lib/show.php?sid='.md5(uniqid()).'" alt="" /><a id="acool-captcha-'.$r.'" rel="nofollow"></a><div class="cool_captcha_clr"><span></span></div></div>
        <div class="cool_captcha_text"><input size="17" type="text" name="captcha" id="captcha" autocomplete="off" /></div>
    </div>';        
}

function checkcaptcha(){
    if(isset($_SESSION['s-cool-captcha'])&&($_SESSION['s-cool-captcha']==md5($_POST['captcha']))) return true;
    else return false;
}
    
?>