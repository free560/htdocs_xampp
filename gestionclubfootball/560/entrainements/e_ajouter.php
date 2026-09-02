<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Entraînement</title>
<style>
body{
    font-family:Arial;
    background:whitesmoke;
}
.container{
    width:600px;
    margin:50px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px whitesmoke;
}
input, textarea, select{
    width:100%;
    padding:10px;
    margin-top:10px;
}
button{
    width:100%;
    padding:10px;
    margin-top:15px;
    border:none;
    background:black;
    color:white;
    cursor:pointer;
}
</style>
</head>
<body>
<?php
include '../config/db.php';
$equipes = mysqli_query($conn, "SELECT id, nom_equipe FROM equipes ORDER BY nom_equipe");
?>
<?php include '../menu_admin.php'; ?>
<div class="container">
<h2>Ajouter un Entraînement</h2>
<form action="e_traitement.php" method="POST">
<select name="equipe_id">
    <option value="">Choisir une équipe</option>
    <?php while ($eq = mysqli_fetch_assoc($equipes)): ?>
    <option value="<?= $eq['id'] ?>"><?= htmlspecialchars($eq['nom_equipe']) ?></option>
    <?php endwhile; ?>
</select>
<input type="datetime-local" name="date_entrainement">
<input type="text" name="lieu" placeholder="Lieu de l'entraînement">
<textarea rows="5" name="description" placeholder="Description"></textarea>
<button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>