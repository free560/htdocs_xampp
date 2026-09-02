<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $equipe_id        = (int) $_POST['equipe_id'];
    $stade_id         = (int) $_POST['stade_id'];
    $adversaire       = mysqli_real_escape_string($conn, $_POST['adversaire']);
    $competition      = mysqli_real_escape_string($conn, $_POST['competition']);
    $date_match       = mysqli_real_escape_string($conn, $_POST['date_match']);
    $type_match       = mysqli_real_escape_string($conn, $_POST['type_match']);
    $statut           = mysqli_real_escape_string($conn, $_POST['statut']);

    // Score équipe : peut être vide si le match n'est pas encore joué
    $score_equipe = ($_POST['score_equipe'] === '') ? 'NULL' : (int) $_POST['score_equipe'];
    $score_adversaire = ($_POST['score_adversaire'] === '') ? 'NULL' : (int) $_POST['score_adversaire'];

    // Validation : équipe obligatoire
    if ($equipe_id <= 0) {
        die("Erreur : veuillez choisir une équipe.");
    }

    // Validation : stade obligatoire
    if ($stade_id <= 0) {
        die("Erreur : veuillez choisir un stade.");
    }

    // Validation : adversaire obligatoire
    if (empty($adversaire)) {
        die("Erreur : veuillez indiquer l'adversaire.");
    }

    // Validation : compétition obligatoire
    if (empty($competition)) {
        die("Erreur : veuillez indiquer la compétition.");
    }

    // Validation : date du match obligatoire
    if (empty($date_match)) {
        die("Erreur : veuillez indiquer la date du match.");
    }

    // Requête d'insertion
    $sql = "INSERT INTO matchs (equipe_id, stade_id, adversaire, competition, date_match, type_match, score_equipe, score_adversaire, statut) 
            VALUES ($equipe_id, $stade_id, '$adversaire', '$competition', '$date_match', '$type_match', $score_equipe, $score_adversaire, '$statut')";

    if (mysqli_query($conn, $sql)) {
        // header() doit être appelé avant tout echo/HTML
        header("Location: m_lister.php");
        exit();
    } else {
        die("Erreur lors de l'enregistrement : " . mysqli_error($conn));
    }

} else {
    // Accès direct sans passer par le formulaire
    header("Location: m_ajouter.php");
    exit();
}
?>