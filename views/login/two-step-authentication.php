<?php
session_start();

include_once "../../src/login/check/Check2faRedirect.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Google Authenticator</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <style type="text/css">
        *{margin:0;padding:0}
        body{color:#FEFEFE;background:#4A4E4F;font-family:'Open Sans', sans-serif;font-size:16px;line-height:2}
        h1{color:#F15841;font-size:30px}
        h2{color:#30B257;font-size:20px}
        a{color:#9DA08D}
        .container{width:80%;margin:100px auto;text-align:center}
        .qrcode{padding:10px;background:#fff;width:200px;height:200px;margin:20px auto;line-height:0;box-shadow:0 0 10px rgba(0,0,0,0.75)}
        form{width:250px;margin:20px auto}
        input{border:1px solid #000;font-size:20px;padding:5px 10px;text-align:center;width:128px;float:left}
        button{font-size:20px;padding:5px 0;float:right;width:100px;border:0;background:#000000;color:#fff;cursor:pointer}
        .error{background:#F15841;color:#fff;margin:20px auto;padding:5px;text-align:center;width:240px}
        .success{background:#30B257;color:#fff;margin:20px auto;padding:5px;text-align:center;width:240px}
    </style>
</head>
<body>
<div class="container">
    <h1>2 - Use Google Authenticator for signin</h1>
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
