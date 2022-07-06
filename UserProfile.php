<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php 
        require_once "Model.php";
        require_once "UserSessionHandler.php";
        require_once "Fonts.php";
        session_start();
        if (!isset($_SESSION['activeUser'])){
            header("Location: ./Index.php");
            exit();
        }
        
        $user = unserialize($_SESSION['activeUser']);
        $username = $user->getUsername();
        $email = $user->getEmail();
        $type = $user->getType();
        echo "<title>$username's Profile</title>";
    ?>
    <title>Profile</title>
    <link href="style.css" rel="stylesheet" type="text/css"></link>
    <script src="jquery-3.6.0.min.js"></script>
    <script src="js/jquery.validate.js"></script>
</head>
<body>
        <?php 
            require_once "Navbar.php";
            $type = $user->getType();
            if ($type == 'seller'){
                $num_products_listed = print_r($user->getNumProductsListed(),true);
                $num_products_sold = print_r($user->getNumProductsSold(),true);
            }
            $name = $user->getName();
            $surname = $user->getSurname();
            $gender = $user->getGender();
            $email = $user->getEmail();
            $age = $user->getAge();
            $date_joined = $user->getDateJoined();
            $num_products_bought = $user->getNumProductsBought();   
        ?>
        
        <section id="profile-div">
            <aside id="personal-info">
                <form action="ModifyUserProfile.php" id="profile-form" method="POST" enctype="multipart/form" >
                    <ul>
                        <div class="profile-form-input"><li><label for="name">Name</label><input type="text" name="name" minlength="2" maxlength="30" required placeholder= "Name" value="<?php echo htmlspecialchars($name) ?>"id="name-input"></li></div>
                        <div class="profile-form-input"><li><label for="surname">Surname</label><input type="text" name="surname" minlength="2" maxlength="30" required placeholder= "Surname" value="<?php echo htmlspecialchars($surname) ?>"id="surname-input"></li></div>
                        <div class="profile-form-input"><li><label for="email">Email</label><input type="email" name="email" maxlength="30" required placeholder= "Email" value = <?php  echo htmlspecialchars($email) ?> ></li></div>
                        <div class="profile-form-input"><li><label for="age">Age</label><input type="number" name="age" min="7" max="99" required step="1" id="age-input" placeholder="Age" value= <?php echo htmlspecialchars($age) ?>></li></div>
                        <div class="profile-form-input"><li><label for="gender">Gender</label><input type="text" name="gender" minlength="1" maxlength="10" required placeholder="Gender" value= <?php echo htmlspecialchars($gender) ?> ></li></div>
                        <div class="profile-form-input"><li><input type="submit" value="Apply" name="submit"></li></div>
                    </ul >
                </form>
            </aside>
            <div id="stats">
                <ul>
                    <li><p>Date joined: <br><?php echo htmlspecialchars($date_joined) ?></p></li>
                    <?php  if($type == 'seller'){
                        echo "<li><p>Products listed:<br>".htmlspecialchars($num_products_listed)."</p></li>
                            <li><p>Products sold: <br>".htmlspecialchars($num_products_sold)."</p></li>";
                    } 
                        echo "<li><p>Products bought: <br>".htmlspecialchars($num_products_bought)."</p></li>";
                    ?>
                </ul>
            </div>  
        </section>

        <?php
        require_once "Footer.php";
        ?>
    
</body>
</html>