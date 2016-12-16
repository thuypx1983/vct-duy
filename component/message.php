
<style>
div.b_about_us{
	min-height: 300px;
}
</style>
<div class="box-whyus">
    <div class="box-title">
        <div class="box-outer-2 box-right">
<?php
$act= @$_GET['act']; 
switch($act){
    case 'spam':
        @readfile(PATH_APPLICATION.'msg-spam.htm');
    break;
	case 'nolinkback':
		@readfile(PATH_APPLICATION.'msg-nolinkback.htm');   
		break;	
	case 'thanklinkex':
		@readfile(PATH_APPLICATION.'msg-thanklinkex.htm');   
		break;	
	case 'errorlinkex':
		@readfile(PATH_APPLICATION.'msg-errorlinkex.htm');   
		break;	
	case 'duplicatelinkex':
		@readfile(PATH_APPLICATION.'msg-duplicatelinkex.htm');   
		break;	
	case 'contact-ok':
		@readfile(PATH_APPLICATION.'msg-contact-ok.htm');  
		break;
	case 'testimonial-ok':
		@readfile(PATH_APPLICATION.'msg-testimonial-ok.htm');
		break;
	case 'send-link-ok':
		@readfile(PATH_APPLICATION.'msg-send-link-ok.htm');  
		break; 
	case 'tour-customize-ok':
		@readfile(PATH_APPLICATION.'msg-tour-customize-ok.htm');  
		break;
	case 'tour-book-ok':
		@readfile(PATH_APPLICATION.'msg-tour-book-ok.htm');  
		break;
	case 'hotel-book-ok':
		@readfile(PATH_APPLICATION.'msg-hotel-book-ok.htm');
		break;
	case 'ticket-book-ok':
		@readfile(PATH_APPLICATION.'msg-ticket-book-ok.htm');
		break;
	case 'cruise-book-ok':
		@readfile(PATH_APPLICATION.'msg-cruise-book-ok.htm');
		break;
	case 'service-book-ok':
		@readfile(PATH_APPLICATION.'msg-service-book-ok.htm');
		break;
    default:
        echo '<div>What does it mean?</div>';
    	break;
}
?>
</div></div>
    </div>