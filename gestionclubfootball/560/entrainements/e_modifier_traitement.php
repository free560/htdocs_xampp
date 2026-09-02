<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id               = intval($_POST['id']);
    $equipe_id        = intval($_POST['equipe_id']);
    $date_entrainement= mysqli_real_escape_string($conn, $_POST['date_entrainement']);
    $lieu             = mysqli_real_escape_string($conn, trim($_POST['lieu']));
    $description      = mysqli_real_escape_string($conn, trim($_POST['description']));

    if (empty($id)) {
        echo "Identifiant invalide.";
        exit();
    }

    if (empty($equipe_id)) {
        echo "Veuillez choisir une équipe.";
        exit();
    }

    $sql = "UPDATE entrainements SET
        equipe_id = '$equipe_id',
        date_entrainement = '$date_entrainement',
        lieu = '$lieu',
        description = '$description'
        WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: e_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>