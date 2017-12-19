<?php
session_start();

echo $_SESSION["username"];

if (!isset($_SESSION["loggedin"])) {
    include_once "../../config/Config.php";

    $config = config();

    header("Location: " . $config["login"]);
    die();
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <?php include '../template/nav.php'; ?>
        <?php include '../template/cssinc.php'; ?>
        <?php include '../template/jsinc.php'; ?>

    </head>
    <body>
        <?php include '../template/sideklant.php'; ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">statistieken over klanten</h1>
                </div>

            </div>
            <?php include 'barchartklantwoonplaats.php'; ?>
            <div id="chart_woonplaats"></div>
            <?php include 'barchartklant.php'; ?>
            <div id="chart_klant"></div>
        </div>
    </body>
</html>
