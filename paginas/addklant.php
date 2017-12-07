<?php
$pdo = new PDO("mysql:host=localhost; dbname=mydb2; port=3306", "root", "");
$stmt = $pdo->prepare("SELECT max(customerID) FROM customer");
$stmt->execute();
$klanten = $stmt->fetch();
$pdo = NULL;
$nieuwnummer = $klanten["max(customerID)"] + 1;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <?php include 'nav.php'; ?>
    </head>
    <body>
        <?php
        include 'sideklant.php';
        ?>
        <div id="page-wrapper">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>klant toevoegen</h3>
                    </div>
                    <div class="panel-body" >
                        <form  method="get" action="overzicht.php">
                            <input type="hidden" name="test">
                            <div class="form-group col-xs-4 row">
                                <label for="voornaam" class="col-2 col-form-label">voornaam</label>
                                <div>
                                    <input class="form-control" type="text" name="voornaam" id="voornaam" required>
                                </div>
                                <label for="achternaam" class="col-2 col-form-label">achternaam</label>
                                <div>
                                    <input class="form-control" type="text" name="achternaam" id="achternaam" required>
                                </div>

                                <label for="email" class="col-2 col-form-label">email adres</label>
                                <div>
                                    <input class="form-control" type="text" name="email" id="email" required>
                                </div>
                                <label for="phonenr" class="col-2 col-form-label">telefoonnummer</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="phonenr" id="phonenr" required>
                                </div>
                                <label for="cellphoneNr" class="col-2 col-form-label">telefoonnummer 2 <i>(optioneel)</i></label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="cellphoneNr" id="cellphoneNr">
                                </div>
                                <br>
                                <input  type="submit" name="toevoegen" class="btn btn-primary" value="Toevoegen">
                            </div>
                            <div  class="form-group col-xs-4 row center-block">
                                <label for="adres" class="col-2 col-form-label">adres</label>
                                <div>
                                    <input class="form-control" type="text" name="adres" id="adres" required>
                                </div>
                                <label for="woonplaats" class="col-2 col-form-label">woonplaats</label>
                                <div>

                                    <input class="form-control" type="text" name="woonplaats" id="woonplaats" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
