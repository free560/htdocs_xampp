<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Statistique</title>
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
    header("Location: stati_j_lister.php");
    exit();
}

$sql    = "SELECT * FROM statistiques_joueurs WHERE id = $id";
$result = mysqli_query($conn, $sql);
$s      = mysqli_fetch_assoc($result);

if (!$s) {
    die("Statistique introuvable.");
}

$joueurs = mysqli_query($conn, "SELECT id, nom, prenom FROM joueurs ORDER BY nom");

// Liste des matchs avec équipe + adversaire + date pour un affichage lisible
$matchs = mysqli_query($conn, "
    SELECT m.id, m.adversaire, m.date_match, e.nom_equipe
    FROM matchs m
    LEFT JOIN equipes e ON m.equipe_id = e.id
    ORDER BY m.date_match DESC
");
?>
<?php include '../menu_admin.php'; ?>
<div class="container">
<h2>Modifier la Statistique</h2>

<form action="stati_j_modifier_traitement.php" method="POST">
    <input type="hidden" name="id" value="<?= $s['id'] ?>">

    <select name="joueur_id">
        <option value="">Choisir un joueur</option>
        <?php while ($j = mysqli_fetch_assoc($joueurs)): ?>
        <option value="<?= $j['id'] ?>" <?= ($j['id'] == $s['joueur_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($j['nom'] . ' ' . $j['prenom']) ?>
        </option>
        <?php endwhile; ?>
    </select>

    <select name="match_id">
        <option value="">Choisir un match</option>
        <?php while ($m = mysqli_fetch_assoc($matchs)): ?>
        <option value="<?= $m['id'] ?>" <?= ($m['id'] == $s['match_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars(($m['nom_equipe'] ?? '?') . ' vs ' . $m['adversaire']) ?>
            (<?= htmlspecialchars($m['date_match']) ?>)
        </option>
        <?php endwhile; ?>
    </select>

    <input type="number" name="buts" value="<?= htmlspecialchars($s['buts']) ?>" placeholder="Buts">
    <input type="number" name="passes_decisives" value="<?= htmlspecialchars($s['passes_decisives']) ?>" placeholder="Passes décisives">
    <input type="number" name="cartons_jaunes" value="<?= htmlspecialchars($s['cartons_jaunes']) ?>" placeholder="Cartons jaunes">
    <input type="number" name="cartons_rouges" value="<?= htmlspecialchars($s['cartons_rouges']) ?>" placeholder="Cartons rouges">
    <input type="number" step="0.1" name="note" value="<?= htmlspecialchars($s['note']) ?>" placeholder="Note (ex: 7.5)">

    <button type="submit">Enregistrer les modifications</button>
</form>
</div>
</body>
</html>