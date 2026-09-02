<?php

$mot_de_passe = password_hash("admin123", PASSWORD_DEFAULT);

echo $mot_de_passe;

?>