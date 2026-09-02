<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Transfert</title>
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
h2{ text-align:center; }
</style>
</head>
<body>
<?php
include '../config/db.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: tra_lister.php");
    exit();
}

$sql    = "SELECT * FROM transferts WHERE id = $id";
$result = mysqli_query($conn, $sql);
$t      = mysqli_fetch_assoc($result);

if (!$t) {
    die("Transfert introuvable.");
}

$joueurs = mysqli_query($conn, "SELECT id, nom, prenom FROM joueurs ORDER BY nom");
?>
<?php include '../menu_admin.php'; ?>
<div class="container">
<h2>Modifier le Transfert</h2>

<form action="tra_modifier_traitement.php" method="POST">
    <input type="hidden" name="id" value="<?= $t['id'] ?>">

    <select name="joueur_id">
        <option value="">Choisir un joueur</option>
        <?php while ($j = mysqli_fetch_assoc($joueurs)): ?>
        <option value="<?= $j['id'] ?>" <?= ($j['id'] == $t['joueur_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($j['nom'] . ' ' . $j['prenom']) ?>
        </option>
        <?php endwhile; ?>
    </select>

    <input type="text" name="ancien_club" value="<?= htmlspecialchars($t['ancien_club']) ?>" placeholder="Ancien club">
    <input type="text" name="nouveau_club" value="<?= htmlspecialchars($t['nouveau_club']) ?>" placeholder="Nouveau club">
    <input type="number" step="0.01" name="montant" value="<?= htmlspecialchars($t['montant']) ?>" placeholder="Montant (FBu)">
    <input type="date" name="date_transfert" value="<?= htmlspecialchars($t['date_transfert']) ?>">

    <button type="submit">Enregistrer les modifications</button>
</form>
</div>
</body>
</html>