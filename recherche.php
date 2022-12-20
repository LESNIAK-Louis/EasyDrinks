<?php

require 'fonctions.php';


if(!empty($_POST['recherche'])){

    $toDisplay = rechercherContenuRecette(trim($_POST['recherche']));
    $resultat = displayRecettes($toDisplay);
    echo $resultat;
}

?>