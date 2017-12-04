<!DOCTYPE html>

<?php
$pdo = new PDO("mysql:host=localhost;dbname=mydb;port=3306", "root", "");
if (isset($_GET["nummer"])) {
    $nummer = $_GET["nummer"];
}
if (isset($_POST["nummer"])) {
    $nummer = $_POST["nummer"];
}
// eerst opslaan
if (isset($_POST["voornaam"])) {
    $stmt = $pdo->prepare("UPDATE customer SET first_name=?,  last_name=?, address=?, city=?, email=?, phoneNr=?, cellphoneNr=?,description=? WHERE customerID=?");
    $stmt->execute(array($_POST["voornaam"], $_POST["achternaam"], $_POST["adres"], $_POST["city"], $_POST["email"], $_POST["phonenr"], $_POST["cellphoneNr"], $_POST["opmerking"], $_POST["customerid"]));
}

// daarna pas de klant uit de database selecteren zodat je de gewijzigde gegevens ziet
$stmt = $pdo->prepare("SELECT * FROM customer WHERE customerID=?");
$stmt->execute(array($nummer));
$klant = $stmt->fetch();
$stmt2 = $pdo->prepare("select c.name as category,r.repairID,daterepair,d.serialnr,deviceinfo,description,chargerincluded from reparation as r
join device as d on r.deviceID=d.deviceID
join category as c on d.categoryID=c.categoryID where customerID=?");
$stmt2->execute(array($nummer));
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
        <?php include 'nav.php'; ?>

    </head>
    <body>
        <?php include 'sideklant.php'; ?>
        <div id="page-wrapper"

             <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3>de klantgegevens van <?php print ($klant["first_name"] . " " . $klant["last_name"]); ?></h3>
                        </div>
                        <?php
                        if (isset($_POST["foto"])) {

                            include 'uploadtest.php';
                        }
                        ?>
                        <div class="panel-body">
                            <div class="form-group col-xs-4 row">
                                <label for="voornaam" class="col-2 col-form-label">voornaam</label>
                                <div id="voornaam" class="form-control" ><?php print($klant["first_name"]); ?></div><br>
                                <label for="achternaam" class="col-2 col-form-label">achternaam</label>
                                <div  id="achternaam" class="form-control">
                                    <?php print($klant["last_name"]); ?></div><br>
                                <label for="adres" class="col-2 col-form-label">adres</label>
                                <div  id="achternaam" class="form-control">
                                    <?php print($klant["address"]); ?></div><br>
                                <label for="woonplaats" class="col-2 col-form-label">woonplaats</label>
                                <div  id="woonplaats" class="form-control">
                                    <?php print($klant["city"]); ?></div><br>
                            </div>
                            <div class="form-group col-xs-4 row center-block">
                                <input type="hidden" name="nummer" value="<?php print($klant["customerID"]); ?>">

                                <label for="telnr" class="col-2 col-form-label">telefoonnummer</label>
                                <div  id="telnr" class="form-control">

                                    <?php print($klant["phoneNr"]); ?></div><br>
                                <label for="telnr2" class="col-2 col-form-label">telefoonnummer 2</label>
                                <div  id="telnr2" class="form-control">
                                    <?php print($klant["cellphoneNr"]); ?></div><br>
                                <label for="email" class="col-2 col-form-label">email</label>
                                <div  id="email" class="form-control">
                                    <?php print($klant["email"]); ?></div><br>
                                <label for="opmerking" class="col-2 col-form-label">opmerking</label>
                                <div>
                                    <textarea rows="3" class="form-control" id="opmerking" name="opmerking" ><?php print($klant["description"]); ?></textarea></div><br>
                            </div>
                            <div class="col-xs-4 center-block row">
                                <img src="../klant/<?php print ($klant["customerID"]); ?>.jpg" class="avatar img-thumbnail" height="200" width="200"><br>
                            </div>


                            <div class="col-md-12" id="center">
                                <h3 align="center">reparatie(s) van <?php print ($klant["first_name"] . " " . $klant["last_name"]); ?></h3>
                            </div>
                            <table  class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <td>categorie</td>
                                        <td>apparaatinfo</td>
                                        <td>serienummer</td>
                                        <td>beschrijving</td>
                                        <td>datum toegevoegd</td>
                                        <td> </td>

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