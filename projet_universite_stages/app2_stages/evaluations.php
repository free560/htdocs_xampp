<?php
require __DIR__ . '/config/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO evaluations (id_stage, note_encadreur, note_soutenance, commentaire, date_evaluation) VALUES (?,?,?,?,?)");
    $stmt->execute([$_POST['id_stage'], $_POST['note_encadreur'], $_POST['note_soutenance'], $_POST['commentaire'], $_POST['date_evaluation']]);
    $message = "<div class='alert success'>Évaluation enregistrée.</div>";
}

$stages = $pdo->query("SELECT id_stage, matricule_etudiant, nom_etudiant_cache FROM stages ORDER BY id_stage DESC")->fetchAll(PDO::FETCH_ASSOC);
$evaluations = $pdo->query("
    SELECT ev.*, s.matricule_etudiant, s.nom_etudiant_cache
    FROM evaluations ev JOIN stages s ON s.id_stage = ev.id_stage
    ORDER BY ev.id_evaluation DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Évaluations</title><link rel="stylesheet" href="style.css"></head>
<body>
<h1>Application 2 — Gestion des stages</h1>
<nav><a href="index.php">Accueil</a> | <a href="entreprises.php">Entreprises</a> | <a href="encadreurs.php">Encadreurs</a> | <a href="stages.php">Stages</a> | <a href="evaluations.php">Évaluations</a></nav>

<h2>Ajouter une évaluation</h2>
<?= $message ?>
<form method="POST">
    <label>Stage</label>
    <select name="id_stage" required>
        <?php foreach ($stages as $s): ?>
        <option value="<?= $s['id_stage'] ?>"><?= htmlspecialchars(($s['nom_etudiant_cache'] ?: $s['matricule_etudiant'])) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Note encadreur (/20)</label>
    <input type="number" step="0.01" name="note_encadreur" min="0" max="20">

    <label>Note soutenance (/20)</label>
    <input type="number" step="0.01" name="note_soutenance" min="0" max="20">

    <label>Commentaire</label>
    <textarea name="commentaire"></textarea>

    <label>Date d'évaluation</label>
    <input type="date" name="date_evaluation">

    <button type="submit">Ajouter</button>
</form>

<h2>Liste des évaluations</h2>
<table border="1" cellpadding="6">
    <tr><th>Étudiant</th><th>Note encadreur</th><th>Note soutenance</th><th>Date</th></tr>
    <?php foreach ($evaluations as $e): ?>
    <tr>
        <td><?= htmlspecialchars($e['nom_etudiant_cache'] ?: $e['matricule_etudiant']) ?></td>
        <td><?= htmlspecialchars($e['note_encadreur']) ?></td>
        <td><?= htmlspecialchars($e['note_soutenance']) ?></td>
        <td><?= htmlspecialchars($e['date_evaluation']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
