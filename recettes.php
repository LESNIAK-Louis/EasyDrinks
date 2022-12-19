<?php

require 'fonctions.php';
   
    $leafs = getFeuilles($_POST['current']);
    $toDispay = getRecettes($leafs);
    $resultat = displayRecettes($toDispay);
    echo $resultat;
?>