<!DOCTYPE html>
<html>
<head>
    <title>EasyDrinks</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
    <script type="text/javascript">

        let histo = new Array(' ');

        function mettreAJourAffichage(categorie){
            $('.listeCategories').empty();
            $('.navigation').empty();
            jQuery.each(categorie, function(index, value){
                $('.listeCategories').append("<div class='categorie'> <a class='boutonMenu' href='#'>" + value + "</a></div>");
                
            });
            histo.forEach(function(item, index, histo){
                $('.navigation').append("<li><a class='histo' href='#'>" + item + "</a></li>")
            });
        }

        function mettreAJourCategories(categorieActuelle){
            $.post("nav.php", 
            {
                current: categorieActuelle
            }, function(data, status){
                
                let res = JSON.parse(data);
                if(!res.error){
                    
                    histo.push(categorieActuelle);
                    mettreAJourAffichage(res);
                }
            });
        }

        function mettreAJourHistorique(categorieActuelle){
            let removeIndex = histo.indexOf(categorieActuelle) + 1;
            histo.splice(removeIndex, histo.length - removeIndex);
            $.post("nav.php", 
            {
                current: categorieActuelle
            }, function(data, status){
                mettreAJourAffichage(JSON.parse(data));
            });
        }

        $(document).ready(function(){
            $(document).on('click', '.boutonMenu', function(){
                mettreAJourCategories($(this).text());
            });

            $(document).on('click', '.histo', function(){
                mettreAJourHistorique($(this).text());
            });

            mettreAJourCategories('Aliment');
            mettreAJourHistorique('Aliment');
        });

        
    </script>
</head>
<body>
    <div class="grid-container">

        <div class="header"> 
            <h1> Easy Drinks </h1>
        
        </div>


        <div class="menu">
            <form class="rechercheTexte">
                <input type="text" id="champRecherche">
                <button id="boutonRechercheTexte"> Rechercher </button>
            </form>

            <div class="listeCategories">
                <div class="categorie">
                    <a class="boutonMenu" href="#">Aliment</a>
                </div>
            </div>
        </div>


        <div class="main">
            <ul class="navigation">

            </ul>
            <div class="containerRecettes">
                <?php
                    require 'Donnees.inc.php';

                    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                                                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                                                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'ç'=>'c',
                                                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                                                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', ' ' => '_', '\'' => '', '"' => '' );

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
                ?>
            </div>
        </div>

        <div class="right">
            <div class="listeIngredients">
                <p>Ingrédient 1</p>
                <p>Ingrédient 2</p>
                <p>Ingrédient 3</p>
                <form class="rechercheRecettes">
                    <button id="boutonRechercheRecette"> Rechercher des recettes </button>
                </form>
            </div>
        </div>

        <div class="footer">
        </div>
        
    </div>
    </body>
</html>