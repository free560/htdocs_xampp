<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Blessure</title>
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


if (!isset($_GET['id'])) {
    echo "Aucun identifiant fourni.";
    exit();
}

$id = intval($_GET['id']);

$sqlBlessure = mysqli_query($conn, "SELECT * FROM blessures WHERE id = '$id'");
$blessure = mysqli_fetch_assoc($sqlBlessure);

if (!$blessure) {
    echo "Blessure introuvable.";
    exit();
}


$joueurs = mysqli_query($conn, "SELECT id, nom, prenom FROM joueurs ORDER BY nom");
?>

<div class="container">
<h2>Modifier une Blessure</h2>

<form action="bl_modifier_traitement.php" method="POST">


    <input type="hidden" name="id" value="<?= $blessure['id'] ?>">

    <select name="joueur_id">
        <option value="">Choisir un joueur</option>
        <?php while ($j = mysqli_fetch_assoc($joueurs)): ?>
            <option value="<?= $j['id'] ?>" <?= ($j['id'] == $blessure['joueur_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($j['nom'] . ' ' . $j['prenom']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="text" name="type_blessure" placeholder="Type de blessure"
           value="<?= htmlspecialchars($blessure['type_blessure']) ?>">

    <input type="date" name="date_blessure"
           value="<?= htmlspecialchars($blessure['date_blessure']) ?>">

    <input type="number" name="duree" placeholder="Durée estimée (jours)"
           value="<?= htmlspecialchars($blessure['duree_estimee']) ?>">

    <textarea name="commentaire" placeholder="Commentaire"><?= htmlspecialchars($blessure['commentaire']) ?></textarea>

    <button type="submit">Mettre à jour</button>
</form>
</div>
</body>
</html>