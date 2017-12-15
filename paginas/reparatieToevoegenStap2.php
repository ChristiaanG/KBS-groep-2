<!DOCTYPE html>

<?php
$pdo = new PDO("mysql:host=localhost; dbname=mydb2; port=3306", "root", "");

$stmt = $pdo->prepare("SELECT * FROM customer WHERE customerID=?");
$stmt->execute(array($_GET["nummer"]));
$klant = $stmt->fetch();

$stmt2 = $pdo->prepare("SELECT DISTINCT d.deviceID, deviceInfo FROM device d JOIN reparation r ON r.deviceID=d.deviceID WHERE r.customerID=?");
$stmt2->execute(array($_GET["nummer"]));
$apparaat = $stmt2->fetchAll();

$stmt3 = $pdo->prepare("SELECT * FROM category");
$stmt3->execute();
$categorie = $stmt3->fetchAll();

$stmtMax = $pdo->prepare("SELECT MAX(deviceID)+1 FROM device");
$stmtMax->execute();
$maxDeviceID = $stmtMax->fetch();


if (isset($_GET["reparatieToevoegen"])) {
    if ($_GET["apparaat"] == "select") {
        if ($_GET["deviceInfo"] == "" || $_GET["serialnr"] == "") {
            print("<div class='alert alert-danger'>
    <strong>Vul a.u.b alles in</strong>
  </div>");
        } else {
            $stmt4 = $pdo->prepare("INSERT INTO device (categoryID, deviceInfo, serialnr) VALUES (?, ?, ?)");
            $stmt4->execute(array($_GET["category"], $_GET["deviceInfo"], $_GET["serialnr"]));
            $stmt5 = $pdo->prepare("INSERT INTO reparation(customerID, deviceID, description, chargerIncluded) VALUES (?, ?, ?, ?)");
            $stmt5->execute(array($_GET["nummer"], $maxDeviceID["MAX(deviceID)+1"], $_GET["repairDescription"], $_GET["chargerIncluded"]));
            $stmt6 = $pdo->prepare("INSERT INTO customer_device(customerID, deviceID) VALUES (?, ?)");
            $stmt6->execute(array($_GET["nummer"], $maxDeviceID["MAX(deviceID)+1"]));
        }
    } elseif ($_GET["apparaat"] !== "select") {
        $stmt7 = $pdo->prepare("INSERT INTO reparation(customerID, deviceID, description, chargerIncluded) VALUES (?,?,?,?)");
        $stmt7->execute(array($_GET["nummer"], $_GET["apparaat"], $_GET["repairDescription"], $_GET["chargerIncluded"]));
    }
}


$pdo = NULL;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reparatie toevoegen v0.1</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/metisMenu.min.css" rel="stylesheet">
        <link href="../css/startmin.css" rel="stylesheet">
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

        <?php include 'nav.php'; ?>
    </head>
    <body>
        <?php include 'sideklant.php'; ?>
        <div id="page-wrapper">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Reparatie toevoegen voor <?php print($klant["first_name"] . " " . $klant["last_name"]); ?></h3>
                </div>
                <div class="panel-body">
                    <form action="reparatieToevoegenStap2.php" method="get">
                        <div class="form-group col-xs-4 row">
                            <label for="apparaatSelect" class="col-2 col-form-label">apparaat selecteren</label>
                            <select id="apparaatSelect" name="apparaat" onchange="removeDeviceInfoForm()">
                                <option value="select">Selecteer een apparaat</option>
                                <?php
                                foreach ($apparaat as $a) {
                                    print("<option value=\"" . $a["d.deviceID"] . "\" name=\"" . $a["d.deviceID"] . "\">" . $a["deviceInfo"] . "</option>");
                                }
                                ?>
                            </select>
                            <input type="hidden" name="nummer" value="<?php print( $_GET["nummer"]); ?>">
                        </div>

                        <div class="form-group col-xs-4 row center-block" >
                            <label for="reparatiebeschrijving" class="col-2 col-form-label">reparatie beschrijving</label>
                            <div><textarea rows="4" class="form-control" id="reparatiebeschrijving" name="repairDescription" required ></textarea></div>

                            <br>
                            <label for="reparatielader" class="col-2 col-form-label">oplader meegeleverd?</label>
                            <br>
                            <input type="radio" id='reparatielader' name="chargerIncluded" value="1" checked> Ja<br>
                            <input type="radio" name="chargerIncluded" value="0" > Nee


                            <input type="hidden" name="nummer" value="<?php print( $_GET["nummer"]); ?>">

                        </div>
                        <div class="form-group col-xs-4 row" >
                            <div id="apparaatInvullen">
                                <label for="apparaat" class="col-2 col-form-label">apparaat catagorie selecteren</label>
                                <select id="apparaat" name="category">
                                    <?php
                                    foreach ($categorie as $c) {
                                        print("<option value=\"" . $c["categoryID"] . "\" name=\"" . $c["categoryID"] . "\">" . $c["categoryID"] . ". " . $c["name"] . "</option>");
                                    }
                                    ?>
                                </select><br><br>

                                <label for="apparaatNaam" class="col-2 col-form-label">naam apparaat</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="deviceInfo" id="apparaatNaam">
                                </div>
                                <br>
                                <label for="apparaatSerie" class="col-2 col-form-label">serienummer apparaat</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" name="serialnr" id="apparaatSerie">
                                </div>
                            </div><br>
                        </div>
                </div>
                <div class="panel-footer ">
                    <input type="submit" name="reparatieToevoegen" class="btn btn-primary" value="Reparatie toevoegen">
                    </form>

                </div>
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

            if (document.getElementById("apparaatSelect").value === "select") {

            }

        </script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/metisMenu.min.js"></script>
        <script src="../js/dataTables/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables/dataTables.bootstrap.min.js"></script>
        <script src="../js/startmin.js"></script>
    </body>
</html>
