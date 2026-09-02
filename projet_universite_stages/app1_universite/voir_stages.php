<?php
require __DIR__ . '/api_client.php';

$matricule = $_GET['matricule'] ?? '';
$stages = [];
if ($matricule) {
    // App1 récupère ici des informations provenant de App2, via l'API
    $result = callApi('stages_api.php?matricule=' . urlencode($matricule), 'GET');
    $stages = $result['body']['data'] ?? [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Stages de l'étudiant</title><link rel="stylesheet" href="style.css"></head>
<body>
<h1>Stages de l'étudiant : <?= htmlspecialchars($matricule) ?></h1>
<p><a href="etudiants.php">&larr; Retour à la liste des étudiants</a></p>

<?php if (empty($stages)): ?>
    <p>Aucun stage trouvé pour cet étudiant (aucune donnée dans l'application 2).</p>
<?php else: ?>
<table border="1" cellpadding="6">
    <tr><th>Entreprise</th><th>Thème</th><th>Début</th><th>Fin</th><th>Statut</th></tr>
    <?php foreach ($stages as $s): ?>
    <tr>
        <td><?= htmlspecialchars($s['nom_entreprise']) ?></td>
        <td><?= htmlspecialchars($s['theme_stage'] ?? '-') ?></td>
        <td><?= htmlspecialchars($s['date_debut']) ?></td>
        <td><?= htmlspecialchars($s['date_fin']) ?></td>
        <td><?= htmlspecialchars($s['statut']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
</body>
</html>
