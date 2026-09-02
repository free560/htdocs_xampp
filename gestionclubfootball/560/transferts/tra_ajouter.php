<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Transfert</title>
<style>
body{
    font-family:Arial;
    background:whitesmoke;
}
.container{
    width:650px;
    margin:40px auto;
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

<?php

include '../config/db.php';
$joueurs = mysqli_query($conn, "SELECT id, nom, prenom FROM joueurs ORDER BY nom");
?>

<div class="container">
<h2>Ajouter un Transfert</h2>

<form action="tra_traitement.php" method="POST">


    <select name="joueur_id">
        <option value="">Choisir joueur</option>
        <?php while ($j = mysqli_fetch_assoc($joueurs)): ?>
            <option value="<?= $j['id'] ?>">
                <?= htmlspecialchars($j['nom'] . ' ' . $j['prenom']) ?>
            </option>
        <?php endwhile;?>
    </select>

    <input type="text" name="ancien_club" placeholder="Ancien club">
    <input type="text" name="nouveau_club" placeholder="Nouveau club">
    <input type="number" name="montant" placeholder="Montant du transfert">
    <input type="date" name="date_transfert">

    <button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>