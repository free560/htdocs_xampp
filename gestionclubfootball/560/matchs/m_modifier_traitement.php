<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id               = intval($_POST['id']);
    $equipe_id        = intval($_POST['equipe_id']);
    $stade_id         = intval($_POST['stade_id']);
    $adversaire       = mysqli_real_escape_string($conn, trim($_POST['adversaire']));
    $competition      = mysqli_real_escape_string($conn, trim($_POST['competition']));
    $date_match       = mysqli_real_escape_string($conn, $_POST['date_match']);
    $type_match       = mysqli_real_escape_string($conn, $_POST['type_match']);
    $score_equipe     = ($_POST['score_equipe'] !== '') ? intval($_POST['score_equipe']) : null;
    $score_adversaire = ($_POST['score_adversaire'] !== '') ? intval($_POST['score_adversaire']) : null;
    $statut           = mysqli_real_escape_string($conn, $_POST['statut']);

    if (empty($id)) {
        echo "Identifiant invalide.";
        exit();
    }

    if (empty($equipe_id)) {
        echo "Veuillez choisir votre équipe.";
        exit();
    }

    $score_equipe_sql     = ($score_equipe === null) ? "NULL" : "'$score_equipe'";
    $score_adversaire_sql = ($score_adversaire === null) ? "NULL" : "'$score_adversaire'";
    $stade_id_sql         = empty($stade_id) ? "NULL" : "'$stade_id'";

    $sql = "UPDATE matchs SET
        equipe_id = '$equipe_id',
        stade_id = $stade_id_sql,
        adversaire = '$adversaire',
        competition = '$competition',
        date_match = '$date_match',
        type_match = '$type_match',
        score_equipe = $score_equipe_sql,
        score_adversaire = $score_adversaire_sql,
        statut = '$statut'
        WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: m_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>