<?php
// Include the database configuration file
require_once 'Config.php';
session_start();
$doctor_username = $_SESSION['doctor_username'];
// If file upload form is submitted
$status = $statusMsg = '';
if(isset($_POST["submit"])){
    $status = 'error';
    if(!empty($_FILES["image"]["name"])) {
        // Get file info
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','gif');
        if(in_array($fileType, $allowTypes)){
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));

            // Insert image content into database
            $insert = $link->query("UPDATE doctors SET doctor_profile_photo = '$imgContent' WHERE doctor_username = '$doctor_username'");

            if($insert){
                $status = 'success';
                $statusMsg = "File uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            }
        }else{
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
        }
    }else{
        $statusMsg = 'Please select an image file to upload.';
    }
}

// Display status message
echo $statusMsg;
echo '<h3><a href="DoctorWelcome.php">Go back to your profile.</a></h3>';
