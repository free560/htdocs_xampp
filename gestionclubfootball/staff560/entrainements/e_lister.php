<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste Entraînements</title>
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
    color:black;
    display:inline-block;
}
.badge-passe{
	background: red;
}
.badge-aujourdhui{
	background: green;
	}
.badge-avenir{
	background: orange;
}
.empty-row{
    text-align:center;
    padding:30px;
    color: black;
}
</style>
</head>
<body>
<?php include '../menu_admin.php'; ?>

<?php
include '../config/db.php';


$entrainements = mysqli_query($conn, "
    SELECT t.id, t.date_entrainement, t.lieu, t.description, e.nom_equipe
    FROM entrainements t
    JOIN equipes e ON t.equipe_id = e.id
    ORDER BY t.date_entrainement DESC
");

$aujourd_hui = date('Y-m-d');
?>

<div class="container">
<h2>Liste des Entraînements</h2>
<table>
<tr>
    <th>Équipe</th>
    <th>Date</th>
    <th>Lieu</th>
    <th>Description</th>
    <th>Statut</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($entrainements) > 0): ?>
    <?php while ($t = mysqli_fetch_assoc($entrainements)): ?>
        <?php
            if ($t['date_entrainement'] < $aujourd_hui) {
                $badge = '<span class="badge badge-passe">Passé</span>';
            } elseif ($t['date_entrainement'] == $aujourd_hui) {
                $badge = '<span class="badge badge-aujourdhui">Aujourd\'hui</span>';
            } else {
                $badge = '<span class="badge badge-avenir">À venir</span>';
            }
        ?>
        <tr>
            <td><?= htmlspecialchars($t['nom_equipe']) ?></td>
            <td><?= htmlspecialchars($t['date_entrainement']) ?></td>
            <td><?= htmlspecialchars($t['lieu']) ?></td>
            <td><?= htmlspecialchars($t['description']) ?></td>
            <td><?= $badge ?></td>
            <td>
                <a href="e_modifier.php?id=<?= $t['id'] ?>" class="btn modifier">Modifier</a>
                <a href="e_supprimer.php?id=<?= $t['id'] ?>" class="btn delete"
                   onclick="return confirm('Confirmer la suppression de cet entraînement ?');">Supprimer</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="empty-row">Aucun entraînement enregistré pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
<div style="margin-top:15px;">
    <a href="e_ajouter.php" class="btn modifier">
       + Ajouter un Entraînement
    </a>
</div>
</div>
</body>
</html>