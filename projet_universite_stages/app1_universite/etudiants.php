<?php
require __DIR__ . '/api_client.php';

$message = '';

// Traitement du formulaire : App1 ENVOIE les données à l'API (pas directement en base)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payload = [
        'matricule'      => $_POST['matricule'],
        'nom'            => $_POST['nom'],
        'prenom'         => $_POST['prenom'],
        'email'          => $_POST['email'],
        'telephone'      => $_POST['telephone'],
        'date_naissance' => $_POST['date_naissance'],
        'sexe'           => $_POST['sexe'],
        'adresse'        => $_POST['adresse'],
    ];

    $result = callApi('etudiants_api.php', 'POST', $payload);

    if ($result['code'] === 201) {
        $message = "<div class='alert success'>Étudiant ajouté avec succès (via l'API).</div>";
    } else {
        $err = $result['body']['message'] ?? 'Erreur inconnue';
        $message = "<div class='alert error'>Échec : $err</div>";
    }
}

// Récupération de la liste : App1 LIT les données via l'API (GET)
$liste = callApi('etudiants_api.php', 'GET')['body']['data'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Application 1 - Étudiants</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Application 1 — Gestion universitaire</h1>
<nav><a href="index.php">Accueil</a> | <a href="formations.php">Formations</a> | <a href="etudiants.php">Étudiants</a> | <a href="inscriptions.php">Inscriptions</a></nav>

<h2>Ajouter un étudiant</h2>
<?= $message ?>
<form method="POST">
    <label>Matricule</label>
    <input type="text" name="matricule" required>

    <label>Nom</label>
    <input type="text" name="nom" required>

    <label>Prénom</label>
    <input type="text" name="prenom" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Téléphone</label>
    <input type="text" name="telephone">

    <label>Date de naissance</label>
    <input type="date" name="date_naissance">

    <label>Sexe</label>
    <select name="sexe" required>
        <option value="M">Masculin</option>
        <option value="F">Féminin</option>
    </select>

    <label>Adresse</label>
    <input type="text" name="adresse">

    <button type="submit">Envoyer à l'API</button>
</form>

<h2>Liste des étudiants (récupérée via l'API)</h2>
<table border="1" cellpadding="6">
    <tr>
        <th>Matricule</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Formation</th>
        <th>Stages (App2)</th>
    </tr>
    <?php foreach ($liste as $e): ?>
    <tr>
        <td><?= htmlspecialchars($e['matricule']) ?></td>
        <td><?= htmlspecialchars($e['nom']) ?></td>
        <td><?= htmlspecialchars($e['prenom']) ?></td>
        <td><?= htmlspecialchars($e['email']) ?></td>
        <td><?= htmlspecialchars($e['nom_formation'] ?? '-') ?></td>
        <td><a href="voir_stages.php?matricule=<?= urlencode($e['matricule']) ?>">Voir stages</a></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
