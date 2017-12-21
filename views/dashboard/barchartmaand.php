<!DOCTYPE html>
<html>
    <?php
    include_once "../../src/login/check/CheckNotLoggedIn.php";
    if (isset($_SESSION["function"])) {
        if ($_SESSION["function"] == "stagiair") {
            header("Location: ../dashboard/index.php");
            die();
        }
    }
    ?>
    <?php
    include_once "../../config/Database.php";
    $pdo = getDbConnection();
    $stmtbar = $pdo->prepare("SELECT
extract(year from daterepair) as jaar,
extract(MONTH from daterepair)as maand,
COUNT(*) as aantal
FROM `reparation`
where active=1
group by jaar,maand;");
    $stmtbar->execute();
    $monthlyrepair = $stmtbar->fetchall();
    $pdo = NULL;
    ?>
    <script>
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawBasic);

        function drawBasic() {

            var data = google.visualization.arrayToDataTable([

                ['maand', 'aantal reparaties', ],
<?php
foreach ($monthlyrepair as $barchart) {
    print("['" . $barchart["maand"] . "e maand van " . $barchart["jaar"] . "'," . " " . $barchart["aantal"] . "],");
}
?>

            ]);

            var options = {
                title: 'aantal reparaties per maand',
                chartArea: {width: '50%'},
                hAxis: {
                    title: 'aantal reparaties',
                    minValue: 0
                },
                vAxis: {
                    title: 'datum'
                }
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
</html>
