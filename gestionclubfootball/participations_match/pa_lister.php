<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste Participation Match</title>
<style>
body{
    font-family:Arial;
    background:whitesmoke;
}
.container{
    width:98%;
    margin:20px auto;
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
    text-align:center;
}
.btn{
    padding:6px 12px;
    color:white;
    text-decoration:none;
    border-radius:5px;
}
.modifier{ background:black; }
.supprimer{ background:#c0392b; }
.badge{
    padding:4px 10px;
    border-radius:12px;
    font-size:12px;
    font-weight:bold;
    color:white;
}
.badge-oui{ background:#27ae60; }
.badge-non{ background:#e74c3c; }
.alert-success{
    background:#d4edda;
    color:#155724;
    padding:10px 15px;
    border-radius:4px;
    margin-bottom:15px;
    font-size:14px;
}
.alert-error{
    background:#fdecea;
    color:#c0392b;
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
include '../menu.php';

$sql = "SELECT pm.id, pm.titulaire, pm.minutes_jouees,
               CONCAT(j.prenom, ' ', j.nom) AS joueur,
               j.poste, j.numero_maillot,
               CONCAT(m.adversaire, ' - ', m.competition) AS match_info,
               m.date_match
        FROM participations_match pm
        JOIN joueurs j ON pm.joueur_id = j.id
        JOIN matchs m ON pm.match_id = m.id
        ORDER BY m.date_match DESC, j.nom ASC";

$result = $conn->query($sql);
?>
<div class="container">
    <h2>Participation Match</h2>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert-success">Participation modifiée avec succès.</div>
    <?php elseif (isset($_GET['success']) && $_GET['success'] == 'suppression'): ?>
        <div class="alert-success">Participation supprimée avec succès.</div>
    <?php elseif (isset($_GET['erreur'])): ?>
        <div class="alert-error">Une erreur est survenue. Veuillez réessayer.</div>
    <?php endif; ?>

    <table>
        <tr>
            <th>Match</th>
            <th>Date</th>
            <th>Joueur</th>
            <th>Poste</th>
            <th>N° Maillot</th>
            <th>Titulaire</th>
            <th>Minutes Jouées</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['match_info']); ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['date_match'])); ?></td>
                <td><?php echo htmlspecialchars($row['joueur']); ?></td>
                <td><?php echo htmlspecialchars($row['poste']); ?></td>
                <td><?php echo htmlspecialchars($row['numero_maillot']); ?></td>
                <td>
                    <?php if ($row['titulaire'] == 1): ?>
                        <span class="badge badge-oui">Oui</span>
                    <?php else: ?>
                        <span class="badge badge-non">Non</span>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($row['minutes_jouees']); ?> min</td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" style="text-align:center; color:#999; padding:20px;">
                    Aucune participation enregistrée.
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>