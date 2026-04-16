<?php
$pageTitle = "Réserver";
require 'includes/header.php';
require 'includes/db.php';
requireLogin();

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();

if (!$event) {
    echo "<div class='container'><p>Événement introuvable.</p></div></body></html>";
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->beginTransaction();

    $check = $pdo->prepare("SELECT nbPlaces FROM events WHERE id = ? FOR UPDATE");
    $check->execute([$id]);
    $places = $check->fetchColumn();

    if ($places <= 0) {
        $pdo->rollBack();
        $error = "Plus de places disponibles pour cet événement.";
    } else {
        $insert = $pdo->prepare("INSERT INTO reservations (user_id, event_id) VALUES (?, ?)");
        $insert->execute([$_SESSION['user_id'], $id]);

        $update = $pdo->prepare("UPDATE events SET nbPlaces = nbPlaces - 1 WHERE id = ?");
        $update->execute([$id]);

        $pdo->commit();
        $success = "Réservation confirmée !";
        $event['nbPlaces']--;
    }
}
?>

<div class="container">
    <div class="form-box" style="max-width: 500px">
        <h1>Confirmer la réservation</h1>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <div class="card" style="box-shadow:none; border:1.5px solid #e5e7eb; margin-bottom:20px">
            <h2><?= htmlspecialchars($event['title']) ?></h2>
            <p class="meta">📅 <?= date('d/m/Y', strtotime($event['date_event'])) ?></p>
            <p class="meta">📍 <?= htmlspecialchars($event['location']) ?></p>
            <p class="price"><?= number_format($event['price'], 2) ?> €</p>
            <p class="places"><?= $event['nbPlaces'] ?> place(s) restante(s)</p>
        </div>

        <?php if (!$success): ?>
            <form method="POST">
                <button type="submit" class="btn btn-success" style="width:100%">✅ Confirmer</button>
            </form>
        <?php endif; ?>

        <p class="text-center mt-12"><a href="index.php">← Retour aux événements</a></p>
    </div>
</div>
</body>
</html>