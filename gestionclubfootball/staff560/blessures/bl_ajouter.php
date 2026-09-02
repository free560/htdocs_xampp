<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Blessure</title>
<style>
body{
    font-family: Arial;
    background:whitesmoke;
}
.container{
    width:400px;
    margin:60px auto;
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 8px whitesmoke;
}
input, textarea, select{
    width:100%;
    padding:10px;
    margin-top:10px;
}
button{
    width:100%;
    padding:10px;
    margin-top:10px;
    background:black;
    color:white;
    border:none;
    cursor:pointer;
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
<h2>Ajouter une Blessure</h2>

<form action="bl_traitement.php" method="POST">

    <select name="joueur_id">
        <option value="">Choisir un joueur</option>
        <?php while ($j = mysqli_fetch_assoc($joueurs)): ?>
            <option value="<?= $j['id'] ?>">
                <?= htmlspecialchars($j['nom'] . ' ' . $j['prenom']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="text" name="type_blessure" placeholder="Type de blessure">
    <input type="date" name="date_blessure">
    <input type="number" name="duree" placeholder="Durée estimée (jours)">
    <textarea name="commentaire" placeholder="Commentaire"></textarea>

    <button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>