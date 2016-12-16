<html>
<head>
<title>POP before SMTP Test</title>
</head>
<body>

<?php
ini_set("include_path", ".:/var/www/vhosts/backup.webteam.vn/httpdocs/");
require("class.phpmailer.php");
require("class.pop3.php"); // required for POP before SMTP

$pop = new POP3();
$pop->Authorise('localhost', 110, 30, 'vdc@backup.webteam.vn', 'vungoimora', 1);

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP();

try {
  $mail->SMTPDebug = 2;
  $mail->Host     = 'localhost';
  $mail->AddAddress('lowhigh46@gmail.com', 'Nguyen Quang Huy');
  $mail->FromName = 'May 123.30.182.66';
  $mail->From='vdc@backup.admin';
  $mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
  $mail->Body = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
?>

</body>
</html>
