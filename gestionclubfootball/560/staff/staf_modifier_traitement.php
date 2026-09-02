<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id            = intval($_POST['id']);
    $equipe_id     = intval($_POST['equipe_id']);
    $nom           = mysqli_real_escape_string($conn, trim($_POST['nom']));
    $prenom        = mysqli_real_escape_string($conn, trim($_POST['prenom']));
    $fonction      = mysqli_real_escape_string($conn, $_POST['fonction']);
    $telephone     = mysqli_real_escape_string($conn, trim($_POST['telephone']));
    $email         = mysqli_real_escape_string($conn, trim($_POST['email']));
    $salaire       = floatval($_POST['salaire']);
    $date_embauche = mysqli_real_escape_string($conn, $_POST['date_embauche']);
    $ancienne_photo = mysqli_real_escape_string($conn, $_POST['photo_actuelle']);

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

    $sql = "UPDATE staff SET
        equipe_id = '$equipe_id',
        nom = '$nom',
        prenom = '$prenom',
        fonction = '$fonction',
        telephone = '$telephone',
        email = '$email',
        salaire = '$salaire',
        date_embauche = '$date_embauche',
        photo = '$nom_photo'
        WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: staf_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>