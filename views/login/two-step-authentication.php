<?php
session_start();

include_once "../../src/login/check/Check2faRedirect.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Google Authenticator</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/resources/css/google-authenticator.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    <h1>Google Authenticator login</h1>
    <?php
    if(isset($_SESSION["twofafailed"])) {
        ?>
        <div class="alert alert-danger">
            <?php
                echo $_SESSION["twofafailed"];
                $_SESSION['twofafailed'] = NULL;
            ?>
        </div>
        <?php
    }
    ?>
    <form method="post" action="../../src/login/TwoStepAuthentication.php">
        <input placeholder="code" type="text" name="2fa_code" maxlength="6" autofocus="autofocus"/>
        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="submit">Verstuur</button>
        <div style="clear:both"></div>
    </form>
</div>
</body>
</html>
