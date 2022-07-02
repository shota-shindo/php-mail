<!-- 
    現在は未使用
    設定値を分離したい場合に使用
 -->
<?php
//SMTP サーバー（サーバーの場合：localhost でも可）
define('MAIL_HOST', 'mail.xxxxxx.com');
 
//PHPMailer を使って送信するための E-mail アカウント
define('MAIL_USER', 'xxxxx@xxxxxxx.com');
  
//パスワード
define('MAIL_PASSWORD', '1234');
 
//送信先
define('SEND_TO', 'xxxx@gmail.com');
 
//送信先の名前
define('SEND_TO_NAME', '翔太');
 
//Bcc アドレス
define('BCC', 'xxxx@xxxxxx.com');
 
//自動返信をする場合の送信元アドレス
define('AR_SEND_FROM', 'xxxx@xxxxxxxx.com');
 
//自動返信をする場合の送信元名前
define('AR_SEND_FROM_NAME', '自動返信送信元名前');
?>