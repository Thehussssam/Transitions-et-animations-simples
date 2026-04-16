<?php
$pageTitle = "Connexion";
require 'includes/header.php';
require 'includes/db.php';

$error = '';

define('ADMIN_EMAIL', 'husssam@gmail.com');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['is_admin']  = ($email === ADMIN_EMAIL);
        header("Location: index.php");
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>

<div class="container">
    <div class="form-box">
        <h1>Connexion</h1>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">Se connecter</button>
        </form>

        <p class="text-center mt-12">Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
    </div>
</div>
</body>
</html>