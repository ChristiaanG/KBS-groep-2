<!DOCTYPE html>
<?php
$pdo = new PDO("mysql:host=localhost; dbname=mydb; port=3306", "root", "");
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
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Jacco Rieks">

        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <link href="../css/metisMenu.min.css" rel="stylesheet">

        <link href="../css/startmin.css" rel="stylesheet">

        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>repaireditor v0.1</title>
        <?php include 'nav.php'; ?>
    </head>
    <body>
        <?php include 'siderepair.php'; ?>
        <div id="page-wrapper">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>klantreparatie gegevens v0.1</h3>
                </div>
                <div class="panel-body">
                    <form method="get" action="klant.php">
                        <input type="hidden" name="repairid" value="<?php print( $_GET["nummer"]); ?>"><br>
                        apparaat info   :<input type="text" name="apparaatinfo" value="<?php print($repair["deviceInfo"]); ?>"><br>
                        serienummer    :<input type="text" name="serienummer" value="<?php print($repair["serialnr"]); ?>"><br>
                        ladermeegeleverd :<input type="text" name="ladermeegeleverd" value="<?php print($repair["chargerIncluded"]); ?>"><br>
                        beschrijving     : <textarea autofocus="true" name="opmerking" ><?php print($repair["description"]); ?></textarea><br>
                        <input type="hidden" name="nummer" value="<?php print( $_GET["nummer"]); ?>">
                        </div>
                        <div class="panel-footer ">
                            <input type="submit" name="opslaan" class="btn right btn-primary" value="Opslaan"> <a href="overzicht.php" class="btn btn-primary right">Terug naar het overzicht</a>

                        </div>
                </div>
            </div>



        </form>
</body>
</html>
