<?php
session_start();

include_once "../../src/login/check/CheckNotLoggedIn.php"
?>
<?php
//hier wordt het hoogste klantnummer opgehaald en er word 1 bij opgeteld.
// zodat ik deze als filename kan gebruiken voor de foto die eventueel wordt geupload.
include_once "../../config/Database.php";
$pdo = getDbConnection();
$stmt = $pdo->prepare("SELECT max(customerID) FROM customer");
$stmt->execute();
$klanten = $stmt->fetch();
$pdo = NULL;
$nieuwnummer = $klanten["max(customerID)"] + 1;
?>
<html>
    <head>
        <meta charset="UTF-8">

        <?php include '../template/nav.php'; ?>
        <?php include '../template/cssinc.php'; ?>
        <?php include '../template/jsinc.php'; ?>

    </head>
    <body>
        <?php include '../template/sideklant.php'; ?>
        <div id="page-wrapper">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>klant toevoegen</h3>
                    </div>
                    <div class="panel-body" >
                        <form  method="post" action="overzicht.php" enctype="multipart/form-data">
                            <input type="hidden" name="nummer" value='<?php
                            //hier wordt het nieuwe nummer meegestuurd naar de uploadfunctie
                            print ($nieuwnummer)
                            ?>'>
                            <div class="form-group col-xs-4 row">
                                <label for="compnaam" class="col-2 col-form-label">bedrijfsnaam (optioneel)</label>
                                <div>
                                    <input class="form-control" type="text" name="compname" id="compnaam">
                                </div>
                                <br>
                                <label for="voornaam" class="col-2 col-form-label">voornaam</label>
                                <div>
                                    <input class="form-control" type="text" name="voornaam" id="voornaam" required>
                                </div>
                                <br>
                                <label for="achternaam" class="col-2 col-form-label">achternaam</label>
                                <div>
                                    <input class="form-control" type="text" name="achternaam" id="achternaam" required>
                                </div>
                                <br>
                                <label for="phonenr" class="col-2 col-form-label">telefoonnummer</label>
                                <div class="col-10">
                                    <input class="form-control" type="tel" name="phonenr" id="phonenr" required>
                                </div>
                                <br>
                                <label for="cellphoneNr" class="col-2 col-form-label">telefoonnummer 2 <i>(optioneel)</i></label>
                                <div class="col-10">
                                    <input class="form-control" type="tel" name="cellphoneNr" id="cellphoneNr">
                                </div>
                                <br>
                                <input  type="submit" name="toevoegen" class="btn btn-primary" value="Toevoegen">
                            </div>
                            <div  class="form-group col-xs-4 row center-block">
                                <label for="email" class="col-2 col-form-label">email adres</label>
                                <div>
                                    <input class="form-control" type="email" name="email" id="email" required>
                                </div>
                                <br>
                                <label for="adres" class="col-2 col-form-label">adres</label>
                                <div>
                                    <input class="form-control" type="text" name="adres" id="adres" required>
                                </div><br>
                                <label for="woonplaats" class="col-2 col-form-label">woonplaats</label>
                                <div>

                                    <input class="form-control" type="text" name="woonplaats" id="woonplaats" required>
                                </div><br>
                                <label for="opmerkingen" class="col-2 col-form-label">opmerkingen</label>
                                <div><textarea rows="4" class="form-control" id="opmerkingen" name="opmerking" ></textarea></div><br>
                            </div>
                            <div class="form-group col-xs-4 row">
                                <label for="foto2" class="col-2 col-form-label">klantfoto uploaden?</label>
                                <div> <input type="file" id="foto2" class="form-horizontal" name="fileToUpload" id="fileToUpload" ></div><br>
                                <label for="foto" class="col-2 col-form-label">foto geupload?</label>
                                <div><input type="checkbox"  id="foto" name="foto"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>