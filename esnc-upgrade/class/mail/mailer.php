<?php
ini_set("include_path", ".:/home/hotel84/domains/hotel84.com/public_html/");
require_once("system/class/mail/class.phpmailer.php");
class mailer{

	var $sender,$recipient,	$cc,$bcc,$importance,$location,$base,$subject,$mime,$body,$sendername;

	function mailer($file=NULL,&$tag=NULL,&$tagvalue=NULL){

		if($this->body=@file_get_contents($file)){

			if(is_array($tag)){

				if(is_array($tagvalue)){

					$tag[]='{{URL_BASE}}';

					$tagvalue[]=URL_BASE;

					$this->body=str_replace($tag,$tagvalue,$this->body);

				}else{

					$tag['{{URL_BASE}}']=URL_BASE;

					$this->body = strtr($this->body,$tag);

				}

			}

			$this->getheader($this->body);

		}

		else{

			$this->sender=EMAIL_WEBMASTER;

			$this->recipient=EMAIL_CONTACT;

			$this->cc='';

			$this->bcc='';

			$this->importance='Normal';

			$this->location='';

			$this->base=URL_BASE;

			$this->mime=EMAIL_MIME_DEFAULT;

			$this->encoding='8bit';

		}

	}

	function alert($msg,$carrier=1){

		

	}

	function send($alert=0,$proto=0){
		@define('EMAIL_WEBMASTER',ini_get('sendmail_from'));

		$sendmail_domain=substr(EMAIL_WEBMASTER,strpos(EMAIL_WEBMASTER,'@'));

		$re = preg_quote($sendmail_domain,'/');

		$sendmail_from= $this->sender ? $this->sender: EMAIL_WEBMASTER;

		ini_set('sendmail_from',$sendmail_from);

		$this->from='"'.($this->sendername ? $this->sendername : $this->sender).'"<'.$sendmail_from.'>';

		if($alert){

			require_once PATH_COMPLS.'user.php';

			$rs = userlist($alert);

			$a=array();

			while($row=mysql_fetch_assoc($rs)) $a[]=$row['email'];

			if(count($a) > 0){

				if($this->cc) $this->cc .= ','.implode(',',$a);

				else $this->cc = implode(',',$a);

			}

			mysql_free_result($rs);

		}
	
		include PATH_CLASS.'mail-header.php';//the mail-header.php needs to be transferred in ascii mode in some poor UNIX system. Normally it should be transferred in binary mode

		$tag=array(

			'{{MAIL_SENDER}}'=>$this->sender,

			'{{MAIL_FROM}}'=> $this->from,

			'{{MAIL_CONTENT_BASE}}'=>URL_BASE,

			'{{MAIL_MIME}}'=>$this->mime,

			'{{MAIL_ENCODING}}'=>$this->encoding,

			'{{MAIL_DATE}}'=>date('r'),

			'{{MAIL_IMPORTANCE}}'=>$this->importance,

			'{{MAIL_CC}}'=>$this->cc,

			'{{MAIL_BCC}}'=>$this->bcc,

		);

        $this->header=strtr($mail_header,$tag);
		$mailer = new PHPMailer(true);
		$mailer->IsSMTP();
		$mailer->Host ='smtp.gmail.com';
		$mailer->SMTPAuth = true;
		$mailer->SMTPSecure = "tls";   
		$mailer->Port       = 587; 
		$mailer->Username = 'hnvn2222@gmail.com';
		$mailer->Password = 'lAgnMM8668Sm';

		if($this->sendername) $mailer->FromName = $this->sendername;
		if($this->sender) $mailer->From = $this->sender;
		$mailer->AddAddress($this->recipient);
		if($this->cc) $mailer->AddCC($this->cc);
		if($this->subject) $mailer->Subject = $this->subject;
		
		$mailer->IsHTML(true);
		$mailer->Body = $this->body;
		$mailer->Send();		
		return TRUE;

 	}

	function getheader(&$s){//support to fetch header (CC,BCC,Subject,From from a file

//		return;

		$er=error_reporting(E_ALL & ~E_NOTICE);

		getmeta($s,$title,$base,$m);

		$this->sender=$m['from'] ? $m['from']: $m['reply-to']? $m['reply-to']:EMAIL_WEBMASTER;

		$this->recipient = $m['to'];

		$this->cc = $m['cc'];

		$this->bcc = $m['bcc'];

		$this->subject=($title ? $title: $m['subject']);

		$this->importance=$m['importance'] ? $m['importance']:'Normal';

		$this->location = $m['location'];

		$this->mime=$m['mime'] ? $m['mime']:($m['content-type'] ? $m['content-type']: EMAIL_MIME_DEFAULT);

		$this->encoding=$m['encoding'] ? $m['encoding']:'8bit';

		$this->base = $m['base'] ? $m['base']:URL_BASE;

		error_reporting($er);

	}

}

?>

