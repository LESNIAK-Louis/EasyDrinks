<?php

function getSousCategories($categorie){

    require 'Donnees.inc.php';

    $sousCateg = array();

    $currentCateg = $Hierarchie[$categorie];
    if (array_key_exists('sous-categorie', $currentCateg)) {
        foreach ($currentCateg['sous-categorie'] as $c) {
            $sousCateg[] = $c;
            $sousCateg = array_merge($sousCateg, getSousCategories($c));
            $sousCateg = array_unique($sousCateg, SORT_REGULAR);
        }
    }
    else{
        if(!in_array($categorie, $sousCateg)){
            $sousCateg[] = $categorie;
        }
    }

    return $sousCateg;
}

function getFeuilles($categorie) {
    require 'Donnees.inc.php';
    $leafs = array();

    if(array_key_exists($categorie, $Hierarchie)){
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

function getRecetteId($titre){
    require 'Donnees.inc.php';
    foreach($Recettes as $recette){
        if($recette['titre'] == $titre)
        {
            if(($key = array_search($recette, $Recettes)) !== false)
                return $key;
        }
    }
}

function displayRecettes($display, $path)
{
    require 'Donnees.inc.php';

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

    $resultat = '';
    foreach($display as $recette)
    {
        $imgFav = 'etoile_vide.png';
        if(isset($_SESSION['favoris']) && in_array(getRecetteId($recette['titre']), $_SESSION['favoris']))
            $imgFav = 'etoile_pleine.png';


        $resultat .= '<div class="boiteRecette">'.
                '<img src="'.$path.'img/'.$imgFav.'" alt="Image Favori Recette" class="imageFavRecette">'
                .getImage($recette, $path).'
                <div class="boiteTitreRecette">
                    <p class="titreRecette">'.$recette['titre'].'</p>
                </div>
            </div>';
    }

    return $resultat;
}

function displayResultatRecherche($resultatRecherche, $totalCriteres){

    $resultat = '';
    foreach($resultatRecherche as $nbCriteres => $recettes){

        $resultat .= '<p class="separateurResultat"> Résultats qui satisfont '.$nbCriteres.' critère'.($nbCriteres > 1 ? 's' : '').' sur '.$totalCriteres.': </p>';
        $resultat .= displayRecettes($recettes, '');
    }

    if(count($resultatRecherche) == 0){
        $resultat = '<p class="separateurResultat">Aucun résultat</p>';
    }
    return $resultat;
}

function getImage($recette, $path){
    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
    'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
    'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'ç'=>'c',
    'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
    'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', ' ' => '_', '\'' => '', '"' => '' );


    $sansAccents = strtr($recette['titre'], $unwanted_array);
    $nomBoisson = ucwords(strtolower($sansAccents));
    $img = '<img src="'.(file_exists($path.'Photos/'.$nomBoisson.'.jpg') ? $path.'Photos/'.$nomBoisson : $path.'img/Notfound').'.jpg" alt="'.$nomBoisson.'" class="imageRecette">';
    return $img;
}

function rechercherCategorieRecette($mot){
    require 'Donnees.inc.php';

    $res = array();
    $motif = '/^'.$mot.'.*/i';

    foreach($Hierarchie as $c => $a){
        if(preg_match($motif, $c, $match)){
            $res[] = $match[0];
        }
    }

    return $res;
}

function rechercherContenuRecette($mot){
    require 'Donnees.inc.php';

    $res = array();
    $motifTitre = '/^'.$mot.'.*/i';
    $leafs = getFeuilles($mot);

    foreach($Recettes as $i => $r){
        if(preg_match($motifTitre, $r['titre'], $match)){
            $res[] = $r;
        }
        foreach($leafs as $f){
            $motifFeuille = '/.*'.$f.'.*/i';
            foreach($r['index'] as $ingredient){
                if(preg_match($motifFeuille, $ingredient, $match)){
                    $res[] = $r;
                }
            }
        }
    }

    $res = array_unique($res, SORT_REGULAR);

    return $res;
}

?>