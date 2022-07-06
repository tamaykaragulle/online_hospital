<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process</title>
    <link rel="stylesheet" href="style.css">
    <?php
        require_once "Fonts.php";
    ?>
</head>
<body>
    <?php
        require_once "UserSessionHandler.php";
        require_once "Model.php";
        require_once 'Navbar.php';
        if (isset($_POST['username']) and $_POST['username'] !== '' and isset($_POST['password']) and $_POST['password'] !==''){
            $username = $_POST["username"];
            $password = $_POST["password"];

            // REGISTRATION HANDLER
            if (isset($_POST["email"]) and $_POST["email"] !== ''){
                $email = $_POST["email"];
                $user = new User($username, $password, $email);

                //SUCCESSFULL REGISTRATION
                if($user->insertToDb()){
                    session_start();
                    $_SESSION['activeUser'] = serialize(new User($username));
                    $user->completeColumns();
                    $state = $user->getType();
                    $_SESSION['userType'] = serialize($state);
                    $_SESSION['lastActivity'] = time();
                    session_write_close();
                    echo "<h3>Successfully registered & logged in.<a href='Index.php'> Home</a></h3>";
                }

                // FAILED REGISTRATION
                else{
                    echo "<h3>User already exists. <a href='Register.php'> Try again.</a></h3>";
                }
            }

            else{
                //SUCCESSFULL LOGIN
                $user = new User($username, $password);
                if ($user->login()){
                    session_start();
                    $user->completeColumns();
                    $state = $user->getType();
                    $_SESSION['userType'] = serialize($state);
                    $_SESSION['activeUser'] = serialize($user);
                    $_SESSION['lastActivity'] = time();
                    session_write_close();
                    header("Location: ./Index.php"); 
                }
                //  FAILED LOGIN
                else{
                    echo "<h3>Username does not exist or password is wrong. <a href='Login.php'> Try again.</a></h3>";
                }
            }
        }
        // INVALID FORM
        else{
            echo "<h3>Fill out all information required.<a href='Login.php'> Return</a></h3>";
        }
    ?>
    
</body>
</html>

