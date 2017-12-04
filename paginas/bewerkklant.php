<!DOCTYPE html>
<?php
$pdo = new PDO("mysql:host=localhost;dbname=mydb;port=3306", "root", "");
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
        <?php include 'nav.php'; ?>
        <?php include 'sideklant.php'; ?>
    </head>
    <body>
        <div id = "page-wrapper">
            <div class = "panel panel-primary">
                <div class = "panel-heading">
                    <h3>klantgegevens <?php print ($klant["first_name"] . " " . $klant["last_name"]); ?></h3>
                </div>
                <div class="panel-body">

                    <img src="../klant/<?php print ($klant["customerID"]); ?>.jpg" height="240px" with="160px">
                    <form action="klant.php" method="post" enctype="multipart/form-data">
                        upload andere foto:  
                        <input type="file" name="fileToUpload" id="fileToUpload" >
                        <input type="hidden" name="nummer" value="<?php print( $_GET["nummer"]); ?>">
                        <input type="hidden" name="customerid" value="<?php print( $_GET["nummer"]); ?>"><br>
                        voornaam        :<input type="text" name="voornaam" value="<?php print($klant["first_name"]); ?>"><br>
                        achternaam      :<input type="text" name="achternaam" value="<?php print($klant["last_name"]); ?>"><br>
                        adres           :<input type="text" name="adres" value="<?php print($klant["address"]); ?>"><br>
                        woonplaats      :<input type="text" name="city" value="<?php print($klant["city"]); ?>"><br>
                        email           :<input type="email" name="email" value="<?php print($klant["email"]); ?>"><br>
                        telefoon nummer :<input type="tel" name="phonenr" value="<?php print($klant["phoneNr"]); ?>"><br>
                        mobiel nummer   :<input type="tel" name="cellphoneNr" value="<?php print($klant["cellphoneNr"]); ?>"><br>
                        opmerkingen     : <textarea autofocus="true" name="opmerking" ><?php print($klant["description"]); ?></textarea><br>
                        <input type="hidden" name="nummer" value="<?php print( $_GET["nummer"]); ?>">
                        </div>
                        </div>

                        <div class="panel-footer ">
                            <input type="submit" name="submit" class="btn right btn-primary " value="opslaan"> <a href="klant.php?nummer=<?php print( $_GET["nummer"]); ?>" class="btn btn-primary pull-right">annuleren</a>

                        </div>
                </div>
            </div>



        </form>

</body>

</html>
