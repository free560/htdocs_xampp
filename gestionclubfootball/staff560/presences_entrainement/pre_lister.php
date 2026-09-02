<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste Présences</title>
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
	text-align:center;
}
tr:hover td{
	background:#fafafa;
}
.present{
	color:green;
	font-weight:bold;
}
.absent{
	color:red;
	font-weight:bold;
}
.retard{
	color:orange;
	font-weight:bold;
}
.modifier{
    background:black;
}
.delete{
    background:#c0392b;
}
.btn{
    text-decoration:none;
    color:white;
    padding:6px 12px;
    border-radius:5px;
    font-size:0.9em;
}
.empty-row{
    text-align:center;
    padding:30px;
    color:#888;
}
</style>
</head>
<body>
<?php include '../menu_admin.php'; ?>

<?php
include '../config/db.php';

// ✅ Double jointure : presences -> entrainements -> equipes, et presences -> joueurs
$presences = mysqli_query($conn, "
    SELECT p.id, p.statut,
           j.nom, j.prenom,
           t.date_entrainement, t.lieu, e.nom_equipe
    FROM presences_entrainement p
    JOIN joueurs j ON p.joueur_id = j.id
    JOIN entrainements t ON p.entrainement_id = t.id
    JOIN equipes e ON t.equipe_id = e.id
    ORDER BY t.date_entrainement DESC
");
?>

<div class="container">
<h2>Présences Entraînement</h2>
<table>
<tr>
    <th>Entraînement</th>
    <th>Joueur</th>
    <th>Statut</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($presences) > 0): ?>
    <?php while ($p = mysqli_fetch_assoc($presences)): ?>
        <?php
            $classeStatut = strtolower($p['statut']); // present / absent / retard
        ?>
        <tr>
            <td>
                <?= htmlspecialchars($p['nom_equipe']) ?> -
                <?= htmlspecialchars($p['date_entrainement']) ?>
                (<?= htmlspecialchars($p['lieu']) ?>)
            </td>
            <td><?= htmlspecialchars($p['nom'] . ' ' . $p['prenom']) ?></td>
            <td class="<?= $classeStatut ?>"><?= htmlspecialchars($p['statut']) ?></td>
            <td>
                <a href="pre_modifier.php?id=<?= $p['id'] ?>" class="btn modifier">Modifier</a>
                <a href="pre_supprimer.php?id=<?= $p['id'] ?>" class="btn delete"
                   onclick="return confirm('Confirmer la suppression de cette présence ?');">Supprimer</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="4" class="empty-row">Aucune présence enregistrée pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
</div>
<div style="margin-top:15px; text-align:center;">
    <a href="pre_ajouter.php" class="btn modifier">
        + Ajouter une Présence
    </a>
</div>
</body>
</html>