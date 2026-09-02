<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Équipe</title>
<style>
body{
    font-family:Arial;
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
input, textarea{
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

if (!isset($_GET['id'])) {
    echo "Aucun identifiant fourni.";
    exit();
}

$id = intval($_GET['id']);

$sqlEquipe = mysqli_query($conn, "SELECT * FROM equipes WHERE id = '$id'");
$equipe = mysqli_fetch_assoc($sqlEquipe);

if (!$equipe) {
    echo "Équipe introuvable.";
    exit();
}
?>

<div class="container">
<h2>Modifier une Équipe</h2>

<form action="eq_modifier_traitement.php" method="POST">

    <input type="hidden" name="id" value="<?= $equipe['id'] ?>">

    <input type="text" name="nom_equipe" placeholder="Nom de l'équipe" value="<?= htmlspecialchars($equipe['nom_equipe']) ?>">
    <input type="text" name="categorie" placeholder="Catégorie" value="<?= htmlspecialchars($equipe['categorie']) ?>">
    <input type="date" name="date_creation" value="<?= htmlspecialchars($equipe['date_creation']) ?>">
    <textarea name="description" placeholder="Description"><?= htmlspecialchars($equipe['description']) ?></textarea>

    <button type="submit">Mettre à jour</button>
</form>
</div>
</body>
</html>