<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id             = intval($_POST['id']);
    $equipe_id      = intval($_POST['equipe_id']);
    $nom            = mysqli_real_escape_string($conn, trim($_POST['nom']));
    $prenom         = mysqli_real_escape_string($conn, trim($_POST['prenom']));
    $sexe           = mysqli_real_escape_string($conn, $_POST['sexe']);
    $date_naissance = mysqli_real_escape_string($conn, $_POST['date_naissance']);
    $nationalite    = mysqli_real_escape_string($conn, trim($_POST['nationalite']));
    $poste          = mysqli_real_escape_string($conn, $_POST['poste']);
    $numero_maillot = intval($_POST['numero_maillot']);
    $taille         = floatval($_POST['taille']);
    $poids          = floatval($_POST['poids']);
    $telephone      = mysqli_real_escape_string($conn, trim($_POST['telephone']));
    $email          = mysqli_real_escape_string($conn, trim($_POST['email']));
    $adresse        = mysqli_real_escape_string($conn, trim($_POST['adresse']));
    $statut         = mysqli_real_escape_string($conn, $_POST['statut']);
    $ancienne_photo = mysqli_real_escape_string($conn, $_POST['ancienne_photo']);

    if (empty($id)) {
        echo "Identifiant invalide.";
        exit();
    }

    if (empty($equipe_id)) {
        echo "Veuillez choisir une équipe.";
        exit();
    }

    if (empty($nom) || empty($prenom)) {
        echo "Le nom et le prénom sont obligatoires.";
        exit();
    }


    if (!empty($_FILES['photo']['name'])) {
        $nom_photo    = time() . '_' . basename($_FILES['photo']['name']);
        $chemin_photo = "../uploads/" . $nom_photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $chemin_photo);
    } else {
        $nom_photo = $ancienne_photo;
    }

    $sql = "UPDATE joueurs SET
        equipe_id = '$equipe_id',
        nom = '$nom',
        prenom = '$prenom',
        sexe = '$sexe',
        date_naissance = '$date_naissance',
        nationalite = '$nationalite',
        poste = '$poste',
        numero_maillot = '$numero_maillot',
        taille = '$taille',
        poids = '$poids',
        telephone = '$telephone',
        email = '$email',
        adresse = '$adresse',
        photo = '$nom_photo',
        statut = '$statut'
        WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: j_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>