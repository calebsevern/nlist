<?php
	$experiment_id = $_GET['experiment_id'];
?>

<!doctype html>
<html>
	<head>
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
		<link rel="stylesheet" href="../css/styles.css">
		<link rel="stylesheet" href="../css/jquery.timepicker.css">
	</head>

	<body>
	
	<div class="page-header">
		<div class="header-text">
			New Session
		</div>
	</div>

	<br>
	
	<div class="new-form-container">
		<form class="new-form new-session" method="POST">
		
			<div class="form-label" data-for="session-date" style="display: inline;">Date</div><br>
			<input type="date" class="session-date" placeholder="Session Date">
			
			<br>
			
			<div class="form-label" data-for="session-time" style="display: inline;">Time</div><br>
			<input type="text" class="session-time">
			
			<br>
			
			<div class="form-label" data-for="session-lab">Laboratory</div><br>
			<input type="text" class="session-lab" placeholder="Laboratory">
			
			<br>
			
			<div class="form-label" data-for="session-length" style="display: inline;">Duration</div><br>
			<input type="text" class="session-length">
			
			<br>
		
			<div class="form-label" data-for="required-participants" style="display: inline;">Required Participants</div><br>
			<input type="number" class="required-participants" value="12">
			
			<br>
			
			<div class="form-label" data-for="reserve-participants" style="display: inline;">Reserve Participants</div><br>
			<input type="number" class="reserve-participants" value="0">
			
			<br>
			
			<div class="form-label" data-for="session-notes">Notes</div><br>
			<textarea rows="4" class="session-notes" placeholder="Notes"></textarea>
			
			<br><br>
			
			<input type="submit" value="CREATE SESSION">
			<br><br>
		</form>
	</div>
	
	<script src="../js/jquery.2.1.1.min.js"></script>
	<script src="../js/jquery-ui.min.js"></script>
	<script src="../js/jquery.timepicker.min.js"></script>
	<script src="../js/script.js"></script>
	<script src="../js/db.js"></script>
	<script>
		function checkDateInput() {
			var input = document.createElement('input');
			input.setAttribute('type','date');

			var notADateValue = 'not-a-date';
			input.setAttribute('value', notADateValue); 

			return !(input.value === notADateValue);
		}
		
		$(function() {
			
			//Set date and time inputs
			
			if(!checkDateInput())
				$("input[type='date']").datepicker();
			
			$(".session-time").timepicker();
			$(".session-time").timepicker('setTime', new Date());
			
			$(".session-length").timepicker();
			$('.session-length').timepicker({'timeFormat': 'H:i:s'});
				
				
			newSessionDetails("<?php echo $experiment_id;?>");
		});
	</script>
	
	</body>

</html>








