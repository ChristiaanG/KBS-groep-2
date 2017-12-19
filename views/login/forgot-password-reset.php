<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 4-12-2017
 * Time: 16:05
 */
session_start();

include_once "../../src/login/check/CheckLoggedIn.php";
include_once "../../src/login/check/CheckPasswordReset.php";
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
            <div class="alert <?= isset($_SESSION["passwordReset"]) ? "alert-success" : (isset($_SESSION["resetPasswordFailed"]) ? "alert-danger" : "") ?>" >
                <?php
                if (isset($_SESSION["passwordReset"])) {
                    echo $_SESSION["passwordReset"];
                    $_SESSION['passwordReset'] = NULL;
                } elseif (isset($_SESSION["resetPasswordFailed"])) {
                    echo $_SESSION["resetPasswordFailed"];
                    $_SESSION['resetPasswordFailed'] = NULL;
                }
                ?>
            </div>
            <div class="loginForm">
                <form class="form-signin" method="post" action="../../src/login/ForgotPasswordReset.php">
                    <div class="loginFormHeader">
                        Wijzig wachtwoord
                    </div>
                    <div class="loginFormBody">
                        <label for="inputPassword">Nieuw wachtwoord</label>
                        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Nieuw wachtwoord" autofocus="autofocus">
                        <label for="inputPasswordRepeat">Wachtwoord herhalen</label>
                        <input type="password" name="passwordRepeat" id="inputPasswordRepeat" class="form-control" placeholder="Wachtwoord herhalen" autofocus="">
                    </div>
                    <div class="loginFormFooter">
                        <button class="btn btn-lg btn-primary btn-signin" type="submit" name="reset">Verstuur</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
