<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste des Équipes</title>
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
    border-bottom:1px solid gray;
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
    background:black;
}
.empty-row{
    text-align:center;
    padding:30px;
    color:white;
}
.ajout {
    display: flex;
    justify-content: flex-end;
    padding: 10px;
}
.ajout a {
    background: black;
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
}
</style>
</head>
<body>
<?php include '../menu_admin.php'; ?>

<?php
include '../config/db.php';

$equipes = mysqli_query($conn, "SELECT * FROM equipes ORDER BY nom_equipe");
?>

<div class="container">
<h2>Liste des Équipes</h2>
<table>
<tr>
    <th>Nom Équipe</th>
    <th>Catégorie</th>
    <th>Date Création</th>
    <th>Description</th>
</tr>

<?php if (mysqli_num_rows($equipes) > 0): ?>
    <?php while ($e = mysqli_fetch_assoc($equipes)): ?>
        <tr>
            <td><?= htmlspecialchars($e['nom_equipe']) ?></td>
            <td><span class="badge"><?= htmlspecialchars($e['categorie']) ?></span></td>
            <td><?= htmlspecialchars($e['date_creation']) ?></td>
            <td><?= htmlspecialchars($e['description']) ?></td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="empty-row">Aucune équipe enregistrée pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
</div>
</body>
</html>