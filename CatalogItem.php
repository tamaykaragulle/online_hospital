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
<body onload='updatePrice()'>
    <?php
        session_start();
        require_once "UserSessionHandler.php";
        require_once "Model.php";
        require_once 'Navbar.php';
        if(isset($_POST['catalog-item']) and $_POST['catalog-item'] !== ''){
            $item = (unserialize(htmlspecialchars_decode(gzinflate(base64_decode($_POST['catalog-item'])))));
            $title = htmlspecialchars($item->getTitle());
            $desc = htmlspecialchars($item->getDescription()); 
            $price = htmlspecialchars($item->getPrice());
            $quantity = htmlspecialchars($item->getQuantity());
            $seller_name = htmlspecialchars($item->getSellerName());
            $sizes = $item->getSizes();
            $color = htmlspecialchars($item->getColor());
        }
    ?>

        <section class="cloth-item-wrapper">
            <form class='cloth-item-purchase-form' action='CatalogItem.php' method='post' id='cloth-item-purchase-form'>
                <?php
                    $serialized_item =  base64_encode(gzdeflate(serialize($item)));
                    echo "<input type='hidden' name='catalog-item' value='".htmlspecialchars($serialized_item)."'>"; 
                ?>
                <div class="cloth-item-col1">
                    <h2><?php echo $title ?></h2>
                    <h6><?php echo $desc ?></h2>
                    <br>
                    <?php 
                    echo "<select name='size-selector' id='size-selector'>";
                    foreach($sizes as $size){
                        $size = htmlspecialchars($size);
                        echo "<option value='$size'>$size</option>";
                    }
                    echo "</select><br><br>";
                    
                    ?>
                </div>
                <div class="cloth-item-col2">
                    <div style="background-color:<?php echo $color ?>;" class="cloth-item-color-box">
                    </div>
                    <?php 
                        echo "<h4><span>$quantity </span>pieces left!</h4>";
                        echo "<input oninput='updatePrice()' type='number' id='item-purchase-quantity-input' min='1' max='$quantity' value='1' name='quantity-input'>";
                        echo "<button id='item-purchase-btn'><span id='item-purchase-price-span'> $</span></button>";

                        echo "<input type='hidden' id='item-hidden-price' value=$price>"; 
                        echo "<input type='hidden' id='item-hidden-quantity' value=$quantity>"; 
                    ?>

                </div>    
            </form>
        </section>
            
        <script>
            const updatePrice = () => {
                let item = document.getElementById('item-purchase-price-span');
                let price = parseInt(document.getElementById('item-hidden-price').value);
                let real_quantity = parseInt(document.getElementById('item-hidden-quantity').value);
                let user_quantity = parseInt(document.getElementById('item-purchase-quantity-input').value);
                console.log("PRICE: ", price, "  QUANTITY: ", user_quantity, " MAX QUANTITY :", real_quantity);
                if (user_quantity <= real_quantity && user_quantity > 0){
                    item.value = price*user_quantity;
                    console.log(price, user_quantity);
                    item.textContent = "BUY FOR " + price*user_quantity + "$";
                }
                
            }
        </script>

    <?php
        require_once "Footer.php";
    ?>

</body>
</html>