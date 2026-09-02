<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: /gestionclubfootball/index.php");
    exit;
}

// Marquer comme lu
if (isset($_GET['marquer']) && is_numeric($_GET['marquer'])) {
    $stmt = $conn->prepare("UPDATE contact_messages SET statut='lu' WHERE id=?");
    $stmt->bind_param("i", $_GET['marquer']);
    $stmt->execute();
    $stmt->close();
    header("Location: contact_lister.php");
    exit;
}

// Supprimer
if (isset($_GET['supprimer']) && is_numeric($_GET['supprimer'])) {
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id=?");
    $stmt->bind_param("i", $_GET['supprimer']);
    $stmt->execute();
    $stmt->close();
    header("Location: contact_lister.php");
    exit;
}

// Filtre
$filtre = isset($_GET['filtre']) && in_array($_GET['filtre'], ['legere','moyenne','grave'])
          ? $_GET['filtre'] : 'tous';

if ($filtre !== 'tous') {
    $stmt = $conn->prepare(
        "SELECT * FROM contact_messages WHERE priorite=?
         ORDER BY FIELD(priorite,'grave','moyenne','legere'), created_at DESC"
    );
    $stmt->bind_param("s", $filtre);
} else {
    $stmt = $conn->prepare(
        "SELECT * FROM contact_messages
         ORDER BY FIELD(priorite,'grave','moyenne','legere'), created_at DESC"
    );
}
$stmt->execute();
$messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$total   = $conn->query("SELECT COUNT(*) as nb FROM contact_messages")->fetch_assoc()['nb'];
$non_lus = $conn->query("SELECT COUNT(*) as nb FROM contact_messages WHERE statut='non_lu'")->fetch_assoc()['nb'];
$graves  = $conn->query("SELECT COUNT(*) as nb FROM contact_messages WHERE priorite='grave' AND statut='non_lu'")->fetch_assoc()['nb'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Messages de Contact</title>
    <style>
        body {
            font-family: Arial;
            background: whitesmoke;
        }
        .container {
            width: 90%;
            margin: 40px auto;
        }
        h2 { margin-bottom: 16px; }

        /* Alerte urgence */
        .alerte-grave {
            background: #fde8e8;
            border-left: 4px solid red;
            padding: 10px 16px;
            border-radius: 5px;
            color: red;
            font-weight: bold;
            margin-bottom: 16px;
        }

        /* Stats */
        .stats {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .stat {
            background: white;
            padding: 12px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 8px whitesmoke;
            text-align: center;
            min-width: 90px;
        }
        .stat span { font-size: 22px; font-weight: bold; display: block; color: black; }
        .stat small { font-size: 12px; color: #666; }

        /* Filtres */
        .filtres {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        .filtres a {
            padding: 5px 14px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 13px;
            border: 1px solid #ccc;
            color: #333;
            background: white;
        }
        .filtres a.active { background: black; color: white; border-color: black; }

        /* Table — style ton projet */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px whitesmoke;
        }
        th {
            background: black;
            color: white;
            padding: 10px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid whitesmoke;
            font-size: 13px;
        }
        tr.non-lu td { background: #fffde7; }

        /* Badges — exactement comme ton projet */
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.85em;
            color: white;
            display: inline-block;
        }
        .badge-grave   { background: red; }
        .badge-moyenne { background: gray; }
        .badge-legere  { background: green; }
        .badge-non_lu  { background: #e67e00; }
        .badge-lu      { background: #888; }

        /* Boutons — style ton projet */
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-size: 12px;
            display: inline-block;
            margin-right: 4px;
        }
        .edit   { background: black; }
        .delete { background: red; }
        .reply  { background: green; }

        .msg-preview {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .empty-row {
            text-align: center;
            padding: 30px;
            color: #999;
        }

        /* Bouton ajouter — style ton projet */
        .add-link {
            display: inline-block;
            margin-bottom: 15px;
            padding: 10px 20px;
            background: black;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php include 'menu_admin.php'; ?>

<div class="container">
    <h2>Messages de Contact</h2>

    <?php if ($graves > 0): ?>
    <div class="alerte-grave">
        <?= $graves ?> message(s) GRAVE(S) non lu(s) nécessitent votre attention !
    </div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="stats">
        <div class="stat"><span><?= $total ?></span><small>Total</small></div>
        <div class="stat"><span><?= $non_lus ?></span><small>Non lus</small></div>
        <div class="stat"><span><?= $graves ?></span><small>Graves</small></div>
    </div>

    <!-- Filtres -->
    <div class="filtres">
        <a href="contact_lister.php" class="<?= $filtre==='tous'    ? 'active':'' ?>">Tous</a>
        <a href="?filtre=grave"   class="<?= $filtre==='grave'   ? 'active':'' ?>">🔴 Grave</a>
        <a href="?filtre=moyenne" class="<?= $filtre==='moyenne' ? 'active':'' ?>">🟠 Moyenne</a>
        <a href="?filtre=legere"  class="<?= $filtre==='legere'  ? 'active':'' ?>">🟢 Légère</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Sujet</th>
                <th>Priorité</th>
                <th>Message</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($messages)): ?>
            <tr><td colspan="9" class="empty-row">Aucun message trouvé.</td></tr>
        <?php else: foreach ($messages as $m): ?>
            <tr class="<?= $m['statut']==='non_lu' ? 'non-lu' : '' ?>">
                <td><?= $m['id'] ?></td>
                <td><?= htmlspecialchars($m['nom']) ?></td>
                <td><?= htmlspecialchars($m['email']) ?></td>
                <td><?= htmlspecialchars($m['sujet']) ?></td>
                <td>
                    <span class="badge badge-<?= $m['priorite'] ?>">
                        <?= $m['priorite']==='grave'   ? 'Grave'
                          : ($m['priorite']==='moyenne' ? 'Moyenne' : 'Légère') ?>
                    </span>
                </td>
                <td class="msg-preview" title="<?= htmlspecialchars($m['message']) ?>">
                    <?= htmlspecialchars($m['message']) ?>
                </td>
                <td>
                    <span class="badge badge-<?= $m['statut'] ?>">
                        <?= $m['statut']==='lu' ? '✓ Lu' : '.Non lu' ?>
                    </span>
                </td>
                <td><?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></td>
                <td>
                    <?php if ($m['statut']==='non_lu'): ?>
                        <a href="?marquer=<?= $m['id'] ?>" class="btn edit">✓ Lu</a>
                    <?php endif; ?>
                    <a href="mailto:<?= htmlspecialchars($m['email']) ?>?subject=Re:<?= urlencode($m['sujet']) ?>"
                       class="btn reply"> Répondre</a>
                    <a href="?supprimer=<?= $m['id'] ?>"
                       class="btn delete"
                       onclick="return confirm('Supprimer ce message ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>

</div>
</body>
</html>