<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

// Récupérer la dernière humidité
$stmt = $pdo->query('SELECT humidite FROM capteurs ORDER BY date_mesure DESC LIMIT 1');
$derniere_mesure = $stmt->fetchColumn();
//Etat terre
$etat_serre = "Les conditions sont stables.";
if ($derniere_mesure < 50) {
    $etat_serre = "ALERTE : Terre très seche. Activez la pompe à eau !";
} elseif ($derniere_mesure > 75) {
    $etat_serre = "ALERTE : Terre trop humide. Stoppez la pompe à eau !.";
}
?>

<?=template_header('Dashboard')?>
<div class="content">
	<h2>Bienvenue, <?=$_SESSION['name']?>!</h2>
	<p>Dernière humidité relevée : <strong><?=$derniere_mesure ?: 'Aucune donnée'?>%</strong></p>
    
    <div style="background-color:#e9f7ef; padding:15px; border-left: 5px solid #38b673; margin-top:20px;">
        <h3>🌿 Etat Serre :</h3>
        <p><?=$etat_serre?></p>

    <div style="margin-bottom: 20px;">
    <a href="export.php" style="background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">
        📥 Exporter les données (CSV/Excel)
    </a>
</div>
</div>
</div>

<div style="display: flex; justify-content: center; width: 100%; margin: 40px 0;">
<iframe
	width="650"
	height="450"
	src="https://embed.windy.com/embed.html?type=map&location=coordinates&metricRain=default&metricTemp=default&metricWind=default&zoom=11&overlay=rh&product=ecmwf&level=surface&lat=43.266&lon=5.44" 
	frameborder="0"
	scrolling="NO"
	frame="1"
</iframe>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> - Test footer</p>
</footer>

<?=template_footer()?>
