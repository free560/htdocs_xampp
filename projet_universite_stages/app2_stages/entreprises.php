<?php
require __DIR__ . '/config/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO entreprises (nom_entreprise, secteur_activite, adresse, ville, telephone, email) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$_POST['nom_entreprise'], $_POST['secteur_activite'], $_POST['adresse'], $_POST['ville'], $_POST['telephone'], $_POST['email']]);
    $message = "<div class='alert success'>Entreprise ajoutée.</div>";
}

$entreprises = $pdo->query("SELECT * FROM entreprises ORDER BY id_entreprise DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Entreprises</title><link rel="stylesheet" href="style.css"></head>
<body>
<h1>Application 2 — Gestion des stages</h1>
<nav><a href="index.php">Accueil</a> | <a href="entreprises.php">Entreprises</a> | <a href="encadreurs.php">Encadreurs</a> | <a href="stages.php">Stages</a> | <a href="evaluations.php">Évaluations</a></nav>

<h2>Ajouter une entreprise</h2>
<?= $message ?>
<form method="POST">
    <label>Nom de l'entreprise</label>
    <input type="text" name="nom_entreprise" required>

    <label>Secteur d'activité</label>
    <input type="text" name="secteur_activite">

    <label>Adresse</label>
    <input type="text" name="adresse">

    <label>Ville</label>
    <input type="text" name="ville">

    <label>Téléphone</label>
    <input type="text" name="telephone">

    <label>Email</label>
    <input type="email" name="email">

    <button type="submit">Ajouter</button>
</form>

<h2>Liste des entreprises</h2>
<table border="1" cellpadding="6">
    <tr><th>ID</th><th>Nom</th><th>Secteur</th><th>Ville</th></tr>
    <?php foreach ($entreprises as $e): ?>
    <tr>
        <td><?= $e['id_entreprise'] ?></td>
        <td><?= htmlspecialchars($e['nom_entreprise']) ?></td>
        <td><?= htmlspecialchars($e['secteur_activite']) ?></td>
        <td><?= htmlspecialchars($e['ville']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
