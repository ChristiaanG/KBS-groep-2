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
city,
COUNT(*) as aantal
FROM customer
where active=1
group by city;");
    $stmtbar->execute();
    $monthlyrepair = $stmtbar->fetchall();
    $pdo = NULL;
    ?>
    <script>
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawBasic);

        function drawBasic() {

            var data = google.visualization.arrayToDataTable([

                ['woonplaats', 'aantal klanten', ],
<?php
foreach ($monthlyrepair as $barchart) {
    print("['" . $barchart["city"] . "'," . " " . $barchart["aantal"] . "],");
}
?>

            ]);

            var options = {
                title: 'aantal klanten per woonplaats',
                chartArea: {width: '50%'},
                hAxis: {
                    title: 'aantal klanten',
                    minValue: 0
                },
                vAxis: {
                    title: 'woonplaats'
                }
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_woonplaats'));

            chart.draw(data, options);
        }
    </script>
</html>
