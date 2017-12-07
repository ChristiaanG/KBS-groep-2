<!DOCTYPE html>
<?php
$pdo = new PDO("mysql:host=localhost; dbname=mydb2; port=3306", "root", "");

$stmt = $pdo->prepare("SELECT * FROM customer");
$stmt->execute();
$klanten = $stmt->fetchAll();
$pdo = NULL;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reparatie toevoegen v0.1</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/metisMenu.min.css" rel="stylesheet">
        <link href="../css/startmin.css" rel="stylesheet">
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

        <?php include 'nav.php'; ?>
    </head>
    <body>
        <?php include 'sideklant.php'; ?>
        <div id="page-wrapper">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 align="center">Reparatie toevoegen v0.1</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <td>Naam</td>
                                <td>Adres</td>
                                <td>Telefoon nummer</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($klanten as $klant) {
                                print("\n\t<tr>");
                                print("\n\t\t<td><a href='reparatieToevoegenStap2.php?nummer=" . $klant["customerID"] . "'>" . $klant["first_name"] . " " . $klant["last_name"] . "</a></td>");
                                print("\n\t\t<td>" . $klant["address"] . "</td>");
                                print("\n\t\t<td>" . $klant["phoneNr"] . "</td>");
                                print("\n\t</tr>");
                            }
                            ?>
                        </tbody>
                    </table>
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
    </body>
</html>
