<Div class="box_hottour_all">
				<div class="padding_hottour" style="padding:5px 0">
					<?php
					$item = productread(@$PDid);
					$name = $item->name;
					echo '<form method="post" action="process.php?act=hotel-book" name="form_contact" onsubmit="return checkBookHotel(this);">';
					$tag = array(
					'{{T_HOTEL_NAME}}'=>$name,
					'{{T_YOUR_NAME}}'=>'<input type="text" class="contact_us"  name="ct_name_2" />',
					'{{T_YOUR_EMAIL}}'=>'<input type="text" class="contact_us" name="ct_email_2" />',
					'{{T_YOUR_COUNTRY}}'=>'<input type="text" name="ct_country" class="contact_us">',
					'{{T_YOUR_CITY}}'=>'<input type="text" class="contact_us" name="ct_city">',
					'{{T_SUBJECT}}'=>'<input type="text" class="contact_us" name="ct_subject" />',
					'{{T_YOUR_PHONE}}'=>'<input type="text" class="contact_us" name="ct_phone"/>',
					'{{T_NUM_ADULT}}'=>'<input value="1"  type="text" class="input_num" name="num_adult" />',
					'{{T_NUM_CHILDREN}}'=>'<input value="0"  class="input_num" type="text" name="num_children" />',
					'{{T_NUM_BABY}}'=>'<input  value="0" type="text" class="input_num" name="num_baby"/>',
					'{{T_ARRIVAL_DATE}}'=>'<input type="text" class="hotel_book_checkin"  name="arriva_date">',
					'{{T_DEPART_DATE}}'=>'<input type="text" class="hotel_book_checkin"  name="depart_date">',
					'{{T_NUM_ROOM}}'=>'<input name="num_room" type="text" class="hotel_book_checkin">',
					'{{T_CONTENT}}'=>'<textarea class="contact_us" rows=" 6" name="ct_content_2"></textarea>',
					'{{T_SPAM}}' => '<input type="text" class="ct_spam" name="scode" />',
					'{{I_SPAM}}'=> '<img id="esnc_captcha" src="'.urlBuild(URL_ADMIN.'texttogif.php',array('url'=>URL_ROOT,'rnd'=>rand())).'" /><div id="refresh_captcha" onclick="document.getElementById(\'esnc_captcha\').src=\''.URL_ADMIN.'texttogif.php?url='.URL_ROOT.'&rnd=\'+Math.random();">'.@T_REFRESH_IMAGE.'</div><div class="clear"><span></span></div>',
					'{{T_SUBMIT}}'=>'<input type="submit" value="'.@T_SUBMIT.'" class="input_send"/>',
					'{{T_RESET}}'=>'<input type="reset" value="'.@T_RESET.'" class="input_send"/>'
					);
					echo strtr(@file_get_contents(PATH_APPLICATION.'form-book-hotel.htm'),$tag);
					echo '<input type="hidden" name="name" value="'.$name.'">';
					echo '</form>';
					?>
				</div>
</Div>