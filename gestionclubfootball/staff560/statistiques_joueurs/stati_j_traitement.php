<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $joueur_id        = intval($_POST['joueur_id']);
    $match_id         = intval($_POST['match_id']);
    $buts             = intval($_POST['buts']);
    $passes_decisives = intval($_POST['passes_decisives']);
    $cartons_jaunes   = intval($_POST['cartons_jaunes']);
    $cartons_rouges   = intval($_POST['cartons_rouges']);
    $note             = floatval($_POST['note']);


    if (empty($joueur_id)) {
        echo "Veuillez choisir un joueur.";
        exit();
    }

    if (empty($match_id)) {
        echo "Veuillez choisir un match.";
        exit();
    }


    if ($note < 0 || $note > 10) {
        echo "La note doit être comprise entre 0 et 10.";
        exit();
    }

    if ($cartons_rouges < 0 || $cartons_jaunes < 0) {
        echo "Les valeurs de cartons doivent être positives.";
        exit();
    }

    $sql = "INSERT INTO statistiques_joueurs(
        joueur_id, match_id, buts, passes_decisives,
        cartons_jaunes, cartons_rouges, note
    ) VALUES (
        '$joueur_id', '$match_id', '$buts', '$passes_decisives',
        '$cartons_jaunes', '$cartons_rouges', '$note'
    )";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: stati_j_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>