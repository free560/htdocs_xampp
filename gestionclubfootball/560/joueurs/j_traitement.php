<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $equipe_id      = intval($_POST['equipe_id']);
    $nom            = trim($_POST['nom']);
    $prenom         = trim($_POST['prenom']);
    $sexe           = $_POST['sexe'];
    $date_naissance = $_POST['date_naissance'];
    $nationalite    = trim($_POST['nationalite']);
    $poste          = $_POST['poste'];
    $numero_maillot = intval($_POST['numero_maillot']);
    $taille         = floatval($_POST['taille']);
    $poids          = floatval($_POST['poids']);
    $telephone      = trim($_POST['telephone']);
    $email          = trim($_POST['email']);
    $adresse        = trim($_POST['adresse']);
    $statut         = $_POST['statut'];

    if (empty($equipe_id) || empty($nom) || empty($prenom)) {
        die("Champs obligatoires manquants.");
    }

    // PHOTO
    if (!empty($_FILES['photo']['name'])) {
        $nom_photo = time() . '_' . basename($_FILES['photo']['name']);
        $chemin_photo = "../uploads/" . $nom_photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $chemin_photo);
    } else {
        $nom_photo = "default.png";
    }

    // 1. INSERT JOUEUR
    $sql = "INSERT INTO joueurs(
        equipe_id, nom, prenom, sexe, date_naissance,
        nationalite, poste, numero_maillot, taille, poids,
        telephone, email, adresse, photo, statut
    ) VALUES (
        '$equipe_id', '$nom', '$prenom', '$sexe', '$date_naissance',
        '$nationalite', '$poste', '$numero_maillot', '$taille', '$poids',
        '$telephone', '$email', '$adresse', '$nom_photo', '$statut'
    )";

    if (!mysqli_query($conn, $sql)) {
        die("Erreur insertion joueur : " . mysqli_error($conn));
    }

    // ID du joueur créé
    $joueur_id = mysqli_insert_id($conn);

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
        joueur_id
    ) VALUES (
        '$nom_utilisateur',
        '$email',
        '$hash',
        'Joueur',
        1,
        1,
        1,
        1,
        $joueur_id
    )";

    if (!mysqli_query($conn, $sqlUser)) {
        die("Erreur insertion utilisateur : " . mysqli_error($conn));
    }

    header("Location: j_lister.php");
    exit();
} else {
    echo "Accès refusé.";
}
?>