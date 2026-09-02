<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id             = intval($_POST['id']);
    $date_operation = mysqli_real_escape_string($conn, $_POST['date_operation']);
    $type_operation = mysqli_real_escape_string($conn, $_POST['type_operation']);
    $categorie      = mysqli_real_escape_string($conn, trim($_POST['categorie']));
    $montant        = floatval($_POST['montant']);
    $description    = mysqli_real_escape_string($conn, trim($_POST['description']));

    if (empty($id)) {
        echo "Identifiant invalide.";
        exit();
    }

    if (empty($type_operation)) {
        echo "Veuillez choisir un type d'opération.";
        exit();
    }

    $sql = "UPDATE finances SET
        date_operation = '$date_operation',
        type_operation = '$type_operation',
        categorie = '$categorie',
        montant = '$montant',
        description = '$description'
        WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: f_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>