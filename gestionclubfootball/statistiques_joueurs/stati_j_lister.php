<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Statistiques Joueurs</title>
<style>
body{
    font-family:Arial;
    background:whitesmoke;
}
.container{
    width:98%;
    margin:20px auto;
}
table{
    width:100%;
    border-collapse:collapse;
    background:white;
}
th{
    background:black;
    color:white;
    padding:12px;
}
td{
    padding:10px;
    border-bottom:1px solid whitesmoke;
    text-align:center;
}
.btn{
    text-decoration:none;
    color:white;
    padding:6px 12px;
    border-radius:5px;
}
.modifier{
    background:black;
}
.supprimer{
    background:#c0392b;
}
.badge{
    padding:4px 8px;
    border-radius:5px;
    color:white;
}
.empty-row{
    text-align:center;
    padding:30px;
    color:#888;
}
</style>
</head>
<body>
<?php include '../menu.php'; ?>
<?php
include '../config/db.php';

// Jointure avec joueurs pour afficher nom + prénom
// Jointure avec matchs + equipes pour afficher "Equipe vs Adversaire (date)"
$stats = mysqli_query($conn, "
    SELECT sj.*, j.nom, j.prenom,
           m.adversaire, m.date_match, e.nom_equipe
    FROM statistiques_joueurs sj
    LEFT JOIN joueurs j ON sj.joueur_id = j.id
    LEFT JOIN matchs m ON sj.match_id = m.id
    LEFT JOIN equipes e ON m.equipe_id = e.id
    ORDER BY sj.id DESC
");
?>
<div class="container">
<h2>Statistiques des Joueurs</h2>
<table>
<tr>
    <th>Joueur</th>
    <th>Match</th>
    <th>Buts</th>
    <th>Passes</th>
    <th>JA</th>
    <th>JR</th>
    <th>Note</th>
</tr>
<?php if (mysqli_num_rows($stats) > 0): ?>
    <?php while ($s = mysqli_fetch_assoc($stats)): ?>
        <tr>
            <td><?= htmlspecialchars(($s['nom'] ?? '') . ' ' . ($s['prenom'] ?? '')) ?></td>
            <td>
                <?php if (!empty($s['nom_equipe']) || !empty($s['adversaire'])): ?>
                    <?= htmlspecialchars(($s['nom_equipe'] ?? '?') . ' vs ' . ($s['adversaire'] ?? '?')) ?>
                    (<?= htmlspecialchars($s['date_match']) ?>)
                <?php else: ?>
                    Match introuvable
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($s['buts']) ?></td>
            <td><?= htmlspecialchars($s['passes_decisives']) ?></td>
            <td><?= htmlspecialchars($s['cartons_jaunes']) ?></td>
            <td><?= htmlspecialchars($s['cartons_rouges']) ?></td>
            <td><?= htmlspecialchars($s['note']) ?></td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="8" class="empty-row">Aucune statistique enregistrée pour le moment.</td>
    </tr>
<?php endif; ?>
</table>
</div>
</body>
</html>