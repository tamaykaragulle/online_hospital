<?php
session_start();
require_once "config.php";
$doctor_speciality = $statement = $get_help_speciality_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  if (empty(trim($_POST["doctor_speciality"])))
  {
      $doctor_speciality_err = "Please choose a speciality.";
  }
  else
  {

      $doctor_speciality = trim($_POST["doctor_speciality"]);
      $_SESSION['doctor_speciality'] = $doctor_speciality;
      $statement = $link->prepare("SELECT doctor_name_surname FROM doctors WHERE doctor_speciality = ?");
      $statement->bind_param("s", $doctor_speciality);
      $statement->execute();
      $statement->bind_result($result);
  }
}

?>

<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <body>
    <?php
      $patient_username = $_SESSION['patient_username'];
      echo "Welcome $patient_username";
    ?>
    <form action="<?php $_PHP_SELF ?>" method="post" enctype="multipart/form">
      <div class="form-group">
        <label for="doctor_speciality">Which speciality you want help with :</label>
        <select id="doctor_speciality" name="doctor_speciality">
          <option value="Anesthesiology">Anesthesiology</option>
          <option value="Dermatology">Dermatology</option>
          <option value="Diagnostic radiology">Diagnostic radiology</option>
          <option value="Emergency medicine">Emergency medicine</option>
          <option value="Family medicine">Family medicine</option>
          <option value="Internal medicine">Internal medicine</option>
          <option value="Medical genetics">Medical genetics</option>
          <option value="Neurology">Neurology</option>
          <option value="Nuclear medicine">Nuclear medicine</option>
          <option value="Obstetrics and gynecology">Obstetrics and gynecology</option>
          <option value="Ophthalmology">Ophthalmology</option>
          <option value="Pathology">Pathology</option>
          <option value="Pediatrics">Pediatrics</option>
          <option value="Physical medicine and rehabilitation">Physical medicine and rehabilitation</option>
          <option value="Preventive medicine">Preventive medicine</option>
          <option value="Psychiatry">Psychiatry</option>
          <option value="Radiation oncology">Radiation oncology</option>
          <option value="Surgery">Surgery</option>
          <option value="Urology">Urology</option>
        </select>
        <input type="submit" value="Get Help" name="get-help-submit" id="get-help-submit">
      </div>
    </form>
    <form action="check_doctor.php" method="post" enctype="multipart/form">
      <select name=selected_doctor>
        <option selected="selected">Choose your doctor</option>
        <?php
            foreach ($statement->get_result() as $row)
            {
                $doctor_name_surname = $row['doctor_name_surname'];
                echo "<option value='($doctor_name_surname)'>$doctor_name_surname</option>";
            }
         ?>
      </select>
      <input type="submit" value="Check doctor" />
    </form>
  </body>
</html>
