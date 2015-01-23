<?php

	$experiment_id = $_GET['experiment'];
	
	$index_check = explode(".", $_FILES['doc']['name']);
	$index_check = $index_check[0];
	
	if(!$_FILES['doc']['name']) {
		
		header("Location: ../admin/experiment.php?id=" . $experiment_id);
	
	} else if($index_check == "index") {
		
		echo 'Sorry, but that filename is not allowed.';
		echo '<br><br><a href="../admin/experiment.php?id=' . $experiment_id . '">Go Back</a>';
		
	} else if($_FILES['doc']['error']) {
		
		echo 'The following error occured:  ' . $_FILES['doc']['error'];
		echo '<br><br><a href="../admin/experiment.php?id=' . $experiment_id . '">Go Back</a>';
	
	} else if(file_exists(dirname(__FILE__) . '/' . $_FILES['doc']['name'])) {
		
		echo 'You have already uploaded that file.<br><br>';
		echo 'Please give it a different name if you wish to upload it again.';
		echo '<br><br><a href="../admin/experiment.php?id=' . $experiment_id . '">Go Back</a>';
		
	} else {
		
		//Move the file from /tmp 
		
		move_uploaded_file($_FILES['doc']['tmp_name'], dirname(__FILE__) . '/' . $_FILES['doc']['name']);
		
		
		//Build the file url
		
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url = explode("?experiment=$experiment_id", $url);
		$url = $url[0];
		$url .= $_FILES['doc']['name'];
		
		//Create row in the Documents table
		
		$configs = include('../conf.php');
		$db = $configs['db'];
		
		$link = new mysqli($configs['host'], $configs['username'], $configs['password']);
		if ($link->connect_error)
			die("Connection failed: " . $link->connect_error);

		$sth = $link->prepare("INSERT INTO $db.Documents (id,name,associated_experiment,url) VALUES (?,?,?,?)");
		$sth -> bind_param("ssss", mt_rand(), $_FILES['doc']['name'], $experiment_id, $url);
		$sth->execute();

		
		
		
		
		
		
		header("Location: ../admin/experiment.php?id=" . $experiment_id);
	}
