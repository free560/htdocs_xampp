<?php
include '../config/db.php';

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    if (empty($id)) {
        echo "ID invalide.";
        exit();
    }

    $sql = "DELETE FROM equipes WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: eq_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
        echo "<br><br>Cette équipe est probablement liée à des joueurs, staff ou matchs existants.";
        echo "<br><a href='eq_lister.php'>Retour à la liste</a>";
    }

} else {
    echo "Aucun identifiant fourni.";
}
?>