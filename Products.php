<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
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

    <section class="products-container">
        <div class="products-row-1">
            <div class="products-filter-bar">

            </div>  
        </div>
        
        <div class="products-row-2">
            <div class="products-list">
                
            </div>

            <div class="product-add-box">
                <?php
                    require_once "Add.php";
                ?>
            </div>
        </div>
    </section>


    <?php
        require_once "Footer.php";
    ?>
    
</body>
</html>