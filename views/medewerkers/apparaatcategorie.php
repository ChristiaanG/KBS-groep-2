<?php
session_start();

include_once "../../src/login/check/CheckNotLoggedIn.php";
if (isset($_SESSION["function"])) {
    if ($_SESSION["function"] == "stagiair" or $_SESSION["function"] == "medewerker") {
        header("Location: ../dashboard/index.php");
        die();
    }
}
?><!DOCTYPE html>

<?php
include_once "../../config/Database.php";
$pdo = getDbConnection();
// Eerst toevoegen als daar op is geklikt
if (isset($_POST["toevoegen"])) {
    // op toevoegen geklikt, nummer bestaat en nummer is niet leeg
    $stmt = $pdo->prepare("insert into category (name) values(?)");
    $stmt->execute(array(filter_input(INPUT_POST, "naam")));
}

// daarna pas alle klanten uit de database selecteren zodat je de toegevoegde klant ook ziet
$stmt = $pdo->prepare("select * from category");
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
                    <h3 align="center">overzicht van alle apparaat categorieën</h3>
                </div>
                <div class="panel-body">
                    <table  class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <td>catagorie nummer</td>
                                <td>categorie naam</td>




                            </tr>
                        </thead>
                        <form >
                            <tbody>
                                <?php
                                foreach ($userdata as $u) {

                                    print("\n\t<tr>");
                                    print("\n\t\t<td>" . $u["categoryID"] . "</td>");
                                    print("\n\t\t<td>" . $u["name"] . "</td>");
                                    print("\n\t</tr>");
                                }
                                ?>
                            </tbody>
                        </form>
                    </table>
                </div>
            </div>
            <h2>categorie toevoegen</h2>
            <table class="table table-striped table-bordered table-hover">
                <tr>

                    <td>Naam</td>
                    <td>toevoegen</td>

                </tr>
                <tr>
                <form method="post" action="apparaatcategorie.php">
                    <td><input type="text" name="naam"></td>
                    <td> <input type="submit" name="toevoegen" class="btn btn-primary" value="Toevoegen"></td>
                </form>
                </tr>
            </table>
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
