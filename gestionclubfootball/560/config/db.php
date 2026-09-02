<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "gestion_club_football"
);

if(!$conn){
    die("Erreur connexion : ".mysqli_connect_error());
}

?>