<?php
require_once "config.php";
session_start();
$doctor_username = $_SESSION['doctor_username'];
$result = $link->query("SELECT doctor_profile_photo FROM doctors WHERE doctor_username = '$doctor_username'");
$resultt=mysqli_fetch_array($result);
echo '<img class="profile-img" src="data:image/jpeg;base64,'.base64_encode( $resultt['doctor_profile_photo'] ).'"/>';
 ?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <body>
    <?php
      echo "Welcome $doctor_username";
      echo "<br>";
    ?>
    <form action="upload_profile_photo.php" method="post" enctype="multipart/form-data">
        <label>Select Image File:</label>
        <input type="file" name="image">
        <input type="submit" name="submit" value="Upload">
    </form>
    <a class="button" href="edit_doctor_profile.php">Edit your profile</a>
    <br />
    <a class="button" href="logout.php">Logout</a>
  </body>
</html>
