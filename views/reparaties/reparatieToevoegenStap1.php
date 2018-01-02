<?php
session_start();

include_once "../../src/login/check/CheckNotLoggedIn.php"
?><!DOCTYPE html>
<?php
include_once "../../config/Database.php";
$pdo = getDbConnection();
;

$stmt = $pdo->prepare("SELECT * FROM customer");
$stmt->execute();
$klanten = $stmt->fetchAll();
$pdo = NULL;
?>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reparatie toevoegen</title>
        <?php include '../template/nav.php'; ?>
        <?php include '../template/cssinc.php'; ?>
        <?php include '../template/jsinc.php'; ?>

    </head>
    <body>
        <?php include '../template/sideklant.php'; ?>
        <div id="page-wrapper">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 align="center">kies een klant</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <td>Naam</td>
                                <td>Adres</td>
                                <td>Telefoon nummer</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($klanten as $klant) {
                                print("\n\t<tr>");
                                print("\n\t\t<td><a href='reparatieToevoegenStap2.php?nummer=" . $klant["customerID"] . "'>" . $klant["first_name"] . " " . $klant["last_name"] . "</a></td>");
                                print("\n\t\t<td>" . $klant["address"] . "</td>");
                                print("\n\t\t<td>" . $klant["phoneNr"] . "</td>");
                                print("\n\t</tr>");
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>
    </body>
</html>
