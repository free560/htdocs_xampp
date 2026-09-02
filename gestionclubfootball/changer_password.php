<?php
session_start();

require_once __DIR__ . "/config/db.php";

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

if(isset($_POST['submit'])){

    $password = trim($_POST['password']);

    if(strlen($password) < 6){
        $message = "Le mot de passe doit contenir au moins 6 caractères.";
    }else{

        $new_pass = password_hash($password,PASSWORD_DEFAULT);

        $sql = "UPDATE utilisateurs
                SET mot_de_passe='$new_pass',
                    must_change_password=0
                WHERE id='$user_id'";

        if(mysqli_query($conn,$sql)){

            if($_SESSION['role']=="Admin"){
                header("Location: /gestionclubfootball/560/dashboard.php");
            }

            elseif($_SESSION['role']=="Joueur"){
                header("Location: /gestionclubfootball/dashboard.php");
            }

            elseif($_SESSION['role']=="Staff"){
                header("Location: /gestionclubfootball/staff560/dashboard.php");
            }

            exit();
        }

        $message="Erreur lors de la modification.";
    }

}
?>
<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<title>Changer le mot de passe</title>

<style>

body{

    font-family:Arial;
    background:whitesmoke;
}

.container{

    width:500px;
    margin:60px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.2);

}

h2{

    text-align:center;
    margin-bottom:20px;

}

input{

    width:100%;
    padding:12px;
    margin-top:10px;
    border:1px solid #ccc;
    border-radius:5px;
    box-sizing:border-box;

}

button{

    width:100%;
    padding:12px;
    margin-top:20px;
    border:none;
    background:black;
    color:white;
    cursor:pointer;
    border-radius:5px;
    font-size:16px;

}

button:hover{

    background:#333;

}

.message{

    color:red;
    text-align:center;
    margin-top:15px;

}

</style>

</head>

<body>

<div class="container">

<h2>Changer votre mot de passe</h2>

<form method="POST">

<input
type="password"
name="password"
placeholder="Nouveau mot de passe"
required>

<button type="submit" name="submit">

Valider

</button>

</form>

<?php

if(isset($message)){
    echo "<div class='message'>$message</div>";
}

?>

</div>

</body>

</html>