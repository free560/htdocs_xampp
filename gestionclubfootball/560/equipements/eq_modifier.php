<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Équipement</title>
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

$sqlEquip = mysqli_query($conn, "SELECT * FROM equipements WHERE id = '$id'");
$equip = mysqli_fetch_assoc($sqlEquip);

if (!$equip) {
    echo "Équipement introuvable.";
    exit();
}
?>

<div class="container">
<h2>Modifier un Équipement</h2>

<form action="eq_modifier_traitement.php" method="POST">

    <input type="hidden" name="id" value="<?= $equip['id'] ?>">

    <input type="text" name="nom" placeholder="Nom de l'équipement" value="<?= htmlspecialchars($equip['nom']) ?>">
    <input type="number" name="quantite" placeholder="Quantité" value="<?= htmlspecialchars($equip['quantite']) ?>">
    <input type="number" step="0.01" name="prix_unitaire" placeholder="Prix unitaire" value="<?= htmlspecialchars($equip['prix_unitaire']) ?>">
    <input type="date" name="date_achat" value="<?= htmlspecialchars($equip['date_achat']) ?>">

    <button type="submit">Mettre à jour</button>
</form>
</div>
</body>
</html>