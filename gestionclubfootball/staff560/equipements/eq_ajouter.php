<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Équipement</title>
<style>
body{
    font-family: Arial;
    background:whitesmoke;
}
.container{
    width:500px;
    margin:50px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px whitesmoke;
}
input{
    width:100%;
    padding:10px;
    margin-top:10px;
}
button{
    width:100%;
    padding:10px;
    margin-top:15px;
    background:black;
    color:white;
    border:none;
    cursor:pointer;
}
</style>
</head>
<body>
<?php include '../menu_admin.php'; ?>
<div class="container">
<h2>Ajouter un Équipement</h2>
<form action="eq_traitement.php" method="POST">
<input type="text" name="nom_equipement" placeholder="Nom de l'équipement">
<input type="number" name="quantite" placeholder="Quantité">
<input type="number" name="prix_unitaire" placeholder="Prix unitaire">
<input type="date" name="date_achat">
<button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>