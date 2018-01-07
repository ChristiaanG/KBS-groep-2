<?php
session_start();

if (!isset($_SESSION["loggedin"])) {
    include_once "../../config/Config.php";

    $config = config();

    header("Location: " . $config["login"]);
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Beheer medewerkers</title>

        <?php include '../template/cssinc.php'; ?>
    </head>
    <body>
        <?php include '../template/nav.php'; ?>
        <?php include '../template/sideklant.php'; ?>
        <div id="wrapper">
            <div id="page-wrapper">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3>Medewerkers beheer paneel</h3>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="message-body">
                            </div>
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Gebruikersnaam</th>
                                                <th>Naam</th>
                                                <th>Functie</th>
                                                <th>Toegang geven</th>
                                                <th>Account verwijderen</th>
                                            </tr>
                                        </thead>
                                        <tbody class="users">
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        <?php include '../template/jsinc.php'; ?>
        <script src="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/resources/js/admin.js"></script>
    </body>
</html>
