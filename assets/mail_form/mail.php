<!-- 
ローカルホストでは、GoogleがプライベートIP（local-ip）を弾くため、
ローカルDNSかリモートサーバーに置かないと作動しない様子。
 -->

<?php
require_once("../../vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

$phpmailer = new PHPMailer();

$name = trim(filter_input(INPUT_POST, 'name'));
$email = trim(filter_input(INPUT_POST, 'email'));
$contact_msg = trim(filter_input(INPUT_POST, "contact-msg"));

// クライアント ID
$CLIENT_ID = "19369194961-3vcvdbabd7jm4sqm9uk7e27lv7i5ibgd.apps.googleusercontent.com";
// クライアント シークレット
$CLIENT_SECRET = "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";
// リフレッシュトークン
$REFRESH_TOKEN = "1//04Lr1MYvYH5-ZCgYIARAAGAQSNwF-L9IrKpLpUtxTe-JnEx27ZGqtexg-uVDeuG6dfh_BI_zQ7Qd7awyfSPKODg9Jw9bzY6as0CU";
// メールアドレス
$USER_NAME = 'sshota12332@gmail.com';

if (isset($_POST["submitted"])) {
    //エラーメッセージを保存する配列の初期化
    $error = array();
    //値の検証
    if ($name == '') {
        $error['name'] = '*お名前は必須項目です。';
    //制御文字でないことと文字数をチェック
    } elseif (preg_match('/\A[[:^cntrl:]]{1,30}\z/u', $name) == 0) {
        $error['name'] = '*お名前は30文字以内でお願いします。';
    }
    if ($email == '') {
        $error['email'] = '*メールアドレスは必須です。';
    } else { //メールアドレスを正規表現でチェック
        $pattern = '/\A([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}\z/uiD';
        if (!preg_match($pattern, $email)) {
            $error['email'] = '*メールアドレスの形式が正しくありません。';
        }
    }

    try {
        //サーバの設定
        $phpmailer->SMTPDebug = SMTP::DEBUG_SERVER;  // デバグの出力を有効に（テスト環境での検証用）
        $phpmailer->isSMTP();   // SMTP を使用
        $phpmailer->SMTPAuth   = true;
        $phpmailer->Host       = 'smtp.gmail.com';
        $phpmailer->Username   = $USER_NAME;
        // $phpmailer->Password   = '1234';
        $phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $phpmailer->Port       = 587;
        $phpmailer->CharSet = 'utf-8';
        $phpmailer->Subject = "test mail";
        $phpmailer->AuthType = "XOAUTH2";
        $phpmailer->Encoding = "base64";

        $provider = new Google(
            [
                'clientId' => $CLIENT_ID,
                'clientSecret' => $CLIENT_SECRET,
            ]
        );
        //Pass the OAuth provider instance to PHPMailer
        $phpmailer->setOAuth(
            new OAuth(
                [
                    'provider' => $provider,
                    'clientId' => $CLIENT_ID,
                    'clientSecret' => $CLIENT_SECRET,
                    'refreshToken' => $REFRESH_TOKEN,
                    'userName' => $USER_NAME,
                ]
            )
        );
        $from = $email;
        //差出人アドレス, 差出人名
        $phpmailer->setFrom($from , "customer");

        //受信者アドレス, 受信者名（受信者名はオプション）
        $phpmailer->addAddress($USER_NAME, "me");
        //追加の受信者（受信者名は省略可能なのでここでは省略）
        // $phpmailer->addAddress('someone@gmail.com');
        //返信用アドレス（差出人以外に別途指定する場合）
        // $phpmailer->addReplyTo('info@example.com', mb_encode_mimeheader("お問い合わせ"));
        //Cc 受信者の指定
        $phpmailer->addCC($USER_NAME);
   
        $phpmailer->Body = $contact_msg; 

        // print_r(isset($_POST["submitted"]));

        // $phpmailer->addAddress("");
        $phpmailer->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        //エラー（例外：Exception）が発生した場合
        echo "Message could not be sent. Mailer Error", $phpmail->ErrorInfo.PHP_EOL;
    }
}
?>

<!-- 
<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>PHPMailer Test</title>
</head>

<body>
    <p>
    </p>
    <form  method="POST">
        <h1>PHPMailer Test</h1>
        <p>お名前: <input type="text" name="name"></p>
        <p>お問い合わせ内容:</p>
        <textarea name="contact-msg" id="" cols="30" rows="10"></textarea>
        <p>メールアドレス: <input type="text" name="email"></p>
        <p><button name="submitted" type="submit">送信</button></p>
    </form>
</body>

</html> -->