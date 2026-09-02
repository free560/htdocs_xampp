<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Match</title>
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

$sqlMatch = mysqli_query($conn, "SELECT * FROM matchs WHERE id = '$id'");
$match = mysqli_fetch_assoc($sqlMatch);

if (!$match) {
    echo "Match introuvable.";
    exit();
}

$equipes = mysqli_query($conn, "SELECT id, nom_equipe FROM equipes ORDER BY nom_equipe");
$stades  = mysqli_query($conn, "SELECT id, nom_stade FROM stades ORDER BY nom_stade");
?>

<div class="container">
<h2>Modifier un Match</h2>

<form action="m_modifier_traitement.php" method="POST">

    <input type="hidden" name="id" value="<?= $match['id'] ?>">

    <select name="equipe_id">
        <option value="">Choisir notre équipe</option>
        <?php while ($eq = mysqli_fetch_assoc($equipes)): ?>
            <option value="<?= $eq['id'] ?>" <?= ($eq['id'] == $match['equipe_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($eq['nom_equipe']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <select name="stade_id">
        <option value="">Choisir un stade</option>
        <?php while ($s = mysqli_fetch_assoc($stades)): ?>
            <option value="<?= $s['id'] ?>" <?= ($s['id'] == $match['stade_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($s['nom_stade']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="text" name="adversaire" placeholder="Adversaire" value="<?= htmlspecialchars($match['adversaire']) ?>">
    <input type="text" name="competition" placeholder="Compétition" value="<?= htmlspecialchars($match['competition']) ?>">
    <input type="date" name="date_match" value="<?= htmlspecialchars($match['date_match']) ?>">

    <select name="type_match">
        <option value="">Type de match</option>
        <option value="Domicile" <?= ($match['type_match'] == 'Domicile') ? 'selected' : '' ?>>Domicile</option>
        <option value="Exterieur" <?= ($match['type_match'] == 'Exterieur') ? 'selected' : '' ?>>Extérieur</option>
    </select>

    <input type="number" name="score_equipe" placeholder="Score notre équipe" value="<?= htmlspecialchars($match['score_equipe']) ?>">
    <input type="number" name="score_adversaire" placeholder="Score adversaire" value="<?= htmlspecialchars($match['score_adversaire']) ?>">

    <select name="statut">
        <option value="">Statut</option>
        <option value="Programme" <?= ($match['statut'] == 'Programme') ? 'selected' : '' ?>>Programmé</option>
        <option value="Joue" <?= ($match['statut'] == 'Joue') ? 'selected' : '' ?>>Joué</option>
        <option value="Annule" <?= ($match['statut'] == 'Annule') ? 'selected' : '' ?>>Annulé</option>
    </select>

    <button type="submit">Mettre à jour</button>
</form>
</div>
</body>
</html>