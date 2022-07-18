<?php
session_start();
require_once "Config.php";
$doctor_username = $doctor_name_surname = $doctor_age = $doctor_mail = $doctor_speciality = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  $doctor_username = trim($_POST["selected_doctor"],"()");
  $doctor_speciality = $_SESSION['doctor_speciality'];

  $sql = $link->query("SELECT doctor_name_surname , doctor_profile_photo , doctor_age , doctor_mail FROM doctors WHERE doctor_username = '$doctor_username'");
  $result = mysqli_fetch_array($sql);
  if ($result["doctor_name_surname"] == NULL)
  {
    echo("<script>alert('Please select a doctor.')</script>");
    echo("<script>window.location = 'PatientWelcome.php';</script>");
  }else {
  $doctor_name_surname = $result["doctor_name_surname"];
  $doctor_age = $result["doctor_age"];
  $doctor_mail = $result["doctor_mail"];

  $_SESSION["doctor_username"] = $doctor_username;
  $_SESSION["doctor_name_surname"] = $doctor_name_surname;
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="Style.css">
  </head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <body>
    <?php echo '<img class="profile-img" src="data:image/jpeg;base64,'.base64_encode( $result['doctor_profile_photo'] ).'"/>';?>
    <br />
    <label class="control-label">Doctor : <?php echo $doctor_name_surname; ?></label>
    <br />
    <label class="control-label">Speciality : <?php echo $doctor_speciality; ?></label>
    <br />
    <label class="control-label">Age : <?php echo $doctor_age; ?></label>
    <br />
    <label class="control-label">Mail : <?php echo $doctor_mail; ?></label>
    <form action = "Reservations.php" method="post">
      <input type="submit" value="Get A Reservation"></input>
    </form>
  </body>
</html>
