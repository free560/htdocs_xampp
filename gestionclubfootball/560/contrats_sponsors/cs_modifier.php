<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Contrat Sponsor</title>
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

if (!isset($_GET['id'])) {
    echo "Aucun identifiant fourni.";
    exit();
}

$id = intval($_GET['id']);

$sqlContrat = mysqli_query($conn, "SELECT * FROM contrats_sponsors WHERE id = '$id'");
$contrat = mysqli_fetch_assoc($sqlContrat);

if (!$contrat) {
    echo "Contrat introuvable.";
    exit();
}

$sponsors = mysqli_query($conn, "SELECT id, nom FROM sponsors ORDER BY nom");
?>

<div class="container">
<h2>Modifier un Contrat Sponsor</h2>

<form action="cs_modifier_traitement.php" method="POST">

    <input type="hidden" name="id" value="<?= $contrat['id'] ?>">

    <select name="sponsor_id">
        <option value="">Choisir un sponsor</option>
        <?php while ($s = mysqli_fetch_assoc($sponsors)): ?>
            <option value="<?= $s['id'] ?>" <?= ($s['id'] == $contrat['sponsor_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($s['nom']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="number" name="montant" placeholder="Montant du contrat" value="<?= htmlspecialchars($contrat['montant']) ?>">
    <input type="date" name="date_debut" value="<?= htmlspecialchars($contrat['date_debut']) ?>">
    <input type="date" name="date_fin" value="<?= htmlspecialchars($contrat['date_fin']) ?>">

    <button type="submit">Mettre à jour</button>
</form>
</div>
</body>
</html>