<?php
session_start();
require_once "config.php";
$doctor_name_surname = $doctor_age = $doctor_mail = $doctor_speciality = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  $doctor_name_surname = trim($_POST["selected_doctor"],"()");
  $doctor_speciality = $_SESSION['doctor_speciality'];

  $sql = $link->query("SELECT doctor_age , doctor_mail FROM doctors WHERE doctor_name_surname = '$doctor_name_surname' AND doctor_speciality = '$doctor_speciality'");

  $result = $sql->fetch_array();
  $doctor_age = $result["doctor_age"];
  $doctor_mail = $result["doctor_mail"];
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <label class="control-label">Doctor : <?php echo $doctor_name_surname; ?></label>
    <br />
    <label class="control-label">Speciality : <?php echo $doctor_speciality; ?></label>
    <br />
    <label class="control-label">Age : <?php echo $doctor_age; ?></label>
    <br />
    <label class="control-label">Mail : <?php echo $doctor_mail; ?></label>
  </body>
</html>
