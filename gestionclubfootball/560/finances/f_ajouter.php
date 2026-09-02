<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Opération Financière</title>
<style>
body{
    font-family: Arial;
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
<h2>Ajouter une Opération Financière</h2>
<form action="f_traitement.php" method="POST">
<input type="date" name="date_operation">
<select name="type_operation">
    <option value="">Type d'opération</option>
    <option value="Recette">Recette</option>
    <option value="Depense">Dépense</option>
</select>
<input type="text" name="categorie" placeholder="Catégorie">
<input type="number" name="montant" placeholder="Montant">
<textarea rows="5" name="description" placeholder="Description"></textarea>
<button type="submit">Enregistrer</button>
</form>
<div style="margin-top:15px;">
    <a href="f_lister.php" class="btn modifier">
        Voir la liste des opérations
    </a>
</div>
</div>
</body>
</html>