<!doctype html>
<html>
	<head>
		<link rel="stylesheet" href="../css/styles.css">
		<link rel="stylesheet" href="../css/jquery-te-1.4.0.css">
	</head>

	<body>
	
	<div class="page-header">
		<div class="header-text">
			Customize Email
		</div>
	</div>

	<br><br><br>
	
	<center>
		<textarea name="textarea" class="jqte-test"></textarea>
		
		<br>
		
		<button class="save-email-content">SAVE EMAIL</button>
	</center>
	
	<script src="../js/jquery.2.1.1.min.js"></script>
	<script src="../js/script.js"></script>
	<script src="../js/db.js"></script>
	<script src="../js/jquery-te-1.4.0.min.js"></script>
	<script>
		$(function() {
			$('.jqte-test').jqte();
			getEmailContent();
		});
	</script>
	
	</body>

</html>