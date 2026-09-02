<?php
require __DIR__ . '/config/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO offres (id_entreprise, titre, description, lieu, duree, date_limite) VALUES (?,?,?,?,?,?)");
    $stmt->execute([
        $_POST['id_entreprise'],
        $_POST['titre'],
        $_POST['description'],
        $_POST['lieu'],
        $_POST['duree'],
        $_POST['date_limite'] ?: null,
    ]);
    $message = "<div class='alert success'>Offre publiée avec succès.</div>";
}

$entreprises = $pdo->query("SELECT id_entreprise, nom_entreprise FROM entreprises ORDER BY nom_entreprise")->fetchAll(PDO::FETCH_ASSOC);

$offres = $pdo->query("
    SELECT o.*, e.nom_entreprise
    FROM offres o JOIN entreprises e ON e.id_entreprise = o.id_entreprise
    ORDER BY o.date_publication DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Offres de stage</title><link rel="stylesheet" href="style.css"></head>
<body>
<h1>Application 2 — Gestion des stages</h1>
<nav><a href="index.php">Accueil</a> | <a href="entreprises.php">Entreprises</a> | <a href="encadreurs.php">Encadreurs</a> | <a href="stages.php">Stages</a> | <a href="offres.php">Offres</a> | <a href="evaluations.php">Évaluations</a></nav>

<h2>Publier une offre de stage</h2>
<?= $message ?>
<form method="POST">
    <label>Entreprise</label>
    <select name="id_entreprise" required>
        <?php foreach ($entreprises as $e): ?>
        <option value="<?= $e['id_entreprise'] ?>"><?= htmlspecialchars($e['nom_entreprise']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>Titre de l'offre</label>
    <input type="text" name="titre" placeholder="Ex: Stage développeur web" required>

    <label>Description</label>
    <textarea name="description"></textarea>

    <label>Lieu</label>
    <input type="text" name="lieu" placeholder="Bujumbura, Gitega...">

    <label>Durée</label>
    <input type="text" name="duree" placeholder="Ex: 3 mois">

    <label>Date limite de candidature</label>
    <input type="date" name="date_limite">

    <button type="submit">Publier</button>
</form>

<h2>Vos offres publiées</h2>
<table border="1" cellpadding="6">
    <tr><th>Titre</th><th>Entreprise</th><th>Lieu</th><th>Durée</th><th>Date limite</th></tr>
    <?php foreach ($offres as $o): ?>
    <tr>
        <td><?= htmlspecialchars($o['titre']) ?></td>
        <td><?= htmlspecialchars($o['nom_entreprise']) ?></td>
        <td><?= htmlspecialchars($o['lieu'] ?? '-') ?></td>
        <td><?= htmlspecialchars($o['duree'] ?? '-') ?></td>
        <td><?= htmlspecialchars($o['date_limite'] ?? '-') ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Autres opportunités (source externe : API Arbeitnow, gratuite et publique)</h2>
<p style="font-size:14px;color:#666;">
    Ces offres viennent d'un vrai service externe qui agrège des opportunités de travail (surtout Europe / remote).
    Elles sont affichées à titre indicatif — Arbeitnow ne permet pas d'y publier vos propres offres directement,
    seulement de les consulter.
</p>
<div id="offresExternes">Chargement des offres externes...</div>

<script>
async function chargerOffresExternes() {
    const conteneur = document.getElementById('offresExternes');
    try {
        const res = await fetch('https://www.arbeitnow.com/api/job-board-api');
        const data = await res.json();
        const offres = (data.data || []).slice(0, 8); // on limite l'affichage aux 8 premières

        if (offres.length === 0) {
            conteneur.innerHTML = '<p>Aucune offre externe disponible pour le moment.</p>';
            return;
        }

        let html = '<table border="1" cellpadding="6"><tr><th>Titre</th><th>Entreprise</th><th>Lieu</th><th>Lien</th></tr>';
        offres.forEach(o => {
            html += `<tr>
                <td>${o.title}</td>
                <td>${o.company_name}</td>
                <td>${o.location || 'Remote'}</td>
                <td><a href="${o.url}" target="_blank" rel="noopener">Voir l'offre</a></td>
            </tr>`;
        });
        html += '</table>';
        conteneur.innerHTML = html;

    } catch (e) {
        conteneur.innerHTML = '<p>Impossible de charger les offres externes pour le moment.</p>';
        console.error(e);
    }
}
chargerOffresExternes();
</script>

</body>
</html>