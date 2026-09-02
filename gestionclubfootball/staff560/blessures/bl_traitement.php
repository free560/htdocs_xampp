<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $joueur_id    = intval($_POST['joueur_id']);
    $type_blessure= mysqli_real_escape_string($conn, trim($_POST['type_blessure']));
    $date_blessure= mysqli_real_escape_string($conn, $_POST['date_blessure']);
    $duree_estimee        = intval($_POST['duree']);
    $commentaire  = mysqli_real_escape_string($conn, trim($_POST['commentaire']));


    if (empty($joueur_id)) {
        echo "Veuillez choisir un joueur.";
        exit();
    }

    $sql = "INSERT INTO blessures(
        joueur_id, type_blessure, date_blessure, duree_estimee, commentaire
    ) VALUES (
        '$joueur_id', '$type_blessure', '$date_blessure', '$duree_estimee', '$commentaire'
    )";

    $result = mysqli_query($conn, $sql);

    if ($result) {


        $sqlStatut = "UPDATE joueurs SET statut = 'Blesse' WHERE id = '$joueur_id'";
        mysqli_query($conn, $sqlStatut);

        header("Location: bl_lister.php");
        exit();

    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>