<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Stade</title>
<style>
body{
    font-family:Arial;
    background:whitesmoke;
}
.container{
    width:600px;
    margin:40px auto;
    background:white;
    padding:25px;
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
    padding:12px;
    margin-top:15px;
    background:black;
    color:white;
    border:none;
    cursor:pointer;
}
h2{ text-align:center; }
</style>
</head>
<body>
<?php
include '../config/db.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: sta_lister.php");
    exit();
}

$sql    = "SELECT * FROM stades WHERE id = $id";
$result = mysqli_query($conn, $sql);
$s      = mysqli_fetch_assoc($result);

if (!$s) {
    die("Stade introuvable.");
}
?>
<?php include '../menu_admin.php'; ?>
<div class="container">
<h2>Modifier le Stade</h2>

<form action="sta_modifier_traitement.php" method="POST">
    <input type="hidden" name="id" value="<?= $s['id'] ?>">

    <input type="text" name="nom_stade" value="<?= htmlspecialchars($s['nom_stade']) ?>" placeholder="Nom du stade">
    <input type="text" name="adresse" value="<?= htmlspecialchars($s['adresse']) ?>" placeholder="Adresse">
    <input type="number" name="capacite" value="<?= htmlspecialchars($s['capacite']) ?>" placeholder="Capacité">

    <button type="submit">Enregistrer les modifications</button>
</form>
</div>
</body>
</html>