<!doctype html>
<html>
	<head>
		<link rel="stylesheet" href="../css/styles.css">
	</head>

	<body>
	
	<div class="page-header">
		<div class="header-text">
			Documents 
		</div>
	</div>

	
	<div class="experiment-sessions-pane" style="left: 30px; width: calc(100% - 70px); position: absolute; overflow-y: auto;">
		<div class="page-header">
			<div class="action import-status" style="width: 220px; text-align: left; display: none;">
				<div class="email-status-text" style="position: relative; left: 10px; top: 16px; font-size: 15px; width: auto;">
					Files must follow <a href="import_example.csv">this template</a>
				</div>
			</div>
			<div class="action import-status" style="width: 310px; text-align: left; display: none;">
				<input type="file" class="email-status-text participant-import" style="position: relative; left: 10px; top: 6px; font-size: 14px; width: auto;">
			</div>
			<div class="action email-status" style="float: right; width: 200px;">
				<input type="text" placeholder="Type to search" class="all-participant-search" style="width: auto; position: relative; top: 6px;">
			</div>
		</div>
		<table class="new-form all-documents" style="position: absolute; width: 100%;">
			<thead>
				<th>Name</th>
				<th>Experiment</th>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	
	<script src="../js/jquery.2.1.1.min.js"></script>
	<script src="../js/script.js"></script>
	<script src="../js/db.js"></script>
	<script>
		$(function() {
			getAllDocuments();
		});
	</script>
	
	</body>

</html>