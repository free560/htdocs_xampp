<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Équipe</title>

<style>

body{
    font-family: Arial;
    background:whitesmoke;

.container{
    width:600px;
    margin:50px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0px 0px 10px rgba whitesmoke;
}

input, textarea, select{
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

<h2>Ajouter une Équipe</h2>

<form action="eq_traitement.php" method="POST">

<input type="text" name="nom_equipe" placeholder="Nom de l'équipe">

<select name="categorie">
    <option value="" >Choisir une catégorie</option>
    <option value="senior">Senior</option>
    <option value="junior">Junior</option>
    <option value="cadet">Cadet</option>
    <option value="Féminine">Féminine</option>
</select>

<input type="date" name="date_creation">

<select name="stade">
    <option value="">Choisir un stade</option>
    <option value="Stade Intwari">Stade Intwari</option>
    <option value="stade CTN">Stade CTN</option>
    <option value="Stade Urunani">Stade Urunani</option>
</select>

<textarea rows="5" name="description" placeholder="Description de l'équipe"></textarea>

<button type="submit">
Enregistrer
</button>

</form>

</div>

</body>
</html>