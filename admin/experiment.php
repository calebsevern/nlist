<?php
    $id = $_GET['id'];
?>

<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>

    <div class="page-header">
        <div class="header-text name-text"></div>
    </div>

    <div class="experiment-details-pane">
        <form class="new-form save-experiment" method="POST">

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

            <div class="form-label" data-for="experiment-finished" style="display: inline;">
                <input type="checkbox" class="experiment-finished" style="width: 30px; position: relative; top: 2px;">
                Experiment Finished</div><br>

            <br><br>

            <input type="submit" value="SAVE EXPERIMENT">
            <br><br>
        </form>
    </div>

    <div class="experiment-details-pane" style="top: 610px; width: 419px;">
        <form class="new-form save-documents" enctype="multipart/form-data" action="../docs/?experiment=<?php echo $id;?>" method="POST">

            <h3>Documents</h3>
            <div class="documents-list"></div>

            <br>

            <input type="file" name="doc">
            <input type="submit" value="UPLOAD DOCUMENT">

        </form>
    </div>

    <div class="experiment-sessions-pane">
        <div class="page-header">
            <div class="header-text">
                SESSIONS
            </div>

            <a href="new_session.php?experiment_id=<?php echo $id;?>" class="action">
                <i class="fa fa-plus"></i>
            </a>
        </div>

        <div class="sessions-list">
        </div>
    </div>

    <script src="../js/jquery.2.1.1.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/db.js"></script>
    <script>
        $(function() {
            populateExperimentDetails("<?php echo $id;?>");
        });
    </script>

    </body>

</html>




