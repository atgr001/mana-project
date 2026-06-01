<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

// Si un bouton est cliqué pour changer l'état
if (isset($_GET['id']) && isset($_GET['etat'])) {
    $stmt = $pdo->prepare('UPDATE actionneurs SET etat = ? WHERE id = ?');
    $stmt->execute([$_GET['etat'], $_GET['id']]);
    header('Location: actionneurs.php');
    exit;
}

// Récupérer les actionneurs
$stmt = $pdo->query('SELECT * FROM actionneurs');
$actionneurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si la table est vide, on crée une pompe pour l'exemple
if (!$actionneurs) {
    $pdo->query("INSERT INTO actionneurs (nom, etat) VALUES ('Pompe à eau', 0), ('Humidificateur', 1)");
    header('Location: actionneurs.php');
    exit;
}
?>

<?=template_header('Actionneurs')?>
<div class="content read">
	<h2>Contrôle des actionneurs</h2>
	<table>
        <thead>
            <tr>
                <td>Équipement</td>
                <td>Statut Actuel</td>
		<td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($actionneurs as $act): ?>
            <tr>
                <td><?=$act['nom']?></td>
                <td style="color: <?=$act['etat'] ? '#38b673' : '#b73737'?>; font-weight:bold;">
                    <?=$act['etat'] ? 'ALLUMÉ' : 'ÉTEINT'?>
                </td>
                <td class="actions">
                    <?php if ($act['etat']): ?>
                        <a href="actionneurs.php?id=<?=$act['id']?>&etat=0" class="trash"><i class="fas fa-power-off"></i> Éteindre</a>
                    <?php else: ?>
                        <a href="actionneurs.php?id=<?=$act['id']?>&etat=1" class="edit"><i class="fas fa-power-off"></i> Allumer</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?=template_footer()?>
