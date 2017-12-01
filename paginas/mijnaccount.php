<!DOCTYPE html>

<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=mydb;port=3306", "root", "");

$stmt = $pdo->prepare("SELECT * FROM user WHERE username= \"test@test.nl\"");
$stmt->execute();
$user = $stmt->fetch();

// eerst opslaan
if(isset($_POST["opslaanpass"])) {
    if($_POST["oldpass"] == $user["password"]) {
    if(isset($_POST["password2"])) {
        if ($_POST["password"] != $_POST["password2"]) {
            $_SESSION["validpass"] = "Passwords niet gelijk";
            header("location: bewerkpassword.php");
            exit(); 
        }
     else {
    $stmt = $pdo->prepare("UPDATE `user` SET `password`=? WHERE `user`.`username`=\"test@test.nl\"");
    $stmt->execute(array($_POST["password"]));
    unset($_POST["password2"]);
}}} else {$_SESSION["validoldpass"] = "Oude password niet correct";
            header("location: bewerkpassword.php");
            exit(); }
            
}
if (isset($_POST["opslaan"])) {
    $stmt = $pdo->prepare("UPDATE `user` SET `name`=? WHERE `user`.`username`=\"test@test.nl\"");
    $stmt->execute(array($_POST["name"]));
}



// daarna pas de user uit de database selecteren zodat je de gewijzigde gegevens ziet
$stmt = $pdo->prepare("SELECT * FROM user WHERE username= \"test@test.nl\"");
$stmt->execute();
$user = $stmt->fetch();
$pdo = NULL;
$_POST["username"] = "test@test.nl"

?>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Jacco Rieks & Bram Kas">

        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <link href="../css/metisMenu.min.css" rel="stylesheet">

        <link href="../css/startmin.css" rel="stylesheet">

        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>Mijn Account v0.1</title>
        <?php include 'nav.php'; ?>

    </head>
    <body>
        <div id="page-wrapper"
             <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3>gegevens van <?php print ($user["name"]) ; ?> v0.1</h3>
                        </div>
                        <div class="panel-body">
                            <br>
                            <?php if (isset($_POST["opslaan"])) {print("<i>Naam gewijzigd</i><br>");} ?>
                            <?php if (isset($_POST["opslaanpass"])) {print("<i>Password gewijzigd</i><br>");} ?>
                            Username: <?php print($user["username"]); ?><br>
                            Naam: <?php print($user["name"]); ?><br>
                            Rol: <?php print($user["role"]); ?><br>
                            <input type="hidden" name="username" value="<?php print($user["username"]); ?>">
                        </div>
                        <div class="panel-footer">
                            <?php print("<a href=\"bewerkaccount.php?username=" . $user["username"] . "\"class=\"btn btn-primary\">Bewerk account</a>"); ?>
                        </div>
                    </div>
                </div>



            </div>

            <script src="../js/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/metisMenu.min.js"></script>
            <script src="../js/dataTables/jquery.dataTables.min.js"></script>
            <script src="../js/dataTables/dataTables.bootstrap.min.js"></script>
            <script src="../js/startmin.js"></script>

            <script>
                $(document).ready(function () {
                    $('#dataTables-example').DataTable({
                        responsive: true
                    });
                });
            </script>
        </div>

    </body>
</html>