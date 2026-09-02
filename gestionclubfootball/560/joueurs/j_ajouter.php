<?php
include '../config/db.php';
$equipes = mysqli_query($conn, "SELECT id, nom_equipe FROM equipes ORDER BY nom_equipe");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Joueur</title>

<style>

body{
    font-family:Arial;
    background:whitesmoke;
}

.container{
    width:700px;
    margin:30px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px whitesmoke;
}

input, select, textarea{
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

<div class="container">

<h2>Ajouter un Joueur</h2>

<form action="J_traitement.php" method="POST" enctype="multipart/form-data">

<select name="equipe_id">
    <option value="">Choisir une équipe</option>
    <?php while ($eq = mysqli_fetch_assoc($equipes)): ?>
        <option value="<?= $eq['id'] ?>"><?= htmlspecialchars($eq['nom_equipe']) ?>
        </option>
    <?php endwhile; ?>
</select>

<input type="text" name="nom" placeholder="Nom">

<input type="text" name="prenom" placeholder="Prénom">

<select name="sexe">
    <option value="">Sexe</option>
    <option value="M">M</option>
    <option value="F">F</option>
</select>

<input type="date" name="date_naissance">

<input type="text" name="nationalite" placeholder="Nationalité">

<select name="poste">
    <option value="">Poste</option>
    <option value="Gardien">Gardien</option>
    <option value="Defenseur">Défenseur</option>
    <option value="Milieu">Milieu</option>
    <option value="Attaquant">Attaquant</option>
</select>

<input type="number" name="numero_maillot" placeholder="Numéro maillot">

<input type="number" step="0.01" name="taille" placeholder="Taille (m)">

<input type="number" step="0.01" name="poids" placeholder="Poids (kg)">

<input type="text" name="telephone" placeholder="Téléphone">

<input type="email" name="email" placeholder="Email">

<textarea name="adresse" placeholder="Adresse"></textarea>

<input type="file" name="photo">

<select name="statut">
    <option value="">Statut</option>
    <option value="Actif">Actif</option>
    <option value="Blesse">Blessé</option>
    <option value="Suspendu">Suspendu</option>
    <option value="Libre">Libre</option>
</select>

<button type="submit">Enregistrer</button>

</form>

</div>

</body>
</html>