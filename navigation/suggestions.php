<?php

require '../fonctions.php';

if(!empty($_POST['recherche'])){

    $result = rechercherCategorieRecette($_POST['recherche']);
    if(!empty($result)){
        foreach ($result as $s) {
            echo '<div class="autocomplete-items">'.$s.'</div>';
        } 
        
    }
}
?>