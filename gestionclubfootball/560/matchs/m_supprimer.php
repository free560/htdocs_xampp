<?php
include '../config/db.php';

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    if (empty($id)) {
        echo "ID invalide.";
        exit();
    }

    $sql = "DELETE FROM matchs WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: m_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
        echo "<br>Ce match est probablement lié à des participations ou statistiques existantes.";
        echo "<br><a href='m_lister.php'>Retour à la liste</a>";
    }

} else {
    echo "Aucun identifiant fourni.";
}
?>