<?php
session_start();
include 'menu.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact Nous</title>
    <style>
        body {
            font-family: Arial;
            background: whitesmoke;
            margin: 0;
        }
        .container {
            width: 90%;
            margin: 40px auto;
        }
        h2 {
            color: #0f172a;
            margin-bottom: 20px;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 14px;
        }
        .alert-success {
			background: #d4edda; 
			color: #155724;
			border: 1px solid #c3e6cb; }
        .alert-error   {
			background: #f8d7da;
			color: #721c24;
			border: 1px solid #f5c6cb;
		}

        .urgence-banner {
            background: #fff3cd;
            border-left: 4px solid #ff9800;
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 13px;
            color: #7a5c00;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            color: #333;
            margin-top: 14px;
            margin-bottom: 5px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            font-family: Arial;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: black;
        }
        textarea {
			resize: vertical;
			min-height: 130px; 
		}

        .btn-submit {
            display: inline-block;
            margin-top: 18px;
            padding: 10px 20px;
            background: black;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
            font-family: Arial;
            transition: background 0.3s;
        }
        .btn-submit:hover {
			background: #333; 
		}
		
    </style>
</head>
<body>
<div class="container">
    <div class="card">

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'ok'): ?>
                <div class="alert alert-success">Message envoyé ! L'admin vous répondra bientôt.</div>
            <?php else: ?>
                <div class="alert alert-error"> Une erreur est survenue. Veuillez réessayer.</div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="urgence-banner">
            Pour une urgence, sélectionnez <strong>"Urgence"</strong> dans la priorité.
        </div>

        <form action="contact_traitement.php" method="POST">

            <label>Nom complet</label>
            <input type="text" name="nom" placeholder="Votre nom" required
                   value="<?= isset($_SESSION['nom_utilisateur']) ? htmlspecialchars($_SESSION['nom_utilisateur']) : '' ?>">

            <label>Email</label>
            <input type="email" name="email" placeholder="Votre email" required>

            <label>Sujet</label>
            <input type="text" name="sujet" placeholder="Sujet de votre message" required>

            <label>Priorité</label>
            <select name="priorite" required>
                <option value="">-- Choisir --</option>
                <option value="legere">Légère</option>
                <option value="moyenne"> Moyenne</option>
                <option value="grave"> Grave / Urgence</option>
            </select>

            <label>Message</label>
            <textarea name="message" placeholder="Décrivez votre problème..." required></textarea>

          
            <input type="text" name="website" style="display:none">

            <button type="submit" class="btn-submit">Envoyer le message</button>
        </form>

    </div>
</div>
</body>
</html>