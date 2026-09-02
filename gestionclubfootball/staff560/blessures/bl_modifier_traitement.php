<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id             = intval($_POST['id']);
    $joueur_id      = intval($_POST['joueur_id']);
    $type_blessure  = mysqli_real_escape_string($conn, trim($_POST['type_blessure']));
    $date_blessure  = mysqli_real_escape_string($conn, $_POST['date_blessure']);
    $duree_estimee  = intval($_POST['duree']);
    $commentaire    = mysqli_real_escape_string($conn, trim($_POST['commentaire']));

    if (empty($id)) {
        echo "Identifiant invalide.";
        exit();
    }

    if (empty($joueur_id)) {
        echo "Veuillez choisir un joueur.";
        exit();
    }

    $sql = "UPDATE blessures SET
        joueur_id = '$joueur_id',
        type_blessure = '$type_blessure',
        date_blessure = '$date_blessure',
        duree_estimee = '$duree_estimee',
        commentaire = '$commentaire'
        WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: bl_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>