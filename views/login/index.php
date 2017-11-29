<?php
session_start();

if(isset($_SESSION["loggedin"])) {
    include_once "../../config/Config.php";

    $config = config();

    header("Location: " . $config["home"]);
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <link href="../../resources/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../resources/css/login.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php
            if(isset($_SESSION["loginfailed"])) {
        ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION["loginfailed"]; ?>
            </div>
        <?php
            }
        ?>
        <div class="loginForm">
            <form class="form-signin" method="post" action="../../src/login/Login.php">
                <div class="loginFormHeader">
                    Login
                </div>
                <div class="loginFormBody">
                    <label for="inputUsername">Gebruikersnaam</label>
                    <input type="email" name="username" id="inputUsername" class="form-control" placeholder="Gebruikersnaam" autofocus="autofocus">
                    <label for="inputPassword">Wachtwoord</label>
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Wachtwoord">
                </div>
                <div class="loginFormFooter">
                    <a href="">Bent u uw wachtwoord vergeten?</a>
                    <button class="btn btn-lg btn-primary btn-signin" type="submit" name="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>