<?php require __DIR__ . '/auth.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Réservations' ?></title>
    <link rel="stylesheet" href="/reservations/includes/style.css">
</head>
<body>
<nav>
    <a href="/reservations/index.php" class="logo">🎟 EventBook</a>
    <div class="nav-links">
        <a href="/reservations/index.php">Événements</a>
        <?php if (isLoggedIn()): ?>
            <a href="./mes-reservation.php">Mes réservations</a>
            <?php if (isAdmin()): ?>
                <a href="/reservations/admin/index.php">Admin</a>
            <?php endif; ?>
            <a href="/reservations/logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="/reservations/login.php">Connexion</a>
            <a href="/reservations/register.php">Inscription</a>
        <?php endif; ?>
    </div>
</nav>