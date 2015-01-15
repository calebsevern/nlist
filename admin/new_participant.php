<!doctype html>
<html>
	<head>
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="../css/styles.css">
	</head>

	<body>
	
	<div class="page-header">
		<div class="header-text">
			New Participant
		</div>
	</div>

	<div class="new-form-container">
		<form class="new-form create-new-experiment" method="POST">
		
			<div class="form-label" data-for="participant-name">Full Name</div><br>
			<input type="text" class="participant-name" placeholder="Full Name">
			
			<br>
			
			<div class="form-label" data-for="participant-email">Email</div><br>
			<input type="text" class="participant-email" placeholder="Email">
			
			<br>
			
			<div class="form-label" data-for="participant-phone">Phone Number</div><br>
			<input type="text" class="participant-phone" placeholder="Phone Number">
			
			<br>
		
			<div class="form-label" data-for="participant-notes">Notes</div><br>
			<textarea rows="4" class="participant-notes" placeholder="Notes"></textarea>
			
			<br><br>
			
			<input type="submit" value="CREATE PARTICIPANT">
			<br><br>
		</form>
	</div>
	
	<script src="../js/jquery.2.1.1.min.js"></script>
	<script src="../js/script.js"></script>
	<script src="../js/db.js"></script>
	
	</body>

</html>