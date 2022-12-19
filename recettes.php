<?php
    function getFeuilles($categorie) {
        require 'Donnees.inc.php';
        $leafs = array();

        $currentCateg = $Hierarchie[$categorie];
        if (array_key_exists('sous-categorie', $currentCateg)) {
            foreach ($currentCateg['sous-categorie'] as $c) {
                $leafs = array_merge($leafs, getFeuilles($c));
                $leafs = array_unique($leafs, SORT_REGULAR);
            }
        }
        else{
            if(!in_array($categorie, $leafs)){
                $leafs[] = $categorie;
            }
        }

        return $leafs;
    }              
    
    function getRecettes($ingredients){
        require 'Donnees.inc.php';
        $recettes = array();
        foreach($Recettes as $recette){
            foreach($recette['index'] as $ingre){
                if(in_array($ingre,$ingredients) && !in_array($recette, $recettes))
                    $recettes[] = $recette;
            }
        }
        return $recettes;
    }

    function displayRecettes($display)
    {
        require 'Donnees.inc.php';

        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'ç'=>'c',
                                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', ' ' => '_', '\'' => '', '"' => '' );


        $resultat = '';
        foreach($display as $recette)
        {
            $sansAccents = strtr($recette['titre'], $unwanted_array);
            $nomBoisson = ucwords(strtolower($sansAccents));

            $resultat .= '<div class="boiteRecette">
                    <img src="Photos/'.(file_exists('Photos/'.$nomBoisson.'.jpg')?$nomBoisson:'Notfound').'.jpg" alt="'.$nomBoisson.'" class="imageRecette">
                    <div class="boiteTitreRecette">
                        <p class="titreRecette">'.$recette['titre'].'</p>
                    </div>
                </div>';
        }
        return $resultat;
    }


    $leafs = getFeuilles($_POST['current']);
    $toDispay = getRecettes($leafs);
    $resultat = displayRecettes($toDispay);
    echo $resultat;
?>