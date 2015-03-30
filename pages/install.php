<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="css/styles.css">
        <script src="js/jquery.2.1.1.min.js"></script>
        <script src="js/auth.js"></script>
        <title>nlist | Login</title>
    </head>
    <body class="auth-body">
        <div class="welcome-box">
            <div class="info">
                <center>
                    <h1>nlist</h1>
                </center>
                <br>
                <p>
                    Thanks for using nlist! To install, simply fill out the form on the right.
                    <br><br>
                    An account with the following credentials will be created - you can login and change
                    your password right away:

                    <br><br>
                    <center>
                        username: admin<br>
                        password: password
                    </center>
                </p>
            </div>
            <div class="register-box"><br>
                <h3>Server Info</h3>
                <form class="register-form install-form" method="POST" action="pages/create_conf.php">
                    <input type="text" name="db" placeholder="Database Name"><br>
                    <input type="text" name="mysql_username" placeholder="MySQL Username"><br>
                    <input type="password" name="mysql_password" placeholder="MySQL Password"><br>
                    <input type="text" name="full_name" placeholder="Full Name"><br>
                    <input type="email" name="email" placeholder="Your Email"><br>
                    <input type="text" name="smtp_host" placeholder="SMTP Host"><br>
                    <input type="text" name="smtp_port" placeholder="SMTP Port"><br>
                    <input type="text" name="smtp_login" placeholder="SMTP Login"><br>
                    <input type="password" name="smtp_password" placeholder="SMTP Password"><br><br>
                    <input type="submit" value="Install" data-flag="install">
                </form>
            </div>
        </div>
    </body>
</html>