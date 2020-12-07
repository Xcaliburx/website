<?php
// require_once 'PHPMailer/class.php';
 require_once 'PHPMailer/PHPMailerAutoload.php';


// Fetching data that is entered by the user
$from = "storejust51@gmail.com";
$password = "Juzt5123";
// Configuring SMTP server settings
date_default_timezone_set('Etc/UTC');
$mail = new PHPMailer(); 
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->SMTPKeepAlive = true;   
$mail->Mailer = "smtp"; // don't change the quotes!
$mail->isSMTP();
$mail->Host =gethostbyname('ssl://smtp.gmail.com');
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true;
$mail->Username = $from;
$mail->Password = $password;
$mail->FromName = "JustStore";
$mail->CharSet = 'UTF-8';
$mail->isHTML(true);

// Email Sending Details
$mail->addAddress($email);
$mail->Subject = 'Email Verification';
$mail->Body = '
    <div style="background-color:#D9E4DD;">
    <h1 style="font-size: 48px;color: #0D3081;text-align:center">Online Learning</h1>
    <div style="border: 2px solid #000000;width: 500px;text-align: center;background-color: #ffffff;padding: 1em 1em 2em 1em; margin:auto;">
        <p>Hi! kamu baru saja mendaftar <b>Online Learning</b> akun.</p>
        <p>Mohon luangkan waktu sejenak untuk memverifikasi bahwa ini adalah email Anda.</p>
        <a href="http://localhost/Online_Learning-master/verify.php?email='.$email.'&hash='.$hash.'" style="border-radius: 5px;background-color: #0D3081;padding: .5em 1em;border: 0;color: #ffffff;margin: .8em 0;cursor: pointer;text-decoration: none;">Verify My Email Address</a>
        <p>Jika Anda tidak membuat akun menggunakan email ini, harap abaikan email ini.</p>
        <p class="regards">Hormat kami,</p>
        <p><b>Online Learning Team</b></p>
    </div>
    <p style="margin-top: 1.5em;text-align:center;">© 2020 <span style="color: #0D3081;">Online Learning</span></p>
    </div>
    ';
// Success or Failure
if (!$mail->send()) {
$error = "Mailer Error: " . $mail->ErrorInfo;
echo '<p>'.$error.'</p>';
}
?>