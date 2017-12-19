<?php
session_start();

include_once "../../src/login/check/CheckNotLoggedIn.php"
?><!DOCTYPE html>
<?php
if (isset($_GET["nummer"]))
    include_once "../../config/Database.php";
$pdo = getDbConnection();
$stmt = $pdo->prepare("update reparation set active=0 where repairID = ?");
$stmt->execute(array($_GET["nummer"]));
$pdo = NULL;
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Jacco Rieks">

        <?php include '../template/nav.php'; ?>
        <?php include '../template/cssinc.php'; ?>
        <?php include '../template/jsinc.php'; ?>

    </head>
    <body>
        <?php include '../template/sideklant.php'; ?>
        <div id="page-wrapper" class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3> reparatie verwijderd</h3>
                </div>
                <div class="panel-body">
                    <?php print("reparatie met het nummer " . $_GET["nummer"] . " is verwijderd"); ?>
                </div>
                <div class="panel-footer">
                    <a href="repairoverzicht.php">Terug naar het overzicht</a>
                </div>
            </div>
        </div>



    </body>
</html>