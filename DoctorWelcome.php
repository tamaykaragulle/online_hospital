<?php
require_once "Config.php";
session_start();
$doctor_username = $_SESSION['doctor_username'];
$result = $link->query("SELECT doctor_profile_photo FROM doctors WHERE doctor_username = '$doctor_username'");
$result=mysqli_fetch_array($result);
echo '<img class="profile-img" src="data:image/jpeg;base64,'.base64_encode( $result['doctor_profile_photo'] ).'"/>';
$_SESSION['profile_photo'] = $result;
 ?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <link rel="stylesheet" href="Style.css">
  <body>
    <?php
      echo "Welcome $doctor_username";
      echo "<br>";
    ?>
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
    <h3><a href="EditDoctorProfile.php">Edit your profile</a></h3>
    <h3><a href="Logout.php">Logout</a></h3>
  </body>
</html>
