<?php
session_start();

include_once "../../src/login/check/CheckNotLoggedIn.php";
if (isset($_SESSION["function"])) {
    if ($_SESSION["function"] == "stagiair") {
        header("Location: ../dashboard/index.php");
        die();
    }
}
?>

<?php
include_once "../../config/Database.php";
$pdo = getDbConnection();
if (isset($_POST["toevoegen"])) {
    $stmt = $pdo->prepare("INSERT INTO customer (comp_name, first_name, last_name, address, city, email, phoneNr, cellphoneNr, description) VALUES(?,?,?,?,?,?,?,?,?)");
    $stmt->execute(array(filter_input(INPUT_POST, "compname"), filter_input(INPUT_POST, "voornaam"), filter_input(INPUT_POST, "achternaam"), filter_input(INPUT_POST, "adres"), filter_input(INPUT_POST, "woonplaats"), filter_input(INPUT_POST, "email"), filter_input(INPUT_POST, "phonenr"), filter_input(INPUT_POST, "cellphoneNr"), filter_input(INPUT_POST, "opmerking")));
    header("Location: klant.php?nummer=" . filter_input(INPUT_POST, "nummer"));
    die();
}

if (isset($_POST["foto"])) {

    include 'uploadtest.php';
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
        <?php include '../template/nav.php'; ?>
        <?php include '../template/cssinc.php'; ?>
        <?php include '../template/jsinc.php'; ?>

    </head>
    <body>
        <?php include '../template/sideklant.php'; ?>
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
                                <td>bedrijfsnaam</td>
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
                                print("\n\t\t<td>" . $klant["comp_name"] . "</td>");
                                print("\n\t\t<td>" . $klant["first_name"] . "</td>");
                                print("\n\t\t<td>" . $klant["last_name"] . "</td>");
                                print("\n\t\t<td>" . $klant["address"] . "</td>");
                                print("\n\t\t<td>" . $klant["city"] . "</td>");
                                print("<td><a href=\"klant.php?nummer=" . $klant["customerID"] . "\"class=\"btn btn-primary\" >ga naar klant</a></td>");
                                print("<td><a href=\"#\" data-href=\"verwijder.php?nummer=" . $klant["customerID"] . "\" data-toggle=\"modal\" data-target=\"#confirm-delete\" class=\"btn btn-primary\">Verwijder klant</a></td>");
                                print("\n\t</tr>");
                            }
                            ?></tbody>


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
