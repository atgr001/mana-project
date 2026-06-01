<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_POST['username'], $_POST['password'])) {
    $stmt = $pdo->prepare('SELECT id, password FROM users WHERE username = ?');
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification basique (idéalement utiliser password_verify si haché)
    if ($user && $_POST['password'] === $user['password']) {
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $_POST['username'];
        $_SESSION['id'] = $user['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        $msg = 'Identifiant ou mot de passe incorrect !';
    }
}
?>

<?=template_header('Login')?>
<div class="content update">
	<h2>Connexion à la Serre</h2>
    <form action="index.php" method="post">
        <label for="username">Identifiant</label>
        <input type="text" name="username" placeholder="ex: chef" id="username" required>
        
        <label for="password">Mot de passe</label>
        <input type="password" name="password" placeholder="ex: admin123" id="password" required>
        
        <input type="submit" value="Se connecter">
    </form>
    <?php if ($msg): ?>
    <p style="color:red;"><?=$msg?></p>
    <?php endif; ?>
</div>
<?=template_footer()?>
