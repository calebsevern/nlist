<?php

	/*
	* Include compatibility for PHP >= 5.3.7 without
	* password_* functionality
	* /

	require "php/password_compat/lib/password.php";

	
    /*
    *    Creates base user with credentials
    *    u: admin
    *    p: password
    */

    $configs = include('conf.php');

    $db = $configs['db'];
    $servername = $configs['host'];
    $username = $configs['username'];
    $password = $configs['password'];
    $email = $configs['email'];
    $full_name = $configs['full_name'];

    // Create connection
    $link = new mysqli($servername, $username, $password);

    // Check connection
    if ($link->connect_error) {
        die("Connection failed: " . $link->connect_error);
    }


    //DB initialization

    mysqli_query($link, "CREATE DATABASE IF NOT EXISTS $db;");
    $econ_db = mysqli_select_db($link, "$db");
    if(!$econ_db)
        die("Can't connect to primary database.\n");
    else
        echo "Connected to primary database.\n";


    //Create Users table
    $sql = "CREATE TABLE IF NOT EXISTS Users( ";
    $sql .= "id VARCHAR(256) NOT NULL, ";
    $sql .= "username VARCHAR(100) NOT NULL, ";
    $sql .= "password VARCHAR(256) NOT NULL, ";
    $sql .= "email VARCHAR(100) NOT NULL, ";
    $sql .= "admin BOOLEAN NOT NULL, ";
    $sql .= "full_name VARCHAR(256) NOT NULL);";

    $create_users = mysqli_query($link, $sql);
    if(!$create_users)
        die("Could not create Users table.\n");
    else
        echo "Created Users table.\n";


    //Create Participants table
    $sql = "CREATE TABLE IF NOT EXISTS Participants( ";
    $sql .= "id VARCHAR(256) NOT NULL, ";
    $sql .= "email VARCHAR(100) NOT NULL, ";
    $sql .= "password VARCHAR(256) NOT NULL, ";
    $sql .= "phone_number VARCHAR(256) NOT NULL, ";
    $sql .= "tag VARCHAR(256) NOT NULL, ";
    $sql .= "notes VARCHAR(512) NOT NULL, ";
    $sql .= "full_name VARCHAR(256) NOT NULL);";

    $create_participants = mysqli_query($link, $sql);
    if(!$create_participants)
        die("Could not create Participants table.\n");
    else
        echo "Created Participants table.\n";


    //Create Registration table
    $sql = "CREATE TABLE IF NOT EXISTS Registration( ";
    $sql .= "id VARCHAR(256) NOT NULL, ";
    $sql .= "active BOOLEAN NOT NULL, ";
    $sql .= "standby BOOLEAN NOT NULL, ";
    $sql .= "confirmed BOOLEAN NOT NULL, ";
    $sql .= "associated_participant VARCHAR(256) NOT NULL, ";
    $sql .= "associated_experiment VARCHAR(256) NOT NULL, ";
    $sql .= "associated_session VARCHAR(256) NOT NULL);";

    $create_registration = mysqli_query($link, $sql);
    if(!$create_registration)
        die("Could not create Registration table.\n");
    else
        echo "Created Registration table.\n";


    //Create Experiments table
    $sql = "CREATE TABLE IF NOT EXISTS Experiments( ";
    $sql .= "id VARCHAR(256) NOT NULL, ";
    $sql .= "name VARCHAR(256) NOT NULL, ";
    $sql .= "description VARCHAR(512) NOT NULL, ";
    $sql .= "class_name VARCHAR(256) NOT NULL, ";
    $sql .= "proctor_email VARCHAR(256) NOT NULL, ";
    $sql .= "finished BOOLEAN NOT NULL, ";
    $sql .= "proctor VARCHAR(256) NOT NULL);";

    $create_experiments = mysqli_query($link, $sql);

    if(!$create_experiments)
        die("Could not create Experiments table.\n");
    else
        echo "Created Experiments table.\n";


    //Create Participant_Attributes table
    $sql = "CREATE TABLE IF NOT EXISTS Participant_Attributes( ";
    $sql .= "name VARCHAR(256) NOT NULL, ";
    $sql .= "description VARCHAR(512) NOT NULL, ";
    $sql .= "active BOOLEAN NOT NULL);";

    $create_participant_attributes = mysqli_query($link, $sql);

    if(!$create_participant_attributes)
        die("Could not create Participant_Attributes table.\n");
    else
        echo "Created Participant_Attributes table.\n";


    //Create Sessions table
    $sql = "CREATE TABLE IF NOT EXISTS Sessions( ";
    $sql .= "id VARCHAR(256) NOT NULL, ";
    $sql .= "start_date VARCHAR(256) NOT NULL, ";
    $sql .= "start_time VARCHAR(512) NOT NULL, ";
    $sql .= "end_time VARCHAR(256) NOT NULL, ";
    $sql .= "duration VARCHAR(256) NOT NULL, ";
    $sql .= "required_participants VARCHAR(256) NOT NULL, ";
    $sql .= "reserve_participants VARCHAR(256) NOT NULL, ";
    $sql .= "associated_experiment VARCHAR(256) NOT NULL, ";
    $sql .= "notes VARCHAR(256) NOT NULL, ";
    $sql .= "reminder VARCHAR(256) NOT NULL, ";
    $sql .= "laboratory VARCHAR(256) NOT NULL);";

    $create_sessions = mysqli_query($link, $sql);

    if(!$create_sessions)
        die("Could not create Sessions table.\n");
    else
        echo "Created Sessions table.\n";


    //Create Documents table
    $sql = "CREATE TABLE IF NOT EXISTS Documents( ";
    $sql .= "id VARCHAR(256) NOT NULL, ";
    $sql .= "name VARCHAR(256) NOT NULL, ";
    $sql .= "associated_experiment VARCHAR(256) NOT NULL, ";
    $sql .= "url VARCHAR(256) NOT NULL);";

    $create_documents = mysqli_query($link, $sql);

    if(!$create_documents)
        die("Could not create Documents table.\n");
    else
        echo "Created Documents table.\n";


    //Create Email table
    $sql = "CREATE TABLE IF NOT EXISTS Email( ";
    $sql .= "id VARCHAR(256) NOT NULL, ";
    $sql .= "content TEXT NOT NULL);";

    $create_email = mysqli_query($link, $sql);

    if(!$create_email)
        die("Could not create Email table.\n");
    else
        echo "Created Email table.\n";

    //Create default administrator with password "password"

    $username = "admin";
    $password = password_hash("password", PASSWORD_DEFAULT);
    $sql = "INSERT INTO Users (id, username, password, email, admin, full_name) ";
    $sql .= "VALUES ('" . mt_rand() . "', '" . $username . "', '" . $password . "', '" . $email . "', 1, '" . $full_name . "');";

    $create_admin = mysqli_query($link, $sql);
    if(!$create_admin)
        die("Could not create admin account.\n");
    else
        echo "Created administrator.\n";

    header("Location: index.php");

