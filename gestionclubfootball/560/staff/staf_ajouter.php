<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Staff</title>
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
    box-shadow:0px 0px 10px whitesmoke;
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
<?php include '../menu_admin.php'; ?>
<?php
include '../config/db.php';
$equipes = mysqli_query($conn, "SELECT id, nom_equipe FROM equipes ORDER BY nom_equipe");
?>
<div class="container">
<h2>Ajouter un Membre du Staff</h2>
<form action="staf_traitement.php" method="POST" enctype="multipart/form-data">
<select name="equipe_id">
    <option value="">Choisir une équipe</option>
    <?php while ($eq = mysqli_fetch_assoc($equipes)): ?>
        <option value="<?= $eq['id'] ?>"><?= htmlspecialchars($eq['nom_equipe']) ?></option>
    <?php endwhile; ?>
</select>
<input type="text" name="nom" placeholder="Nom">
<input type="text" name="prenom" placeholder="Prénom">
<select name="fonction">
    <option value="">Fonction</option>
    <option value="Entraineur">Entraîneur</option>
    <option value="Manager">Manager</option>
    <option value="Medecin">Médecin</option>
    <option value="Comptable">Comptable</option>
    <option value="Secretaire">Secrétaire</option>
    <option value="Preparateur Physique">Préparateur Physique</option>
</select>
<input type="text" name="telephone" placeholder="Téléphone">
<input type="email" name="email" placeholder="Email">
<input type="number" name="salaire" placeholder="Salaire">
<input type="date" name="date_embauche">

<label style="margin-top:12px; display:block; font-size:13px; color:#555;">
    Photo
</label>
<input type="file" name="photo" accept="image/*">

<button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>