<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste des Finances</title>
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
.recette{
    color:green;
    font-weight:bold;
}
.depense{
    color:red;
    font-weight:bold;
}
.resume{
    display:flex;
    gap:20px;
    margin-bottom:20px;
}
.carte{
    flex:1;
    background:white;
    padding:20px;
    border-radius:10px;
    text-align:center;
    box-shadow:0 2px 8px whitesmoke;
}
.carte h3{
    margin:0 0 10px 0;
    font-size:0.9em;
    color:white;
}
.carte p{
    margin:0;
    font-size:1.4em;
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

$finances = mysqli_query($conn, "SELECT * FROM finances ORDER BY date_operation DESC");

$totalRecettes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(montant) AS total FROM finances WHERE type_operation = 'Recette'"))['total'] ?? 0;
$totalDepenses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(montant) AS total FROM finances WHERE type_operation = 'Depense'"))['total'] ?? 0;
$solde = $totalRecettes - $totalDepenses;
?>

<div class="container">
<h2>Liste des Opérations Financières</h2>

<div class="resume">
    <div class="carte">
        <h3>Total Recettes</h3>
        <p class="recette"><?= number_format($totalRecettes, 0, ',', ' ') ?> FBu</p>
    </div>
    <div class="carte">
        <h3>Total Dépenses</h3>
        <p class="depense"><?= number_format($totalDepenses, 0, ',', ' ') ?> FBu</p>
    </div>
    <div class="carte">
        <h3>Solde</h3>
        <p style="color:<?= $solde >= 0 ? 'green' : 'red' ?>"><?= number_format($solde, 0, ',', ' ') ?> FBu</p>
    </div>
</div>

<table>
<tr>
    <th>Date</th>
    <th>Type</th>
    <th>Catégorie</th>
    <th>Montant</th>
    <th>Description</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($finances) > 0): ?>
    <?php while ($f = mysqli_fetch_assoc($finances)): ?>
        <tr>
            <td><?= htmlspecialchars($f['date_operation']) ?></td>
            <td class="<?= strtolower($f['type_operation']) ?>">
                <?= htmlspecialchars($f['type_operation']) ?>
            </td>
            <td><?= htmlspecialchars($f['categorie']) ?></td>
            <td class="<?= strtolower($f['type_operation']) ?>">
                <?= number_format($f['montant'], 0, ',', ' ') ?> FBu
            </td>
            <td><?= htmlspecialchars($f['description']) ?></td>
            <td>
                <a href="f_modifier.php?id=<?= $f['id'] ?>" class="btn modifier">Modifier</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="empty-row">Aucune opération financière enregistrée pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
<div style="margin-top:15px;">
    <a href="f_ajouter.php" class="btn modifier">
       Ajouter Finances
    </a>
</div>
</div>
</body>
</html>