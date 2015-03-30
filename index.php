<?php

    if(file_exists("conf.php") && (file_get_contents("conf.php") != "")) {
    
        require_once('auth/auth_check.php');
        require_once('pages/navigation.php');
    
    } else {
    
        require_once('pages/install.php');
    
    }

    
?>