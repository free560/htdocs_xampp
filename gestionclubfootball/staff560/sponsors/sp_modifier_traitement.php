<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id        = intval($_POST['id']);
    $nom       = mysqli_real_escape_string($conn, trim($_POST['nom']));
    $contact   = mysqli_real_escape_string($conn, trim($_POST['contact']));
    $telephone = mysqli_real_escape_string($conn, trim($_POST['telephone']));
    $email     = mysqli_real_escape_string($conn, trim($_POST['email']));

    if (empty($id)) {
        echo "Identifiant invalide.";
        exit();
    }

    if (empty($nom)) {
        echo "Le nom du sponsor est obligatoire.";
        exit();
    }

    $sql = "UPDATE sponsors SET
        nom = '$nom',
        contact = '$contact',
        telephone = '$telephone',
        email = '$email'
        WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: sp_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>