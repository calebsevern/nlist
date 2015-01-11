<?php
	require_once('auth/auth_check.php');
	//require_once('php/db_functions.php');
	
?>
<!doctype html>
<html>
	<head>
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/styles.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="js/script.js"></script>
		<script src="js/db.js"></script>
		<script src="js/db-test.js"></script>
		<title>nlist | Home</title>
	</head>
	<body>
		<div class="nav">
			<div class="logo">
				nlist
				<i class="fa fa-home"></i>
			</div>
			<div class="tab"></div>
			<div class="label">Experiments</div>
			<div class="tab" data-url="newexperiment.html">Create New</div>
			<div class="tab" data-url="currentexperiments.html">Current</div>
			<div class="tab" data-url="completedexperiments.html">Completed</div>
			<div class="tab" data-url="currentexperiments.html">Overview</div>
			
			<div class="tab"></div>
			<div class="label">Participants</div>
			<div class="tab">Create New</div>
			<div class="tab">Overview</div>
			
			<div class="tab"></div>
			<div class="label">Utilities</div>
			<div class="tab">Documents</div>
			<div class="tab">Settings</div>
			<div class="tab">Statistics</div>
			<div class="tab"></div>
			<div class="tab logout">Logout</div>
		</div>
		<div class="content-pane">
			
		</div>
	</body>
</html>