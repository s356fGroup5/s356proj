<link href="demo-style.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php
require_once('dbConnect.php');
//check exist value
$emails = $_GET["email"];
$code = $_GET["forgot_pwd_codes"];
if ($emails == '' || $code == '')
    header("refresh:0;url=./index.php");

$sql = "Select * from user Where email = '$emails' And forgot_pwd_code = '$code'"; //reset by correct code only
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0)
    header("refresh:0;url=./index.php");

// cheking code and reset pwd
if (isset($_POST["reset-password"])) {
    //$conn = mysqli_connect("localhost", "root", "", "db");
    $sql = "UPDATE `ouhks356_db`.`user` SET `password` = '" . $_POST["member_password"] . "' WHERE `user`.`email` = '" . $_GET["email"] . "' AND `user`.`forgot_pwd_code` = '" . $_GET["forgot_pwd_codes"] . "';";
    $result = mysqli_query($conn, $sql);
    $sql = "UPDATE `user` SET `forgot_pwd_code`='' WHERE `email` = '" . $_GET["email"] . "';";
    $result = mysqli_query($conn, $sql);
    $success_message = "Password is reset successfully. <br> Redirecting to login page.";
    header("refresh:3;url=./login.php");
}
?>
<link href="demo-style.css" rel="stylesheet" type="text/css">
<script>
    function validate_password_reset() {
        if ((document.getElementById("member_password").value == "") && (document.getElementById("confirm_password").value == "")) {
            document.getElementById("validation-message").innerHTML = "Please enter new password!";
            return false;
        }
        if (document.getElementById("member_password").value != document.getElementById("confirm_password").value) {
            document.getElementById("validation-message").innerHTML = "Both password should be same!";
            return false;
        }

        return true;
    }
</script>


<form method="post" onSubmit="return validate_password_reset();">
    <div class="container">
        <h1>Reset Password</h1><br>
        <?php if (!empty($success_message)) { ?>
            <div class="success_message"><?php echo $success_message; ?></div>
        <?php } ?>

        <div id="validation-message">
            <?php if (!empty($error_message)) { ?>
                <?php echo $error_message; ?>
            <?php } ?>
        </div>
        <div class="panel">

            <br>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">New Password</span>
                <input type="password" class="form-control" name="member_password" id="member_password">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Confirm Password</span>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password">
            </div>
            <br>
            <button type="submit" ntype="submit" name="reset-password" id="reset-password" value="Reset Password"
                    class="btn btn-secondary">Submit
            </button>
        </div>
    </div>
</form>
