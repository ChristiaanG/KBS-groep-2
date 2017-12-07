<!DOCTYPE html>

<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=mydb2;port=3306", "root", "");

$stmt = $pdo->prepare("SELECT * FROM user WHERE username= 'test@test.nl'");
$stmt->execute();
$user = $stmt->fetch();

$stmt2 = $pdo->prepare("SELECT c.name as category, d.serialnr, deviceinfo, repairID, description FROM reparation as r
JOIN device as d on r.deviceID=d.deviceID
JOIN category as c on d.categoryID=c.categoryID WHERE repairedBy = 'test@test.nl'");
$stmt2->execute();
$reparation = $stmt2->fetchall();
$stmt3 = $pdo->prepare("SELECT count(*) FROM reparation WHERE repairedBy='test@test.nl'");
$stmt3->execute();
$totallrepairs = $stmt3->fetch();


// eerst opslaan
if (isset($_POST["opslaanpass"])) {
    $hashcontrole = password_verify($_POST["oldpass"], $user["password"]);
    if ($hashcontrole) {
        if (isset($_POST["password2"])) {
            if ($_POST["password"] != $_POST["password2"]) {
                $_SESSION["validpass"] = "Passwords niet gelijk";
                header("location: bewerkpassword.php");
                exit();
            } else {
                $hasholdpass = password_hash($_POST["password"], PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("UPDATE `user` SET `password`=? WHERE `user`.`username`='test@test.nl'");
                $stmt->execute(array($hasholdpass));
                unset($_POST["password2"]);
            }
        }
    } else {
        $_SESSION["validoldpass"] = "Oude password niet correct";
        header("location: bewerkpassword.php");
        exit();
    }
}
if (isset($_POST["opslaan"])) {
    $stmt = $pdo->prepare("UPDATE `user` SET `name`=? WHERE `user`.`username`='test@test.nl'");
    $stmt->execute(array($_POST["name"]));
}



// daarna pas de user uit de database selecteren zodat je de gewijzigde gegevens ziet
$stmt = $pdo->prepare("SELECT * FROM user WHERE username= \"test@test.nl\"");
$stmt->execute();
$user = $stmt->fetch();
$pdo = NULL;
$_POST["username"] = "test@test.nl"
?>

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
    <title>Mijn Account v0.1</title>
    <?php include 'nav.php'; ?>
    <?php include 'jokes.php'; ?>

</head>
<body>
    <?php include 'sideklant.php'; ?>
    <div id="page-wrapper"
         <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>gegevens van <?php print ($user["name"]); ?> v0.1</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group col-xs-4 row">
                            <br>
                            <?php
                            if (isset($_POST["opslaan"])) {
                                print("<i>Naam gewijzigd</i><br>");
                            }
                            ?>
                            <?php
                            if (isset($_POST["opslaanpass"])) {
                                print("<i>Password gewijzigd</i><br>");
                            }
                            ?>
                            <label for="username" class="col-2 col-form-label">Username</label>
                            <div class="form-control" name="username">
                                <?php print($user["username"]); ?><br>
                            </div>
                            <label for="name" class="col-2 col-form-label">Naam</label>
                            <div class="form-control" name="name">
                                <?php print($user["name"]); ?><br>
                            </div>
                            <label for="role" class="col-2 col-form-label">Rol</label>
                            <div class="form-control" name="role">
<?php print($user["role"]); ?><br>
                            </div>
                            <input type="hidden" name="username" value="<?php print($user["username"]); ?>">
                        </div>
                        <div class="col-sm-3">
                            <div class="hero-widget well well-sm">
                                <div class="icon">
                                    <i class="glyphicon glyphicon-wrench"></i>
                                </div>
                                <div class="test">
                                    <span class="value"><?php print($totallrepairs[0]); ?></span>
                                    <label class="text-muted">Reparatie <?php
if ($totallrepairs[0] != 1) {
    print("s");
}
?></label>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="hero-widget well well-sm">
                                <span style="font-size: 20px">Random joke:<br><?php print($joke); ?></span>
                            </div>
                        </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                        <div id="center">
                            <h3>Reparatie <?php
                                if ($totallrepairs[0] != 1) {
                                    print("s");
                                }
?>door <?php print ($user["name"]); ?></h3>
                        </div>
                        <table  class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <td>categorie</td>
                                    <td>apparaatinfo</td>
                                    <td>serienummer</td>
                                    <td>beschrijving</td>
                                    <td>open</td>

                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($reparation as $reparation) {
                                    print("\n\t<tr>");
                                    print("\n\t\t<td>" . $reparation["category"] . "</td>");
                                    print("\n\t\t<td>" . $reparation["deviceinfo"] . "</td>");
                                    print("\n\t\t<td>" . $reparation["serialnr"] . "</td>");
                                    print("\n\t\t<td>" . $reparation["description"] . "</td>");
                                    print("<td><a href=\"repair.php?nummer=" . $reparation["repairID"] . "\"class=\"btn btn-primary\">ga naar reparatie</a></td>");
                                    print("\n\t</tr>");
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="panel-footer">
<?php print("<a href=\"bewerkaccount.php?username=" . $user["username"] . "\"class=\"btn btn-primary\">Bewerk account</a>"); ?>
                        </div>
                    </div>
                </div>



            </div>

            <script src="../js/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/metisMenu.min.js"></script>
            <script src="../js/dataTables/jquery.dataTables.min.js"></script>
            <script src="../js/dataTables/dataTables.bootstrap.min.js"></script>
            <script src="../js/startmin.js"></script>

            <script>
                $(document).ready(function () {
                    $('#dataTables-example').DataTable({
                        responsive: true
                    });
                });
            </script>
        </div>

</body>
</html>