<?php

	/*
	*	Creates base user with credentials
	*	u: admin
	*	p: password
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
	$sql .= "admin TINYINT(1) NOT NULL, ";
	$sql .= "full_name VARCHAR(256) NOT NULL);";
	
	$create_users = mysqli_query($link, $sql);
	if(!$create_users)
		die("Could not create Users table.\n");
	else
		echo "Created Users table.\n";
		
		
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
		
		
	//Create Sessions table
	$sql = "CREATE TABLE IF NOT EXISTS Sessions( ";
	$sql .= "id VARCHAR(256) NOT NULL, ";
	$sql .= "start_date VARCHAR(256) NOT NULL, ";
	$sql .= "start_time VARCHAR(512) NOT NULL, ";
	$sql .= "end_time VARCHAR(256) NOT NULL, ";
	$sql .= "length VARCHAR(256) NOT NULL, ";
	$sql .= "required_participants VARCHAR(256) NOT NULL, ";
	$sql .= "reserve_participants VARCHAR(256) NOT NULL, ";
	$sql .= "associated_experiment VARCHAR(256) NOT NULL, ";
	$sql .= "notes VARCHAR(256) NOT NULL, ";
	$sql .= "laboratory VARCHAR(256) NOT NULL);";
	
	$create_sessions = mysqli_query($link, $sql);
	
	if(!$create_sessions)
		die("Could not create Sessions table.\n");
	else
		echo "Created Sessions table.\n";


	//Create default administrator with password "password"

	$username = "admin";
	$password = password_hash("password", PASSWORD_DEFAULT);
	$sql = "INSERT INTO Users (id, username, password, email, admin, full_name) ";
	$sql .= "VALUES ('" . mt_rand() . "', '" . $username . "', '" . $password . "', '" . $email . "', 1, '" . $full_name . "');";
	
	$create_admin = mysqli_query($link, $sql);
	if(!$create_admin)
		echo "Error: " . mysqli_error($link);
	else
		echo "Created administrator.\n";

	echo "Connected successfully.\n\n";

