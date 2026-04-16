<?php
$pageTitle = "Événements à venir";
require 'includes/header.php';
require 'includes/db.php';

$stmt = $pdo->query("SELECT * FROM events WHERE date_event >= CURDATE() ORDER BY date_event ASC");
$events = $stmt->fetchAll();
?>

<div class="container">
    <h1>Événements à venir</h1>

    <?php if (empty($events)): ?>
        <p>Aucun événement disponible pour le moment.</p>
    <?php else: ?>
        <div class="events-grid">
            <?php foreach ($events as $event): ?>
                <div class="card">
                    <h2><?= htmlspecialchars($event['title']) ?></h2>
                    <p class="meta">📅 <?= date('d/m/Y', strtotime($event['date_event'])) ?></p>
                    <p class="meta">📍 <?= htmlspecialchars($event['location']) ?></p>
                    <p class="price"><?= number_format($event['price'], 2) ?> DH</p>
                    <p class="places">
                        <?php if ($event['nbPlaces'] > 0): ?>
                            <?= $event['nbPlaces'] ?> place(s) disponible(s)
                        <?php else: ?>
                            <span class="badge-sold">Sold Out</span>
                        <?php endif; ?>
                    </p>

                    <?php if ($event['nbPlaces'] > 0): ?>
                        <?php if (isLoggedIn()): ?>
                            <a href="reserver.php?id=<?= $event['id'] ?>" class="btn btn-primary">Réserver</a>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-outline">Connectez-vous pour réserver</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <button class="btn" disabled>Complet</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>