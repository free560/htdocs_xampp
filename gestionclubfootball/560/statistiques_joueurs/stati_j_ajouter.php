<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ajouter Statistiques</title>
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


$matchs = mysqli_query($conn, "
    SELECT m.id, e.nom_equipe, m.adversaire, m.date_match
    FROM matchs m
    JOIN equipes e ON m.equipe_id = e.id
    ORDER BY m.date_match DESC
");
?>

<div class="container">
<h2>Ajouter Statistiques Joueur</h2>

<form action="stati_j_traitement.php" method="POST">

    <select name="joueur_id">
        <option value="">Choisir joueur</option>
        <?php while ($j = mysqli_fetch_assoc($joueurs)): ?>
            <option value="<?= $j['id'] ?>">
                <?= htmlspecialchars($j['nom'] . ' ' . $j['prenom']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <select name="match_id">
        <option value="">Choisir match</option>
        <?php while ($m = mysqli_fetch_assoc($matchs)): ?>
            <option value="<?= $m['id'] ?>">
                <?= htmlspecialchars($m['nom_equipe'] . ' vs ' . $m['adversaire']) ?>
                (<?= htmlspecialchars($m['date_match']) ?>)
            </option>
        <?php endwhile; ?>
    </select>

    <input type="number" name="buts" placeholder="Buts">
    <input type="number" name="passes_decisives" placeholder="Passes décisives">
    <input type="number" name="cartons_jaunes" placeholder="Cartons jaunes">
    <input type="number" name="cartons_rouges" placeholder="Cartons rouges">
    <input type="number" name="note" step="0.1" placeholder="Note">

    <button type="submit">Enregistrer</button>
</form>
</div>
</body>
</html>