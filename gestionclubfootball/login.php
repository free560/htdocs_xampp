<?php
session_start();

// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "", "gestion_club_football");

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Vérifier que le formulaire a été envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Requête préparée
    $stmt = mysqli_prepare($conn, "SELECT * FROM utilisateurs WHERE email = ?");

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        // Vérifier si le compte est actif
        if ($user['actif'] == 0) {
            die("Votre compte est désactivé.");
        }

        // Vérifier le mot de passe
        if (password_verify($password, $user['mot_de_passe'])) {

            // Création de la session
            $_SESSION['id'] = $user['id'];
            $_SESSION['nom_utilisateur'] = $user['nom_utilisateur'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['joueur_id'] = $user['joueur_id'];
            $_SESSION['staff_id'] = $user['staff_id'];


            if ($user['must_change_password'] == 1) {
                header("Location: changer_password.php");
                exit();
            }

            switch ($user['role']) {

                case "Admin":
                    header("Location: /gestionclubfootball/560/dashboard.php");
                    exit();

                case "Joueur":
                    header("Location: /gestionclubfootball/dashboard.php");
                    exit();

                case "Staff":
                    header("Location: /gestionclubfootball/staff560/dashboard.php");
                    exit();

                default:
                    echo "Rôle inconnu. Veuillez contacter l'administrateur.";
                    exit();
            }

        } else {
            echo "Mot de passe incorrect.";
        }

    } else {
        echo "Aucun utilisateur trouvé avec cette adresse e-mail.";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>