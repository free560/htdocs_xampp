<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste Équipements</title>
<style>
body{
    font-family: Arial;
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
.montant{
    font-weight:bold;
}
.badge{
    padding:4px 10px;
    border-radius:20px;
    font-size:0.85em;
    color:white;
    display:inline-block;
}
.badge-stock{
	background: green; 
}
.badge-faible{
	background:orange; 
}
.badge-rupture{
	background:red;
}
.empty-row{
    text-align:center;
    padding:30px;
    color: white;
}
</style>
</head>
<body>
<?php include '../menu_admin.php'; ?>

<?php
include '../config/db.php';

$equipements = mysqli_query($conn, "SELECT * FROM equipements ORDER BY date_achat DESC");
?>

<div class="container">
<h2>Liste des Équipements</h2>
<table>
<tr>
    <th>Nom</th>
    <th>Quantité</th>
    <th>Prix Unitaire</th>
    <th>Valeur Totale</th>
    <th>Date Achat</th>
    <th>Stock</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($equipements) > 0): ?>
    <?php while ($eq = mysqli_fetch_assoc($equipements)): ?>
        <?php
            $valeur_totale = $eq['quantite'] * $eq['prix_unitaire'];

            if ($eq['quantite'] == 0) {
                $badge = '<span class="badge badge-rupture">Rupture</span>';
            } elseif ($eq['quantite'] <= 5) {
                $badge = '<span class="badge badge-faible">Stock faible</span>';
            } else {
                $badge = '<span class="badge badge-stock">En stock</span>';
            }
        ?>
        <tr>
            <td><?= htmlspecialchars($eq['nom']) ?></td>
            <td><?= htmlspecialchars($eq['quantite']) ?></td>
            <td class="montant"><?= number_format($eq['prix_unitaire'], 0, ',', ' ') ?> FBu</td>
            <td class="montant"><?= number_format($valeur_totale, 0, ',', ' ') ?> FBu</td>
            <td><?= htmlspecialchars($eq['date_achat']) ?></td>
            <td><?= $badge ?></td>
            <td>
                <a href="eq_modifier.php?id=<?= $eq['id'] ?>" class="btn modifier">Modifier</a>
                <a href="eq_supprimer.php?id=<?= $eq['id'] ?>" class="btn delete"
                   onclick="return confirm('Confirmer la suppression de cet équipement ?');">Supprimer</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="7" class="empty-row">Aucun équipement enregistré pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
<div style="margin-top:15px;">
    <a href="eq_ajouter.php" class="btn modifier">
       + Ajouter un Équipement
    </a>
</div>
</div>
</body>
</html>