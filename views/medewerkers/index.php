<?php
session_start();

include_once "../../src/login/check/CheckNotLoggedIn.php";
if (isset($_SESSION["functie"])) {
    if ($_SESSION["functie"] == "stagiair" or $_SESSION["functie"] == "medewerker") {
        header("Location: ../dashboard/index.php");
        die();
    }
}
?><!DOCTYPE html>

<?php
include_once "../../config/Database.php";
$pdo = getDbConnection();
// Eerst toevoegen als daar op is geklikt
if (isset($_GET["activeer"])) {
    // op toevoegen geklikt, nummer bestaat en nummer is niet leeg
    $stmt = $pdo->prepare("update user set approved=1 where username=?");
    $stmt->execute(array(filter_input(INPUT_GET, "activeer")));
}
if (isset($_GET["deactiveer"])) {
    // op toevoegen geklikt, nummer bestaat en nummer is niet leeg
    $stmt = $pdo->prepare("update user set approved=0 where username=?");
    $stmt->execute(array(filter_input(INPUT_GET, "deactiveer")));
}
// daarna pas alle klanten uit de database selecteren zodat je de toegevoegde klant ook ziet
$stmt = $pdo->prepare("select username, name, function,2fa_enabled, approved from user");
$stmt->execute();
$userdata = $stmt->fetchAll();


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
        <div id="page-wrapper">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 align="center">overzicht van alle gebruikers</h3>
                </div>
                <div class="panel-body">
                    <table  class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <td>username</td>
                                <td>naam</td>
                                <td>functie</td>
                                <td>twee factor authenticatie ingeschakeld</td>
                                <td>account geactiveerd</td>
                                <td>account activeren</td>
                                <td>account deactiveren</td>




                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($userdata as $u) {
                                print("\n\t<tr>");
                                print("\n\t\t<td>" . $u["username"] . "</td>");
                                print("\n\t\t<td>" . $u["name"] . "</td>");
                                print("\n\t\t<td>" . $u["function"] . "</td>");
                                print("\n\t\t<td>" . $u["2fa_enabled"] . "</td>");
                                print("\n\t\t<td>" . $u["approved"] . "</td>");
                                print("<td><a href=\"index.php?activeer=" . $u["username"] . "\"class=\"btn btn-primary\" >account activeren</a></td>");
                                print("<td><a href=\"index.php?deactiveer=" . $u["username"] . "\"class=\"btn btn-primary\" >account deactiveren</a></td>");
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
