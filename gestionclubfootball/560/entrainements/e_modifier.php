<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Entraînement</title>
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
input, select, textarea{
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

$sqlEntrainement = mysqli_query($conn, "SELECT * FROM entrainements WHERE id = '$id'");
$entrainement = mysqli_fetch_assoc($sqlEntrainement);

if (!$entrainement) {
    echo "Entraînement introuvable.";
    exit();
}

$equipes = mysqli_query($conn, "SELECT id, nom_equipe FROM equipes ORDER BY nom_equipe");
?>

<div class="container">
<h2>Modifier un Entraînement</h2>

<form action="e_modifier_traitement.php" method="POST">

    <input type="hidden" name="id" value="<?= $entrainement['id'] ?>">

    <select name="equipe_id">
        <option value="">Choisir une équipe</option>
        <?php while ($eq = mysqli_fetch_assoc($equipes)): ?>
            <option value="<?= $eq['id'] ?>" <?= ($eq['id'] == $entrainement['equipe_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($eq['nom_equipe']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="date" name="date_entrainement" value="<?= htmlspecialchars($entrainement['date_entrainement']) ?>">
    <input type="text" name="lieu" placeholder="Lieu" value="<?= htmlspecialchars($entrainement['lieu']) ?>">
    <textarea name="description" placeholder="Description"><?= htmlspecialchars($entrainement['description']) ?></textarea>

    <button type="submit">Mettre à jour</button>
</form>
</div>
</body>
</html>