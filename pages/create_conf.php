<?php
    
    $db = $_POST['db'];
    $mysql_username = $_POST['mysql_username'];
    $mysql_password = $_POST['mysql_password'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $smtp_host = $_POST['smtp_host'];
    $smtp_port = $_POST['smtp_port'];
    $smtp_login = $_POST['smtp_login'];
    $smtp_password = $_POST['smtp_password'];
    
    $conf_text = file_get_contents("conf_template.txt");
    
    $conf_text = str_replace("db_placeholder", $db, $conf_text);
    $conf_text = str_replace("username_placeholder", $mysql_username, $conf_text);
    $conf_text = str_replace("password_placeholder", $mysql_password, $conf_text);
    $conf_text = str_replace("email_placeholder", $email, $conf_text);
    $conf_text = str_replace("full_name_placeholder", $full_name, $conf_text);
    $conf_text = str_replace("smtp_host_placeholder", $smtp_host, $conf_text);
    $conf_text = str_replace("smtp_port_placeholder", $smtp_port, $conf_text);
    $conf_text = str_replace("smtp_login_placeholder", $smtp_login, $conf_text);
    $conf_text = str_replace("smtp_password_placeholder", $smtp_password, $conf_text);
    
    if(chmod("../conf.php", 0777)) 
        chmod("../conf.php", 0755);
        
    $content = file_put_contents("../conf.php", $conf_text); 
    
    if($content == 0) {
        echo "Install failed - please check the permissions on conf.php to ensure it is writeable.";
    } else {
        header("Location: ../setup.php");
    }
    
    