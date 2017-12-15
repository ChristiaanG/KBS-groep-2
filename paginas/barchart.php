<!DOCTYPE html>
<html>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=mydb2;port=3306", "root", "");
    $stmtbar = $pdo->prepare("SELECT
extract(year from daterepair) as jaar,
extract(MONTH from daterepair)as maand,
COUNT(*) as aantal
FROM `reparation`
where active=1
group by jaar,maand;");
    $stmtbar->execute();
    $monthlyrepair = $stmtbar->fetchall();
    ?>
    <script>
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawBasic);

        function drawBasic() {

            var data = google.visualization.arrayToDataTable([

                ['maand', 'aantal reparaties', ],
<?php
foreach ($monthlyrepair as $barchart) {
    print("['" . $barchart["maand"] . "de maand van " . $barchart["jaar"] . "'," . " " . $barchart["aantal"] . "],");
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
