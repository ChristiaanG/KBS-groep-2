<!DOCTYPE html>
<?php
session_start();

include_once "../../src/login/check/CheckNotLoggedIn.php";


include_once "../../config/Database.php";
$pdo = getDbConnection();
// Eerst toevoegen als daar op is geklikt
// daarna pas alle klanten uit de database selecteren zodat je de toegevoegde klant ook ziet
$stmt2 = $pdo->prepare("select * from reparation as r
join device as d on r.deviceID=d.deviceID
join category as c on d.categoryID=c.categoryID where r.repairID=?");
$stmt2->execute(array(filter_input(INPUT_GET, "nummer")));
$repair = $stmt2->fetch();


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
        <div id="page-wrapper">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>Reparatie bewerken</h3>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="repair.php">
                            <div class="form-group col-xs-4 row">
                                <label for="apparaatInfo" class="col-2 col-form-label">Apparaat info:</label>
                                <input class="form-control" type="text" name="apparaatInfo" value="<?php print($repair["deviceInfo"]); ?>" disabled><br>
                                <label for="serieNummer" class="col-2 col-form-label">Serienummer:</label>
                                <input class="form-control" type="text" name="serieNummer" value="<?php print($repair["serialnr"]); ?>" disabled><br>
                                <label for="laderMeegeleverd" class="col-2 col-form-label">Lader meegeleverd:</label>
                                <input class="form-control" type="text" name="laderMeegeleverd" value="<?php print($repair["chargerIncluded"]); ?>"> 0 = Nee, 1 = Ja<br><br>
                                <label for="opmerking" class="col-2 col-form-label">Beschrijving:</label>
                                <textarea class="form-control" autofocus="true" name="opmerking" ><?php print($repair["description"]); ?></textarea><br>
                                <input type="hidden" name="nummer" value="<?php print(filter_input(INPUT_GET, "nummer")); ?>">
                                <input type="submit" name="opslaan" class="btn right btn-primary" value="Opslaan">
                            </div>
                            <div class="form-group col-lg-offset-5">
                                <label for="finished" class="col-2 col-form-label">Reparatie klaar?</label><br>
                                <input type="radio" name="finished" value="1" <?php
                                if ($repair["finished"]) {
                                    print("checked");
                                }
                                ?>> Ja <br>
                                <input type="radio" name="finished" value="0" <?php
                                if ($repair["finished"] == false) {
                                    print("checked");
                                }
                                ?>> Nee <br><br>
                                <label for="checked" class="col-2 col-form-label">Reparatie gecheckt en dus voltooien?</label><br>
                                <input type="radio" name="checked" value="1" <?php
                                if ($repair["checked"]) {
                                    print("checked");
                                }if (isset($_SESSION["function"])) {
                                    if ($_SESSION["function"] == "stagiair") {
                                        print (" disabled");
                                    }
                                }
                                ?>> Ja <br>
                                <input type="radio" name="checked" value="0" <?php
                                if ($repair["checked"] == false) {
                                    print("checked");
                                }if (isset($_SESSION["function"])) {
                                    if ($_SESSION["function"] == "stagiair") {
                                        print (" disabled");
                                    }
                                }
                                ?>> Nee <br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
