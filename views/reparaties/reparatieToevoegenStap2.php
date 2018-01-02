<!DOCTYPE html>

<?php
session_start();

include_once "../../src/login/check/CheckNotLoggedIn.php"
?>
<?php
include_once "../../config/Database.php";
$pdo = getDbConnection();

$stmt = $pdo->prepare("SELECT * FROM customer WHERE customerID=?");
$stmt->execute(array(filter_input(INPUT_GET, "nummer")));
$klant = $stmt->fetch();

$stmt2 = $pdo->prepare("SELECT DISTINCT d.deviceID, deviceInfo FROM device d JOIN reparation r ON r.deviceID=d.deviceID WHERE r.customerID=?");
$stmt2->execute(array(filter_input(INPUT_GET, "nummer")));
$apparaat = $stmt2->fetchAll();

$stmt3 = $pdo->prepare("SELECT * FROM category");
$stmt3->execute();
$categorie = $stmt3->fetchAll();

$stmtMax = $pdo->prepare("SELECT MAX(deviceID)+1 FROM device");
$stmtMax->execute();
$maxDeviceID = $stmtMax->fetch();

$stmttMax = $pdo->prepare("SELECT MAX(repairID)+1 FROM reparation");
$stmttMax->execute();
$maxRepairID = $stmttMax->fetch();




$pdo = NULL;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reparatie toevoegen v0.1</title>
        <?php include '../template/nav.php'; ?>
        <?php include '../template/cssinc.php'; ?>
        <?php include '../template/jsinc.php'; ?>

    </head>
    <body>
        <?php include '../template/sideklant.php'; ?>
        <div id="page-wrapper">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Reparatie toevoegen voor <?php print($klant["first_name"] . " " . $klant["last_name"]); ?></h3>
                </div>
                <form action="repair.php" method="post" name="reparatieForm" onsubmit="return formValidation()">
                    <div class="panel-body">
                        <div class="form-group col-xs-4 row">
                            <label for="apparaatSelect" class="col-2 col-form-label">Apparaat selecteren</label>
                            <select id="apparaatSelect" name="apparaat" onchange="removeDeviceInfoForm()">
                                <option value="select">Selecteer een apparaat</option>
                                <?php
                                foreach ($apparaat as $a) {
                                    print("<option value=\"" . $a["deviceID"] . "\">" . $a["deviceInfo"] . "</option>");
                                }
                                ?>
                            </select>
                            <input type="hidden" name="nummer" value="<?php print(filter_input(INPUT_GET, "nummer")); ?>">
                            <input type="hidden" name="repair" value="<?php print($maxRepairID["MAX(repairID)+1"]); ?>">
                        </div>

                        <div class="form-group col-xs-4 row center-block" >
                            <label for="reparatiebeschrijving" class="col-2 col-form-label">Reparatie beschrijving</label>
                            <div><textarea rows="4" class="form-control" id="reparatiebeschrijving" name="repairDescription" required ></textarea></div>

                            <br>
                            <label for="reparatielader" class="col-2 col-form-label">Oplader meegeleverd?</label>
                            <br>
                            <input type="radio" id='reparatielader' name="chargerIncluded" value="1" checked> Ja<br>
                            <input type="radio" name="chargerIncluded" value="0" > Nee


                        </div>
                        <div class="form-group col-xs-4 row" >
                            <div id="apparaatInvullen">
                                <label for="apparaat" class="col-2 col-form-label">Apparaat categorie </label>
                                <select id="apparaat" name="category">
                                    <?php
                                    foreach ($categorie as $c) {
                                        print("<option value=\"" . $c["categoryID"] . "\">" . $c["categoryID"] . ". " . $c["name"] . "</option>");
                                    }
                                    ?>
                                </select><br><br>

                                <label for="apparaatNaam" class="col-2 col-form-label">Naam apparaat</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="deviceInfo" id="apparaatNaam">
                                </div>
                                <br>
                                <label for="apparaatSerie" class="col-2 col-form-label">Serienummer </label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="serialnr" id="apparaatSerie">
                                </div>
                            </div><br>
                        </div>
                    </div>
                    <div class="panel-footer ">
                        <input type="submit" name="reparatieToevoegen" class="btn btn-primary" value="Reparatie toevoegen">
                    </div>
                </form>
            </div>
        </div>

        <script>
            function removeDeviceInfoForm() {
                if (document.getElementById("apparaatSelect").value !== "select") {
                    document.getElementById("apparaatInvullen").style.display = "none";
                } else {
                    document.getElementById("apparaatInvullen").style.display = "block";
                }
            }

            function formValidation() {
                var x = document.forms["reparatieForm"]["deviceInfo"].value;
                var y = document.forms["reparatieForm"]["serialnr"].value;
                if (document.getElementById("apparaatSelect").value === "select") {
                    if (x === "" || y === "") {
                        alert("Vul a.u.b. alles in.");
                        return false;
                    }
                }
            }
        </script>

        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>
    </body>
</html>