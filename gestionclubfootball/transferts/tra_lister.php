<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste Transferts</title>
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
    border-bottom:1px solid black;
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
.money{
    color:green;
    font-weight:bold;
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

$transferts = mysqli_query($conn, "
    SELECT t.*, j.nom, j.prenom
    FROM transferts t
    LEFT JOIN joueurs j ON t.joueur_id = j.id
    ORDER BY t.date_transfert DESC
");
?>

<div class="container">
<h2>Liste des Transferts</h2>
<table>
<tr>
    <th>Joueur</th>
    <th>Ancien Club</th>
    <th>Nouveau Club</th>
    <th>Montant</th>
    <th>Date</th>
</tr>

<?php if (mysqli_num_rows($transferts) > 0): ?>
    <?php while ($t = mysqli_fetch_assoc($transferts)): ?>
        <tr>
            <td><?= htmlspecialchars(($t['nom'] ?? '') . ' ' . ($t['prenom'] ?? '')) ?></td>
            <td><?= htmlspecialchars($t['ancien_club']) ?></td>
            <td><?= htmlspecialchars($t['nouveau_club']) ?></td>
            <td class="money">
                <?= htmlspecialchars(number_format($t['montant'], 0, ',', ' ')) ?> FBu
            </td>
            <td><?= htmlspecialchars($t['date_transfert']) ?></td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="empty-row">Aucun transfert enregistré pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
</div>
</body>
</html>