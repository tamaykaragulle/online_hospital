<?php
    session_start();
    if(isset($_SESSION['activeUser']) and $_SESSION['activeUser'] !== ''){
        session_unset();
        session_destroy();
        header("Location: ./Index.php");
        exit();
    }
?>
