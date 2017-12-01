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
                        <input type="hidden" name="username" value="<?php print( $user["username"]); ?>"><br>
                        Oude password   :<input type="text" name="oldpass" required><br>
                        Nieuw Password  :<input type="password" name="password" pattern=".{4,20}" title="4-20 characters" required><br>
                        Herhaal password:<input type="password" name="password2" required><br>
                        <input type="hidden" name="username" value="<?php print( $user["username"]); ?>">
                    
                    <div>
                        <i>
                            <?php if(isset($_SESSION["validpass"])) {
                                print($_SESSION["validpass"]);
                                unset($_SESSION["validpass"]);
                            }
                            if(isset($_SESSION["validoldpass"])) {
                                print($_SESSION["validoldpass"]);
                                unset($_SESSION["validoldpass"]);
                            }
                                ?>
                            
                        </i>
                    </div>
                </div>
                        <div class="panel-footer ">
                            <input type="submit" name="opslaanpass" class="btn right btn-primary" value="Opslaan"> <a href="mijnaccount.php" class="btn btn-primary right">Terug naar mijn account</a>

                        </div>
                 </form>
                </div>
            </div>

       

        
        <?php
        // put your code here
        ?>
</body>
</html>
