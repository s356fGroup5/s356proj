<?php
if (!class_exists('PHPMailer')) {
    require('phpmailer/class.phpmailer.php');
    require('phpmailer/class.smtp.php');
}

require_once("mail_configuration.php");


$mail = new PHPMailer();

$emailBody = "<div>" . "Hi," . $user["username"] . ",<br><br><p>Click this link to recover your password<br><a href='" . PROJECT_HOME . "reset_password.php?email=" . $user["email"] . "&forgot_pwd_codes=" . $forgot_pwd_codes . "'>" . PROJECT_HOME . "reset_password.php?email=" . $user["email"] . "&forgot_pwd_codes=" . $forgot_pwd_codes . "</a><br><br></p>Regards,<br> Admin.</div>";

$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port = 587;
$mail->Username = "ouhks356f@gmail.com";
$mail->Password = "ouhks356f123";
$mail->Host = "smtp.gmail.com";
$mail->Mailer = "smtp";

$mail->SetFrom("ouhks356f@gmail.com", "OUHKS356F");
$mail->AddReplyTo("ouhks356f@gmail.com", "OUHKS356F");
$mail->ReturnPath = "ouhks356f@gmail.com";
$mail->AddAddress($user["email"]);
$mail->Subject = "Forgot Password Recovery";
$mail->MsgHTML($emailBody);
$mail->IsHTML(true);

if (!$mail->Send()) {
    $error_message = 'Problem in Sending Password Recovery Email';
} else {
    $success_message = 'Please check your email to reset password!';
}

?>
