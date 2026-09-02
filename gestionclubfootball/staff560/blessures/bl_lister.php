<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste Blessures</title>
<style>
body{
    font-family: Arial;
    background:whitesmoke;
}
.container{
    width:90%;
    margin:40px auto;
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
    padding:10px;
}
td{
    padding:10px;
    border-bottom:1px solid whitesmoke;
}
.btn{
    padding:5px 10px;
    text-decoration:none;
    color:white;
    border-radius:5px;
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
.badge-grave{ 
    background:red; 
}
.badge-moyenne{
	background:glay;
}
.badge-legere{
	background:green; 
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
<?php include '../menu_admin.php'; ?>

<?php
include '../config/db.php';

$blessures = mysqli_query($conn, "
    SELECT b.id, b.type_blessure, b.date_blessure, b.duree_estimee, b.commentaire,
           j.nom, j.prenom
    FROM blessures b
    JOIN joueurs j ON b.joueur_id = j.id
    ORDER BY b.date_blessure DESC
");
?>

<div class="container">
<h2>Liste des Blessures</h2>
<table>
<tr>
    <th>Joueur</th>
    <th>Blessure</th>
    <th>Date</th>
    <th>Durée</th>
    <th>Gravité</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($blessures) > 0): ?>
    <?php while ($b = mysqli_fetch_assoc($blessures)): ?>
        <tr>
            <td><?= htmlspecialchars($b['nom'] . ' ' . $b['prenom']) ?></td>
            <td><?= htmlspecialchars($b['type_blessure']) ?></td>
            <td><?= htmlspecialchars($b['date_blessure']) ?></td>
            <td><?= htmlspecialchars($b['duree_estimee']) ?> jours</td>
            <td>
                <?php
                
                if ($b['duree_estimee'] >= 30) {
                    echo '<span class="badge badge-grave">Grave</span>';
                } elseif ($b['duree_estimee'] >= 10) {
                    echo '<span class="badge badge-moyenne">Moyenne</span>';
                } else {
                    echo '<span class="badge badge-legere">Légère</span>';
                }
                ?>
            </td>
            <td>
                <a class="btn edit" href="bl_modifier.php?id=<?= $b['id'] ?>">Modifier</a>
                <a class="btn delete" href="bl_supprimer.php?id=<?= $b['id'] ?>"
                   onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="empty-row">Aucune blessure enregistrée pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
<div>
 <a class="add-link" href="bl_ajouter.php">+ Ajouter Nouvelle Blessure</a>
</div>
</div>
</body>
</html>