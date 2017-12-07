<!DOCTYPE html>
<?php
$pdo = new PDO("mysql:host=localhost; dbname=mydb2; port=3306", "root", "");
if (isset($_GET["toevoegen"])) {
    $stmt = $pdo->prepare("INSERT INTO customer (first_name, last_name, address, city, email, phoneNr, cellphoneNr) VALUES(?,?,?,?,?,?,?)");
    $stmt->execute(array($_GET["voornaam"], $_GET["achternaam"], $_GET["adres"], $_GET["woonplaats"], $_GET["email"], $_GET["phonenr"], $_GET["cellphoneNr"]));
}
$stmt = $pdo->prepare("SELECT * FROM customer where active=1");
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
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>weet uw het zeker?</h3>
                    </div>
                    <div class="modal-body">
                        het verwijderen van een klant kan niet terug gedraaid worden
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">annuleer</button>
                        <a class="btn btn-primary btn-ok">verwijder klant</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="page-wrapper">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h3 align="center">Klant overzicht</h3>
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
                                <td> </td>

                                <td> </td>
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
                                print("<td><a href=\"klant.php?nummer=" . $klant["customerID"] . "\"class=\"btn btn-primary\" >ga naar klant</a></td>");
                                print("<td><a href=\"#\" data-href=\"verwijder.php?nummer=" . $klant["customerID"] . "\" data-toggle=\"modal\" data-target=\"#confirm-delete\" class=\"btn btn-primary\">Verwijder klant</a></td>");
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
                        <script>
                            $('#confirm-delete').on('show.bs.modal', function (e) {
                                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
                            });
                        </script>
                    </table>
                </div>
            </div>
        </div>

    </body>
</html>
