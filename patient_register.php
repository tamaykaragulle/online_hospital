<?php
require_once "config.php";

// bunlar belki username , password , mail olarak degistirilebilir
$patient_username = $patient_password = $patient_mail = "";
$patient_username_err = $patient_password_err = $patient_mail_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty(trim($_POST["patient_username"])))
    {
        $patient_username_err = "Please enter a username.";
    }
    elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["patient_username"])))
    {
        $patient_username_err = "Username can only contain letters, numbers, and underscores.";
    }
    else
    {
        $sql = "SELECT id FROM patients WHERE patient_username = ?";

        if ($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $_POST["patient_username"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt))
            {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1)
                {
                    $patient_username_err = "This username is already taken.";
                }
                else
                {
                    $patient_username = $_POST["patient_username"];
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

    if (empty(trim($_POST["patient_password"])))
    {
        $patient_password_err = "Please enter a password.";
    }
    elseif (strlen(trim($_POST["patient_password"])) < 6)
    {
        $patient_password_err = "Password must have atleast 6 characters.";
    }
    else
    {
        $patient_password = trim($_POST["patient_password"]);
    }

    if (empty(trim($_POST["patient_mail"])))
    {
        $patient_mail_err = "Please enter a e-mail address.";
    }
    else
    {
        $sql = "SELECT id FROM patients WHERE patient_mail = ?";

        if ($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_mail);

            // Set parameters
            $param_mail = $_POST["patient_mail"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt))
            {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1)
                {
                    $patient_mail_err = "This e-mail address is already taken.";
                }
                else
                {
                    $patient_mail = $_POST["patient_mail"];
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

    // Check input errors before inserting in database
    if (empty($patient_username_err) && empty($patient_password_err) && empty($patient_mail_err))
    {
        // Prepare an insert statement
        $sql = "INSERT INTO patients (patient_username, patient_password, patient_mail) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_mail);

            // Set parameters
            $param_username = $patient_username;
            $param_password = password_hash($patient_password, PASSWORD_DEFAULT); // Creates a password hash
            $param_mail = $patient_mail;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt))
            {
                // Redirect to login page
                header("location: patient_login.php");
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<body>
  <div class="register-box">
      <form action="<?php $_PHP_SELF ?>" method="post" enctype="multipart/form">
        <div class="form-group">
          <input type="text" placeholder="Patient Userame" maxlength="20" name="patient_username" class="form-control <?php echo (!empty($patient_username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $patient_username; ?>">
          <span class="invalid-feedback"><?php echo $patient_username_err; ?></span>
        </div>
        <div class="form-group">
          <input type="password" placeholder="Patient Password" maxlength="20" name="patient_password" class="form-control <?php echo (!empty($patient_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $patient_password; ?>">
          <span class="invalid-feedback"><?php echo $patient_password_err; ?></span>
        </div>
        <div class="form-group">
          <input type="email" placeholder="Patient E-Mail" maxlength="5" name="patient_mail" class="form-control <?php echo (!empty($patient_mail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $patient_mail; ?>">
          <span class="invalid-feedback"><?php echo $patient_mail_err; ?></span>
        </div>
          <input type="submit" value="REGISTER" name="register-submit" id="register-submit">
          <h3>Already a user? <a href="patient_login.php">Login</a></h3>
          <h3><a href="choose.php">Choose</a></h3>
      </form>
  </div>
</body>
</html>
