<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Contrat Sponsor</title>
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
input, select{
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
</style>
</head>
<body>
<?php include '../menu_admin.php'; ?>

<?php

include '../config/db.php';
$sponsors = mysqli_query($conn, "SELECT id, nom FROM sponsors ORDER BY nom");
?>

<div class="container">
<h2>Ajouter Contrat Sponsor</h2>

<form action="cs_traitement.php" method="POST">


    <select name="sponsor_id">
        <option value="">Choisir un sponsor</option>
        <?php while ($s = mysqli_fetch_assoc($sponsors)): ?>
            <option value="<?= $s['id'] ?>">
                <?= htmlspecialchars($s['nom']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="number" name="montant" placeholder="Montant du contrat">
    <input type="date" name="date_debut">
    <input type="date" name="date_fin">

    <button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>