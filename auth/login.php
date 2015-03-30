<?php

    $configs = include('../conf.php');

    $link = new mysqli($configs['host'], $configs['username'], $configs['password']);

    // Check connection
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }

    $username = $_POST['email'];
    $password = $_POST['password'];

    $sth = $link->prepare("SELECT id, username, password, full_name FROM Users WHERE username=?");
    $sth -> bind_param("s", $username);
    $sth -> bind_result($id, $username, $hash, $full_name);
    $sth->execute();
    while($sth->fetch()) {

        //Verify the password
        if (password_verify($password, $hash)) {
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["full_name"] = $full_name;
            $_SESSION["id"] = $id;

            echo "ok";
            exit();
        }

    }

    echo "Email/password not found.";
