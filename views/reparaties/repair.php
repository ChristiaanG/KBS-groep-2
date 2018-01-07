<?php
session_start();

include_once "../../src/login/check/CheckNotLoggedIn.php"
?><!DOCTYPE html>
<?php
include_once "../../config/Database.php";
$pdo = getDbConnection();

$stmtMax = $pdo->prepare("SELECT MAX(deviceID)+1 FROM device");
$stmtMax->execute();
$maxDeviceID = $stmtMax->fetch();

$stmttMax = $pdo->prepare("SELECT MAX(repairID)+1 FROM reparation");
$stmttMax->execute();
$maxRepairID = $stmttMax->fetch();

// Eerst toevoegen als daar op is geklikt
if (isset($_GET["opslaan"])) {
    $stmt = $pdo->prepare("UPDATE reparation
SET description = ?, finished = ?, checked = ?, chargerIncluded = ?
WHERE repairID=?");
    $stmt->execute(array(filter_input(INPUT_GET, "opmerking"), filter_input(INPUT_GET, "finished"), filter_input(INPUT_GET, "checked"), filter_input(INPUT_GET, "laderMeegeleverd"), filter_input(INPUT_GET, "nummer")));
}
if (isset($_POST["reparatieToevoegen"])) {
    if (filter_input(INPUT_POST, "apparaat") == "select") {
        if (filter_input(INPUT_POST, "deviceInfo") !== "" && filter_input(INPUT_POST, "serialnr") !== "") {
            $stmt4 = $pdo->prepare("INSERT INTO device (categoryID, deviceInfo, serialnr) VALUES (?, ?, ?)");
            $stmt4->execute(array(filter_input(INPUT_POST, "category"), filter_input(INPUT_POST, "deviceInfo"), filter_input(INPUT_POST, "serialnr")));
            $stmt5 = $pdo->prepare("INSERT INTO reparation(customerID, deviceID, description, chargerIncluded) VALUES (?, ?, ?, ?)");
            $stmt5->execute(array(filter_input(INPUT_POST, "nummer"), $maxDeviceID["MAX(deviceID)+1"], filter_input(INPUT_POST, "repairDescription"), filter_input(INPUT_POST, "chargerIncluded")));
            $stmt6 = $pdo->prepare("INSERT INTO customer_device(customerID, deviceID) VALUES(?, ?)");
            $stmt6->execute(array(filter_input(INPUT_POST, "nummer"), $maxDeviceID["MAX(deviceID)+1"]));
        }
    } elseif (filter_input(INPUT_POST, "apparaat") !== "select") {
        $stmt7 = $pdo->prepare("INSERT INTO reparation(customerID, deviceID, description, chargerIncluded) VALUES (?,?,?,?)");
        $stmt7->execute(array(filter_input(INPUT_POST, "nummer"), filter_input(INPUT_POST, "apparaat"), filter_input(INPUT_POST, "repairDescription"), filter_input(INPUT_POST, "chargerIncluded")));
    }
    // daarna pas alle klanten uit de database selecteren zodat je de toegevoegde klant ook ziet
    $stmt2 = $pdo->prepare("SELECT * FROM reparation as r
JOIN device as d ON r.deviceID=d.deviceID
JOIN category as c ON d.categoryID=c.categoryID WHERE r.repairID=?");
    $stmt2->execute(array(filter_input(INPUT_POST, "repair")));
    $repair = $stmt2->fetch();
} else {
    $stmt2 = $pdo->prepare("SELECT * FROM reparation as r
JOIN device as d ON r.deviceID=d.deviceID
JOIN category as c ON d.categoryID=c.categoryID WHERE r.repairID=?");
    $stmt2->execute(array(filter_input(INPUT_GET, "nummer")));
    $repair = $stmt2->fetch();
}

$custdev = $pdo->prepare("SELECT first_name, last_name FROM customer c
JOIN customer_device cd ON c.customerID=cd.customerID
JOIN device d ON d.deviceID=cd.deviceID
WHERE d.deviceID=?");
$custdev->execute(array($repair["deviceID"]));
$customerDevice = $custdev->fetch();
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
        <div  id="page-wrapper">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 align="center">Reparatie overzicht</h3>
                </div>
                <div class="panel-body">
                    <h3><?php print("Reparatie van " . $customerDevice["first_name"] . " " . $customerDevice["last_name"]); ?></h3><br>
                    <div class="form-group col-xs-4 row">
                        <label for="reparatieID" class="col-2 col-form-label">ReparatieID</label>
                        <div id="reparatieID" class="form-control" ><?php print($repair["repairID"]); ?></div><br>

                        <label for="apparaatInfo" class="col-2 col-form-label">Apparaat info</label>
                        <div id="apparaatInfo" class="form-control" ><?php print($repair["deviceInfo"]); ?></div><br>

                        <label for="serieNummer" class="col-2 col-form-label">Serienummer</label>
                        <div id="serieNummer" class="form-control" ><?php print($repair["serialnr"]); ?></div><br>

                        <label for="typeApparaat" class="col-2 col-form-label">Type apparaat</label>
                        <div id="typeApparaat" class="form-control" ><?php print($repair["name"]); ?></div><br>
                    </div>
                    <div class="form-group col-xs-4 row center-block">
                        <label for="beschrijving" class="col-2 col-form-label">Beschrijving</label>
						<div>
                                    <textarea rows="3" class="form-control" id="beschrijving"  ><?php print($repair["description"]); ?></textarea></div><br>
                        

                        <label for="laderMeegeleverd" class="col-2 col-form-label">Lader meegeleverd</label>
                        <div id="typeApparaat" class="form-control" ><?php
                            if ($repair["chargerIncluded"]) {
                                print("Ja");
                            } else {
                                print("Nee");
                            }
                            ?>
                        </div><br>
                    </div>
                </div>
                <div class="panel-footer">
                    <?php print("<a href=\"bewerkrepair.php?nummer=" . $repair["repairID"] . "\"class=\"btn btn-primary\">Bewerken</a>"); ?> <?php if ($_SESSION["function"] == "admin" or $_SESSION["function"] == "medewerker") {
                        print("<a href=\"../klant/klant.php?nummer=" . $repair["customerID"] . "\"class=\"btn btn-primary\">Ga naar klant</a>");
                    } ?>
                </div>
            </div>
        </div>
    </body>

    <script>
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
</html>
