<div class="breadcrumbs clearfix">
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <a  href="<?php echo URL_BASE ?>" itemprop="url">
            <span itemprop="title"><?php echo @T_HOME ?></span>
        </a>
    </div>
    <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
        <span itemprop="title"><?php echo T_TOUR_CUSTOMIZE?></span>
    </div>
</div>
<div class="box-title">
    <div class="box-outer-2 box-right">
					<?php
					echo '<form method="post" action="process.php?act=tour-customize" name="form_contact" onsubmit="return checkContactForm_4(this);">';
					$tag = array(
					'{{T_YOUR_NAME}}'=>'<input type="text" class="contact_us"  name="ct_name_2" />',
					'{{T_YOUR_EMAIL}}'=>'<input type="text" class="contact_us" name="ct_email_2" />',
					'{{T_YOUR_COUNTRY}}'=>'<input type="text" class="contact_us" name="ct_country">',
					'{{T_YOUR_CITY}}'=>'<input type="text" class="contact_us" name="ct_city">',
					'{{T_YOUR_PHONE}}'=>'<input type="text" class="contact_us" name="ct_phone"/>',
					'{{T_NUM_ADULT}}'=>'<input value=""  type="text" class="input_num" name="num_adult" placeholder="0"/>',
					'{{T_NUM_CHILDREN}}'=>'<input value=""  class="input_num" type="text" name="num_children" placeholder="0"/>',
					'{{T_NUM_BABY}}'=>'<input  value="" type="text" class="input_num" name="num_baby" placeholder="0"/>',
					'{{T_TOUR_START}}' => '<input type="text" class="contact_us" name="departdate">',
					'{{T_DURATION_TOUR}}'=>'<input type="text" class="contact_us" name="duration">',
					'{{T_STAR_HOTEL}}'=>'<select class="contact_us" name="star_hotel">'.@file_get_contents(PATH_APPLICATION.'hotelstar.htm').'</select>',
					'{{T_SUBJECT}}'=>'<input type="text" class="contact_us" name="ct_subject" />',
					'{{T_CONTENT}}'=>'<textarea class="contact_us" rows=" 6" name="ct_content_2"></textarea>',
					'{{T_SPAM}}' => '<input type="text" class="ct_spam" name="scode" />',
					'{{I_SPAM}}'=> '<img id="esnc_captcha" src="'.urlBuild(URL_ADMIN.'texttogif.php',array('url'=>URL_ROOT,'rnd'=>rand())).'" /><div id="refresh_captcha" onclick="document.getElementById(\'esnc_captcha\').src=\''.URL_ADMIN.'texttogif.php?url='.URL_ROOT.'&rnd=\'+Math.random();">'.@T_REFRESH_IMAGE.'</div><div class="clear"><span></span></div>',
					'{{T_SUBMIT}}'=>'<input type="submit" value="'.@T_SUBMIT.'" class="input_send"/>',
					'{{T_RESET}}'=>'<input type="reset" value="'.@T_RESET.'" class="input_send"/>'
					);
					echo strtr(@file_get_contents(PATH_APPLICATION.'form-tour-customize.htm'),$tag);
					echo '</form>';
					?>
				</div>

</Div>