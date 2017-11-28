<!DOCTYPE html>

<?php
$pdo = new PDO("mysql:host=localhost;dbname=mydb;port=3306", "root", "");

// eerst opslaan
if (isset($_GET["opslaan"])) {
    $stmt = $pdo->prepare("UPDATE customer SET first_name=?,  last_name=?, address=?, city=?, email=?, phoneNr=?, cellphoneNr=?,description=? WHERE customerID=?");
    $stmt->execute(array($_GET["voornaam"], $_GET["achternaam"], $_GET["adres"], $_GET["city"], $_GET["email"], $_GET["phonenr"], $_GET["cellphoneNr"], $_GET["opmerking"], $_GET["customerid"]));
}

// daarna pas de klant uit de database selecteren zodat je de gewijzigde gegevens ziet
$stmt = $pdo->prepare("SELECT * FROM customer WHERE customerID=?");
$stmt->execute(array($_GET["nummer"]));
$klant = $stmt->fetch();
$stmt2 = $pdo->prepare("select c.name as category,r.repairID,daterepair,d.serialnr,deviceinfo,description,chargerincluded from reparation as r
join device as d on r.deviceID=d.deviceID
join category as c on d.categoryID=c.categoryID where customerID=?");
$stmt2->execute(array($_GET["nummer"]));
$reparatie = $stmt2->fetchall();
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
        <title>klantgegevens v0.1</title>
        <?php include 'nav.php'; ?>

    </head>
    <body>
        <?php include 'sideklant.php'; ?>
        <div id="page-wrapper"
             <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3>gegevens van <?php print ($klant["first_name"] . " " . $klant["last_name"]); ?> v0.1</h3>
                        </div>
                        <div class="panel-body">
                            <img src="../klant/<?php print ($klant["customerID"]); ?>.jpg" height="160px" with="160px">
                            <br>
                            voornaam:<?php print($klant["first_name"]); ?><br>
                            achternaam:<?php print($klant["last_name"]); ?><br>
                            adres: <?php print($klant["address"]); ?><br>
                            woonplaats: <?php print($klant["city"]); ?><br>
                            email:  <?php print($klant["email"]); ?><br>
                            telefoonnummer:  <?php print($klant["phoneNr"]); ?><br>
                            mobielnummer:  <?php print($klant["cellphoneNr"]); ?><br>
                            opmerking:  <?php print($klant["description"]); ?><br>

                            <input type="hidden" name="nummer" value="<?php print($klant["customerID"]); ?>">
                            <div id="center">
                                <h3>reparatie(s) van <?php print ($klant["first_name"] . " " . $klant["last_name"]); ?></h3>
                            </div>
                            <table  class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <td>categorie</td>
                                        <td>apparaatinfo</td>
                                        <td>serienummer</td>
                                        <td>beschrijving</td>
                                        <td>datum toegevoegd</td>
                                        <td>open</td>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    foreach ($reparatie as $r) {
                                        print("\n\t<tr>");
                                        print("\n\t\t<td>" . $r["category"] . "</td>");
                                        print("\n\t\t<td>" . $r["deviceinfo"] . "</td>");
                                        print("\n\t\t<td>" . $r["serialnr"] . "</td>");
                                        print("\n\t\t<td>" . $r["description"] . "</td>");
                                        print("\n\t\t<td>" . $r["daterepair"] . "</td>");
                                        print("<td><a href=\"repair.php?nummer=" . $r["repairID"] . "\"class=\"btn btn-primary\">ga naar reparatie</a></td>");
                                        print("\n\t</tr>");
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <?php print("<a href=\"bewerkklant.php?nummer=" . $klant["customerID"] . "\"class=\"btn btn-primary\">bewerk klant</a>"); ?>
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