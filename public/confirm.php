<?php
    $session_id = $_GET['s'];
    $experiment_id = $_GET['e'];
    $participant_id = $_GET['p'];

    $purpose = (isset($_GET['purpose'])) ? $_GET['purpose'] : "";
?>
<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <script src="../js/jquery.2.1.1.min.js"></script>
        <script src="../js/db.js"></script>
        <script src="../js/script.js"></script>
        <title>nlist | Login</title>
    </head>
    <body class="auth-body">
        <div class="welcome-box">
            <div class="info" style="left: 220px; top: 100px;">
                <center>
                    <h1>thanks!</h1>
                </center>
                <br>
                <?php if($purpose == "registration") { ?>
                <p>
                    We're received your information and look forward to seeing you around.
                    <br>
                </p>
                <?php } else { ?>
                <p>
                    We've receieved your confirmation and look forward to seeing you at the experiment.
                    <br>
                </p>
                <?php } ?>
            </div>
        </div>
    </body>
    <script>
        $(function() {
            confirmRegistration("<?php echo $session_id;?>", "<?php echo $experiment_id;?>", "<?php echo $participant_id;?>");
        });
    </script>
</html>