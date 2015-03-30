<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>
    
    <div class="page-header">
        <div class="header-text">
            New Experiment
        </div>
    </div>

    <center>
    <div class="experiment-details-pane" style="position: relative; width: 500px;">
        <form class="new-form create-new-experiment" method="POST">
        
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
    </center>
    
    <script src="../js/jquery.2.1.1.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/db.js"></script>
    
    </body>

</html>