<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste des Stades</title>
<style>
body{
    font-family:Arial;
    background:whitesmoke;
}
.container{
    width:95%;
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

$stades = mysqli_query($conn, "SELECT * FROM stades ORDER BY nom_stade");
?>

<div class="container">
<h2>Liste des Stades</h2>
<table>
<tr>
    <th>Nom</th>
    <th>Adresse</th>
    <th>Capacité</th>
</tr>

<?php if (mysqli_num_rows($stades) > 0): ?>
    <?php while ($s = mysqli_fetch_assoc($stades)): ?>
        <tr>
            <td><?= htmlspecialchars($s['nom_stade']) ?></td>
            <td><?= htmlspecialchars($s['adresse']) ?></td>
            <td><?= htmlspecialchars(number_format($s['capacite'], 0, ',', ' ')) ?></td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="4" class="empty-row">Aucun stade enregistré pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
</div>
</body>
</html>