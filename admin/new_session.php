<?php
	$experiment_id = $_GET['experiment_id'];
?>

<!doctype html>
<html>
	<head>
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="../css/styles.css">
	</head>

	<body>
	
	<div class="page-header">
		<div class="header-text">
			New Session
		</div>
	</div>

	<div class="new-form-container">
		<form class="new-form new-session" method="POST">
		
			<div class="form-label" data-for="experiment-name">Experiment Name</div><br>
			<input type="text" class="experiment-name" placeholder="Experiment Name">
			
			<br>
			
			<div class="form-label" data-for="experiment-description">Description</div><br>
			<textarea rows="4" class="experiment-description" placeholder="Description"></textarea>
			
			<br>
			
			<div class="form-label" data-for="experiment-class">Class</div><br>
			<input type="text" class="experiment-class" placeholder="Class (e.g. ECON 400)">
			
			<br>
			
			<div class="form-label" data-for="experiment-proctor">Proctor Name</div><br>
			<input type="text" class="experiment-proctor" placeholder="Proctor Name">
			
			<br>
		
			<div class="form-label" data-for="experiment-proctor-email">Proctor Email</div><br>
			<input type="text" class="experiment-proctor-email" placeholder="Proctor Email">
			
			<br><br>
			
			<input type="submit" value="CREATE EXPERIMENT">
			<br><br>
		</form>
	</div>
	
	<script src="../js/jquery.2.1.1.min.js"></script>
	<script src="../js/script.js"></script>
	<script src="../js/db.js"></script>
	<script>
		$(function() {
			newSessionDetails("<?php echo $experiment_id;?>");
		});
	</script>
	
	</body>

</html>