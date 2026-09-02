<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Sponsor</title>
<style>
body{
    font-family:Arial;
    background:whitesmoke;
}
.container{
    width:600px;
    margin:50px auto;
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
<?php include '../menu_admin.php'; ?>
<div class="container">
<h2>Ajouter un Sponsor</h2>


<form action="sp_traitement.php" method="POST">
    <input type="text" name="nom_sponsor" placeholder="Nom du sponsor">
    <input type="text" name="contact" placeholder="Contact">
    <input type="text" name="telephone" placeholder="Téléphone">
    <input type="email" name="email" placeholder="Email">
    <button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>