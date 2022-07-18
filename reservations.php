<?php
session_start();
require_once "Config.php";

$doctor_username = $reservation_date_err = $doctor_name_surname = $patient_username = $reservation_date = "";

$patient_username = $_SESSION["patient_username"];
$doctor_name_surname = $_SESSION["doctor_name_surname"];
$doctor_username = $_SESSION["doctor_username"];

if (!empty($_POST['reservation_date']))
{
  if ($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $reservation_date = $_POST["reservation_date"];
    $sql = "SELECT reservation_date FROM reservations WHERE doctor_username = '$doctor_username' AND reservation_date = '$reservation_date'";
    $result = $link->query($sql);

    if ($result->num_rows > 0)
    {
      $reservation_date_err = "This date is not available.";
    }
    else
    {
      $sql = "INSERT INTO reservations (doctor_username, doctor_name_surname, patient_username, reservation_date) VALUES (?,?,?,?)";
      if ($stmt = mysqli_prepare($link,$sql))
      {
        mysqli_stmt_bind_param($stmt,"ssss",$doctor_username,$doctor_name_surname,$patient_username,$reservation_date);

        if (mysqli_stmt_execute($stmt))
        {
          mysqli_stmt_store_result($stmt);
        }
        else {
          echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
      }
    }
  }
}
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <link rel="stylesheet" href="Style.css">
  <body>
    <?php

     ?>
    <form action="<?php $_PHP_SELF ?>" method="post">
      <input type="date" name="reservation_date" min="<?= date('Y-m-d'); ?>"class="form-control <?php echo (!empty($reservation_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $reservation_date_err; ?>"/>
      <span class="invalid-feedback"><?php echo $reservation_date_err; ?></span>
      <br />
      <input type="submit" value="Get A Reservation"/>
    </form>
    <h3><a href="PatientWelcome.php">Go back</a></h3>
  </body>
</html>
