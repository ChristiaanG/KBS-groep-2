<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION["function"])) {
    if ($_SESSION["function"] == "stagiair") {
        header("Location: ../dashboard/index.php");
        die();
    }
}
include_once "../../src/login/check/CheckNotLoggedIn.php";
?>
<?php
include_once "../../config/Database.php";
$pdo = getDbConnection();
$stmt = $pdo->prepare("SELECT * FROM customer WHERE customerID=?");
$stmt->execute(array($_GET["nummer"]));
$klant = $stmt->fetch();

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
        <?php include '../template/nav.php'; ?>
        <?php include '../template/cssinc.php'; ?>
        <?php include '../template/jsinc.php'; ?>

    </head>
    <body>
        <?php include '../template/sideklant.php'; ?>

        <div id = "page-wrapper">
            <div class = "panel panel-primary">
                <div class = "panel-heading">
                    <h3>klantgegevens <?php print ($klant["first_name"] . " " . $klant["last_name"]); ?></h3>
                </div>
                <div class="panel-body">
                    <div class="form-group col-xs-4 row">
                        <form action="klant.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="nummer" value="<?php print( $_GET["nummer"]); ?>">
                            <input type="hidden" name="customerid" value="<?php print( $_GET["nummer"]); ?>">
                            <label for="compnaam" class="col-2 col-form-label">bedrijfsnaam</label>
                            <div><input type="text" id="compnaam" class="form-control" name="compnaam" value="<?php print($klant["comp_name"]); ?>"></div><br>
                            <label for="voornaam" class="col-2 col-form-label">voornaam</label>
                            <div><input type="text" id="voornaam" class="form-control" name="voornaam" value="<?php print($klant["first_name"]); ?>"></div><br>
                            <label for="achternaam" class="col-2 col-form-label">achternaam</label>
                            <div><input type="text" id="achternaam" class="form-control" name="achternaam" value="<?php print($klant["last_name"]); ?>"></div><br>
                            <label for="adres" class="col-2 col-form-label">adres</label>
                            <div><input type="text" id="adres" class="form-control" name="adres" value="<?php print($klant["address"]); ?>"></div><br>
                            <label for="woonplaats" class="col-2 col-form-label">woonplaats</label>
                            <div><input type="text" id="woonplaats" class="form-control" name="city" value="<?php print($klant["city"]); ?>"></div><br>
                            </div>
                            <div  class="form-group col-xs-4 row center-block">
                                <label for="email" class="col-2 col-form-label">email</label>
                                <div><input type="email" id="email" class="form-control" name="email" value="<?php print($klant["email"]); ?>"></div><br>
                                <label for="telnr" class="col-2 col-form-label">telefoon nummer</label>
                                <div><input type="tel" id="telnr" class="form-control" name="phonenr" value="<?php print($klant["phoneNr"]); ?>"></div><br>
                                <label for="cellphoneNr" class="col-2 col-form-label">telefoonnummer 2</label>
                                <div><input type="tel" class="form-control" id="cellphoneNr" name="cellphoneNr" value="<?php print($klant["cellphoneNr"]); ?>"></div><br>
                                <label for="opmerkingen" class="col-2 col-form-label">opmerkingen</label>
                                <div><textarea rows="3" class="form-control" id="opmerkingen" name="opmerking" ><?php print($klant["description"]); ?></textarea></div><br>
                                <input type="hidden" name="nummer" value="<?php print( $_GET["nummer"]); ?>">
                            </div>
                            <div class="form-group col-xs-4 row">
                                <div>
                                    <img src="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/resources/img/<?php print ($klant["customerID"]); ?>.jpg" class="avatar img-thumbnail" height="200" width="200"><br>
                                </div>

                                <label for="foto2" class="col-2 col-form-label">andere foto uploaden?</label>
                                <div> <input type="file" id="foto2" class="form-horizontal" name="fileToUpload" id="fileToUpload" ></div><br>
                                <label for="foto" class="col-2 col-form-label">foto geupload?</label>
                                <div><input type="checkbox"  id="foto" name="foto"></div>
                            </div>
                    </div>
                    <div class="panel-footer ">
                        <input type="submit" name="submit" class="btn right btn-primary " value="opslaan"> <a href="klant.php?nummer=<?php print( $_GET["nummer"]); ?>" class="btn btn-primary pull-right">annuleren</a>

                    </div>
                </div>

            </div>




        </div>
    </div>



</form>

</body>

</html>
