<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>À propos</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:whitesmoke;
}

.container{
    width:800px;
    margin:50px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px whitesmoke;
}

h1{
    text-align:center;
    color:black;
}

p{
    line-height:1.6;
    font-size:16px;
    color:gray;
}
</style>
</head>

<body>
<?php include 'menu_admin.php';?>

<div class="container">

<h1>À propos du projet</h1>

<p>
Ce projet est une application de gestion de club de football développée en PHP.
Il permet de gérer les joueurs, les matchs, les équipes, les sponsors, les finances,
les entraînements et plusieurs autres modules importants du club.
</p>

<p>
L’objectif est de faciliter la gestion administrative et sportive d’un club de football
avec une interface simple, claire et dynamique.
</p>

<p>
Ce système peut évoluer vers une version complète avec base de données MySQL,
authentification des utilisateurs et statistiques en temps réel.
</p>

</div>

</body>
</html>