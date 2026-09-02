<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste Matchs</title>
<style>
body{
    font-family:Arial;
    background:whitesmoke;
}
.container{
    width:98%;
    margin:20px auto;
}
h2{
    text-align:center;
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
}

.btn{
    text-decoration:none;
    color:white;
    padding:6px 12px;
    border-radius:5px;
    font-size:0.9em;
}
.modifier{
    background:black;
}
.delete{
    background:red;
}
.programme{
    color:blue;
    font-weight:bold;
}
.joue{
    color:green;
    font-weight:bold;
}
.annule{
    color:red;
    font-weight:bold;
}
.score{
    font-weight:bold;
    font-size:1.1em;
}
.empty-row{
    text-align:center;
    padding:30px;
    color:white;
}
</style>
</head>
<body>
<?php include '../menu.php'; ?>

<?php
include '../config/db.php';


$matchs = mysqli_query($conn, "
    SELECT m.*, e.nom_equipe, s.nom_stade
    FROM matchs m
    JOIN equipes e ON m.equipe_id = e.id
    LEFT JOIN stades s ON m.stade_id = s.id
    ORDER BY m.date_match DESC
");
?>

<div class="container">
<h2>Liste des Matchs</h2>
<table>
<tr>
    <th>Équipe</th>
    <th>Adversaire</th>
    <th>Compétition</th>
    <th>Stade</th>
    <th>Date</th>
    <th>Score</th>
    <th>Statut</th>
</tr>

<?php if (mysqli_num_rows($matchs) > 0): ?>
    <?php while ($m = mysqli_fetch_assoc($matchs)): ?>
        <?php
            switch (strtolower($m['statut'])) {
                case 'programme':
                    $classeStatut = 'programme';
                    $libelleStatut = 'Programmé';
                    break;
                case 'joue':
                    $classeStatut = 'joue';
                    $libelleStatut = 'Joué';
                    break;
                case 'annule':
                    $classeStatut = 'annule';
                    $libelleStatut = 'Annulé';
                    break;
                default:
                    $classeStatut = '';
                    $libelleStatut = htmlspecialchars($m['statut']);
            }
        ?>
        <tr>
            <td><?= htmlspecialchars($m['nom_equipe']) ?></td>
            <td><?= htmlspecialchars($m['adversaire']) ?></td>
            <td><?= htmlspecialchars($m['competition']) ?></td>
            <td><?= htmlspecialchars($m['nom_stade'] ?? 'Non défini') ?></td>
            <td><?= htmlspecialchars($m['date_match']) ?></td>
            <td class="score">
                <?= htmlspecialchars($m['score_equipe'] ?? '-') ?> - <?= htmlspecialchars($m['score_adversaire'] ?? '-') ?>
            </td>
            <td class="<?= $classeStatut ?>"><?= $libelleStatut ?></td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="8" class="empty-row">Aucun match enregistré pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
</div>
</body>
</html>