<!DOCTYPE html>
<?php
include_once "../../config/Database.php";
$pdo = getDbConnection();
// Eerst toevoegen als daar op is geklikt
// daarna pas alle klanten uit de database selecteren zodat je de toegevoegde klant ook ziet
$stmt2 = $pdo->prepare("select * from reparation as r
join device as d on r.deviceID=d.deviceID
join category as c on d.categoryID=c.categoryID where r.repairID=?");
$stmt2->execute(array($_GET["nummer"]));
$repair = $stmt2->fetch();
$pdo = NULL;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <?php include '../template/nav.php'; ?>
        <?php include '../template/cssinc.php'; ?>
        <?php include '../template/jsinc.php'; ?>

    </head>
    <body>
        <?php include '../template/sideklant.php'; ?>
        <div  id="page-wrapper">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 align="center">reparatie overzicht v0.1</h3>
                </div>
                <div class="panel-body">
                    reperatieID :<?php print($repair["repairID"]); ?><br>
                    apparaat info:<?php print($repair["deviceInfo"]); ?><br>
                    serienummer:<?php print($repair["serialnr"]); ?><br>
                    lader meegeleverd:<?php print($repair["chargerIncluded"]); ?><br>
                    beschrijving:<?php print($repair["description"]); ?><br>
                    type apparaat:<?php print($repair["name"]); ?><br>
                </div>
                <div class="panel-footer">
                    <?php print("<a href=\"bewerkrepair.php?nummer=" . $repair["deviceID"] . "\"class=\"btn btn-primary\">ga naar apparaat</a>"); ?> <?php print("<a href=\"klant.php?nummer=" . $repair["customerID"] . "\"class=\"btn btn-primary\">ga naar klant</a>"); ?>    <?php print("<a href=\"bewerkrepair.php?nummer=" . $repair["repairID"] . "\"class=\"btn btn-primary\">bewerken</a>"); ?>
                </div>
            </div>
        </div>



    </body>

    <script>
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
</html>
