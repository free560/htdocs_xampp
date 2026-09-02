<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier Joueur</title>
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

// Récupération de l'id depuis l'URL
$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: j_lister.php");
    exit();
}

// Récupération du joueur
$sql    = "SELECT * FROM joueurs WHERE id = $id";
$result = mysqli_query($conn, $sql);
$j      = mysqli_fetch_assoc($result);

if (!$j) {
    die("Joueur introuvable.");
}

// Chargement des équipes pour le select
$equipes = mysqli_query($conn, "SELECT id, nom_equipe FROM equipes ORDER BY nom_equipe");
?>
<?php include '../menu_admin.php'; ?>
<div class="container">
<h2>Modifier le Joueur</h2>

<?php if (!empty($j['photo'])): ?>
<div class="photo-actuelle">
    <p style="margin:0; font-size:13px; color:#777;">Photo actuelle</p>
    <img src="../uploads/<?= htmlspecialchars($j['photo']) ?>">
</div>
<?php endif; ?>

<form action="j_modifier_traitement.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $j['id'] ?>">
    <input type="hidden" name="photo_actuelle" value="<?= htmlspecialchars($j['photo']) ?>">

    <input type="text" name="nom" value="<?= htmlspecialchars($j['nom']) ?>" placeholder="Nom">
    <input type="text" name="prenom" value="<?= htmlspecialchars($j['prenom']) ?>" placeholder="Prénom">

    <select name="equipe_id">
        <option value="">Choisir une équipe</option>
        <?php
        // Reset du pointeur au cas où
        mysqli_data_seek($equipes, 0);
        while ($eq = mysqli_fetch_assoc($equipes)):
        ?>
        <option value="<?= $eq['id'] ?>" <?= ($eq['id'] == $j['equipe_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($eq['nom_equipe']) ?>
        </option>
        <?php endwhile; ?>
    </select>

    <select name="poste">
        <option value="">Poste</option>
        <?php
        $postes = ['Gardien', 'Défenseur', 'Milieu', 'Attaquant'];
        foreach ($postes as $p):
        ?>
        <option value="<?= $p ?>" <?= ($j['poste'] === $p) ? 'selected' : '' ?>><?= $p ?></option>
        <?php endforeach; ?>
    </select>

    <input type="number" name="numero_maillot" value="<?= htmlspecialchars($j['numero_maillot']) ?>" placeholder="N° Maillot">
    <input type="text" name="nationalite" value="<?= htmlspecialchars($j['nationalite']) ?>" placeholder="Nationalité">
    <input type="date" name="date_naissance" value="<?= htmlspecialchars($j['date_naissance']) ?>">

    <select name="sexe">
        <option value="M" <?= ($j['sexe'] === 'M') ? 'selected' : '' ?>>Masculin</option>
        <option value="F" <?= ($j['sexe'] === 'F') ? 'selected' : '' ?>>Féminin</option>
    </select>

    <input type="text" name="telephone" value="<?= htmlspecialchars($j['telephone']) ?>" placeholder="Téléphone">
    <input type="email" name="email" value="<?= htmlspecialchars($j['email']) ?>" placeholder="Email">
    <input type="number" step="0.1" name="taille" value="<?= htmlspecialchars($j['taille']) ?>" placeholder="Taille (cm)">
    <input type="number" step="0.1" name="poids" value="<?= htmlspecialchars($j['poids']) ?>" placeholder="Poids (kg)">
    <input type="text" name="adresse" value="<?= htmlspecialchars($j['adresse']) ?>" placeholder="Adresse">

    <select name="statut">
        <option value="actif"   <?= ($j['statut'] === 'actif')   ? 'selected' : '' ?>>Actif</option>
        <option value="inactif" <?= ($j['statut'] === 'inactif') ? 'selected' : '' ?>>Inactif</option>
    </select>

    <label style="margin-top:12px; display:block; font-size:13px; color:#555;">
        Changer la photo (laisser vide pour garder l'actuelle)
    </label>
    <input type="file" name="photo" accept="image/*">

    <button type="submit">Enregistrer les modifications</button>
</form>
</div>
</body>
</html>