<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $joueur_id     = intval($_POST['joueur_id']);
    $ancien_club   = mysqli_real_escape_string($conn, trim($_POST['ancien_club']));
    $nouveau_club  = mysqli_real_escape_string($conn, trim($_POST['nouveau_club']));
    $montant       = floatval($_POST['montant']);
    $date_transfert= mysqli_real_escape_string($conn, $_POST['date_transfert']);


    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    die();*/

    if (empty($joueur_id)) {
        echo "Veuillez choisir un joueur.";
        exit();
    }


    if (empty($ancien_club) || empty($nouveau_club)) {
        echo "Veuillez renseigner l'ancien et le nouveau club.";
        exit();
    }


    if ($montant <= 0) {
        echo "Le montant du transfert doit être supérieur à 0.";
        exit();
    }

    $sql = "INSERT INTO transferts(
        joueur_id, ancien_club, nouveau_club, montant, date_transfert
    ) VALUES (
        '$joueur_id', '$ancien_club', '$nouveau_club', '$montant', '$date_transfert'
    )";

    $result = mysqli_query($conn, $sql);

    if ($result) {


        $sqlEquipe = mysqli_query($conn, "SELECT id FROM equipes WHERE nom_equipe = '$nouveau_club'");
        if ($sqlEquipe && mysqli_num_rows($sqlEquipe) > 0) {
            $equipe = mysqli_fetch_assoc($sqlEquipe);
            $nouvelle_equipe_id = $equipe['id'];
            mysqli_query($conn, "UPDATE joueurs SET equipe_id = '$nouvelle_equipe_id' WHERE id = '$joueur_id'");
        }

        header("Location: tra_lister.php");
        exit();

    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>