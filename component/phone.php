<div class="breadcrumbs clearfix">
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a  href="<?php echo URL_BASE ?>" itemprop="url">
            <span itemprop="title"><?php echo @T_HOME ?></span>
        </a>
    </div>
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <span itemprop="title">Callback request</span>
    </div>
</div>
<div class="box-title">
    <div class="box-outer-2 box-right">
            <?php
            echo '<form method="post" action="process.php?act=callback" class="form_phone" onsubmit="return checkPhone(this);">';
            $tag = array(
            '{{T_FIRST_NAME}}'=>'<input type="text" class="first_name" name="first_name"/>',
            '{{T_GENDER}}' => '<select name="gender">'.file_get_contents(PATH_APPLICATION.'gender.htm').'</select>',
            '{{T_CODE_COUNTRY}}' => '<select class="select_country" name="code_country">'.file_get_contents(PATH_APPLICATION.'phonecode.htm').'</select>',
            '{{T_LAST_NAME}}'=>'<input type="text" class="last_name" name="last_name"/>',
            '{{T_EMAIL}}'=>'<input type="text" class="contact_us" name="email" />',
            '{{T_COUNTRY}}' => '<select class="select_country_2" name="country">'.file_get_contents(PATH_APPLICATION.'countrycodes.htm').'</select>',
            '{{T_PHONE}}'=>'<input type="text" name="phone" class="first_name">',
            '{{T_HOUR}}' => '<select class="select_country" name="hour"><option value="">'.T_SELECT_HOUR.'</option>'.file_get_contents(PATH_APPLICATION.'hourcallback.htm').'</select>',
            '{{T_DATE}}' => '<input type="text" class="first_name" name="date" id="Rinput"/> <img src="images/calendar.gif" id="Idepart" class="img_calendar"/>',
            '{{T_CONTENT}}'=>'<textarea class="contact_us" rows=" 6" name="ct_content_2"></textarea>',
            '{{T_SUBMIT}}'=>'<input type="submit" value="'.@T_SUBMIT.'" class="input_send"/>',
            '{{T_RESET}}'=>'<input type="reset" value="'.@T_RESET.'" class="reset"/>',
            '{{T_SPAM}}' => '<input type="text" class="ct_spam" name="scode" />',
            '{{I_SPAM}}'=> '<img id="esnc_captcha" src="'.urlBuild(URL_ADMIN.'texttogif.php',array('url'=>URL_ROOT,'rnd'=>rand())).'" /><div id="refresh_captcha" onclick="document.getElementById(\'esnc_captcha\').src=\''.URL_ADMIN.'texttogif.php?url='.URL_ROOT.'&rnd=\'+Math.random();">'.@T_REFRESH_IMAGE.'</div><div class="clear"><span></span></div>',
            );
            echo strtr(@file_get_contents(PATH_APPLICATION.'form-callback.htm'),$tag);
            echo '</form>';
            ?>
            <script language="javascript" type="text/javascript">
                Calendar.setup(
                    {
                        inputField : "Rinput",
                        ifFormat : '%Y-%m-%d',
                        button : "Idepart"
                    }
                )
            </script>
        </div>
</Div>