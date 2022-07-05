<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    header("location: doctor_welcome.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$doctor_username = $doctor_password = "";
$doctor_username_err = $doctor_password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Check if doctor_username is empty
    if (empty(trim($_POST["doctor_username"])))
    {
        $doctor_username_err = "Please enter a username.";
    }
    else
    {
        $doctor_username = trim($_POST["doctor_username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["doctor_password"])))
    {
        $doctor_password_err = "Please enter your password.";
    }
    else
    {
        $doctor_password = trim($_POST["doctor_password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($doctor_password_err))
    {
        // Prepare a select statemen
        $sql = "SELECT id, doctor_username, doctor_password FROM doctors WHERE doctor_username = ?";

        if ($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $doctor_username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt))
            {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1)
                {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $doctor_username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt))
                    {
                        if (password_verify($doctor_password, $hashed_password))
                        {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["doctor_username"] = $doctor_username;

                            // Redirect user to welcome page
                            header("location: doctor_welcome.php");
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<body>
  <?php
if (!empty($login_err))
{
    echo '<div class="alert alert-danger">' . $login_err . '</div>';
}
?>
  <div class="login-box">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form">
      <div class="form-group">
        <input type="text" placeholder="Doctor Name" name="doctor_username" class="form-control <?php echo (!empty($doctor_username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $doctor_username; ?>">
        <span class="invalid-feedback"><?php echo $doctor_username_err; ?></span>
      </div>
      <div class="form-group">
        <input type="password" placeholder="Doctor Password" name="doctor_password" class="form-control <?php echo (!empty($doctor_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $doctor_password; ?>">
        <span class="invalid-feedback"><?php echo $doctor_password_err; ?></span>
      </div>
        <input type="submit" value="Login" name="login-submit" id="login-submit">
        <h3>Don't have an account ? <a href="doctor_register.php">Register</a></h3>
        <h3><a href="choose.php">Choose</a></h3>
    </form>
  </div>
</body>
</html>
