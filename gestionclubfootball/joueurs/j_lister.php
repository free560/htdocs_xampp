<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste des Joueurs</title>
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
.actif{
    color:green;
    font-weight:bold;
}
.badge{
    padding:4px 10px;
    border-radius:20px;
    font-size:0.85em;
    color:white;
    display:inline-block;
}
.badge-actif{ background:#27ae60; }
.badge-blesse{ background:#c0392b; }
.badge-suspendu{ background:#e67e22; }
.badge-libre{ background:#888; }
.badge-compte-bloque{ background:#7f8c8d; }
.photo-joueur{
    width:50px;
    height:50px;
    border-radius:50%;
    object-fit:cover;
}
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
</style>
</head>
<body>
<?php include '../menu.php'; ?>

<?php
include '../config/db.php';

// ✅ Jointure inversée : on part de joueurs, et on cherche le compte via utilisateurs.joueur_id
$joueurs = mysqli_query($conn, "
    SELECT j.*, e.nom_equipe, u.id AS utilisateur_id, u.actif AS compte_actif
    FROM joueurs j
    LEFT JOIN equipes e ON j.equipe_id = e.id
    LEFT JOIN utilisateurs u ON u.joueur_id = j.id
    ORDER BY j.nom
");
?>

<div class="container">
<h2>Liste des Joueurs</h2>
<table>
<tr>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Photo</th>
    <th>Équipe</th>
    <th>Poste</th>
    <th>N°</th>
    <th>Téléphone</th>
    <th>Statut</th>
</tr>

<?php if (mysqli_num_rows($joueurs) > 0): ?>
    <?php while ($j = mysqli_fetch_assoc($joueurs)): ?>
        <?php
            switch ($j['statut']) {
                case 'Actif':
                    $badge = '<span class="badge badge-actif">Actif</span>';
                    break;
                case 'Blesse':
                    $badge = '<span class="badge badge-blesse">Blessé</span>';
                    break;
                case 'Suspendu':
                    $badge = '<span class="badge badge-suspendu">Suspendu</span>';
                    break;
                case 'Libre':
                    $badge = '<span class="badge badge-libre">Libre</span>';
                    break;
                default:
                    $badge = htmlspecialchars($j['statut']);
            }

            $photo = !empty($j['photo']) ? $j['photo'] : 'default.png';

            $compte_actif = $j['compte_actif'];
            if ($j['utilisateur_id'] === null) {
                $badgeCompte = '<span class="badge badge-compte-bloque">Aucun compte</span>';
                $boutonCompte = '';
            } elseif ($compte_actif == 1) {
                $badgeCompte = '<span class="badge badge-actif">Actif</span>';
                $boutonCompte = '<a href="j_bloquer.php?id=' . $j['id'] . '" class="btn bloquer"
                                   onclick="return confirm(\'Bloquer le compte de ce joueur ?\');">Bloquer</a>';
            } else {
                $badgeCompte = '<span class="badge badge-compte-bloque">Bloqué</span>';
                $boutonCompte = '<a href="j_debloquer.php?id=' . $j['id'] . '" class="btn debloquer"
                                   onclick="return confirm(\'Débloquer le compte de ce joueur ?\');">Débloquer</a>';
            }
        ?>
        <tr>
            <td><?= htmlspecialchars($j['nom']) ?></td>
            <td><?= htmlspecialchars($j['prenom']) ?></td>
            <td>
                <img src="../uploads/<?= htmlspecialchars($photo) ?>" class="photo-joueur" alt="Photo">
            </td>
            <td><?= htmlspecialchars($j['nom_equipe'] ?? 'Non assignée') ?></td>
            <td><?= htmlspecialchars($j['poste']) ?></td>
            <td><?= htmlspecialchars($j['numero_maillot']) ?></td>
            <td><?= htmlspecialchars($j['telephone']) ?></td>
            <td><?= $badge ?></td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="10" class="empty-row">Aucun joueur enregistré pour le moment.</td>
    </tr>
<?php endif; ?>

</table>
</div>
</body>
</html>