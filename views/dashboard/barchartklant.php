<!DOCTYPE html>
<html>

    <?php
    include_once "../../config/Database.php";
    $pdo = getDbConnection();
    $stmtbar = $pdo->prepare("SELECT
extract(year from dateadded) as jaar,
extract(MONTH from dateadded)as maand,
COUNT(*) as aantal
FROM customer
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

                ['maand', 'aantal klanten', ],
<?php
foreach ($monthlyrepair as $barchart) {
    print("['" . $barchart["maand"] . "e maand van " . $barchart["jaar"] . "'," . " " . $barchart["aantal"] . "],");
}
?>

            ]);

            var options = {
                title: 'aantal nieuwe klanten per maand',
                chartArea: {width: '50%'},
                hAxis: {
                    title: 'aantal klanten',
                    minValue: 0
                },
                vAxis: {
                    title: 'datum'
                }
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_klant'));

            chart.draw(data, options);
        }
    </script>
</html>
