<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Match</title>
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
input, select{
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
    cursor:pointer;
}
h2{
    text-align:center;
}
</style>
</head>
<body>
<?php
include '../config/db.php';
$equipes = mysqli_query($conn, "SELECT id, nom_equipe FROM equipes ORDER BY nom_equipe");
$stades  = mysqli_query($conn, "SELECT id, nom_stade FROM stades ORDER BY nom_stade");
?>
<?php include '../menu_admin.php'; ?>
<div class="container">
<h2>Ajouter un Match</h2>
<form action="m_traitement.php" method="POST">
<select name="equipe_id">
    <option value="">Equipe</option>
    <?php while ($eq = mysqli_fetch_assoc($equipes)): ?>
    <option value="<?= $eq['id'] ?>"><?= htmlspecialchars($eq['nom_equipe']) ?></option>
    <?php endwhile; ?>
</select>
<select name="stade_id">
    <option value="">Stade</option>
    <?php while ($st = mysqli_fetch_assoc($stades)): ?>
    <option value="<?= $st['id'] ?>"><?= htmlspecialchars($st['nom_stade']) ?></option>
    <?php endwhile; ?>
</select>
<input type="text" name="adversaire" placeholder="Adversaire">
<input type="text" name="competition" placeholder="Competition">
<input type="datetime-local" name="date_match">
<select name="type_match">
    <option value="Domicile">Domicile</option>
    <option value="Exterieur">Exterieur</option>
</select>
<input type="number" name="score_equipe" placeholder="Score equipe">
<input type="number" name="score_adversaire" placeholder="Score adversaire">
<select name="statut">
    <option value="Programme">Programme</option>
    <option value="Joue">Joue</option>
    <option value="Annule">Annulé</option>
</select>
<button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>