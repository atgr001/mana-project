<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

// Récupérer les 15 dernières données
$stmt = $pdo->query("SELECT humidite, date_mesure FROM capteurs ORDER BY date_mesure DESC LIMIT 15");
$data = array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));
?>

<?=template_header('Graphique')?>
<div class="content">
	<h2>Évolution de l'humidité</h2>
    <!-- Conteneur AnyChart -->
    <div id="container" style="width: 100%; height: 400px; margin-top:20px; border: 1px solid #ebebeb;"></div>
</div>

<script>
anychart.onDocumentReady(function () {
    var data = [
        <?php foreach($data as $row): ?>
            {x: "<?=date('H:i', strtotime($row['date_mesure']))?>", value: <?=$row['humidite']?>},
        <?php endforeach; ?>
    ];

    var chart = anychart.column();
    var series = chart.column(data);
    
    series.name("Humidité");
    series.fill("#38b673"); // Reprend le vert de ton template
    series.stroke("#32a367");

    chart.yScale().minimum(0).maximum(100);
    chart.xAxis().title("Heure");
    chart.yAxis().title("Humidité (%)");
    
    chart.container("container");
    chart.draw();
});
</script>
<?=template_footer()?>
