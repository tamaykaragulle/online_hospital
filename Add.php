<?php   
    echo'<section class="add-cloth">
        <form id="add-cloth-form" action="AddClothProcess.php" method="post">
            
            <div class="cloth-input-div" id="title-input-div"><input type="text" placeholder="Title" name="title" id="title-input"></div>
            <div class="cloth-input-div" id="desc-input-div"><input type="text" placeholder="Description" name="desc" id="desc-input"></div>
            <div class="cloth-input-div" id="size-input-div">';

                $types = ['Jeans', 'Shirt', 'Hat', 'Shoes', 'Sweatpants', 'PJ', 'Jacket'];
                $sizes = array('XS', 'S', 'M', 'L', 'XL');
                foreach ($sizes as $size){
                    echo '<label>'.htmlspecialchars($size).'<br><input type="checkbox" name="sizes[]"" class="size-option" value='.htmlspecialchars($size).'></label>'; 
                }
            echo '    
            </div>
            <div class="cloth-input-div" id="color-input-div"><label>Color<br><input type="color" name="color" id="color-input"></label></div>
            <div class="cloth-input-div" id="quantity-input-div"><label>Quantity<br><input type="number" min="0" max="999999" step="1" name="quantity" id="quantity-input"></label></div>
            <div class="cloth-input-div" id="price-input-div"><label>Price<br><input type="number" min="0" max="999999" step="0.01" placeholder="$" name="price" id="price-input"></label></div>
            <div class="cloth-input-div">
                <label>Type<br>
                    <select name="type" id="type-select">';
                        foreach ($types as $type){
                            echo '<option value='.htmlspecialchars(strtolower($type)).' class="type-option">'.htmlspecialchars($typ).'</option>';
                        }
            echo '
                    </select>
                </label>
            </div>
            <div class="cloth-input-div"><input id="add-cloth-submit" type="submit" value="SUBMIT"></div>
        </form>';

?>
