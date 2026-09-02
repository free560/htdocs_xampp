<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $date_operation = mysqli_real_escape_string($conn, $_POST['date_operation']);
    $type_operation = mysqli_real_escape_string($conn, $_POST['type_operation']);
    $categorie      = mysqli_real_escape_string($conn, $_POST['categorie']);
    $montant        = (float) $_POST['montant'];
    $description    = mysqli_real_escape_string($conn, $_POST['description']);

    // Validation : date obligatoire
    if (empty($date_operation)) {
        die("Erreur : veuillez indiquer la date de l'opération.");
    }

    // Validation : type d'opération obligatoire (Recette ou Depense)
    if (empty($type_operation)) {
        die("Erreur : veuillez choisir un type d'opération.");
    }

    // Validation : catégorie obligatoire
    if (empty($categorie)) {
        die("Erreur : veuillez indiquer une catégorie.");
    }

    // Validation : montant positif
    if ($montant <= 0) {
        die("Erreur : le montant doit être supérieur à 0.");
    }

    // Requête d'insertion
    $sql = "INSERT INTO finances (date_operation, type_operation, categorie, montant, description) 
            VALUES ('$date_operation', '$type_operation', '$categorie', $montant, '$description')";

    if (mysqli_query($conn, $sql)) {
        // header() doit être appelé avant tout echo/HTML
        header("Location: f_lister.php");
        exit();
    } else {
        die("Erreur lors de l'enregistrement : " . mysqli_error($conn));
    }

} else {
    // Accès direct sans passer par le formulaire
    header("Location: f_ajouter.php");
    exit();
}
?>