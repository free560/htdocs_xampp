<?php
require __DIR__ . '/config/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO inscriptions (id_etudiant, id_formation, annee_academique, statut) VALUES (?,?,?,?)");
    $stmt->execute([$_POST['id_etudiant'], $_POST['id_formation'], $_POST['annee_academique'], $_POST['statut']]);
    $message = "<div class='alert success'>Inscription enregistrée.</div>";
}

$etudiants  = $pdo->query("SELECT id_etudiant, matricule, nom, prenom FROM etudiants ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
$formations = $pdo->query("SELECT id_formation, nom_formation FROM formations ORDER BY nom_formation")->fetchAll(PDO::FETCH_ASSOC);

$inscriptions = $pdo->query("
    SELECT i.*, e.nom, e.prenom, f.nom_formation
    FROM inscriptions i
    JOIN etudiants e ON e.id_etudiant = i.id_etudiant
    JOIN formations f ON f.id_formation = i.id_formation
    ORDER BY i.id_inscription DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Inscriptions</title><link rel="stylesheet" href="style.css"></head>
<body>
<h1>Application 1 — Gestion universitaire</h1>
<nav><a href="index.php">Accueil</a> | <a href="formations.php">Formations</a> | <a href="etudiants.php">Étudiants</a> | <a href="inscriptions.php">Inscriptions</a></nav>

<h2>Inscrire un étudiant à une formation</h2>
<?= $message ?>
<form method="POST">
    <label>Étudiant</label>
    <select name="id_etudiant" required>
        <?php foreach ($etudiants as $e): ?>
        <option value="<?= $e['id_etudiant'] ?>"><?= htmlspecialchars($e['matricule'] . ' - ' . $e['nom'] . ' ' . $e['prenom']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Formation</label>
    <select name="id_formation" required>
        <?php foreach ($formations as $f): ?>
        <option value="<?= $f['id_formation'] ?>"><?= htmlspecialchars($f['nom_formation']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Année académique</label>
    <input type="text" name="annee_academique" placeholder="2025-2026" required>

    <label>Statut</label>
    <select name="statut">
        <option value="en_cours">En cours</option>
        <option value="validee">Validée</option>
        <option value="annulee">Annulée</option>
    </select>

    <button type="submit">Inscrire</button>
</form>

<h2>Liste des inscriptions</h2>
<table border="1" cellpadding="6">
    <tr><th>Étudiant</th><th>Formation</th><th>Année</th><th>Statut</th></tr>
    <?php foreach ($inscriptions as $i): ?>
    <tr>
        <td><?= htmlspecialchars($i['nom'] . ' ' . $i['prenom']) ?></td>
        <td><?= htmlspecialchars($i['nom_formation']) ?></td>
        <td><?= htmlspecialchars($i['annee_academique']) ?></td>
        <td><?= htmlspecialchars($i['statut']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
