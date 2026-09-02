<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste Contrats Sponsors</title>
<style>
body{
    font-family:Arial;
    background:whitesmoke;
}
.container{
    width:95%;
    margin:30px auto;
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
tr:hover td{
    background:#fafafa;
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
.badge{
    padding:4px 10px;
    border-radius:20px;
    font-size:0.85em;
    color:white;
    display:inline-block;
}
.badge-actif{
	background:green; 
}
.badge-expire{
	background:red;
}
.badge-bientot{
	background:orange;
}
.montant{
    font-weight:bold;
}
.empty-row{
    text-align:center;
    padding:30px;
    color:white;
}
</style>
</head>
<body>
<?php include '../menu_admin.php'; ?>

<?php
include '../config/db.php';


$contrats = mysqli_query($conn, "
    SELECT cs.id, cs.montant, cs.date_debut, cs.date_fin, s.nom
    FROM contrats_sponsors cs
    JOIN sponsors s ON cs.sponsor_id = s.id
    ORDER BY cs.date_fin DESC
");

$aujourd_hui = date('Y-m-d');
?>

<div class="container">
<h2>Liste des Contrats Sponsors</h2>
<table>
<tr>
    <th>Sponsor</th>
    <th>Montant</th>
    <th>Date Début</th>
    <th>Date Fin</th>
    <th>Statut</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($contrats) > 0): ?>
    <?php while ($c = mysqli_fetch_assoc($contrats)): ?>
        <?php
            $jours_restants = (strtotime($c['date_fin']) - strtotime($aujourd_hui)) / 86400;

            if ($jours_restants < 0) {
                $badge = '<span class="badge badge-expire">Expiré</span>';
            } elseif ($jours_restants <= 60) {
                $badge = '<span class="badge badge-bientot">Bientôt fini</span>';
            } else {
                $badge = '<span class="badge badge-actif">Actif</span>';
            }
        ?>
        <tr>
            <td><?= htmlspecialchars($c['nom']) ?></td>
            <td class="montant"><?= number_format($c['montant'], 0, ',', ' ') ?> BIF</td>
            <td><?= htmlspecialchars($c['date_debut']) ?></td>
            <td><?= htmlspecialchars($c['date_fin']) ?></td>
            <td><?= $badge ?></td>
            <td>
                <a href="cs_modifier.php?id=<?= $c['id'] ?>" class="btn modifier">Modifier</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="empty-row">Aucun contrat sponsor enregistré pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
<div style="margin-top:15px;">
    <a href="cs_ajouter.php" class="btn modifier">
      + Ajouter Nouveau Contrat Sponsors
    </a>
</div>
</div>
</body>
</html>