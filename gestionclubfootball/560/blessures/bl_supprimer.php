<?php
include '../config/db.php';

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    if (empty($id)) {
        echo "ID invalide.";
        exit();
    }


    $sqlCheck = mysqli_query($conn, "SELECT joueur_id FROM blessures WHERE id = '$id'");
    $blessure = mysqli_fetch_assoc($sqlCheck);

    if (!$blessure) {
        echo "Blessure introuvable.";
        exit();
    }

    $joueur_id = intval($blessure['joueur_id']);

    $sql = "DELETE FROM blessures WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {


        $sqlAutres = mysqli_query($conn, "SELECT id FROM blessures WHERE joueur_id = '$joueur_id'");
        if (mysqli_num_rows($sqlAutres) == 0) {
            mysqli_query($conn, "UPDATE joueurs SET statut = 'Actif' WHERE id = '$joueur_id'");
        }

        header("Location: bl_lister.php");
        exit();

    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Aucun identifiant fourni.";
}
?>