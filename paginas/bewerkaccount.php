<!DOCTYPE html>
<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=mydb;port=3306", "root", "");
$stmt = $pdo->prepare("SELECT * FROM user WHERE username=\"test@test.nl\"");
$stmt->execute();
$user = $stmt->fetch();

$pdo = NULL;
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Jacco Rieks & Bram Kas">

        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <link href="../css/metisMenu.min.css" rel="stylesheet">

        <link href="../css/startmin.css" rel="stylesheet">

        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <title>user editor v0.1</title>
        <?php include 'nav.php'; ?>

    </head>
    <body>
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>medewerker gegevens <?php print ($user["name"]); ?></h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="mijnaccount.php">
                        <div class="form-group col-xs-4 row">
                        <input type="hidden" name="username" value="<?php print( $user["username"]); ?>">
                        <label for="name" class="col-2 col-form-label">Naam</label>
                        <div>
                            <input class="form-control" type="text" name="name" value="<?php print($user["name"]); ?>" required><br>
                        </div>
                        <a href="bewerkpassword.php" class="btn btn-primary right">Wachtwoord wijzigen</a>
                        <input type="hidden" name="username" value="<?php print( $user["username"]); ?>">
                        </div>
                    
                    <div>
                        <i>
                            <?php if(isset($_SESSION["validpass"])) {
                                print($_SESSION["validpass"]);
                                unset($_SESSION["validpass"]);
                            }
                                ?>
                            
                        </i>
                    </div>
                </div>
                        <div class="panel-footer ">
                            <input type="submit" name="opslaan" class="btn right btn-primary" value="Opslaan"> <a href="mijnaccount.php" class="btn btn-primary right">Terug naar mijn account</a>

                        </div>
                 </form>
                </div>
            </div>

       

        
        <?php
        // put your code here
        ?>
</body>
</html>
