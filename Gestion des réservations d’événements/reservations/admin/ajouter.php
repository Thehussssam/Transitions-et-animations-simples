<?php
$pageTitle = "Ajouter un événement";
require_once '../includes/header.php';
require_once '../includes/db.php';
requireAdmin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['title']);
    $date     = $_POST['date_event'];
    $location = trim($_POST['location']);
    $places   = (int) $_POST['nbPlaces'];
    $price    = (float) $_POST['price'];

    if (!$title || !$date || !$location || $places <= 0 || $price < 0) {
        $error = "Tous les champs sont obligatoires et valides.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO events (title, date_event, location, nbPlaces, price) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $date, $location, $places, $price]);
        $success = "Événement ajouté avec succès !";
    }
}
?>

<div class="container">
    <div class="form-box" style="max-width: 520px">
        <h1>Nouvel événement</h1>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?> <a href="index.php">Retour à la liste</a></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Titre</label>
                <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date_event" value="<?= htmlspecialchars($_POST['date_event'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Lieu</label>
                <input type="text" name="location" value="<?= htmlspecialchars($_POST['location'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Nombre de places</label>
                <input type="number" name="nbPlaces" min="1" value="<?= htmlspecialchars($_POST['nbPlaces'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Prix (DH)</label>
                <input type="number" name="price" step="0.01" min="0" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">Ajouter l'événement</button>
        </form>

        <p class="text-center mt-12"><a href="index.php">← Retour à la liste</a></p>
    </div>
</div>
</body>
</html>