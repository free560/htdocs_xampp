<?php
include '../config/db.php';

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    if (empty($id)) {
        echo "ID invalide.";
        exit();
    }

    // ✅ Vérifier que le joueur a bien un compte lié (via utilisateurs.joueur_id)
    $sqlUser = mysqli_query($conn, "SELECT id FROM utilisateurs WHERE joueur_id = '$id'");
    $user = mysqli_fetch_assoc($sqlUser);

    if (!$user) {
        echo "Ce joueur n'a pas de compte utilisateur associé.";
        exit();
    }

    // ✅ Bloquer le compte (le login deviendra impossible)
    $sql = "UPDATE utilisateurs SET actif = 0 WHERE joueur_id = '$id'";
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