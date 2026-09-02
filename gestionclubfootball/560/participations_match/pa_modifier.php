<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Participation Match</title>
<style>
body{
    font-family:Arial;
    background:whitesmoke;
}
.container{
    width:55%;
    margin:30px auto;
    background:white;
    padding:25px 30px;
    border-radius:6px;
}
h2{
    margin-bottom:20px;
}
label{
    display:block;
    margin-bottom:5px;
    font-weight:bold;
    font-size:14px;
}
select, input[type="number"]{
    width:100%;
    padding:9px 10px;
    margin-bottom:16px;
    border:1px solid whitw;
    border-radius:4px;
    font-size:14px;
    box-sizing:border-box;
    background:white;
}
.btn{
    padding:8px 18px;
    color:white;
    text-decoration:none;
    border-radius:5px;
    border:none;
    cursor:pointer;
    font-size:14px;
}
.modifier{ background:black; }
.annuler{ background:red; }
.form-actions{
    display:flex;
    gap:10px;
    margin-top:5px;
}
.alert-error{
    background:black;
    color:red;
    padding:10px 15px;
    border-radius:4px;
    margin-bottom:15px;
    font-size:14px;
}
</style>
</head>
<body>
<?php
include '../config/db.php';
include '../menu_admin.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: pa_lister.php');
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM participations_match WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$participation = $result->fetch_assoc();
$stmt->close();

if (!$participation) {
    header('Location: pa_lister.php');
    exit;
}


$matchs = $conn->query(
    "SELECT id, CONCAT(adversaire, ' - ', competition, ' (', DATE_FORMAT(date_match,'%d/%m/%Y'), ')') AS libelle
     FROM matchs ORDER BY date_match DESC"
);


$joueurs = $conn->query(
    "SELECT id, CONCAT(prenom, ' ', nom, ' - N°', numero_maillot) AS libelle
     FROM joueurs ORDER BY nom ASC"
);
?>
<div class="container">
    <h2>Modifier Participation</h2>

    <?php if (isset($_GET['erreur'])): ?>
        <div class="alert-error">Veuillez remplir tous les champs correctement.</div>
    <?php endif; ?>

    <form action="pa_modifier_traitement.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $participation['id']; ?>">

        <label for="match_id">Match</label>
        <select name="match_id" id="match_id" required>
            <option value="">-- Sélectionner un match --</option>
            <?php while ($m = $matchs->fetch_assoc()): ?>
                <option value="<?php echo $m['id']; ?>"
                    <?php echo ($m['id'] == $participation['match_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($m['libelle']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="joueur_id">Joueur</label>
        <select name="joueur_id" id="joueur_id" required>
            <option value="">-- Sélectionner un joueur --</option>
            <?php while ($j = $joueurs->fetch_assoc()): ?>
                <option value="<?php echo $j['id']; ?>"
                    <?php echo ($j['id'] == $participation['joueur_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($j['libelle']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="titulaire">Titulaire</label>
        <select name="titulaire" id="titulaire" required>
            <option value="1" <?php echo ($participation['titulaire'] == 1) ? 'selected' : ''; ?>>Oui</option>
            <option value="0" <?php echo ($participation['titulaire'] == 0) ? 'selected' : ''; ?>>Non</option>
        </select>

        <label for="minutes_jouees">Minutes Jouées</label>
        <input type="number" name="minutes_jouees" id="minutes_jouees"
               min="0" max="120"
               value="<?php echo htmlspecialchars($participation['minutes_jouees']); ?>"
               required>

        <div class="form-actions">
            <button type="submit" class="btn modifier">Enregistrer</button>
            <a href="pa_lister.php" class="btn annuler">Annuler</a>
        </div>
    </form>
</div>
</body>
</html>