<!DOCTYPE html>

<?php
$pdo = new PDO("mysql:host=localhost; dbname=mydb; port=3306", "root", "");
// Eerst toevoegen als daar op is geklikt
if (isset($_GET["toevoegen"])) {
    // op toevoegen geklikt, nummer bestaat en nummer is niet leeg
    $stmt = $pdo->prepare("INSERT INTO customer (first_name, last_name, address, city, email, phoneNr, cellphoneNr) VALUES(?,?,?,?,?,?,?)");
    $stmt->execute(array($_GET["voornaam"], $_GET["achternaam"], $_GET["adres"], $_GET["woonplaats"], $_GET["email"], $_GET["phonenr"], $_GET["cellphoneNr"]));
}
// daarna pas alle klanten uit de database selecteren zodat je de toegevoegde klant ook ziet
$stmt = $pdo->prepare("SELECT * FROM customer");
$stmt->execute();
$klanten = $stmt->fetchAll();


$pdo = NULL;
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

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

            <!-- Navigation -->

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 align="center">Klantenoverzicht v0.1</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <td>klantnummer</td>
                                <td>naam</td>
                                <td>achternaam</td>
                                <td>adres</td>
                                <td>woonplaats</td>
                                <td>email</td>
                                <td>telefoonnummer</td>
                                <td>telefoonnummer 2</td>
                                <td>profiel</td>

                                <td>verwijder</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($klanten as $klant) {
                                print("\n\t<tr>");
                                print("\n\t\t<td>" . $klant["customerID"] . "</td>");
                                print("\n\t\t<td>" . $klant["first_name"] . "</td>");
                                print("\n\t\t<td>" . $klant["last_name"] . "</td>");
                                print("\n\t\t<td>" . $klant["address"] . "</td>");
                                print("\n\t\t<td>" . $klant["city"] . "</td>");
                                print("\n\t\t<td>" . $klant["email"] . "</td>");
                                print("\n\t\t<td>" . $klant["phoneNr"] . "</td>");
                                print("\n\t\t<td>" . $klant["cellphoneNr"] . "</td>");
                                print("<td><a href=\"klant.php?nummer=" . $klant["customerID"] . "\"class=\"btn btn-primary\">ga naar klant</a></td>");

                                print("<td><a href=\"verwijder.php?nummer=" . $klant["customerID"] . "\"class=\"btn btn-primary\">Verwijder klant</a></td>");
                                print("\n\t</tr>");
                            }
                            ?></tbody>
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
                    </table>

                </div>

            </div>
        </div>





    </body>
</html>
