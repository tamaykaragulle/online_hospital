<?php
require_once "config.php";

$doctor_name_surname = "";
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
        $sql = "SELECT id FROM doctors WHERE doctor_username = ?";

        if ($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_doctor_name_surname);

            // Set parameters
            $param_doctor_name_surname = $_POST["doctor_name_surname"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt))
            {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1)
                {
                    $doctor_name_surname_err = "This name/surname is already taken.";
                }
                else
                {
                    $doctor_name_surname = $_POST["doctor_name_surname"];
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
    if (empty($patient_username_err))
    {
        // Prepare an insert statement
        $getid = "SELECT id FROM doctors WHERE doctor_username = '$doctor_username'";
        $sql = "UPDATE doctors SET 'doctor_name_surname' = ? , 'doctor_age' = ? WHERE ('id'= ?)";




        if ($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_doctor_name_surname, $param_age);

            // Set parameters
            $param_doctor_name_surname = $doctor_name_surname;
            $param_age = $doctor_age;

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
  </head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <body>
    <?php
    session_start();
    $doctor_username = $_SESSION['doctor_username'];
    echo "Welcome $doctor_username";
    echo "<br>";
     ?>
     <form action="<?php $_PHP_SELF ?>" method="post" enctype="multipart/form">
       <div class="form-group">
         <label>Name and surname : </label>
         <input type="text" placeholder="Name1 Surname1" name="doctor_name_surname" size="30" class="form-control <?php echo (!empty($doctor_name_surname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $doctor_name_surname; ?>"/>
         <span class="invalid-feedback"><?php echo $doctor_name_surname_err; ?></span>
       </div>
       <br />
       <div class="form-group">
         <label>Your age : </label>
         <input type="number" min="20" max="100" name="doctor_age"/>
         <br /><br />
       </div>
       <input type="submit" value="Save changes"/>
    </form>
    <form action="doctor_welcome.php">
      <button>Cancel</button>
    </form>
  </body>
</html>
