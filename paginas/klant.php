<!DOCTYPE html>

<?php
$pdo = new PDO("mysql:host=localhost;dbname=mydb;port=3306", "root", "");

// eerst opslaan
if (isset($_GET["opslaan"])) {
    $stmt = $pdo->prepare("UPDATE customer SET first_name=?,  last_name=?, address=?, email=?, phoneNr=?, cellphoneNr=?,description=? WHERE customerID=?");
    $stmt->execute(array($_GET["voornaam"], $_GET["achternaam"], $_GET["adres"], $_GET["email"], $_GET["phonenr"], $_GET["cellphoneNr"], $_GET["opmerking"], $_GET["customerid"]));
}

// daarna pas de klant uit de database selecteren zodat je de gewijzigde gegevens ziet
$stmt = $pdo->prepare("SELECT * FROM customer WHERE customerID=?");
$stmt->execute(array($_GET["nummer"]));
$klant = $stmt->fetch();
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
        <title>klantgegevens v0.1</title>
    </head>
    <body>
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>gegevens van <?php print ($klant["first_name"] . " " . $klant["last_name"]); ?> v0.1</h3>
                </div>
                <div class="panel-body">
                    <img src="../klant/<?php print ($klant["customerID"]); ?>.jpg" height="160px" with="160px">
                    <br>
                    voornaam:<?php print($klant["first_name"]); ?><br>
                    achternaam:<?php print($klant["last_name"]); ?><br>
                    adres: <?php print($klant["address"]); ?><br>
                    email:  <?php print($klant["email"]); ?><br>
                    telefoonnummer:  <?php print($klant["phoneNr"]); ?><br>
                    mobielnummer:  <?php print($klant["cellphoneNr"]); ?><br>
                    opmerking:  <?php print($klant["description"]); ?><br>

                    <input type="hidden" name="nummer" value="<?php print($klant["customerID"]); ?>">
                </div>
                <div class="panel-footer">
                    <a href="overzicht.php" class="btn btn-primary">Terug naar het overzicht</a>    <?php print("<a href=\"bewerkklant.php?nummer=" . $klant["customerID"] . "\"class=\"btn btn-primary\">bewerken</a>"); ?>
                </div>
            </div>
        </div>





    </body>
</html>