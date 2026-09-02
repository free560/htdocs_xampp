<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste Staff</title>
<style>
body{
    font-family:Arial;
    background: whitesmoke;
}
.container{
    width:98%;
    margin:20px auto;
}
h2{
    text-align:center;
}
table{
    width:100%;
    border-collapse:collapse;
    background:white;
}
th{
    background:black;
    color:white;
    padding:12px;
}
td{
    padding:10px;
    border-bottom:1px solid whitesmoke;
}
tr:hover td{
    background:#fafafa;
}
.btn{
    text-decoration:none;
    color:white;
    padding:6px 12px;
    border-radius:5px;
    font-size:0.9em;
}
.modifier{
    background: black;
}
.bloquer{
    background:#c0392b;
}
.debloquer{
    background:#27ae60;
}
.photo-staff{
    width:50px;
    height:50px;
    border-radius:50%;
    object-fit:cover;
}
.badge{
    padding:4px 10px;
    border-radius:20px;
    font-size:0.85em;
    color:white;
    display:inline-block;
}
.badge-actif{ background:#27ae60; }
.badge-compte-bloque{ background:#7f8c8d; }
.empty-row{
    text-align:center;
    padding:30px;
    color:#888;
}
.ajout {
    display: flex;
    justify-content: flex-end;
    padding: 10px;
}
.ajout a {
    background: black;
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    border-radius: 5px;
}
.retour{
    padding:10px;
}
</style>
</head>
<body>
<?php include '../menu_admin.php'; ?>

<?php
include '../config/db.php';
$staff = mysqli_query($conn, "
    SELECT s.*, e.nom_equipe, u.id AS utilisateur_id, u.actif AS compte_actif
    FROM staff s
    LEFT JOIN equipes e ON s.equipe_id = e.id
    LEFT JOIN utilisateurs u ON u.staff_id = s.id
    ORDER BY s.nom
");
?>

<div class="container">
<h2>Liste du Staff</h2>
<table>
<tr>
    <th>Photo</th>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Fonction</th>
    <th>Équipe</th>
    <th>Téléphone</th>
    <th>Salaire</th>
    <th>Date d'embauche</th>
    <th>Compte</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($staff) > 0): ?>
    <?php while ($s = mysqli_fetch_assoc($staff)): ?>
        <?php
            $photo = !empty($s['photo']) ? $s['photo'] : 'default.png';

            $compte_actif = $s['compte_actif'];
            if ($s['utilisateur_id'] === null) {
                $badgeCompte = '<span class="badge badge-compte-bloque">Aucun compte</span>';
                $boutonCompte = '';
            } elseif ($compte_actif == 1) {
                $badgeCompte = '<span class="badge badge-actif">Actif</span>';
                $boutonCompte = '<a href="staf_bloquer.php?id=' . $s['id'] . '" class="btn bloquer"
                                   onclick="return confirm(\'Bloquer le compte de ce membre du staff ?\');">Bloquer</a>';
            } else {
                $badgeCompte = '<span class="badge badge-compte-bloque">Bloqué</span>';
                $boutonCompte = '<a href="staf_debloquer.php?id=' . $s['id'] . '" class="btn debloquer"
                                   onclick="return confirm(\'Débloquer le compte de ce membre du staff ?\');">Débloquer</a>';
            }
        ?>
        <tr>
            <td>
                <img src="../uploads/<?= htmlspecialchars($photo) ?>" class="photo-staff" alt="Photo">
            </td>
            <td><?= htmlspecialchars($s['nom']) ?></td>
            <td><?= htmlspecialchars($s['prenom']) ?></td>
            <td><?= htmlspecialchars($s['fonction']) ?></td>
            <td><?= htmlspecialchars($s['nom_equipe'] ?? 'Non assignée') ?></td>
            <td><?= htmlspecialchars($s['telephone']) ?></td>
            <td><?= htmlspecialchars(number_format($s['salaire'], 0, ',', ' ')) ?> FBu</td>
            <td><?= htmlspecialchars($s['date_embauche']) ?></td>
            <td><?= $badgeCompte ?></td>
            <td>
                <a href="staf_modifier.php?id=<?= $s['id'] ?>" class="btn modifier">Modifier</a>
                <?= $boutonCompte ?>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="10" class="empty-row">Aucun membre du staff enregistré pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
</div>
</body>
</html>