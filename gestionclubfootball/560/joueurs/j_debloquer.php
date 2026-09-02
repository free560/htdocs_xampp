<?php
include '../config/db.php';

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    if (empty($id)) {
        echo "ID invalide.";
        exit();
    }

    $sqlUser = mysqli_query($conn, "SELECT id FROM utilisateurs WHERE joueur_id = '$id'");
    $user = mysqli_fetch_assoc($sqlUser);

    if (!$user) {
        echo "Ce joueur n'a pas de compte utilisateur associé.";
        exit();
    }

    // ✅ Débloquer le compte (le login redevient possible)
    $sql = "UPDATE utilisateurs SET actif = 1 WHERE joueur_id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: j_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Aucun identifiant fourni.";
}
?>