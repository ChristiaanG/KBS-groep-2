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
    <link href="../../resources/css/register.css" rel="stylesheet">
</head>
<body>
<div class="container">

    <form class="form-signin" method="post" action="../../src/login/Register.php">
        <h2 class="form-signin-heading">Registreer</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="username" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required="">
        <label for="inputName" class="sr-only">Name</label>
        <input type="text" name="name" id="inputName" class="form-control" placeholder="Name" required" />
        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="submit">Registreer</button>
    </form>
</div>
</body>
</html>