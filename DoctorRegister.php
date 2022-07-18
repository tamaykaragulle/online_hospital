<?php
require_once "Config.php";

// bunlar belki username , password , mail olarak degistirilebilir
$doctor_username = $doctor_password = $doctor_mail = $doctor_speciality = "";
$doctor_username_err = $doctor_password_err = $doctor_mail_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty(trim($_POST["doctor_username"])))
    {
        $doctor_username_err = "Please enter a username.";
    }
    elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["doctor_username"])))
    {
        $doctor_username_err = "Username can only contain letters, numbers, and underscores.";
    }
    else
    {
        $doctor_username = $_POST["doctor_username"];

        $sql = "SELECT doctor_username FROM doctors WHERE doctor_username = '$doctor_username'";

        if ($stmt = mysqli_prepare($link, $sql))
        {
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt))
            {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1)
                {
                    $doctor_username_err = "This username is already taken.";
                }
                else
                {
                    $doctor_username = $_POST["doctor_username"];
                }
            }
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if (empty(trim($_POST["doctor_password"])))
    {
        $doctor_password_err = "Please enter a password.";
    }
    elseif (strlen(trim($_POST["doctor_password"])) < 6)
    {
        $doctor_password_err = "Password must have atleast 6 characters.";
    }
    else
    {
        $doctor_password = trim($_POST["doctor_password"]);
    }

    if (empty(trim($_POST["doctor_mail"])))
    {
        $doctor_mail_err = "Please enter a e-mail address.";
    }
    else
    {
        $sql = "SELECT doctor_username FROM doctors WHERE doctor_mail = ?";

        if ($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_mail);

            // Set parameters
            $param_mail = $_POST["doctor_mail"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt))
            {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1)
                {
                    $doctor_mail_err = "This e-mail address is already taken.";
                }
                else
                {
                    $doctor_mail = $_POST["doctor_mail"];
                }
            }
            else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if (empty(trim($_POST["doctor_speciality"])))
    {
        $doctor_speciality_err = "Please choose a speciality.";
    }
    else
    {
        $doctor_speciality = trim($_POST["doctor_speciality"]);
    }

    // Check input errors before inserting in database
    if (empty($doctor_username_err) && empty($doctor_password_err) && empty($doctor_mail_err) && empty($doctor_speciality_err))
    {
        // Prepare an insert statement
        $sql = "INSERT INTO doctors (doctor_username, doctor_password, doctor_mail, doctor_speciality) VALUES (?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_mail, $param_speciality);

            // Set parameters
            $param_username = $doctor_username;
            $param_password = password_hash($doctor_password, PASSWORD_DEFAULT); // Creates a password hash
            $param_mail = $doctor_mail;
            $param_speciality = $doctor_speciality;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt))
            {
                // Redirect to login page
                header("location: DoctorLogin.php");
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
<html lang="en">
<head>
  <title>Choose</title>
</head>
<link rel="stylesheet" href="Style.css">
<body style="background-color:#2596be">
      <form action="<?php $_PHP_SELF ?>" method="post" enctype="multipart/form">
          <input type="text" id="username-input" placeholder="Doctor Username" name="doctor_username" class="form-control <?php echo (!empty($doctor_username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $doctor_username; ?>">
          <span class="invalid-feedback"><?php echo $doctor_username_err; ?></span>
        <br />
        <div class="form-group">
          <input type="password" id="password-input" placeholder="Doctor Password" name="doctor_password" class="form-control <?php echo (!empty($doctor_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $doctor_password; ?>">
          <span class="invalid-feedback"><?php echo $doctor_password_err; ?></span>
        <br />
          <input type="email" id="email-input" placeholder="Doctor E-Mail" name="doctor_mail" class="form-control <?php echo (!empty($doctor_mail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $doctor_mail; ?>">
          <span class="invalid-feedback"><?php echo $doctor_mail_err; ?></span>
        <br />
          <h2>Choose speciality : </h2>
          <select id="select-box" name="doctor_speciality">
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
        <br />
        <input type="submit" id="register-submit" value="REGISTER" name="register-submit" id="register-submit">
        <h3>Already a user? <a href="DoctorLogin.php">Login</a></h3>
        <h3><a href="Choose.php">Choose doctor/patient</a></h3>
      </form>
</body>
</html>
