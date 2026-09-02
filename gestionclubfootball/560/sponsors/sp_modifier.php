<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Sponsor</title>
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
    header("Location: sp_lister.php");
    exit();
}

$sql    = "SELECT * FROM sponsors WHERE id = $id";
$result = mysqli_query($conn, $sql);
$s      = mysqli_fetch_assoc($result);

if (!$s) {
    die("Sponsor introuvable.");
}
?>
<?php include '../menu_admin.php'; ?>
<div class="container">
<h2>Modifier le Sponsor</h2>

<form action="sp_modifier_traitement.php" method="POST">
    <input type="hidden" name="id" value="<?= $s['id'] ?>">

    <input type="text" name="nom" value="<?= htmlspecialchars($s['nom']) ?>" placeholder="Nom du sponsor">
    <input type="text" name="contact" value="<?= htmlspecialchars($s['contact']) ?>" placeholder="Personne de contact">
    <input type="text" name="telephone" value="<?= htmlspecialchars($s['telephone']) ?>" placeholder="Téléphone">
    <input type="email" name="email" value="<?= htmlspecialchars($s['email']) ?>" placeholder="Email">

    <button type="submit">Enregistrer les modifications</button>
</form>
</div>
</body>
</html>