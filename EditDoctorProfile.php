<?php
session_start();
require_once "Config.php";

$doctor_username = $_SESSION['doctor_username'];
$result = $_SESSION['profile_photo'];
$doctor_name_surname = $doctor_mail = "";
$doctor_age = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty(trim($_POST["doctor_name_surname"])))
    {
        $doctor_name_surname_err = "Please enter your name and surname.";
    }
    elseif (!preg_match("/[a-zA-Z]/", trim($_POST["doctor_name_surname"])))
    {
        $doctor_name_surname_err = "Username can only contain letters, numbers, and underscores.";
    }
    else
    {
        $sql = "SELECT doctor_username FROM doctors WHERE doctor_username = '$doctor_username'";

        if ($stmt = mysqli_prepare($link, $sql))
        {
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt))
            {
                /* store result */
                mysqli_stmt_store_result($stmt);
                $doctor_name_surname = $_POST["doctor_name_surname"];
            }
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    if (empty(trim($_POST["doctor_age"])))
    {
        $doctor_age_err = "Please select your age.";
    }
    else
    {
        $doctor_age = trim($_POST["doctor_age"]);
    }

    if (empty(trim($_POST["doctor_mail"])))
    {
      $doctor_mail_err = "Please enter your e-mail.";
    }
    else {
      $doctor_mail = trim($_POST["doctor_mail"]);
    }
    // Check input errors before inserting in database
    if (empty($doctor_name_surname_err))
    {
        // Prepare an insert statement
        $sql = "UPDATE doctors SET doctor_name_surname = ?, doctor_age = ?, doctor_mail = ? WHERE doctor_username = '$doctor_username'";

        if ($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sis", $param_doctor_name_surname,$param_doctor_age,$param_doctor_mail);

            // Set parameters
            $param_doctor_name_surname = $doctor_name_surname;
            $param_doctor_age = $doctor_age;
            $param_doctor_mail = $doctor_mail;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt))
            {
                echo "Changes saved successfully.";
            }
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <link rel="stylesheet" href="Style.css">
  <body>
    <?php
    //session_start();
    $doctor_username = $_SESSION['doctor_username'];
    echo "Welcome $doctor_username";
    echo "<br>";
    echo '<img class="profile-img" src="data:image/jpeg;base64,'.base64_encode( $result['doctor_profile_photo'] ).'"/>';
     ?>
     <form action="UploadProfilePhoto.php" method="post" enctype="multipart/form-data">
         <label>Change profile photo : </label>
         <input type="file" name="image">
         <br />
         <input type="submit" name="submit" value="Upload profile photo">
     </form>
     <form action="<?php $_PHP_SELF ?>" method="post" enctype="multipart/form">
       <div class="form-group">
         <label>Name and surname : </label>
         <input type="text" placeholder="Name1 Surname1" name="doctor_name_surname" size="30" class="form-control <?php echo (!empty($doctor_name_surname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $doctor_name_surname; ?>"/>
         <span class="invalid-feedback"><?php echo $doctor_name_surname_err; ?></span>
       </div>
       <br />
       <div class="form-group">
         <label>Your age : </label>
         <input type="number" min="20" max="100" name="doctor_age" class="form-control <?php echo (!empty($doctor_age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $doctor_age; ?>"/>
         <span class="invalid-feedback"><?php echo $doctor_age_err; ?></span>
         <br /><br />
       </div>
       <div class="form-group">
         <label>E-Mail : </label>
         <input type="text" placeholder="someone@gmail.com" name="doctor_mail" size="30" class="form-control <?php echo (!empty($doctor_mail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $doctor_mail; ?>"/>
         <span class="invalid-feedback"><?php echo $doctor_mail_err; ?></span>
       </div>
       <input type="submit" value="Save changes"/>
    </form>
    <form action="DoctorWelcome.php">
      <button>Cancel</button>
    </form>
  </body>
</html>
