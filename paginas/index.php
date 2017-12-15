<!DOCTYPE html>
<?php
$pdo = new PDO("mysql:host=localhost;dbname=mydb2;port=3306", "root", "");

$stmt3 = $pdo->prepare("SELECT count(*) FROM reparation WHERE finished=1 and checked=0 and active=1");
$stmt3->execute();
$finishedrepairs = $stmt3->fetch();

$stmt2 = $pdo->prepare("SELECT count(*) FROM reparation WHERE finished=0 and checked=0 and active=1");
$stmt2->execute();
$unfinishedrepairs = $stmt2->fetch();

$stmt4 = $pdo->prepare("SELECT count(*) FROM reparation where active=1");
$stmt4->execute();
$totalrepairs = $stmt4->fetch();

$stmt1 = $pdo->prepare("SELECT count(*) FROM reparation WHERE finished=1 and checked=1 and active=1");
$stmt1->execute();
$checkedrepairs = $stmt1->fetch();
?>
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
                    <h1 class="page-header">dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-database  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php print($totalrepairs["count(*)"]); ?></div>
                                    <div>totaal overzicht reparaties</div>
                                </div>
                            </div>
                        </div>
                        <a href="repairoverzicht.php">
                            <div class="panel-footer">
                                <span class="pull-left">ga naar overzicht</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-check-square-o  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php print($checkedrepairs["count(*)"]); ?></div>
                                    <div>totaal afgeronde reparaties</div>
                                </div>
                            </div>
                        </div>
                        <a href="repaircheckedoverzicht.php">
                            <div class="panel-footer">
                                <span class="pull-left">ga naar overzicht</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-edit fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php print($finishedrepairs["count(*)"]); ?></div>
                                    <div>ongecontroleerde reparaties</div>
                                </div>
                            </div>
                        </div>
                        <a href="repairuncheckedoverzicht.php">
                            <div class="panel-footer">
                                <span class="pull-left">ga naar overzicht</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-exclamation-triangle  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php print($unfinishedrepairs["count(*)"]); ?></div>
                                    <div>openstaande reparaties</div>
                                </div>
                            </div>
                        </div>
                        <a href="repairidleoverzicht.php">
                            <div class="panel-footer">
                                <span class="pull-left">ga naar overzicht</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <h1>statistieken over reparaties</h1>
            <?php include 'barchartmaand.php'; ?>
            <div id="chart_div"></div>
        </div>
    </body>
</html>
