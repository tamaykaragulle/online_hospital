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
        if (isset($_POST['desc']) and $_POST['desc'] != "" 
        and isset($_POST['sizes']) and $_POST['sizes'] != "" 
        and isset($_POST['color']) and $_POST['color'] != "" 
        and isset($_POST['price']) and $_POST['price'] != ""
        and isset($_POST['title']) and $_POST['title'] != ""){
            $title = $_POST['title'];
            $desc = $_POST['desc'];
            $color = $_POST['color'];
            $price = $_POST['price'];
            $sizes = $_POST['sizes'];
            $quantity = $_POST['quantity']; 
            $type = $_POST['type'];
            session_start();
            $seller_name = unserialize($_SESSION["activeUser"])->getUsername();
            $cloth = new Cloth($title, $desc, $color, $price, $sizes, $quantity, $seller_name, $type);
            if($cloth->insertToDb()) echo "<h3>Cloth successfully added to the database. <a href='Add.php'>Return</a></h3> ";
            else echo "not added.";
        }else{
            echo "<h3>Fill out all information required. <a href='Add.php'>Return</a></h3>";
        }
    ?>
    
</body>
</html>
