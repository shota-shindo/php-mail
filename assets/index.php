<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>PHPMailer Test</title>
</head>

<body>
    <form action="" method="POST">
        <h1>PHPMailer Test</h1>
        <p>お名前: <input type="text" name="name"></p>
        <p>お問い合わせ内容:</p>
        <textarea name="contact-msg" id="" cols="30" rows="10"></textarea>
        <p>メールアドレス: <input type="text" name="email"></p>
        <p><button type="submit">送信</button></p>
    </form>
</body>

</html>

<?php include('mail_form/mail.php'); ?>