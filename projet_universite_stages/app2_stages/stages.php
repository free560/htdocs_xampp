<?php
require __DIR__ . '/config/db.php';
require __DIR__ . '/api_client.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Envoi via l'API (comme demandé : la création du stage passe par l'API)
    $payload = [
        'matricule_etudiant'  => $_POST['matricule_etudiant'],
        'nom_etudiant_cache'  => $_POST['nom_etudiant_cache'],
        'id_entreprise'       => $_POST['id_entreprise'],
        'id_encadreur'        => $_POST['id_encadreur'] ?: null,
        'theme_stage'         => $_POST['theme_stage'],
        'date_debut'          => $_POST['date_debut'],
        'date_fin'            => $_POST['date_fin'],
        'statut'              => $_POST['statut'],
    ];
    $result = callApi('stages_api.php', 'POST', $payload);

    if ($result['code'] === 201) {
        $message = "<div class='alert success'>Stage enregistré avec succès (via l'API).</div>";
    } else {
        $err = $result['body']['message'] ?? 'Erreur inconnue';
        $message = "<div class='alert error'>Échec : $err</div>";
    }
}

// App2 récupère la liste des étudiants depuis App1, via l'API
$etudiantsApi = callApi('etudiants_api.php', 'GET')['body']['data'] ?? [];

$entreprises = $pdo->query("SELECT id_entreprise, nom_entreprise FROM entreprises ORDER BY nom_entreprise")->fetchAll(PDO::FETCH_ASSOC);
$encadreurs  = $pdo->query("SELECT id_encadreur, nom, prenom FROM encadreurs ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

// Liste des stages : lue via l'API également
$stagesApi = callApi('stages_api.php', 'GET')['body']['data'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Stages</title><link rel="stylesheet" href="style.css"></head>
<body>
<h1>Application 2 — Gestion des stages</h1>
<nav><a href="index.php">Accueil</a> | <a href="entreprises.php">Entreprises</a> | <a href="encadreurs.php">Encadreurs</a> | <a href="stages.php">Stages</a> | <a href="evaluations.php">Évaluations</a></nav>

<h2>Créer un stage</h2>
<?= $message ?>
<form method="POST" id="stageForm">
    <label>Étudiant (données venant de l'application 1 via l'API)</label>
    <select name="matricule_etudiant" id="etudiantSelect" required>
        <option value="">-- Choisir --</option>
        <?php foreach ($etudiantsApi as $et): ?>
        <option value="<?= htmlspecialchars($et['matricule']) ?>" data-nom="<?= htmlspecialchars($et['nom'] . ' ' . $et['prenom']) ?>">
            <?= htmlspecialchars($et['matricule'] . ' - ' . $et['nom'] . ' ' . $et['prenom']) ?>
        </option>
        <?php endforeach; ?>
    </select>
    <input type="hidden" name="nom_etudiant_cache" id="nomEtudiantCache">

    <label>Entreprise</label>
    <select name="id_entreprise" required>
        <?php foreach ($entreprises as $e): ?>
        <option value="<?= $e['id_entreprise'] ?>"><?= htmlspecialchars($e['nom_entreprise']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Encadreur</label>
    <select name="id_encadreur">
        <option value="">-- Aucun --</option>
        <?php foreach ($encadreurs as $e): ?>
        <option value="<?= $e['id_encadreur'] ?>"><?= htmlspecialchars($e['nom'] . ' ' . $e['prenom']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Thème du stage</label>
    <input type="text" name="theme_stage">

    <label>Date de début</label>
    <input type="date" name="date_debut" required>

    <label>Date de fin</label>
    <input type="date" name="date_fin" required>

    <label>Statut</label>
    <select name="statut">
        <option value="planifie">Planifié</option>
        <option value="en_cours">En cours</option>
        <option value="termine">Terminé</option>
        <option value="abandonne">Abandonné</option>
    </select>

    <button type="submit">Enregistrer via l'API</button>
</form>

<script>
document.getElementById('etudiantSelect').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    document.getElementById('nomEtudiantCache').value = opt.dataset.nom || '';
});
</script>

<h2>Liste des stages</h2>
<table border="1" cellpadding="6">
    <tr><th>Étudiant</th><th>Entreprise</th><th>Thème</th><th>Début</th><th>Fin</th><th>Statut</th></tr>
    <?php foreach ($stagesApi as $s): ?>
    <tr>
        <td><?= htmlspecialchars($s['nom_etudiant_cache'] ?? $s['matricule_etudiant']) ?></td>
        <td><?= htmlspecialchars($s['nom_entreprise']) ?></td>
        <td><?= htmlspecialchars($s['theme_stage'] ?? '-') ?></td>
        <td><?= htmlspecialchars($s['date_debut']) ?></td>
        <td><?= htmlspecialchars($s['date_fin']) ?></td>
        <td><?= htmlspecialchars($s['statut']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
