<?php include('header.php'); ?>
    <h1>Avater Generator</h1><br>
    <div class="panel">

        <br>

        <?php
        //importing dbConnect.php script
        require_once('dbConnect.php');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {

                //Getting values
                $icon_url = $_POST['icon_url'];
                $user_id = $_SESSION['user_id'];


                $watermark = imagecreatefrompng("$icon_url");
                $imageURL = imagecreatefromjpeg('./images/icon-background/background.jpeg');
                $watermarkX = imagesx($watermark);
                $watermarkY = imagesy($watermark);
                $imageX = imagesx($imageURL);
                $imageY = imagesy($imageURL);

                $percent = 0.75;
                $newwidth = $watermarkX * $percent;
                $newheight = $watermarkY * $percent;

// create a new image with the new dimension.
                $new_watermark = imagecreatetruecolor($newwidth, $newheight);

// Retain image transparency for your watermark, if any.
                imagealphablending($new_watermark, false);
                imagesavealpha($new_watermark, true);

// copy $watermark, and resized, into $new_watermark
// change to `imagecopyresampled` for better quality
                imagecopyresized($new_watermark, $watermark, 0, 0, 0, 0, $newwidth, $newheight, $watermarkX, $watermarkY);


                imagecopy($imageURL, $new_watermark, ($imageX - $newwidth) / 2, ($imageY - $newheight) / 2, 0, 0, $newwidth, $newheight);
                imagepng($imageURL, './images/icon/' . $user_id . '.png');
                imagedestroy($imageURL);


//

                $icon = imagecreatefrompng('./images/icon/' . $user_id . '.png');
                $new_icon = imagecreatetruecolor(180, 220);

                $sourceX = imagesx($icon);
                $sourceY = imagesy($icon);

// Retain image transparency for your watermark, if any.
                imagealphablending($new_icon, false);
                imagesavealpha($new_icon, true);

// copy $watermark, and resized, into $new_watermark
// change to `imagecopyresampled` for better quality
                imagecopyresampled($new_icon, $icon, 0, 0, 0, 0, 180, 220, $sourceX, $sourceY);

                imagepng($new_icon, './images/icon/' . $user_id . '.png');

//                echo '<img src="./images/icon/"'.$user_id.'.png>';
//                echo gettype($user_id) . get_resource_type($icon) . get_resource_type($new_icon);

                $update_sql = "UPDATE user SET icon = '$user_id.png' WHERE user_id = $user_id";
                $update_result = mysqli_query($con, $update_sql);

                if ($update_result)
                    echo '<div class="alert alert-success"><strong>Success! </strong></div>';

//                header("refresh:3;url=./index.php");
            }
        } else {


            echo '<div class="alert alert-danger"><strong>Error! </strong></div>';
            header("refresh:3;url=./index.php");


        }
        ?>

    </div>
<?php include('footer.php'); ?>