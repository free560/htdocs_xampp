<?php
include '../config/db.php';

$nom_equipe = htmlspecialchars($_POST['nom_equipe']);
$categorie = htmlspecialchars($_POST['categorie']);
$date_creation = htmlspecialchars($_POST['date_creation']);
$description = htmlspecialchars($_POST['description']);

$sql = "INSERT INTO equipes(nom_equipe, categorie, date_creation, description)
VALUES('$nom_equipe', '$categorie', '$date_creation', '$description')";

$result = mysqli_query($conn, $sql);


if($result){
    header("Location: eq_lister.php");
} else {
    echo "Erreur lors de l'insertion";
}
?>