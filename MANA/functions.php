<?php
session_start();

function pdo_connect_mysql() {
    // MODIFICATIONS ICI pour correspondre à tes identifiants
    $DATABASE_HOST = 'localhost'; 
    $DATABASE_USER = 'user';  // Changé 'admin_serre' en 'user'
    $DATABASE_PASS = 'admin'; // Changé 'ton_mot_de_passe' en 'admin'
    $DATABASE_NAME = 'serre_db'; 
    
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	exit('Echec à la connexion vers la base !');
    }
}

function template_header($title) {
// Si l'utilisateur n'est pas sur la page index (login) et n'est pas connecté, on le bloque
if (basename($_SERVER['PHP_SELF']) != 'index.php' && !isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title - Ma Serre</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <!-- Ajout de AnyChart -->
        <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-base.min.js"></script>
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>MANA PROJECT</h1>
EOT;
// On affiche le menu uniquement si connecté
if (isset($_SESSION['loggedin'])) {
echo <<<EOT
            <a href="dashboard.php"><i class="fas fa-home"></i>Dashboard</a>
    		<a href="graph.php"><i class="fas fa-chart-bar"></i>Graphique</a>
            <a href="actionneurs.php"><i class="fas fa-power-off"></i>Actionneurs</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Déconnexion</a>
EOT;
}
echo <<<EOT
    	</div>
    </nav>
EOT;
}

function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>
