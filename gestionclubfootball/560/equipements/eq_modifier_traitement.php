<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id            = intval($_POST['id']);
    $nom           = mysqli_real_escape_string($conn, trim($_POST['nom']));
    $quantite      = intval($_POST['quantite']);
    $prix_unitaire = floatval($_POST['prix_unitaire']);
    $date_achat    = mysqli_real_escape_string($conn, $_POST['date_achat']);

    if (empty($id)) {
        echo "Identifiant invalide.";
        exit();
    }

    if (empty($nom)) {
        echo "Le nom de l'équipement est obligatoire.";
        exit();
    }

    if ($quantite < 0) {
        echo "La quantité ne peut pas être négative.";
        exit();
    }

    $sql = "UPDATE equipements SET
        nom = '$nom',
        quantite = '$quantite',
        prix_unitaire = '$prix_unitaire',
        date_achat = '$date_achat'
        WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: eq_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>