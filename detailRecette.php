<?php

require 'Donnees.inc.php';
require 'fonctions.php';

foreach($Recettes as $recette){
    if($recette['titre'] == $_POST['current'])
    {
        try{
            $recettePhoto = $recette;
            $recettePhoto['image'] = getImage($recette);
            echo json_encode($recettePhoto);
        }catch(Exception $e){
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                ),));
        }
    }
}

?>