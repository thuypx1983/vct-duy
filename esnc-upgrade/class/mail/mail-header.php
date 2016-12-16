<?php 
$mail_header=
'Reply-to: {{MAIL_SENDER}}
From: {{MAIL_FROM}}
MIME-Version: 1.0
Content-Base: {{MAIL_CONTENT_BASE}}
Content-Location: {{MAIL_CONTENT_BASE}}
Content-Type: {{MAIL_MIME}}
Content-Transfer-Encoding: {{MAIL_ENCODING}}
Date: {{MAIL_DATE}}
X-Priority: 3
X-MSMail-Priority: {{MAIL_IMPORTANCE}}
Cc:{{MAIL_CC}}
Bcc:{{MAIL_BCC}}

';?>