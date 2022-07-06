<?php
    $loggedIn = isset($_SESSION['activeUser']);
    echo"<nav>
        <h1><a href='Index.php'>SILKY</a></h1>
            <ul>
                <li><h3><a href='Catalog.php'>Catalog</a></h3></li>";
                
                if(!$loggedIn){
                    echo "<li><h3><a href='Login.php'>LOGIN</a></li>";
                }
                else if(isset($_SESSION['activeUser']) and isset($_SESSION['userType'])){
                    
                    $userType = unserialize($_SESSION['userType']);
                    if (strtolower($userType) == "seller"){
                        echo "<li><h3><a href='Products.php'>Products</a></h3></li>";
                    }
                    
                    $activeUser = unserialize($_SESSION['activeUser']);
                        echo "
                <li><h3><a href='UserProfile.php'><span style='color:rgb(240, 244, 247);'>Welcome, </span> ".strtoupper($activeUser->getUsername())."!</a></h3></li>
                <li><a href='Logout.php'>Logout</a></li>";
                }
    echo    "</ul>
        </nav>";
?>
