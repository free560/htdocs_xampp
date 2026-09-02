<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = intval($_POST['id']);
    $joueur_id = intval($_POST['joueur_id']);
    $date_debut = mysqli_real_escape_string($conn, $_POST['date_debut']);
    $date_fin = mysqli_real_escape_string($conn, $_POST['date_fin']);
    $salaire = floatval($_POST['salaire']);
    $prime_match = floatval($_POST['prime_match']);

    if (empty($id)) {
        echo "Identifiant invalide.";
        exit();
    }

    if (empty($joueur_id)) {
        echo "Veuillez choisir un joueur.";
        exit();
    }

    if ($date_fin <= $date_debut) {
        echo "La date de fin doit être après la date de début.";
        exit();
    }

    $sql = "UPDATE contrats SET
        joueur_id = '$joueur_id',
        date_debut = '$date_debut',
        date_fin = '$date_fin',
        salaire = '$salaire',
        prime_match = '$prime_match'
        WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: c_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>