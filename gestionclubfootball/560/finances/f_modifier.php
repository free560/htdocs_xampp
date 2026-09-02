<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Opération Financière</title>
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

$sqlFinance = mysqli_query($conn, "SELECT * FROM finances WHERE id = '$id'");
$finance = mysqli_fetch_assoc($sqlFinance);

if (!$finance) {
    echo "Opération introuvable.";
    exit();
}
?>

<div class="container">
<h2>Modifier une Opération Financière</h2>

<form action="f_modifier_traitement.php" method="POST">

    <input type="hidden" name="id" value="<?= $finance['id'] ?>">

    <input type="date" name="date_operation" value="<?= htmlspecialchars($finance['date_operation']) ?>">

    <select name="type_operation">
        <option value="">Type d'opération</option>
        <option value="Recette" <?= ($finance['type_operation'] == 'Recette') ? 'selected' : '' ?>>Recette</option>
        <option value="Depense" <?= ($finance['type_operation'] == 'Depense') ? 'selected' : '' ?>>Dépense</option>
    </select>

    <input type="text" name="categorie" placeholder="Catégorie" value="<?= htmlspecialchars($finance['categorie']) ?>">
    <input type="number" step="0.01" name="montant" placeholder="Montant" value="<?= htmlspecialchars($finance['montant']) ?>">
    <textarea name="description" placeholder="Description"><?= htmlspecialchars($finance['description']) ?></textarea>

    <button type="submit">Mettre à jour</button>
</form>
</div>
</body>
</html>