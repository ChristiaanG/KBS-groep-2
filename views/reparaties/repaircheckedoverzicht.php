<?php
session_start();

include_once "../../src/login/check/CheckNotLoggedIn.php"
?><!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include_once "../../config/Database.php";
$pdo = getDbConnection();
// Eerst toevoegen als daar op is geklikt
if (isset($_GET["toevoegen"])) {
    // op toevoegen geklikt, nummer bestaat en nummer is niet leeg
    $stmt = $pdo->prepare("INSERT INTO customer (first_name, last_name, address, email, phoneNr, cellphoneNr) VALUES(?,?,?,?,?,?)");
    $stmt->execute(array($_GET["voornaam"], $_GET["achternaam"], $_GET["adres"], $_GET["email"], $_GET["phonenr"], $_GET["cellphoneNr"]));
}
// daarna pas alle klanten uit de database selecteren zodat je de toegevoegde klant ook ziet
$stmt = $pdo->prepare("select c.name as category,r.repairID,daterepair,d.serialnr,deviceinfo,description,chargerincluded from reparation as r
join device as d on r.deviceID=d.deviceID
join category as c on d.categoryID=c.categoryID where r.active=1 and finished=1 and checked=1");
$stmt->execute();
$reparatie = $stmt->fetchAll();


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
                        het verwijderen van een reperatie kan niet terug gedraaid worden
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">annuleer</button>
                        <a class="btn btn-primary btn-ok">verwijder reperatie</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="page-wrapper">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 align="center">overzicht van alle afgeronde reparaties</h3>
                </div>
                <div class="panel-body">
                    <table  class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <td>categorie</td>
                                <td>apparaatinfo</td>
                                <td>serienummer</td>
                                <td>beschrijving</td>
                                <td>datum toegevoegd</td>
                                <td> </td>
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
                                print("<td><a href=\"#\" data-href=\"verwijderrepair.php?nummer=" . $r["repairID"] . "\" data-toggle=\"modal\" data-target=\"#confirm-delete\" class=\"btn btn-primary\">Verwijder reparatie</a></td>");
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
        <script>
            $('#confirm-delete').on('show.bs.modal', function (e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });
        </script>
    </body>
</html>