<?php
require __DIR__ . '/config/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO encadreurs (id_entreprise, nom, prenom, fonction, email, telephone) VALUES (?,?,?,?,?,?)");
    $stmt->execute([$_POST['id_entreprise'], $_POST['nom'], $_POST['prenom'], $_POST['fonction'], $_POST['email'], $_POST['telephone']]);
    $message = "<div class='alert success'>Encadreur ajouté.</div>";
}

$entreprises = $pdo->query("SELECT id_entreprise, nom_entreprise FROM entreprises ORDER BY nom_entreprise")->fetchAll(PDO::FETCH_ASSOC);
$encadreurs = $pdo->query("
    SELECT enc.*, ent.nom_entreprise
    FROM encadreurs enc JOIN entreprises ent ON ent.id_entreprise = enc.id_entreprise
    ORDER BY enc.id_encadreur DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Encadreurs</title><link rel="stylesheet" href="style.css"></head>
<body>
<h1>Application 2 — Gestion des stages</h1>
<nav><a href="index.php">Accueil</a> | <a href="entreprises.php">Entreprises</a> | <a href="encadreurs.php">Encadreurs</a> | <a href="stages.php">Stages</a> | <a href="evaluations.php">Évaluations</a></nav>

<h2>Ajouter un encadreur</h2>
<?= $message ?>
<form method="POST">
    <label>Entreprise</label>
    <select name="id_entreprise" required>
        <?php foreach ($entreprises as $e): ?>
        <option value="<?= $e['id_entreprise'] ?>"><?= htmlspecialchars($e['nom_entreprise']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Nom</label>
    <input type="text" name="nom" required>

    <label>Prénom</label>
    <input type="text" name="prenom" required>

    <label>Fonction</label>
    <input type="text" name="fonction">

    <label>Email</label>
    <input type="email" name="email">

    <label>Téléphone</label>
    <input type="text" name="telephone">

    <button type="submit">Ajouter</button>
</form>

<h2>Liste des encadreurs</h2>
<table border="1" cellpadding="6">
    <tr><th>Nom</th><th>Fonction</th><th>Entreprise</th></tr>
    <?php foreach ($encadreurs as $e): ?>
    <tr>
        <td><?= htmlspecialchars($e['nom'] . ' ' . $e['prenom']) ?></td>
        <td><?= htmlspecialchars($e['fonction']) ?></td>
        <td><?= htmlspecialchars($e['nom_entreprise']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
