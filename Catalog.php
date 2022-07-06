<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog</title>
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

        $mysqli = new mysqli("localhost", "root", "#B!je?651*rK", "clothing_shop_db");
        $statement = "SELECT * FROM clothes";
        $result = $mysqli->query($statement);
        echo "<section class='catalog'>";
            if (var_export($result,  true)){
                $i = 0;
                foreach($result as $item){
                    $title = $item['title'];
                    $desc = $item['description'];
                    $color = $item['color'];
                    $price = floatval($item['price']);
                    $sizes = json_decode($item['sizes']);
                    $quantity = intval($item['quantity']);                    
                    $seller_name = $item['seller_name'];
                    $type = $item['type'];
                    $cloth = new Cloth($title, $desc, $color, $price, $sizes, $quantity, $seller_name, $type);
                    //$serialized_cloth = serialize($cloth);
                    $serialized_cloth = base64_encode(gzdeflate(htmlspecialchars(serialize($cloth))));

                    echo '<form style="display: none" action="CatalogItem.php" method="post" id="catalog-item-form'.$i.'">
                            <input type="hidden" name="catalog-item" value='.$serialized_cloth.'">
                          </form>';
                    echo "<div onclick='submitItem($i)' class='cloth-item'> 
                        <h3>".htmlspecialchars($title)."</h3> <div class='color-container' style='width: 100%; height: 100%; background-color:$color'></div>";
                                        
                    foreach($sizes as $size){
                        echo "<span class='size-tag'>".htmlspecialchars($size)."</span>";
                    }
                    echo "<span class='price-tag'>".htmlspecialchars($price)." $</span></div>";
                    $i+=1;
                } 
            }
            /* $new = "<a href='test'>Test</a>";
            echo htmlspecialchars($new, ENT_QUOTES); */
            
        ?>

    </section>

    <script>
        function submitItem(i){   
            document.getElementById(('catalog-item-form'+i)).submit();
            //console.log(document.getElementById('catalog-item-form'));
            
        }
    </script>

    <?php
        require_once "Footer.php";
    ?>
    
</body>
</html>
