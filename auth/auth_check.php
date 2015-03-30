<?php
    
    session_start();
    
    echo "SESSION: " . $_SESSION["id"];
    
    if(!$_SESSION["username"]) {
        header('Location: auth');
    }
    