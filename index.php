<?php
require 'Donnees.inc.php';

$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', ' ' => '_', '\'' => '', '"' => '' );


echo '
        <html>
        <head>
            <title>EasyDrinks</title>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
        </head>
        
        <body>';         
        
        foreach($Recettes as $recette)
        {
            $sansAccents = strtr($recette['titre'], $unwanted_array );
            $nomBoisson = ucwords(strtolower($sansAccents));

            echo '<div class="boiteRecette">
                    <img src="Photos/'.(file_exists('Photos/'.$nomBoisson.'.jpg')?$nomBoisson:'Notfound').'.jpg" alt="'.$nomBoisson.'" class="imageRecette">
                    <div class="boiteTitreRecette">
                        <p class="titreRecette">'.$recette['titre'].'</p>
                    </div>
                   </div>';
        }
        echo '        
        </body>
        </html>
        ';
?>