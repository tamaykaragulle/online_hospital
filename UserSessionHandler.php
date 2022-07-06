<?php 
    // DELETE USER SESSION IF "N" SECONDS HAS PASSED
    
    /* 1 DAY ==> */$N = 86400;
    if(isset($_SESSION["lastActivity"]) and time() - $_SESSION["lastActivity"] >= $N){
        session_unset();
        session_destroy();
    } 
    else{
        $_SESSION["lastActivity"] = time();
        session_write_close();
    }
    
?>