<?php
include '../config/db.php';

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    if (empty($id)) {
        echo "ID invalide.";
        exit();
    }


    $sqlUser = mysqli_query($conn, "SELECT id FROM utilisateurs WHERE staff_id = '$id'");
    $user = mysqli_fetch_assoc($sqlUser);

    if (!$user) {
        echo "Ce membre du staff n'a pas de compte utilisateur associé.";
        exit();
    }

 
    $sql = "UPDATE utilisateurs SET actif = 0 WHERE staff_id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: staf_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Aucun identifiant fourni.";
}
?>