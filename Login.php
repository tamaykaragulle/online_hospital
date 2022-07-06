<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php require 'Fonts.php' ?>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        require_once "UserSessionHandler.php";
        require_once "Model.php";
        require_once 'Navbar.php';
    ?>
    

    <div class="login-box">
        <form action="authenticate.php" method="post" enctype="multipart/form">
            <input type="text" placeholder="Username" name="username">
            <input type="password" placeholder="Password" name="password">
            <input type="submit" value="LOGIN" name="login-submit" id="login-submit">
            <h3>Not a user? <a href="Register.php">Register</a></h3>
        </form>
    </div>
    
    <?php
        require_once "Footer.php";
    ?>
</body>
</html>
