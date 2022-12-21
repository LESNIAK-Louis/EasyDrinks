<?php
session_start();

require 'fonctions.php';
require 'db.php';

    $recetteId = getRecetteId($_POST['current']);
    $etoile = 'img/etoile_pleine.png';

    if(isset($recetteId))
    { 
        if(isset($_SESSION['favoris'])){
            
            $favoris = $_SESSION['favoris'];
            if(in_array($recetteId, $favoris) && ($key = array_search($recetteId, $favoris)) !== false){
                unset($favoris[$key]);
                $etoile = 'img/etoile_vide.png';

                if(isset($_SESSION['login'])){
                    supprimerDuPanier($_SESSION['login'], $recetteId);
                }
            }
            else{
                $favoris[] = $recetteId;

                if(isset($_SESSION['login'])){
                    ajouterAuPanier($_SESSION['login'], $recetteId);
                }
            }
        }
        else{
            $favoris = array();
            $favoris[] = $recetteId;

            if(isset($_SESSION['login'])){
                ajouterAuPanier($_SESSION['login'], $recetteId);
            }
        }
        $_SESSION['favoris'] = $favoris;
    }

    echo $etoile;
?>
