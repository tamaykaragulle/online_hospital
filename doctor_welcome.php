<?php
require_once "config.php";
session_start();
$doctor_username = $_SESSION['doctor_username'];
$result = $link->query("SELECT doctor_profile_photo FROM doctors WHERE doctor_username = '$doctor_username'");
$result=mysqli_fetch_array($result);
echo '<img class="profile-img" src="data:image/jpeg;base64,'.base64_encode( $result['doctor_profile_photo'] ).'"/>';
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
        <label>Change profile photo : </label>
        <input type="file" name="image">
        <br />
        <input type="submit" name="submit" value="Upload profile photo">
    </form>
    <div>
      <h2>Reservations</h2>
      <br />
      <?php
        $sql = "SELECT patient_username, reservation_date FROM reservations WHERE doctor_username = '$doctor_username'";
        $result = $link->query($sql);
        if($result->num_rows > 0)
        {
          while ($row = $result->fetch_assoc()) {
            echo $row['patient_username']." = ".$row['reservation_date'];
            echo "<br />";
          }
        }
        else {
          echo "No reservations yet.";
        }
       ?>
    </div>
    <h3><a href="edit_doctor_profile.php">Edit your profile</a></h3>
    <h3><a href="logout.php">Logout</a></h3>
  </body>
</html>
