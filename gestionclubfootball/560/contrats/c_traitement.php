<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $joueur_id  = intval($_POST['joueur_id']);
    $date_debut = mysqli_real_escape_string($conn, $_POST['date_debut']);
    $date_fin   = mysqli_real_escape_string($conn, $_POST['date_fin']);
    $salaire    = floatval($_POST['salaire']);
    $prime_match= floatval($_POST['prime_match']);

    // ✅ Vérifier que le joueur est bien sélectionné
    if (empty($joueur_id)) {
        echo "Veuillez choisir un joueur.";
        exit();
    }

    // ✅ Vérifier que la date de fin est après la date de début
    if ($date_fin <= $date_debut) {
        echo "La date de fin doit être après la date de début.";
        exit();
    }

    $sql = "INSERT INTO contrats(
        joueur_id, date_debut, date_fin, salaire, prime_match
    ) VALUES (
        '$joueur_id', '$date_debut', '$date_fin', '$salaire', '$prime_match'
    )";

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