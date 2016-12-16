<?php
require_once('config.php');
require_once(PATH_CLASS.'mailer.php');
require_once(PATH_COMPLS.'esnc_aform.php');
require_once(PATH_COMPLS.'product.php');
require_once(PATH_COMPLS.'user.php');
require_once(PATH_COMPLS.'email.php');
require(PATH_INC.'commonguest.php');
require_once PATH_INC.'session.php';
require(PATH_CLASS.'cache.php');
require(PATH_INC.'dbconguest.php');
require_once PATH_COMPLS.'product-detail.php';
require_once(PATH_CLASS.'sessiondata.php');
require_once('function-add.php');
define('SESSION_COMMIT_OFF',TRUE);
require PATH_CLASS.'customer.php';
# convert array to string include element of array splited by ','
# parameter: arrray
# return: string

$act= @$_GET['act']; 
$header_sales = '';
$header_sales .= 
'User IP: '.@$_SESSION['USip'].'<br>'.
'Connection: '.@$_SERVER['HTTP_CONNECTION'].'<br>'.
'Via: '.@$_SERVER['SERVER_PROTOCOL'].'<br>'.
'Accept: '.@$_SERVER['HTTP_ACCEPT'].'<br>'.
'Accept-Encoding: '.@$_SERVER['HTTP_ACCEPT_ENCODING'].'<br>'.
'Accept-Language: '.@$_SERVER['HTTP_ACCEPT_LANGUAGE'].'<br>'.
'Accept-Charset: '.@$_SERVER['HTTP_ACCEPT_CHARSET'].'<br>'.
'Cookie: '.@$_SERVER['HTTP_COOKIE'].'<br>'.
'Host: '.@$_SERVER['HTTP_HOST'].'<br>'.
'Referer: '.@$_SERVER['HTTP_REFERER'].'<br>'.
'User-Agent: '.@$_SERVER['HTTP_USER_AGENT'].'<br>';

switch($act){
	case 'post-comment':
		if(!checkSubmit()){
			echo '<script>alert("The code is not correct, please review it !");history.go(-1)</script>';
		}else{ 
			require_once PATH_COMPLS.'product-detail.php';
			$PDid = $_POST['PDid'];
			$item = productread($PDid);
			$o = new StdClass; 
			$o->custname = @$_POST['name']; 
			$o->content = @$_POST['content'];
			$o->productid = $PDid;
			reviewAdd($o,$PDid); 
			$tag= array('{{T_URL}}','{{T_HEADER_HTTP}}','{{T_PRODUCT_NAME}}','{{T_NAME}}', '{{T_CONTENT}}');
			$tagvalue= array(urlBuild('tour-detail.php',array('CPname'=>$item->caturlrewrite,'url'=>$item->urlrewrite)),$header_sales,$item->name,@$_POST['name'], @$_POST['content']);
			
			/* email send to admin */
			$mr2= new mailer(PATH_APPLICATION.'email-feedback-tour.htm', $tag, $tagvalue);
			$mr2->sender = EMAIL_CONTACT;
			$mr2->sendername = @$_POST['name'];
			$mr2->from = EMAIL_CONTACT;
			$mr2->recipient= EMAIL_CONTACT;
			if(@EMAIL_CONTACT!=@EMAIL_WEBMASTER) $mr2->cc = @EMAIL_WEBMASTER;
			$mr2->subject= T_EMAIL_FEEDBACK_TOUR;
			$rs = userlist(USER_ALERT_FEEDBACK);
			while($row=mysql_fetch_assoc($rs)) $mr2->recipient .=','.$row['email'];
			$mr2->send();
			echo '<script>alert("'.T_SEND_REVIEW_SUCESS.'");self.close()</script>';
		}
		break;
    case 'contact': 
        if(!checkSubmit()){
        	echo '<script>alert("The code is not correct, please review it !");history.go(-1)</script>';
            //redirect('message.php?act=spam');
        }else{
           $tag= array('{{T_YOUR_EMAIL}}','{{T_YOUR_NAME}}','{{T_YOUR_COUNTRY}}','{{T_YOUR_PHONE}}','{{T_SUBJECT}}','{{T_CONTENT}}','{{SUBMIT_INFO}}');
            $tagvalue= array(@$_POST['ct_email_2'],@$_POST['ct_name_2'],@$_POST['ct_country'],@$_POST['ct_phone'],@$_POST['ct_subject'],nl2br(@$_POST['ct_content_2']),'<br/>'.print_r(getallheaders(), true));
	        $mr= new mailer(PATH_APPLICATION.'email-contact.htm', $tag, $tagvalue);
            $mr->recipient= @$_POST['ct_email_2'];
            $mr->sender =@EMAIL_CONTACT;
            $mr->sendername = @T_SENDNAME;
            $mr->from = @EMAIL_CONTACT;
          	$mr->subject=html_entity_decode(@T_EMAIL_CONTACT_SUBJECT);
            $mr->send(); 
            /* email send to admin */
			array_push($tag,'{{T_HEADER_HTTP}}'); 
			array_push($tagvalue,$header_sales); 
            $mr2= new mailer(PATH_APPLICATION.'email-contact-admin.htm', $tag, $tagvalue);
            $mr2->sender = @$_POST['ct_email_2'];
            $mr2->sendername =@$_POST['ct_name_2'];
            $mr2->from = @EMAIL_CONTACT;
            $mr2->recipient= @EMAIL_CONTACT;
            $mr2->cc = @EMAIL_WEBMASTER;
            $mr2->subject= html_entity_decode(@T_EMAIL_CONTACT_SUBJECT_ADMIN);
            $rs = userlist(USER_ALERT_FEEDBACK);
			while($row=mysql_fetch_assoc($rs)) $mr2->recipient .=','.$row['email'];
           	$mr2->send();
            redirect('message.php?act=contact-ok');
        }
        break;
         case 'callback': 
          if(!checkSubmit()){
        	echo '<script>alert("The code is not correct, please review it !");history.go(-1)</script>';
        }else{
         $gender = $_POST['gender'];
         $firstname = $_POST['first_name'];
         $lastname = $_POST['last_name'];
         $email = $_POST['email'];
         $country = $_POST['country'];
         $code = $_POST['code_country'];
         $date = $_POST['date'];
         $hour = $_POST['hour'];
         $phone = $_POST['phone'];
        if($gender && $firstname && $lastname&&$email&&$country&&$code&&$date&&$hour){
           $tag= array('{{T_YOUR_EMAIL}}','{{T_LAST_NAME}}','{{T_FIRST_NAME}}','{{T_GENDER}}','{{T_CODE_PHONE}}','{{T_YOUR_COUNTRY}}','{{T_YOUR_PHONE}}','{{T_HOUR}}','{{T_DATE}}');
            $tagvalue= array($email,$lastname,$firstname,$gender,$code,$country,$phone,$hour,$date);
	        $mr= new mailer(PATH_APPLICATION.'email-callback.htm', $tag, $tagvalue);
            $mr->recipient= @$_POST['ct_email_2'];
            $mr->sender =@EMAIL_CONTACT;
            $mr->sendername = @T_SENDNAME;
            $mr->from = @EMAIL_CONTACT;
          	$mr->subject=html_entity_decode(@T_EMAIL_CALLBACK_SUBJECT);
            $mr->send(); 
            /* email send to admin */
			array_push($tag,'{{T_HEADER_HTTP}}'); 
			array_push($tagvalue,$header_sales); 
            $mr2= new mailer(PATH_APPLICATION.'email-callback-admin.htm', $tag, $tagvalue);
            $mr2->sender = $email;
            $mr2->sendername =$gender.' '.$firstname.' '.$lastname;
            $mr2->from = @EMAIL_CONTACT;
            $mr2->recipient= @EMAIL_CONTACT;
            $mr2->cc = @EMAIL_WEBMASTER;
            $mr2->subject= html_entity_decode(@T_EMAIL_CALLBACK_SUBJECT_ADMIN);
            $rs = userlist(USER_ALERT_FEEDBACK);
			while($row=mysql_fetch_assoc($rs)) $mr2->recipient .=','.$row['email'];
           	$mr2->send();
            redirect('message.php?act=contact-ok');
        }
        else  redirect(URL_ROOT);
        }
        break;
     case 'testimonial': 
        if(!checkSubmit()){
            echo '<script>alert("The code is not correct, please review it !");history.go(-1)</script>';
        }else{
           $tag= array('{{T_YOUR_EMAIL}}','{{T_YOUR_NAME}}','{{T_YOUR_COUNTRY}}','{{T_YOUR_PHONE}}','{{T_SUBJECT}}','{{T_CONTENT}}','{{SUBMIT_INFO}}');
            $tagvalue= array(@$_POST['ct_email_2'],@$_POST['ct_name_2'],@$_POST['ct_country'],@$_POST['ct_phone'],@$_POST['ct_subject'],nl2br(@$_POST['ct_content_2']),'<br/>'.print_r(getallheaders(), true));
	        $mr= new mailer(PATH_APPLICATION.'email-testimonial.htm', $tag, $tagvalue);
            $mr->recipient= @$_POST['ct_email_2'];
            $mr->sender =@EMAIL_CONTACT;
            $mr->sendername = @T_SENDNAME;
            $mr->from = @EMAIL_CONTACT;
          	$mr->subject=html_entity_decode(@T_EMAIL_TESTIMONIAL_SUBJECT);
            $mr->send(); 
            /* email send to admin */
			array_push($tag,'{{T_HEADER_HTTP}}'); 
			array_push($tagvalue,$header_sales); 
            $mr2= new mailer(PATH_APPLICATION.'email-testimonial-admin.htm', $tag, $tagvalue);
            $mr2->sender = @$_POST['ct_email_2'];
            $mr2->sendername =@$_POST['ct_name_2'];
            $mr2->from = @EMAIL_CONTACT;
            $mr2->recipient= @EMAIL_CONTACT;
            $mr2->cc = @EMAIL_WEBMASTER;
            $mr2->subject= html_entity_decode(@T_EMAIL_TESTIMONIAL_SUBJECT_ADMIN);
            $rs = userlist(USER_ALERT_FEEDBACK);
			while($row=mysql_fetch_assoc($rs)) $mr2->recipient .=','.$row['email'];
           	$mr2->send();
            redirect('message.php?act=testimonial-ok');
        }
        break;
    // service book 
    case 'service-book': 
        if(!checkSubmit()){
            echo '<script>alert("The code is not correct, please review it !");history.go(-1)</script>';
        }else{
            $tag= array('{{T_SERVICE_NAME}}','{{T_YOUR_EMAIL}}','{{T_YOUR_NAME}}','{{T_YOUR_COUNTRY}}','{{T_YOUR_CITY}}','{{T_YOUR_PHONE}}','{{T_SERVICE_START}}','{{T_SUBJECT}}','{{T_CONTENT}}','{{SUBMIT_INFO}}');
            $tagvalue= array(@$_POST['name'],@$_POST['ct_email_2'],@$_POST['ct_name_2'],@$_POST['ct_country'],@$_POST['ct_city'],@$_POST['ct_phone'],@$_POST['departdate'],@$_POST['ct_subject'],nl2br(@$_POST['ct_content_2']),'<br/>'.print_r(getallheaders(), true));
	        $mr= new mailer(PATH_APPLICATION.'email-service-book.htm', $tag, $tagvalue);
            $mr->recipient= @$_POST['ct_email_2'];
            $mr->sender =@EMAIL_SALES;
            $mr->sendername = @T_SENDNAME;
            $mr->from = @EMAIL_SALES;
          	$mr->subject=html_entity_decode(@T_EMAIL_SERVICE_BOOK_SUBJECT);
            $mr->send(); 
            /* email send to admin */
			array_push($tag,'{{T_HEADER_HTTP}}'); 
			array_push($tagvalue,$header_sales); 
            $mr2= new mailer(PATH_APPLICATION.'email-service-book-admin.htm', $tag, $tagvalue);
            $mr2->sender = @$_POST['ct_email_2'];
            $mr2->sendername =@$_POST['ct_name_2'];
            $mr2->from = @EMAIL_SALES;
            $mr2->recipient= @EMAIL_SALES;
            $mr2->cc = @EMAIL_WEBMASTER;
            $mr2->subject= html_entity_decode(@T_EMAIL_SERVICE_BOOK_SUBJECT_ADMIN);
            $rs = userlist(USER_ALERT_ORDER);
			while($row=mysql_fetch_assoc($rs)) $mr2->recipient .=','.$row['email'];
           	$mr2->send();
            redirect('message.php?act=service-book-ok');
        }
        break;
    // book-hotel
     case 'hotel-book':
    	 if(!checkSubmit()){
            echo '<script>alert("The code is not correct, please review it !");history.go(-1)</script>';
        }else{
             $tag= array('{{T_SUBJECT}}','{{T_NUM_ROOM}}','{{T_NUM_BABY}}','{{T_HOTEL_NAME}}','{{T_YOUR_EMAIL}}','{{T_YOUR_NAME}}','{{T_YOUR_COUNTRY}}','{{T_YOUR_CITY}}','{{T_YOUR_PHONE}}','{{T_NUM_ADULT}}','{{T_NUM_CHILDREN}}','{{T_ARRIVAL_DATE}}','{{T_DEPART_DATE}}','{{T_TYPE_HOTEL}}','{{T_CONTENT}}','{{SUBMIT_INFO}}');
            $tagvalue= array(@$_POST['ct_subject'],@$_POST['num_room'],@$_POST['num_baby'],@$_POST['name'],@$_POST['ct_email_2'],@$_POST['ct_name_2'],@$_POST['ct_country'],@$_POST['ct_city'],@$_POST['ct_phone'],@$_POST['num_adult'],@$_POST['num_children'],@$_POST['arriva_date'],@$_POST['depart_date'],@$_POST['hoteltype'],nl2br(@$_POST['ct_content_2']),'<br/>'.print_r(getallheaders(), true));
	        $mr= new mailer(PATH_APPLICATION.'email-hotel-book.htm', $tag, $tagvalue);
            $mr->recipient= @$_POST['ct_email_2'];
            $mr->sender =@EMAIL_SALES;
            $mr->sendername = @T_SENDNAME;
            $mr->from = @EMAIL_SALES;
          	$mr->subject=html_entity_decode(@T_EMAIL_HOTEL_BOOK_SUBJECT);
            $mr->send(); 
            /* email send to admin */
			array_push($tag,'{{T_HEADER_HTTP}}'); 
			array_push($tagvalue,$header_sales); 
            $mr2= new mailer(PATH_APPLICATION.'email-hotel-book-admin.htm', $tag, $tagvalue);
            $mr2->sender = @$_POST['ct_email_2'];
            $mr2->sendername =@$_POST['ct_name_2'];
            $mr2->from = @EMAIL_SALES;
            $mr2->recipient= @EMAIL_SALES;
            $mr2->cc = @EMAIL_WEBMASTER;
            $mr2->subject= html_entity_decode(@T_EMAIL_HOTEL_BOOK_SUBJECT_ADMIN);
            $rs = userlist(USER_ALERT_ORDER);
			while($row=mysql_fetch_assoc($rs)) $mr2->recipient .=','.$row['email'];
           	$mr2->send();
            redirect('message.php?act=hotel-book-ok');
        }
        break;
    // book-hotel
     case 'tour-book':
    	 if(!checkSubmit()){
            echo '<script>alert("The code is not correct, please review it !");history.go(-1)</script>';
        }else{
            $tag= array('{{T_NUM_BABY}}','{{T_TOUR_NAME}}','{{T_YOUR_EMAIL}}','{{T_YOUR_NAME}}','{{T_YOUR_COUNTRY}}','{{T_YOUR_CITY}}','{{T_YOUR_PHONE}}','{{T_NUM_ADULT}}','{{T_NUM_CHILDREN}}','{{T_TOUR_START}}','{{T_DURATION_TOUR}}','{{T_TYPE_HOTEL}}','{{T_SUBJECT}}','{{T_CONTENT}}','{{SUBMIT_INFO}}');
            $tagvalue= array(@$_POST['num_baby'],@$_POST['name'],@$_POST['ct_email_2'],@$_POST['ct_name_2'],@$_POST['ct_country'],@$_POST['ct_city'],@$_POST['ct_phone'],@$_POST['num_adult'],@$_POST['num_children'],@$_POST['departdate'],@$_POST['duration'],@$_POST['star_hotel'],@$_POST['ct_subject'],nl2br(@$_POST['ct_content_2']),'<br/>'.print_r(getallheaders(), true));
	        $mr= new mailer(PATH_APPLICATION.'email-tour-book.htm', $tag, $tagvalue);
            $mr->recipient= @$_POST['ct_email_2'];
            $mr->sender =@EMAIL_SALES;
            $mr->sendername = @T_SENDNAME;
            $mr->from = @EMAIL_SALES;
          	$mr->subject=html_entity_decode(@T_EMAIL_TOUR_BOOK_SUBJECT);
            $mr->send(); 
            /* email send to admin */
			array_push($tag,'{{T_HEADER_HTTP}}'); 
			array_push($tagvalue,$header_sales); 
            $mr2= new mailer(PATH_APPLICATION.'email-tour-book-admin.htm', $tag, $tagvalue);
            $mr2->sender = @$_POST['ct_email_2'];
            $mr2->sendername =@$_POST['ct_name_2'];
            $mr2->from = @EMAIL_SALES;
            $mr2->recipient= @EMAIL_SALES;
            $mr2->cc = @EMAIL_WEBMASTER;
            $mr2->subject= html_entity_decode(@T_EMAIL_TOUR_BOOK_SUBJECT_ADMIN);
            $rs = userlist(USER_ALERT_ORDER);
			while($row=mysql_fetch_assoc($rs)) $mr2->recipient .=','.$row['email'];
           	$mr2->send();
            redirect('message.php?act=tour-book-ok');
        }
        break;
	// book-resort
    case 'tour-customize': 
    	 if(!checkSubmit()){
            echo '<script>alert("The code is not correct, please review it !");history.go(-1)</script>';
        }else{
            $tag= array('{{T_NUM_BABY}}','{{T_YOUR_EMAIL}}','{{T_YOUR_NAME}}','{{T_YOUR_COUNTRY}}','{{T_YOUR_CITY}}','{{T_YOUR_PHONE}}','{{T_NUM_ADULT}}','{{T_NUM_CHILDREN}}','{{T_TOUR_START}}','{{T_DURATION_TOUR}}','{{T_TYPE_HOTEL}}','{{T_SUBJECT}}','{{T_CONTENT}}','{{SUBMIT_INFO}}');
            $tagvalue= array(@$_POST['num_baby'],@$_POST['ct_email_2'],@$_POST['ct_name_2'],@$_POST['ct_country'],@$_POST['ct_city'],@$_POST['ct_phone'],@$_POST['num_adult'],@$_POST['num_children'],@$_POST['departdate'],@$_POST['duration'],@$_POST['star_hotel'],@$_POST['ct_subject'],nl2br(@$_POST['ct_content_2']),'<br/>'.print_r(getallheaders(), true));
	        $mr= new mailer(PATH_APPLICATION.'email-tour-customize.htm', $tag, $tagvalue);
			
            $mr->recipient= @$_POST['ct_email_2'];
			$mr->from = @EMAIL_CONTACT;
            $mr->sender =@EMAIL_SALES;
            $mr->sendername = @T_SENDNAME;
          	$mr->subject=html_entity_decode(@T_EMAIL_TOUR_CUSTOMIZE_SUBJECT);
            $mr->send(); 
            /* email send to admin */
			array_push($tag,'{{T_HEADER_HTTP}}');
			array_push($tagvalue,$header_sales); 
            $mr2= new mailer(PATH_APPLICATION.'email-tour-customize-admin.htm', $tag, $tagvalue);
            $mr2->sender = @$_POST['ct_email_2'];
            $mr2->sendername =@$_POST['ct_name_2'];
            $mr2->from = EMAIL_SALES;
            $mr2->recipient= @EMAIL_SALES;
            $mr2->cc = @EMAIL_WEBMASTER;
            $mr2->subject= html_entity_decode(@T_EMAIL_TOUR_CUSTOMIZE_SUBJECT_ADMIN);
            $rs = userlist(USER_ALERT_ORDER);
			while($row=mysql_fetch_assoc($rs)) $mr2->recipient .=','.$row['email'];
           	$mr2->send();
            redirect('message.php?act=tour-customize-ok');
        }
    	break;
	 case 'send-email':
    	$href = $_POST['link'];
    	if(!checkSubmit()){
    		echo '<script>alert("The code is not correct, please review it !");history.go(-1)</script>';
    	}else{
			$tag=array('{{LINK}}','{{YOUR_NAME}}','{{EMAIL_TO}}','{{EMAIL_CC}}','{{CONTENT}}','{{SUBMIT_INFO}}');
			$tagvalue=array($href,$_POST['your-name'],$_POST['send_email_1'],$_POST['send_email_cc'],$_POST['ct_content_2'],"\r\n".print_r(getallheaders(),TRUE));
			
			$tag2=array('{{LINK}}','{{NAME}}','{{FROM_EMAIL}}','{{CONTENT}}','{{SUBMIT_INFO}}');
			$tagvalue2=array($href,$_POST['your-name'],$_POST['send_email_2'],$_POST['ct_content_2'],"\r\n".print_r(getallheaders(),TRUE));
			
			$mr = new mailer(PATH_APPLICATION.'email-send-mail-from.htm',$tag,$tagvalue);
			$mr->recipient=$_POST['send_email_2'];
			$mr->sender = @EMAIL_CONTACT;
			$mr->subject=@T_MAIL_SEND_LINK_FROM;
			$mr->cc = @EMAIL_CONTACT;
			$mr->send();
			
			$mr1 = new mailer(PATH_APPLICATION.'email-send-mail-to.htm',$tag2,$tagvalue2);
			$mr1->recipient=$_POST['send_email_1'];
			$mr1->sender = @EMAIL_CONTACT;
			$mr1->subject=@T_MAIL_SEND_LINK_TO;
			if($_POST['send_email_cc']) $mr1->cc = $_POST['send_email_cc'];
			$mr1->send();
			redirect('send-email.php?act=send-email-ok');
    	}
    	break;
   
	}
	
?>
