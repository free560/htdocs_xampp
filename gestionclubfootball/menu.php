<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Menu Navigation</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:whitesmoke;
}

.navbar{
    background:black;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 25px;
}

.logo{
    color:white;
    font-size:20px;
    font-weight:bold;
}

.menu{
    display:flex;
    gap:15px;
}

.menu a{
    text-decoration:none;
    color:white;
    padding:8px 12px;
    border-radius:5px;
    transition:0.3s;
}

.menu a:hover{
    background:white;
    color:black;
}

@media (max-width:600px){
    .menu{
        flex-direction:column;
        background:black;
        position:absolute;
        top:60px;
        right:10px;
        padding:10px;
        border-radius:10px;
    }
}
</style>
</head>

<body>

<div class="navbar">

    <div class="logo">
        Club Football
    </div>

    <div class="menu">
	    <a href="/gestionclubfootball/dashboard.php">Accueil</a>
		<a href="/gestionclubfootball/contact_nous.php">Contact</a>
		<a href="/gestionclubfootball/apropos.php">À propos</a>
		<a href="/gestionclubfootball/logout.php">Déconnexion</a>
    </div>

</div>

</body>
</html>