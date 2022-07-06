<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SILKY</title>
    <link rel="stylesheet" href="style.css">
    <?php
        include "Fonts.php";
    ?>
    
</head>
<body>
    <?php
        session_start();
        require_once "UserSessionHandler.php";
        require_once "Model.php";
        require_once 'Navbar.php';
    ?>  

    <?php
        require_once "Footer.php";
    ?>
</body>
</html>
