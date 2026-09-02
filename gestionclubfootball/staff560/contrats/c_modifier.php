<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Contrat</title>
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


$sqlContrat = mysqli_query($conn, "SELECT * FROM contrats WHERE id = '$id'");
$contrat = mysqli_fetch_assoc($sqlContrat);

if (!$contrat) {
    echo "Contrat introuvable.";
    exit();
}

$joueurs = mysqli_query($conn, "SELECT id, nom, prenom FROM joueurs ORDER BY nom");
?>

<div class="container">
<h2>Modifier un Contrat</h2>

<form action="c_modifier_traitement.php" method="POST">

    <input type="hidden" name="id" value="<?= $contrat['id'] ?>">

    <select name="joueur_id">
        <option value="">Choisir un joueur</option>
        <?php while ($j = mysqli_fetch_assoc($joueurs)): ?>
            <option value="<?= $j['id'] ?>" <?= ($j['id'] == $contrat['joueur_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($j['nom'] . ' ' . $j['prenom']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="date" name="date_debut" value="<?= htmlspecialchars($contrat['date_debut']) ?>">
    <input type="date" name="date_fin" value="<?= htmlspecialchars($contrat['date_fin']) ?>">
    <input type="number" name="salaire" placeholder="Salaire" value="<?= htmlspecialchars($contrat['salaire']) ?>">
    <input type="number" name="prime_match" placeholder="Prime par match" value="<?= htmlspecialchars($contrat['prime_match']) ?>">

    <button type="submit">Mettre à jour</button>
</form>
</div>
</body>
</html>