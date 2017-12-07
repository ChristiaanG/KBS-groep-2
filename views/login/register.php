<?php
session_start();

include_once "../../src/login/check/CheckLoggedIn.php";
require_once '../../lib/securimage/securimage.php';

$secureimage = new Securimage();
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
    <link href="../../resources/css/register.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php
        if(isset($_SESSION["registerfailed"])) {
    ?>
        <div class="alert alert-danger">
            <?php
                echo $_SESSION["registerfailed"];
                $_SESSION['registerfailed'] = NULL;
            ?>
        </div>
        <?php
        }
    ?>
    <div class="loginForm">
        <form class="form-signin" method="post" action="../../src/login/Register.php">
            <div class="loginFormHeader">
                <h2 class="form-signin-heading">Registreer</h2>
            </div>
            <div class="loginFormBody">
                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" name="username" id="inputEmail" class="form-control" placeholder="Email address" autofocus="autofocus">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
                <label for="inputName" class="sr-only">Name</label>
                <input type="text" name="name" id="inputName" class="form-control" placeholder="Name" />
                <?= $secureimage->getCaptchaHtml(); ?>
            </div>
            <div class="loginFormFooter">
                <button class="btn btn-lg btn-primary btn-signin" type="submit" name="submit">Registreer</button>
            </div>
    </form>
    </div>
</div>
</body>
</html>