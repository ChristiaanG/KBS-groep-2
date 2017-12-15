<!DOCTYPE html>
<html>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=mydb2;port=3306", "root", "");
    $stmtbar = $pdo->prepare("SELECT
city,
COUNT(*) as aantal
FROM customer
where active=1
group by city;");
    $stmtbar->execute();
    $monthlyrepair = $stmtbar->fetchall();
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
