<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Le formulaire envoie "nom_equipement", la table attend "nom"
    $nom           = mysqli_real_escape_string($conn, $_POST['nom_equipement']);
    $quantite      = (int) $_POST['quantite'];
    $prix_unitaire = (float) $_POST['prix_unitaire'];
    $date_achat    = mysqli_real_escape_string($conn, $_POST['date_achat']);

    // Validation : nom obligatoire
    if (empty($nom)) {
        die("Erreur : veuillez indiquer le nom de l'équipement.");
    }

    // Validation : quantité positive
    if ($quantite <= 0) {
        die("Erreur : la quantité doit être supérieure à 0.");
    }

    // Validation : prix unitaire positif
    if ($prix_unitaire <= 0) {
        die("Erreur : le prix unitaire doit être supérieur à 0.");
    }

    // Validation : date obligatoire
    if (empty($date_achat)) {
        die("Erreur : veuillez indiquer la date d'achat.");
    }

    // Requête d'insertion
    $sql = "INSERT INTO equipements (nom, quantite, prix_unitaire, date_achat) 
            VALUES ('$nom', $quantite, $prix_unitaire, '$date_achat')";

    if (mysqli_query($conn, $sql)) {
        // header() doit être appelé avant tout echo/HTML
        header("Location: eq_lister.php");
        exit();
    } else {
        die("Erreur lors de l'enregistrement : " . mysqli_error($conn));
    }

} else {
    // Accès direct sans passer par le formulaire
    header("Location: eq_ajouter.php");
    exit();
}
?>