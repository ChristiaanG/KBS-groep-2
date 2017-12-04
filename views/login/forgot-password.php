<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 30-11-2017
 * Time: 11:03
 */

session_start();
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
    <div class="alert <?= isset($_SESSION["mailsend"]) ? "alert-success" : (isset($_SESSION["mailerror"]) ? "alert-danger" : "")  ?>" >
    <?php
        if(isset($_SESSION["mailsend"])) {
            echo $_SESSION["mailsend"];
            $_SESSION['mailsend'] = NULL;
        } elseif(isset($_SESSION["mailerror"])) {
            echo $_SESSION["mailerror"];
            $_SESSION['mailerror'] = NULL;
        }
    ?>
    </div>
    <div class="loginForm">
        <form class="form-signin" method="post" action="../../src/login/ForgotPassword.php">
            <div class="loginFormHeader">
                Login
            </div>
            <div class="loginFormBody">
                <label for="inputEmail">Email</label>
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" autofocus="autofocus">
            </div>
            <div class="loginFormFooter">
                <button class="btn btn-lg btn-primary btn-signin" type="submit" name="submit">Verstuur</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
