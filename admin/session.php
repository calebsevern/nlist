<?php
	$session_id = $_GET['id'];
	$experiment = $_GET['experiment'];
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
			Edit Session
		</div>
	</div>

	<br>
	
	<div class="new-form-container">
		<form class="new-form edit-session" method="POST">
		
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
			<input type="number" class="required-participants">
			
			<br>
			
			<div class="form-label" data-for="reserve-participants" style="display: inline;">Reserve Participants</div><br>
			<input type="number" class="reserve-participants">
			
			<br>
			
			<div class="form-label" data-for="session-notes">Notes</div><br>
			<textarea rows="4" class="session-notes" placeholder="Notes"></textarea>
			
			<br><br>
			
			<input type="submit" value="SAVE SESSION">
			<br><br>
		</form>
	</div>
	
	<div class="experiment-sessions-pane" style="overflow-y: auto;">
		<div class="page-header">
			<div class="header-text">
				Participants
			</div>
			
			<a href="#" class="action save-session-participants">
				<i class="fa fa-floppy-o"></i>
			</a>
			<a href="#" class="action send-session-emails" id="<?php echo $session_id;?>">
				<i class="fa fa-envelope-o"></i>
			</a>
			<div class="action email-status" style="width: 150px; display: none;">
				<i class="fa fa-spinner fa-spin"></i> 
				<text class="email-status-text" style="position: relative; left: 10px; top: 15px;">
					Sending
				</text>
			</div>
			<div class="action email-status" style="float: right; width: 200px;">
				<input type="text" placeholder="Type to search" class="participant-search" style="width: auto; position: relative; top: 6px;">
			</div>
			
			
		</div>
		
		<table class="sessions-list" style="width: 100%; height: auto; border-collapse: collapse; background: none;">
			<thead>
				<tr>
					<th></th>
					<th><input type="checkbox" class="select-all">Add</th>
					<th>Standby</th>
					<th style="text-align: left;">Name</th>
					<th style="text-align: left;">Email</th>
					<th style="text-align: left;">Tag</th>
				</tr>
			</thead>
		</table>
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
			
			getSessionParticipants("<?php echo $session_id;?>", "<?php echo $experiment;?>");
			
			//Set date and time inputs
			
			if(!checkDateInput())
				$("input[type='date']").datepicker();
			
			$(".session-time").timepicker();
			
			$(".session-length").timepicker();
			$('.session-length').timepicker({'timeFormat': 'H:i:s'});
				
				
			editSessionDetails("<?php echo $session_id;?>");
		});
	</script>
	
	</body>

</html>








