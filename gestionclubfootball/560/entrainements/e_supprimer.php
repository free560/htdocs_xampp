<?php
include '../config/db.php';

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    if (empty($id)) {
        echo "ID invalide.";
        exit();
    }

    $sql = "DELETE FROM entrainements WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: e_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Aucun identifiant fourni.";
}
?>