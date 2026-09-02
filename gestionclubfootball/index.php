<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Connexion</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:whitesmoke;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}


.login-box{
    background:white;
    width:350px;
    padding:30px;
    border-radius:12px;
    box-shadow:whitesmoke;
    text-align:center;
}


.login-box h2{
    margin-bottom:20px;
    color:black;
}

.login-box input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid whitesmoke;
    border-radius:8px;
    outline:none;
    transition:0.3s;
}

.login-box input:focus{
    border-color:black;
}

.login-box button{
    width:100%;
    padding:12px;
    margin-top:10px;
    background:black;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
    transition:0.3s;
}

.login-box button:hover{
    background:black;
}


.footer-text{
    margin-top:15px;
    font-size:12px;
    color:gray;
}
</style>

</head>

<body>

<div class="login-box">
    <h2> Gestion Club Football</h2>

    <form method="POST" action="login.php">

        <input type="email" name="email" placeholder="Email">

        <input type="password" name="password" placeholder="Mot de passe">

        <button type="submit">Connexion</button>

    </form>

    <div class="footer-text">
        Accès sécurisé Du Systeme
    </div>
</div>

</body>
</html>