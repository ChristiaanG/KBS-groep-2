<!DOCTYPE html>

<?php
$pdo = new PDO("mysql:host=localhost; dbname=mydb; port=3306", "root", "");
// Eerst toevoegen als daar op is geklikt
if (isset($_GET["toevoegen"])) {
    // op toevoegen geklikt, nummer bestaat en nummer is niet leeg
    $stmt = $pdo->prepare("INSERT INTO customer (first_name, last_name, address, email, phoneNr, cellphoneNr) VALUES(?,?,?,?,?,?)");
    $stmt->execute(array($_GET["voornaam"], $_GET["achternaam"], $_GET["adres"], $_GET["email"], $_GET["phonenr"], $_GET["cellphoneNr"]));
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
        <title>Klantenoverzicht v0.1</title>
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
                <h3 align="center">Klantenoverzicht v0.1</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Naam</td>
                            <td>achternaam</td>
                            <td>adres</td>
                            <td>email</td>
                            <td>telefoon nummer</td>
                            <td>mobiel nummer</td>
                            <td>profiel</td>
                            <td>bewerk</td>
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
                            print("\n\t\t<td>" . $klant["email"] . "</td>");
                            print("\n\t\t<td>" . $klant["phoneNr"] . "</td>");
                            print("\n\t\t<td>" . $klant["cellphoneNr"] . "</td>");
                            print("<td><a href=\"klant.php?nummer=" . $klant["customerID"] . "\"class=\"btn btn-primary\">ga naar klant</a></td>");
                            print("<td><a href=\"bewerkklant.php?nummer=" . $klant["customerID"] . "\"class=\"btn btn-primary\">bewerk klant</a></td>");
                            print("<td><a href=\"verwijder.php?nummer=" . $klant["customerID"] . "\"class=\"btn btn-primary\">Verwijder klant</a></td>");
                            print("\n\t</tr>");
                        }
                        ?></tbody>
                    <form method="get" action="overzicht.php">
                        <tfoot>
                            <tr>
                                <td>ID</td>
                                <td>Naam</td>
                                <td>achternaam</td>
                                <td>adres</td>
                                <td>email</td>
                                <td>telefoon nummer</td>
                                <td>mobiel nummer</td>
                                <td>profiel</td>
                                <td>bewerkern</td>
                                <td>verwijderen</td>
                            </tr>

                        </tfoot>
                    </form>
                </table>

            </div>
            <div class="panel-footer">
                <br>

            </div>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <td>ID</td>
                <td>Naam</td>
                <td>achternaam</td>
                <td>adres</td>
                <td>email</td>
                <td>telefoon nummer</td>
                <td>mobiel nummer</td>
                <td>profiel</td>
                <td>bewerkern</td>
                <td>verwijderen</td>
            </tr>
            <tr>
            <form method="get" action="overzicht.php">
                <td><input type="hidden" name="test"></td>
                <td> <input type="text" name="voornaam"></td>
                <td> <input type="text" name="achternaam"></td>
                <td> <input type="text" name="adres"></td>
                <td> <input type="text" name="email"></td>
                <td><input type="text" name="phonenr"></td>
                <td> <input type="text" name="cellphoneNr"></td>
                <td> <input type="submit" name="toevoegen" class="btn btn-primary" value="Toevoegen"></td>
                <td><input type="hidden"></td>
                <td><input type="hidden"></td>
            </form>
        </tr>
    </table>





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
