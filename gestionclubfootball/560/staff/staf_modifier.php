<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Staff</title>
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
    box-shadow:0px 0px 10px whitesmoke;
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
.photo-actuelle{
    margin-top:10px;
    text-align:center;
}
.photo-actuelle img{
    width:80px;
    height:80px;
    border-radius:50%;
    object-fit:cover;
}
</style>
</head>
<body>
<?php
include '../config/db.php';

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: staff_lister.php");
    exit();
}

$sql    = "SELECT * FROM staff WHERE id = $id";
$result = mysqli_query($conn, $sql);
$s      = mysqli_fetch_assoc($result);

if (!$s) {
    die("Membre du staff introuvable.");
}

$equipes = mysqli_query($conn, "SELECT id, nom_equipe FROM equipes ORDER BY nom_equipe");
?>
<?php include '../menu_admin.php'; ?>
<div class="container">
<h2>Modifier le Membre du Staff</h2>

<?php if (!empty($s['photo'])): ?>
<div class="photo-actuelle">
    <p style="margin:0; font-size:13px; color:#777;">Photo actuelle</p>
    <img src="../uploads/<?= htmlspecialchars($s['photo']) ?>">
</div>
<?php endif; ?>

<form action="staf_modifier_traitement.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $s['id'] ?>">
    <input type="hidden" name="photo_actuelle" value="<?= htmlspecialchars($s['photo']) ?>">

    <select name="equipe_id">
        <option value="">Choisir une équipe</option>
        <?php
        mysqli_data_seek($equipes, 0);
        while ($eq = mysqli_fetch_assoc($equipes)):
        ?>
        <option value="<?= $eq['id'] ?>" <?= ($eq['id'] == $s['equipe_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($eq['nom_equipe']) ?>
        </option>
        <?php endwhile; ?>
    </select>

    <input type="text" name="nom" value="<?= htmlspecialchars($s['nom']) ?>" placeholder="Nom">
    <input type="text" name="prenom" value="<?= htmlspecialchars($s['prenom']) ?>" placeholder="Prénom">

    <select name="fonction">
        <option value="">Fonction</option>
        <?php
        $fonctions = [
            'Entraineur'             => 'Entraîneur',
            'Manager'                => 'Manager',
            'Medecin'                => 'Médecin',
            'Comptable'              => 'Comptable',
            'Secretaire'             => 'Secrétaire',
            'Preparateur Physique'   => 'Préparateur Physique',
        ];
        foreach ($fonctions as $valeur => $libelle):
        ?>
        <option value="<?= $valeur ?>" <?= ($s['fonction'] === $valeur) ? 'selected' : '' ?>><?= $libelle ?></option>
        <?php endforeach; ?>
    </select>

    <input type="text" name="telephone" value="<?= htmlspecialchars($s['telephone']) ?>" placeholder="Téléphone">
    <input type="email" name="email" value="<?= htmlspecialchars($s['email']) ?>" placeholder="Email">
    <input type="number" name="salaire" value="<?= htmlspecialchars($s['salaire']) ?>" placeholder="Salaire">
    <input type="date" name="date_embauche" value="<?= htmlspecialchars($s['date_embauche']) ?>">

    <label style="margin-top:12px; display:block; font-size:13px; color:#555;">
        Changer la photo (laisser vide pour garder l'actuelle)
    </label>
    <input type="file" name="photo" accept="image/*">

    <button type="submit">Enregistrer les modifications</button>
</form>
</div>
</body>
</html>