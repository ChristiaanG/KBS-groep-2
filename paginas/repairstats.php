<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

    <head>
        <meta charset="UTF-8">
        <?php
        include 'nav.php';
        ?>
    </head>
    <body>
        <?php include 'sideklant.php'; ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">statistieken over reparaties</h1>
                </div>

            </div>
            <?php include 'barchartmaand.php'; ?>
            <?php include 'piechart.php'; ?>
            <div id="piechart"></div>
            <div id="chart_div"></div>
        </div>
    </body>
</html>
