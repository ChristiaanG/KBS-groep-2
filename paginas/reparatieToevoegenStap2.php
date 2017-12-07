<!DOCTYPE html>

<?php
$pdo = new PDO("mysql:host=localhost; dbname=mydb; port=3306", "root", "");

$stmt = $pdo->prepare("SELECT * FROM customer WHERE customerID=?");
$stmt->execute(array($_GET["nummer"]));
$klant = $stmt->fetch();

$stmt2 = $pdo->prepare("SELECT * FROM device d JOIN reparation r ON r.deviceID=d.deviceID WHERE customerID=?");
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
            $stmt6 = $pdo->prepare("INSERT INTO customer_device(customerID, deviceID)");
            $stmt6->execute(array($_GET["nummer"], $_GET["MAX(deviceID)+1"]));
        }
    } elseif ($_GET["apparaat"] !== "select") {
        $stmt7 = $pdo->prepare("INSERT INTO reparation(customerID, deviceID, description, chargerIncluded) VALUES (?,?,?,?)");
        $stmt7->execute(array($_GET["nummer"], $_GET["apparaat"], $_GET["repairDescription"], $_GET["chargerIncluded"]));
    }
}

if (isset($_GET["reparatieToevoegen"])) {
    print($_GET["apparaat"]);
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
    </head>
    <body>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 align="center">Reparatie toevoegen v0.1</h3>
            </div>
            <h4>Reparatie toevoegen voor <?php print($klant["first_name"] . " " . $klant["last_name"]); ?></h4><br>
            <?php ?>
            <h4>Apparaat selecteren:</h4>

            <form action="reparatieToevoegenStap2.php" method="get">
                <select id="apparaatSelect" name="apparaat" onchange="removeDeviceInfoForm()">
                    <option value="select">Selecteer een apparaat</option>
                    <?php
                    foreach ($apparaat as $a) {
                        print("<option value=\"" . $a["deviceID"] . "\" name=\"" . $a["deviceID"] . "\">" . $a["deviceInfo"] . "</option>");
                    }
                    ?>
                </select>
                <input type="hidden" name="nummer" value="<?php print( $_GET["nummer"]); ?>">
                <br>
                <div id="apparaatInvullen">
                    <h4>Categorie van apparaat: </h4>
                    <select name="category">
                        <?php
                        foreach ($categorie as $c) {
                            print("<option value=\"" . $c["categoryID"] . "\" name=\"" . $c["categoryID"] . "\">" . $c["categoryID"] . ". " . $c["name"] . "</option>");
                        }
                        ?>
                    </select><br><br>
                    Naam van apparaat: <input type="text" name="deviceInfo">
                    <br>
                    Serienummer: <input type="text" name="serialnr">

                </div><br>
                Info over reparatie: <br><textarea name="repairDescription" required></textarea><br><br>

                Oplader meegeleverd? <br><input type="radio" name="chargerIncluded" value="1" checked> Ja<br>
                <input type="radio" name="chargerIncluded" value="0" > Nee<br><br>

                <input type="submit" name="reparatieToevoegen" class="btn btn-primary" value="Reparatie toevoegen">
                <input type="hidden" name="nummer" value="<?php print( $_GET["nummer"]); ?>">
            </form><br>

        </div>

        <?php
        if (isset($_GET["reparatieToevoegen"])) {
            print($maxDeviceID["MAX(deviceID)+1"]);
        }
        ?>
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

        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>
    </body>
</html>
