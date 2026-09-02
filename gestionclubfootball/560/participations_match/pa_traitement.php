<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $match_id = intval($_POST['match_id']);
    $joueur_id = intval($_POST['joueur_id']);
    $titulaire = mysqli_real_escape_string($conn, $_POST['titulaire']);
    $minutes_jouees = intval($_POST['minutes_jouees']);

    // ✅ Vérifier que match et joueur sont bien sélectionnés
    if (empty($match_id)) {
        echo "Veuillez choisir un match.";
        exit();
    }

    if (empty($joueur_id)) {
        echo "Veuillez choisir un joueur.";
        exit();
    }

    if (empty($titulaire)) {
        echo "Veuillez préciser si le joueur est titulaire.";
        exit();
    }

    // ✅ Vérifier que les minutes jouées sont cohérentes (0 à 120 min)
    if ($minutes_jouees < 0 || $minutes_jouees > 120) {
        echo "Les minutes jouées doivent être comprises entre 0 et 120.";
        exit();
    }

    $sql = "INSERT INTO participations_match(
        match_id, joueur_id, titulaire, minutes_jouees
    ) VALUES (
        '$match_id', '$joueur_id', '$titulaire', '$minutes_jouees'
    )";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: pa_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>