<?php

require 'fonctions.php';
require 'Donnees.inc.php';

$cpt = array_fill(0, count($Recettes), array());

if(!empty($_POST['recherche'])){

    foreach($_POST['recherche'] as $ing){

        $ning = str_replace('Sans ', '', $ing);

        if(!array_key_exists($ning, $Hierarchie)){
            echo '<p class="separateurResultat">Ingrédients non valides</p>';
            return;
        }
        
        $leafs = getSousCategories($ning);
        foreach($Recettes as $index => $recette){
            $cpt[$index][$ing] = strlen($ning) == strlen($ing) ? 0 : 1;
            foreach($leafs as $f){
                if(in_array($f, $recette['index']) && strlen($ning) == strlen($ing)){
                    $cpt[$index][$ing] = 1;
                }
                if(in_array($f, $recette['index']) && strlen($ning) < strlen($ing)){
                    $cpt[$index][$ing] = 0;
                }
            }
        }
    }
    $res = array();
    foreach($cpt as $index => $recette){
        $res[$index] = array_sum($cpt[$index]);
    }
    arsort($res);
    $maxs = array_filter($res);
    
    $toDisplay = array();
    foreach($maxs as $k => $v){
        $toDisplay[$v][$k] = $Recettes[$k];
    }

    $resultat = displayResultatRecherche($toDisplay, count($_POST['recherche']));
    echo $resultat;
    
}

?>