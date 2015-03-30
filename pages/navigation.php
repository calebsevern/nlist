<!doctype html>
<html>
    <head>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/styles.css">
        <title>nlist | Home</title>
    </head>
    <body>
        <div class="nav">
            <div class="logo">
                nlist
                <!--<i class="fa fa-home"></i>-->
            </div>
            <div class="tab"></div>
            <div class="label">Experiments</div>
            <div class="tab" data-url="admin/new_experiment.php">Create New</div>
            <div class="tab selected" data-url="admin/current_experiments.php">Current</div>
            <div class="tab" data-url="admin/completed_experiments.php">Completed</div>
            <div class="tab" data-url="admin/all_experiments.php">All</div>

            <div class="tab"></div>
            <div class="label">Participants</div>
            <div class="tab" data-url="admin/new_participant.php">Create New</div>
            <div class="tab" data-url="admin/participant_overview.php">All</div>

            <div class="tab"></div>
            <div class="label">Utilities</div>
            <div class="tab" data-url="admin/documents.php">Documents</div>
            <div class="tab" data-url="admin/email_content.php">Email</div>
            <div class="tab"></div>
            <div class="tab logout">Logout</div>
        </div>
        <iframe class="content-pane" src="admin/current_experiments.php"></iframe>

        <script src="js/jquery.2.1.1.min.js"></script>
        <script src="js/script.js"></script>
        <script src="js/db.js"></script>
        <script src="js/db-test.js"></script>
    </body>
</html>