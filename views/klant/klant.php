<!DOCTYPE html>
<?php
session_start();

include_once "../../src/login/check/CheckNotLoggedIn.php";
if (isset($_SESSION["function"])) {
    if ($_SESSION["function"] != "admin" and $_SESSION["function"] != "medewerker") {
        header("Location: ../dashboard/index.php");
        die();
    }
}
?>
<?php
include_once "../../config/Database.php";
$pdo = getDbConnection();
if (isset($_GET["nummer"])) {
    $nummer = filter_input(INPUT_GET, "nummer");
}
if (isset($_POST["nummer"])) {
    $nummer = filter_input(INPUT_POST, "nummer");
}
// eerst opslaan
if (isset($_POST["submit"])) {
    $stmt = $pdo->prepare("UPDATE customer SET comp_name=?, first_name=?,  last_name=?, address=?, city=?, email=?, phoneNr=?, cellphoneNr=?,description=? WHERE customerID=?");
    $stmt->execute(array(filter_input(INPUT_POST, "compname"), filter_input(INPUT_POST, "voornaam"), filter_input(INPUT_POST, "achternaam"), filter_input(INPUT_POST, "adres"), filter_input(INPUT_POST, "city"), filter_input(INPUT_POST, "email"), filter_input(INPUT_POST, "phonenr"), filter_input(INPUT_POST, "cellphoneNr"), filter_input(INPUT_POST, "opmerking"), filter_input(INPUT_POST, "customerid")));
}

// daarna pas de klant uit de database selecteren zodat je de gewijzigde gegevens ziet
$stmt = $pdo->prepare("SELECT * FROM customer WHERE customerID=?");
$stmt->execute(array($nummer));
$klant = $stmt->fetch();
$stmt2 = $pdo->prepare("select c.name as category,r.repairID,daterepair,d.serialnr,deviceinfo,description,chargerincluded from reparation as r
join device as d on r.deviceID=d.deviceID
join category as c on d.categoryID=c.categoryID where active=1 and customerID=?");
$stmt2->execute(array($nummer));
$reparatie = $stmt2->fetchall();
$pdo = NULL;
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Jacco Rieks">
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
                        het verwijderen van een reparatie kan niet teruggedraaid worden
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">annuleer</button>
                        <a class="btn btn-primary btn-ok">verwijder reperatie</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="page-wrapper"
             <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3>de klantgegevens van <?php print ($klant["first_name"] . " " . $klant["last_name"]); ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php
                            if (isset($_POST["foto"])) {

                                include 'uploadtest.php';
                            }
                            ?>
                            <div class="form-group col-xs-4 row">
                                <label for="compnaam" class="col-2 col-form-label">bedrijfsnaam</label>
                                <div id="compnaam" class="form-control" ><?php print($klant["comp_name"]); ?></div><br>
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
                                <img src="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/resources/img/klant/<?php print ($klant["customerID"]); ?>.jpg" class="avatar img-thumbnail" height="200" width="200"><br>
                            </div>
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
                                        print("<td><a href=\"../reparaties/repair.php?nummer=" . $r["repairID"] . "\"class=\"btn btn-primary\">ga naar reparatie</a></td>");
                                        print("<td><a href=\"#\" data-href=\"verwijderrepair.php?nummer=" . $r["repairID"] . "\" data-toggle=\"modal\" data-target=\"#confirm-delete\" class=\"btn btn-primary\">Verwijder reparatie</a></td>");
                                        print("\n\t</tr>");
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <?php print("<a href=\"bewerkklant.php?nummer=" . $klant["customerID"] . "\"class=\"btn btn-primary\">bewerk klant</a>"); ?>

                            <a href="../reparaties/reparatieToevoegenStap2.php?nummer=<?php print $nummer ?>" class="btn btn-primary"> reparatie toevoegen</a>
                        </div>
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
        </div>

    </body>
</html>