<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id               = intval($_POST['id']);
    $joueur_id        = intval($_POST['joueur_id']);
    $match_id         = intval($_POST['match_id']);
    $buts             = intval($_POST['buts']);
    $passes_decisives = intval($_POST['passes_decisives']);
    $cartons_jaunes   = intval($_POST['cartons_jaunes']);
    $cartons_rouges   = intval($_POST['cartons_rouges']);
    $note             = floatval($_POST['note']);

    if (empty($id)) {
        echo "Identifiant invalide.";
        exit();
    }

    if (empty($joueur_id)) {
        echo "Veuillez choisir un joueur.";
        exit();
    }

    $sql = "UPDATE statistiques_joueurs SET
        joueur_id = '$joueur_id',
        match_id = '$match_id',
        buts = '$buts',
        passes_decisives = '$passes_decisives',
        cartons_jaunes = '$cartons_jaunes',
        cartons_rouges = '$cartons_rouges',
        note = '$note'
        WHERE id = '$id'";

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