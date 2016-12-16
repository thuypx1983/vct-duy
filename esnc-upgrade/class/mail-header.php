<?php 
$mail_header=
'Reply-to: {{MAIL_SENDER}}\r\n
From: {{MAIL_FROM}}\r\n
MIME-Version: 1.0\r\n
Content-Base: {{MAIL_CONTENT_BASE}}\r\n
Content-Location: {{MAIL_CONTENT_BASE}}\r\n
Content-Type: {{MAIL_MIME}}\r\n
Content-Transfer-Encoding: {{MAIL_ENCODING}}\r\n
Date: {{MAIL_DATE}}\r\n
X-Priority: 3\r\n
X-MSMail-Priority: {{MAIL_IMPORTANCE}}\r\n
Bcc:{{MAIL_BCC}}\r\n';?>