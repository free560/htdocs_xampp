<?php
session_start();
if(!isset($_SESSION['id']))
{
    header("Location: /gestionclubfootball/index.php");
    exit();
}

include 'config/db.php';

// Fonction utilitaire : compte le nombre de lignes d'une table
function compterLignes($conn, $table) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM $table");
    if (!$result) {
        return 0;
    }
    $row = mysqli_fetch_assoc($result);
    return (int) $row['total'];
}

$nb_equipes               = compterLignes($conn, 'equipes');
$nb_joueurs                = compterLignes($conn, 'joueurs');
$nb_staff                  = compterLignes($conn, 'staff');
$nb_matchs                 = compterLignes($conn, 'matchs');
$nb_blessures               = compterLignes($conn, 'blessures');
$nb_transferts              = compterLignes($conn, 'transferts');
$nb_finances                = compterLignes($conn, 'finances');
$nb_sponsors                = compterLignes($conn, 'sponsors');
$nb_contrats                = compterLignes($conn, 'contrats');
$nb_stades                  = compterLignes($conn, 'stades');
$nb_entrainements           = compterLignes($conn, 'entrainements');
$nb_equipements             = compterLignes($conn, 'equipements');
$nb_presences               = compterLignes($conn, 'presences_entrainement');
$nb_participations          = compterLignes($conn, 'participations_match');
$nb_contrats_sponsors       = compterLignes($conn, 'contrats_sponsors');
$nb_statistiques_joueurs    = compterLignes($conn, 'statistiques_joueurs');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard Football</title>
<style>
body{
    margin:0;
    font-family: Arial;
    background: whitesmoke;
}
header{
    background:black;
    color:white;
    padding:18px;
    text-align:center;
    font-size:22px;
}
.grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 15px;
    padding: 20px;
}
.card{
    background:white;
    border-radius:15px;
    padding:20px;
    text-align:center;
    box-shadow:0 6px 15px black;
    transition:0.3s;
    cursor:pointer;
    text-decoration:none;
    color:black;
    display:block;
}
.card:hover{
    transform:scale(1.05);
}
.card h2{
    margin:10px 0;
    font-size:28px;
	color: black;
}
.card span{
    color:gray;
    font-size:14px;
}
</style>
</head>
<body>
<?php include 'menu_admin.php';?>
<header>
  Dashboard Gestion Club Football
</header>
<div class="grid">
<a href="equipes/eq_lister.php" class="card">
    <span>Équipes</span>
    <h2 class="dark"><?= $nb_equipes ?></h2>
</a>
<a href="joueurs/j_lister.php" class="card">
    <span>Joueurs</span>
    <h2 class="blue"><?= $nb_joueurs ?></h2>
</a>
<a href="staff/staf_lister.php" class="card">
    <span>Staff</span>
    <h2 class="orange"><?= $nb_staff ?></h2>
</a>
<a href="matchs/m_lister.php" class="card">
    <span>Matchs</span>
    <h2 class="green"><?= $nb_matchs ?></h2>
</a>
<a href="blessures/bl_lister.php" class="card">
    <span>Blessures</span>
    <h2 class="red"><?= $nb_blessures ?></h2>
</a>
<a href="transferts/tra_lister.php" class="card">
    <span>Transferts</span>
    <h2 class="purple"><?= $nb_transferts ?></h2>
</a>
<a href="finances/f_lister.php" class="card">
    <span>Finances</span>
    <h2 class="green"><?= $nb_finances ?></h2>
</a>
<a href="sponsors/sp_lister.php" class="card">
    <span>Sponsors</span>
    <h2 class="blue"><?= $nb_sponsors ?></h2>
</a>
<a href="contrats/c_lister.php" class="card">
    <span>Contrats</span>
    <h2 class="orange"><?= $nb_contrats ?></h2>
</a>
<a href="stades/sta_lister.php" class="card">
    <span>Stades</span>
    <h2 class="dark"><?= $nb_stades ?></h2>
</a>
<a href="entrainements/e_lister.php" class="card">
    <span>Entraînements</span>
    <h2 class="purple"><?= $nb_entrainements ?></h2>
</a>
<a href="equipements/eq_lister.php" class="card">
    <span>Équipements</span>
    <h2 class="blue"><?= $nb_equipements ?></h2>
</a>
<a href="presences_entrainement/pre_lister.php" class="card">
    <span>Présences</span>
    <h2 class="green"><?= $nb_presences ?></h2>
</a>
<a href="participations_match/pa_lister.php" class="card">
    <span>Participation Match</span>
    <h2 class="red"><?= $nb_participations ?></h2>
</a>
<a href="Contrats_sponsors/cs_lister.php" class="card">
    <span>Contrats Sponsors</span>
    <h2 class="red"><?= $nb_contrats_sponsors ?></h2>
</a>
<a href="statistiques_Joueurs/stati_j_lister.php" class="card">
    <span>Statistiques Joueurs</span>
    <h2 class="red"><?= $nb_statistiques_joueurs ?></h2>
</a>
</div>
</body>
</html>