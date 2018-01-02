<?php
session_start();

if (!isset($_SESSION["loggedin"])) {
    include_once "../../../config/Config.php";

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

        <title>Startmin - Bootstrap Admin Theme</title>

        <?php include '../template/cssinc.php'; ?>
    </head>
    <body>
        <?php include '../template/nav.php'; ?>
        <?php include '../template/sideklant.php'; ?>
        <div id="wrapper">

            <!-- Navigation -->


            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Medewerkers</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                DataTables Advanced Tables
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
    </body>
</html>
