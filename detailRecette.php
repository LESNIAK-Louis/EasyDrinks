<?php

require 'Donnees.inc.php';
require 'fonctions.php';

foreach($Recettes as $recette){
    if($recette['titre'] == $_POST['current'])
    {
        try{
            $recettePhoto = $recette;

            $path = '';
            if(isset($_POST['pathImg']))
                $path = $_POST['pathImg'];

            $recettePhoto['image'] = getImage($recette, $path);
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