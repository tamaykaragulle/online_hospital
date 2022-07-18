<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    header("location: PatientWelcome.php");
    exit;
}

// Include config file
require_once "Config.php";

// Define variables and initialize with empty values
$patient_username = $patient_password = "";
$patient_username_err = $patient_password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Check if patient_username is empty
    if (empty(trim($_POST["patient_username"])))
    {
        $patient_username_err = "Please enter a username.";
    }
    else
    {
        $patient_username = trim($_POST["patient_username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["patient_password"])))
    {
        $patient_password_err = "Please enter your password.";
    }
    else
    {
        $patient_password = trim($_POST["patient_password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($patient_password_err))
    {
        // Prepare a select statemen
        $sql = "SELECT patient_username, patient_password FROM patients WHERE patient_username = ?";

        if ($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $patient_username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt))
            {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1)
                {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $patient_username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt))
                    {
                        if (password_verify($patient_password, $hashed_password))
                        {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["patient_username"] = $patient_username;

                            // Redirect user to welcome page
                            header("location: PatientWelcome.php");
                        }
                        else
                        {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                }
                else
                {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
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
  <?php
if (!empty($login_err))
{
    echo '<div class="alert alert-danger">' . $login_err . '</div>';
}
?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form">
        <input type="text" id="username-input" placeholder="Patient Userame" name="patient_username" class="form-control <?php echo (!empty($patient_username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $patient_username; ?>">
        <span class="invalid-feedback"><?php echo $patient_username_err; ?></span>
        <br />
        <input type="password" id="password-input" placeholder="Patient Password" name="patient_password" class="form-control <?php echo (!empty($patient_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $patient_password; ?>">
        <span class="invalid-feedback"><?php echo $patient_password_err; ?></span>
        <br />
        <input type="submit" id="submit" value="Login" name="login-submit" id="login-submit">
        <h3>Don't have an account ? <a href="PatientRegister.php">Register</a></h3>
        <h3><a href="Choose.php">Choose doctor/patient</a></h3>
    </form>
</body>
</html>
