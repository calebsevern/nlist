<?php

	$configs = include('../conf.php');
	
	$link = new mysqli($configs['host'], $configs['username'], $configs['password']);

	// Check connection
	if ($link->connect_error) {
		die("Connection failed: " . $link->connect_error);
	} 
	
	$username = $_POST['email'];
	$password = $_POST['password'];
	$full_name = $_POST['full_name'];
	
	//Check to see if the user exists
	
	$sth = $link->prepare("SELECT username FROM econ.Users WHERE username=?");
	$sth -> bind_param("s", $username);
    $sth -> bind_result($u);
	$sth->execute();
	
	$user_exists = 0;
	while($sth->fetch())
		$user_exists = 1;
	
	if(!$user_exists) {
	
		$password = password_hash($password, PASSWORD_DEFAULT);
	
		$sth = $link->prepare("INSERT INTO econ.Users (id, username, password, email, admin, full_name) VALUES (?, ?, ?, ?, ?, ?);");
		$sth -> bind_param("ssssis", mt_rand(), $username, $password, $username, $temp=1, $full_name);
		//$sth -> bind_result();
		$sth->execute();
		if($sth->error)
			die($sth->error);
		//if (!$link->query($sth)) {
		//	trigger_error($link->error);
		//}
		echo "ok";
	} else {
		echo "User exists.";
	}
	
	
	
	
	
	
	