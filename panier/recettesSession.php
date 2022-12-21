<?php
session_start();
require '../fonctions.php';
require '../Donnees.inc.php';

    if(isset($_SESSION['favoris'])){
        $toDisplay = array();

        $favs = $_SESSION['favoris'];
        foreach($favs as $fav){
            $toDisplay[] = $Recettes[$fav];
        }
   
        $resultat = displayRecettes($toDisplay, '../');
        echo $resultat;
    }
    else{
        echo 'Panier vide';
    }
?>