<!doctype html>
<html>
	<head>
		<link rel="stylesheet" href="../css/styles.css">
	</head>

	<body>
	
	<div class="page-header">
		<div class="header-text">
			Participant Attributes
		</div>
	</div>

	<div class="new-form-container">
		<div class="new-form">
		
			<br>
			
			You can create custom attributes for participants if there's any special information you'd like to record.
			
			<br><br>
			
			<table class="custom-attributes">
				<thead>
					<tr>
						<td>Name</td>
						<td>Description</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="attribute-name">Name</td>
						<td class="attribute-description">Participant's full name</td>
					</tr>
					<tr>
						<td class="attribute-name">Email</td>
						<td class="attribute-description">Participant's email address</td>
					</tr>
					<tr>
						<td class="attribute-name">Phone Number</td>
						<td class="attribute-description">Participant's primary phone number</td>
					</tr>
					<tr>
						<td class="attribute-name">Notes</td>
						<td class="attribute-description">Any additional notes</td>
					</tr>
					<tr>
						<td class="attribute-name">
							<input type="text" class="new-attr-name" placeholder="New Field" style="width: 90%;">
						</td>
						<td class="attribute-description">
							<input type="text" class="new-attr-description" placeholder="Description" style="width: 90%;">
						</td>
					</tr>
				</tbody>
			</table>			
		</div>
	</div>
	
	<script src="../js/jquery.2.1.1.min.js"></script>
	<script src="../js/script.js"></script>
	<script src="../js/db.js"></script>
	
	</body>

</html>