<!DOCTYPE html>
<?php
if (isset($_GET["nummer"]))
    $pdo = new PDO("mysql:host=localhost;dbname=mydb;port=3306", "root", "");
$stmt = $pdo->prepare("delete from customer where customerID = ?");
$stmt->execute(array($_GET["nummer"]));
$pdo = NULL;
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Jacco Rieks">

        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <link href="../css/metisMenu.min.css" rel="stylesheet">

        <link href="../css/startmin.css" rel="stylesheet">

        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <?php include 'nav.php'; ?>
        <title>Klant verwijderen v0.1</title>
    </head>
    <body>
        <?php include 'sideklant.php'; ?>
        <div id="page-wrapper" class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3> klant verwijderd</h3>
                </div>
                <div class="panel-body">
                    <?php print("Klant " . $_GET["nummer"] . " is verwijderd"); ?>
                </div>
                <div class="panel-footer">
                    <a href="overzicht.php">Terug naar het overzicht</a>
                </div>
            </div>
        </div>



    </body>
</html>