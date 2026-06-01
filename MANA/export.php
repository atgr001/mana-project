<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

// 1. Nom du fichier avec la date du jour
$filename = "export_serre_" . date('Y-m-d') . ".csv";

// 2. Forcer le téléchargement du fichier
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// 3. Ouvrir le flux de sortie "en écriture"
$output = fopen('php://output', 'w');

// 4. Ajouter la ligne d'entête pour Excel
fputcsv($output, array('ID', 'Humidité (%)', 'Date de mesure'));

// 5. Récupérer les données de la table capteurs
$query = $pdo->query("SELECT id, humidite, date_mesure FROM capteurs ORDER BY date_mesure DESC");

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
exit;
?>
