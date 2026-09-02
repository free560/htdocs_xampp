<?php
require __DIR__ . '/config/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO formations (nom_formation, niveau, duree_annees, description) VALUES (?,?,?,?)");
    $stmt->execute([$_POST['nom_formation'], $_POST['niveau'], $_POST['duree_annees'], $_POST['description']]);
    $message = "<div class='alert success'>Formation ajoutée.</div>";
}

$formations = $pdo->query("SELECT * FROM formations ORDER BY id_formation DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Formations</title><link rel="stylesheet" href="style.css"></head>
<body>
<h1>Application 1 — Gestion universitaire</h1>
<nav><a href="index.php">Accueil</a> | <a href="formations.php">Formations</a> | <a href="etudiants.php">Étudiants</a> | <a href="inscriptions.php">Inscriptions</a></nav>

<h2>Ajouter une formation</h2>
<?= $message ?>
<form method="POST">
    <label>Nom de la formation</label>
    <input type="text" name="nom_formation" required>

    <label>Niveau</label>
    <input type="text" name="niveau" placeholder="Bac1, Bac2, Bac3..." required>

    <label>Durée (années)</label>
    <input type="number" name="duree_annees" value="3" required>

    <label>Description</label>
    <textarea name="description"></textarea>

    <button type="submit">Ajouter</button>
</form>

<h2>Liste des formations</h2>
<table border="1" cellpadding="6">
    <tr><th>ID</th><th>Nom</th><th>Niveau</th><th>Durée</th></tr>
    <?php foreach ($formations as $f): ?>
    <tr>
        <td><?= $f['id_formation'] ?></td>
        <td><?= htmlspecialchars($f['nom_formation']) ?></td>
        <td><?= htmlspecialchars($f['niveau']) ?></td>
        <td><?= $f['duree_annees'] ?> an(s)</td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
