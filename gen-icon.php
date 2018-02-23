<?php include('header.php'); ?>
    <h1>Avater Generator</h1><br>
    <div class="panel">
        <h5>Choose one for your avater!</h5>
        <br>

        <?php
        //importing dbConnect.php script
        require_once('dbConnect.php');

        //redirect to user profile if login successfully
        if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {

            echo '<form action="icon.php" method=post>';
            echo '<table class="table table-bordered" ><tr>';
            $count = 0;
            foreach (glob('./images/icon-people/*.*') as $filename) {
                $count++;
                //echo $filename;

                echo '<td>';
                echo '<div class="radio"><label><input type="radio" name="icon_url" value="' . $filename . '"><img src="' . $filename . '" width=180 height=180></label></div>';
                echo '</td>';

                if ($count % 4 == 0) echo '</tr><tr>';

            }
            echo '</tr></table>';

            echo '<br>';
            echo 'Reference: https://www.flaticon.com/packs/avatars-20
		<br>Published by Freepik
		<br>License: Flaticon Basic License ';
            echo '<br>
<input type="submit" value="Submit" class="btn">
</form>';

        } else {


            echo '<div class="alert alert-danger"><strong>Error! </strong></div>';
            header("refresh:3;url=./profile.php");


        }
        ?>

    </div>
<?php include('footer.php'); ?>