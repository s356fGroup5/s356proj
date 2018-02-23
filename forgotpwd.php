<?php
if (!empty($_POST["forgot-password"])) {
    //$conn = mysqli_connect("localhost", "root", "", "db");
    require_once('dbConnect.php');
    $condition = "";

    if (!empty($_POST["user-email"])) {
        if (!empty($condition)) {
            $condition = " and ";
        }
        $condition = " email = '" . $_POST["user-email"] . "'";
    }

    if (!empty($condition)) {
        $condition = " where " . $condition;
    }

    $sql = "Select * from user " . $condition;
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result);

    if (!empty($user)) {
        $forgot_pwd_codes = rand(10000, 99999);
        $sql = "UPDATE `user` SET `forgot_pwd_code`=" . $forgot_pwd_codes . $condition;
        $result = mysqli_query($conn, $sql);
        require_once("forgot-password-recovery-mail.php");
    } else {
        $error_message = 'No User Found';
    }
}
?>
<link href="demo-style.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    function validate_forgot() {
        if ((document.getElementById("user-email").value == "")) {
            document.getElementById("validation-message").innerHTML = "Login Email is required!";
            return false;
        }
        return true
    }
</script>


<!-- <form name="frmForgot" id="frmForgot" method="post" onSubmit="return validate_forgot();">
<h1>Forgot Password?</h1>
	<?php if (!empty($success_message)) { ?>
	<div class="success_message"><?php echo $success_message; ?></div>
	<?php } ?>

	<div id="validation-message">
		<?php if (!empty($error_message)) { ?>
	<?php echo $error_message; ?>
	<?php } ?>
	</div>
	
	<div class="field-group">
		<div><label for="email">Email</label></div>
		<div><input type="text" name="user-email" id="user-email" class="input-field"></div>
	</div>
	
	<div class="field-group">
		<div><input type="submit" name="forgot-password" id="forgot-password" value="Submit" class="form-submit-button"></div>
	</div>	
</form> -->

<form method="post" onSubmit="return validate_forgot();">
    <div class="container">
        <h1>Forgot Password?</h1><br>
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
                <span class="input-group-addon" id="basic-addon1">@</span>
                <input type="text" class="form-control" placeholder="Email Address" aria-describedby="basic-addon1"
                       name="user-email" id="user-email">
            </div>
            <br>
            <button type="submit" name="forgot-password" id="forgot-password" value="Submit" class="btn btn-secondary">
                Submit
            </button>
        </div>
    </div>
</form>