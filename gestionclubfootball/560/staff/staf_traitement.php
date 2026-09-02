<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $equipe_id      = intval($_POST['equipe_id']);
    $nom            = mysqli_real_escape_string($conn, trim($_POST['nom']));
    $prenom         = mysqli_real_escape_string($conn, trim($_POST['prenom']));
    $fonction       = mysqli_real_escape_string($conn, $_POST['fonction']);
    $telephone      = mysqli_real_escape_string($conn, trim($_POST['telephone']));
    $email          = mysqli_real_escape_string($conn, trim($_POST['email']));
    $salaire        = floatval($_POST['salaire']);
    $date_embauche  = mysqli_real_escape_string($conn, $_POST['date_embauche']);

    if (empty($equipe_id) || empty($nom) || empty($prenom) || empty($fonction)) {
        die("Champs obligatoires manquants.");
    }

    // PHOTO
    if (!empty($_FILES['photo']['name'])) {
        $nom_photo    = time() . '_' . basename($_FILES['photo']['name']);
        $chemin_photo = "../uploads/" . $nom_photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $chemin_photo);
    } else {
        $nom_photo = "default.png";
    }

    // 1. INSERT STAFF
    $sql = "INSERT INTO staff(
        equipe_id, nom, prenom, fonction,
        telephone, email, salaire, date_embauche, photo
    ) VALUES (
        '$equipe_id', '$nom', '$prenom', '$fonction',
        '$telephone', '$email', '$salaire', '$date_embauche', '$nom_photo'
    )";

    if (!mysqli_query($conn, $sql)) {
        die("Erreur insertion staff : " . mysqli_error($conn));
    }

    // ID du staff créé
    $staff_id = mysqli_insert_id($conn);

    // 2. CREER UTILISATEUR
    $mot_temporaire = "123456";
    $hash = password_hash($mot_temporaire, PASSWORD_DEFAULT);

    $nom_utilisateur = strtolower($nom . "." . $prenom);

    $sqlUser = "INSERT INTO utilisateurs(
        nom_utilisateur,
        email,
        mot_de_passe,
        role,
        actif,
        doit_changer_mdp,
        premiere_connexion,
        must_change_password,
        staff_id
    ) VALUES (
        '$nom_utilisateur',
        '$email',
        '$hash',
        'Staff',
        1,
        1,
        1,
        1,
        $staff_id
    )";

    if (!mysqli_query($conn, $sqlUser)) {
        die("Erreur insertion utilisateur : " . mysqli_error($conn));
    }

    header("Location: staf_lister.php");
    exit();
} else {
    echo "Accès refusé.";
}
?>