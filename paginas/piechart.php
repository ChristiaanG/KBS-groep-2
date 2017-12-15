<html>
    <?php
    $pdo = new PDO("mysql:host=localhost;dbname=mydb2;port=3306", "root", "");
    $stmtpie = $pdo->prepare("SELECT count(*) as aantal, c.name FROM reparation as r join `device` as d on r.deviceID=d.deviceID join category as c on d.categoryID=c.categoryID where active=1 group by c.categoryID");
    $stmtpie->execute();
    $catagoryrepair = $stmtpie->fetchall();
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['categorie', 'aantal reparaties'],
<?php
foreach ($catagoryrepair as $barchart) {
    print("['" . $barchart["name"] . "'," . " " . $barchart["aantal"] . "],");
}
?>

            ]);

            var options = {
                title: 'aantal reparaties per categorie'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>

</html>
