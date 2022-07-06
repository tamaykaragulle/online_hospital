<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <body>
    <?php
      session_start();
      $doctor_username = $_SESSION['doctor_username'];
      echo "Welcome $doctor_username";
      echo "<br>";
    ?>
    <a class="button" href="edit_doctor_profile.php">Edit your profile</a>
    <br />
    <a class="button" href="logout.php">Logout</a>
  </body>
</html>
