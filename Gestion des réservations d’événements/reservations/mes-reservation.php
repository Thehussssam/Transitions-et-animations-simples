<?php
$pageTitle = "Mes réservations";
require 'includes/header.php';
require 'includes/db.php';
requireLogin();

$stmt = $pdo->prepare("SELECT * FROM reservations WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$reservations = $stmt->fetchAll();
?>

<div class="container">
    <h1>Mes réservations</h1>

    <?php if (empty($reservations)): ?>
        <p>Vous n'avez pas encore de réservation. <a href="index.php">Voir les événements</a></p>
    <?php else: ?>
        <table>
            <th>
                <tr>
                    <th>Événement</th>
                    <th>Date événement</th>
                    <th>Lieu</th>
                    <th>Prix</th>
                    <th>Réservé le</th>
                </tr>
            </th>
            <tbody>

                <?php foreach ($reservations as $r): ?>

                    <?php
                    $stmt2 = $pdo->prepare("SELECT * FROM events WHERE id = ?");
                    $stmt2->execute([$r['event_id']]);
                    $event = $stmt2->fetch();
                    ?>

                    <tr>
                        <td><?= htmlspecialchars($event['title']) ?></td>
                        <td><?= date('d/m/Y', strtotime($event['date_event'])) ?></td>
                        <td><?= htmlspecialchars($event['location']) ?></td>
                        <td><?= number_format($event['price'], 2) ?> DH</td>
                        <td><?= date('d/m/Y H:i', strtotime($r['reservation_date'])) ?></td>
                    </tr>

                <?php endforeach; ?>

            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>