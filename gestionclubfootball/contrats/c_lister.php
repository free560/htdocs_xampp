<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste Contrats</title>
<style>
body{
    font-family:Arial;
    background:whitesmoke;
}
.container{
    width:90%;
    margin:40px auto;
}
h2{
    text-align:center;
}
table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 2px 8px whitesmoke;
}
th{
    background:black;
    color:white;
    padding:12px;
    text-align:left;
}
td{
    padding:12px;
    border-bottom:1px solid whitesmoke;
}
tr:hover td{
    background:#fafafa;
}
.btn{
    padding:6px 12px;
    text-decoration:none;
    color:white;
    border-radius:5px;
    font-size:0.9em;
}
.edit{
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
	background: green;
}
.badge-expire{
	background: red; 
}
.badge-bientot{
	background: orange; 
}
.montant{
    font-weight:bold;
}
.empty-row{
    text-align:center;
    padding:30px;
    color:white;
}
.add-link{
    display:inline-block;
    margin-top:15px;
    padding:10px 20px;
    background:black;
    color:white;
    text-decoration:none;
    border-radius:5px;
}
</style>
</head>
<body>
<?php include '../menu.php'; ?>

<?php
include '../config/db.php';


$contrats = mysqli_query($conn, "
    SELECT c.id, c.date_debut, c.date_fin, c.salaire, c.prime_match,
           j.nom, j.prenom
    FROM contrats c
    JOIN joueurs j ON c.joueur_id = j.id
    ORDER BY c.date_fin DESC
");

$aujourd_hui = date('Y-m-d');
?>

<div class="container">
<h2>Liste des Contrats</h2>
<table>
<tr>
    <th>Joueur</th>
    <th>Date début</th>
    <th>Date fin</th>
    <th>Salaire</th>
    <th>Prime / match</th>
    <th>Statut</th>
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
            <td><?= htmlspecialchars($c['nom'] . ' ' . $c['prenom']) ?></td>
            <td><?= htmlspecialchars($c['date_debut']) ?></td>
            <td><?= htmlspecialchars($c['date_fin']) ?></td>
            <td class="montant"><?= number_format($c['salaire'], 0, ',', ' ') ?> BIF</td>
            <td class="montant"><?= number_format($c['prime_match'], 0, ',', ' ') ?> BIF</td>
            <td><?= $badge ?></td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="7" class="empty-row">Aucun contrat enregistré pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
</div>
</body>
</html>