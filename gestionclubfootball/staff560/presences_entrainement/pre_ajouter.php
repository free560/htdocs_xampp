<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Présence Entraînement</title>
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
	margin-top:10px;}
	
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

// ✅ jointure avec equipes pour afficher le nom de l'équipe au lieu de l'ID
$entrainements = mysqli_query($conn, "
    SELECT t.id, e.nom_equipe, t.date_entrainement, t.lieu
    FROM entrainements t
    JOIN equipes e ON t.equipe_id = e.id
    ORDER BY t.date_entrainement DESC
");

$joueurs = mysqli_query($conn, "SELECT id, nom, prenom FROM joueurs ORDER BY nom");
?>
<div class="container">
<h2>Ajouter Présence Entraînement</h2>
<form action="pre_traitement.php" method="POST">

    <select name="entrainement_id">
        <option value="">Entraînement</option>
        <?php while ($e = mysqli_fetch_assoc($entrainements)): ?>
            <option value="<?= $e['id'] ?>">
                <?= htmlspecialchars($e['nom_equipe'] . ' - ' . $e['date_entrainement'] . ' (' . $e['lieu'] . ')') ?>
            </option>
        <?php endwhile; ?>
    </select>

    <select name="joueur_id">
        <option value="">Joueur</option>
        <?php while ($j = mysqli_fetch_assoc($joueurs)): ?>
            <option value="<?= $j['id'] ?>">
                <?= htmlspecialchars($j['nom'] . ' ' . $j['prenom']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <select name="statut">
        <option value="">Statut</option>
        <option value="Present">Présent</option>
        <option value="Absent">Absent</option>
        <option value="Retard">Retard</option>
    </select>

    <button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>