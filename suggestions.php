<?php

function rechercherDebut($mot){
    require 'Donnees.inc.php';

    $res = array();
    $motif = '/^'.$mot.'.*/i';

    foreach($Recettes as $i => $r){
        if(preg_match($motif, $r['titre'], $match)){
            $res[] = $match[0];
        }
    }

    foreach($Hierarchie as $c => $a){
        if(preg_match($motif, $c, $match)){
            $res[] = $match[0];
        }
    }

    return $res;
}

if(!empty($_POST['recherche'])){

    $result = rechercherDebut($_POST['recherche']);
    if(!empty($result)){
        foreach ($result as $s) {
            echo '<div class="autocomplete-items"> '.$s.'</div>';
        } 
        
    }
}
?>