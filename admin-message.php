<?php
if (!class_exists('PHPMailer')) {
    require('phpmailer/class.phpmailer.php');
    require('phpmailer/class.smtp.php');
}

require_once("mail_configuration.php");


$mail = new PHPMailer();

$emailBody = "<div>" . "Hi," . $_POST["username"] . ",<br><br><p>" . $_POST["content"] . "<br><br></p>Regards,<br> Admin.</div>";

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
$mail->AddAddress($_POST["to"]);
$mail->Subject = $_POST["subject"];
$mail->MsgHTML($emailBody);
$mail->IsHTML(true);
?>

<html>
<head>
    <title>Admin Homepage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Admin Homepage</h1><br>
    <div class="panel">

        <br>

        <?php
        if (!$mail->Send()) {
            echo '<div class="alert alert-danger"><strong>Error! </strong></div>';
            header("refresh:3;url=./admin.php?action=manageuser");
        } else {
            echo '<div class="alert alert-success"><strong>Success! </strong></div>';
            header("refresh:3;url=./admin.php?action=manageuser");
        }

        ?>
    </div>
</div>
</body>
</html>
