<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Participation Match</title>
<style>
body{
	font-family:Arial;
	background:whitesmoke;
}
.container{
	width:650px;
	margin:40px auto;
	background:white;
	padding:25px;
	border-radius:10px;
	box-shadow:0 0 10px whitesmoke;
}
input,select{
	width:100%;
	padding:10px;
	margin-top:10px;
}
button{
	width:100%;
	padding:12px;
	margin-top:15px;
	background:black;
	color:white;
	border:none;
}
</style>
</head>
<body>
<?php include '../menu_admin.php'; ?>
<?php
include '../config/db.php';


$matchs = mysqli_query($conn, "
    SELECT m.id, e.nom_equipe, m.adversaire, m.date_match
    FROM `matchs` m
    JOIN equipes e ON m.equipe_id = e.id
    ORDER BY m.date_match DESC
");

$joueurs = mysqli_query($conn, "SELECT id, nom, prenom FROM joueurs ORDER BY nom");
?>
<div class="container">
<h2>Ajouter Participation Match</h2>
<form action="pa_traitement.php" method="POST">
 
    <select name="match_id">
        <option value="">Choisir Match</option>
        <?php while ($m = mysqli_fetch_assoc($matchs)): ?>
            <option value="<?= $m['id'] ?>">
                <?= htmlspecialchars($m['nom_equipe'] . ' vs ' . $m['adversaire']) ?>
                (<?= htmlspecialchars($m['date_match']) ?>)
            </option>
        <?php endwhile; ?>
    </select>
  
    <select name="joueur_id">
        <option value="">Choisir Joueur</option>
        <?php while ($j = mysqli_fetch_assoc($joueurs)): ?>
            <option value="<?= $j['id'] ?>">
                <?= htmlspecialchars($j['nom'] . ' ' . $j['prenom']) ?>
            </option>
        <?php endwhile; ?>
    </select>
    <select name="titulaire">
        <option value="">Titulaire ?</option>
        <option value="Oui">Oui</option>
        <option value="Non">Non</option>
    </select>
    <input type="number" name="minutes_jouees" placeholder="Minutes jouées">
    <button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>