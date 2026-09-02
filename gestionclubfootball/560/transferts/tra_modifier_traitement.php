<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id             = intval($_POST['id']);
    $joueur_id      = intval($_POST['joueur_id']);
    $ancien_club    = mysqli_real_escape_string($conn, trim($_POST['ancien_club']));
    $nouveau_club   = mysqli_real_escape_string($conn, trim($_POST['nouveau_club']));
    $montant        = floatval($_POST['montant']);
    $date_transfert = mysqli_real_escape_string($conn, $_POST['date_transfert']);

    if (empty($id)) {
        echo "Identifiant invalide.";
        exit();
    }

    if (empty($joueur_id)) {
        echo "Veuillez choisir un joueur.";
        exit();
    }

    if (empty($nouveau_club)) {
        echo "Le nouveau club est obligatoire.";
        exit();
    }

    $sql = "UPDATE transferts SET
        joueur_id = '$joueur_id',
        ancien_club = '$ancien_club',
        nouveau_club = '$nouveau_club',
        montant = '$montant',
        date_transfert = '$date_transfert'
        WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: tra_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>