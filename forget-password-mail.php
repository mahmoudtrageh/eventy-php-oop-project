<?php
    
require_once 'vendor/autoload.php';
define("PROJECT_NAME", 'http://localhost/eventy/');
$mail = new PHPMailer\PHPMailer\PHPMailer;
$mail->SMTPDebug = 0;
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = "geo.mahmoudtaha@gmail.com";
$mail->Password = "Ra2311996";
$mail->SMPTSecure = "tls";
$mail->Port = 587;
$mail->SetFrom ("geo.mahmoudtaha@gmail.com");
$mail->FromName = "Mahmoud Taha";
$mail->addAddress($_POST['user-mail']);
$mail->isHTML(true);

$mail->Subject = "Forget password Recover";

$mail->Body="<div>" . $user[0]["firstname"]."<br><br><p>Click here to recover your password<br><a href='" .PROJECT_NAME."resetPassword.php?name=".$user[0]["firstname"]."'>".PROJECT_NAME."resetPassword.php?name=".$user[0]['firstname']."</a><br><br></p>Regards<br>Admin.</div>";

if(!$mail->send()) {
    $error_message = "Mailer Error : ". $mail->ErrorInfo; 
} else {
    $success_message = "تم إرسال رسالة التعديل، من فضلك تصفح بريدك";
}

?>