<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste Sponsors</title>
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
<?php include '../menu_admin.php';?>

<?php
include '../config/db.php';

$sponsors = mysqli_query($conn, "SELECT * FROM sponsors ORDER BY nom");
?>

<div class="container">
<h2>Liste des Sponsors</h2>
<table>
<tr>
    <th>Nom</th>
    <th>Contact</th>
    <th>Téléphone</th>
    <th>Email</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($sponsors) > 0): ?>
    <?php while ($s = mysqli_fetch_assoc($sponsors)): ?>
        <tr>
            <td><?= htmlspecialchars($s['nom']) ?></td>
            <td><?= htmlspecialchars($s['contact']) ?></td>
            <td><?= htmlspecialchars($s['telephone']) ?></td>
            <td><?= htmlspecialchars($s['email']) ?></td>
            <td>
                <a href="sp_modifier.php?id=<?= $s['id'] ?>" class="btn modifier">Modifier</a>
                <a href="sp_supprimer.php?id=<?= $s['id'] ?>" class="btn supprimer"
                   onclick="return confirm('Supprimer définitivement ce sponsor ?');">Supprimer</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="empty-row">Aucun sponsor enregistré pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
<div style="margin-top:15px;">
    <a href="sp_ajouter.php" class="btn modifier">
        Ajouter un Sponsor
    </a>
</div>
</div>
</body>
</html>