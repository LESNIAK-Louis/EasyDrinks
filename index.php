<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>EasyDrinks</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
    <script type="text/javascript" src="fonctions.js"></script>
    <script type="text/javascript">

        let histo = new Array(' ');
        let ingredients = new Array();


        $(document).ready(function(){

            $(document).on('click', '.categorie', function(){
                $('.containerRecettes').show();
                $('.contenuRecette').hide();
                mettreAJourCategories($(this).text(), histo);
                mettreAJourRecettes($(this).text());
            });

            $(document).on('click', '.histo', function(){
                $('.containerRecettes').show();
                $('.contenuRecette').hide();
                mettreAJourHistorique($(this).text(), histo);
                mettreAJourRecettes($(this).text());
            });

            $(document).on('click', '.boiteRecette', function(){
                afficherRecette($(".titreRecette", this).text(), '');
            });

            $(document).on('click', '.imageFavRecette', function(){
                mettreAJourFavori($(this));
                stopPropagation();
            });

            $('#champRecherche').keyup( function(){
                let mot = $(this).val();
                $.post("navigation/suggestions.php",
                {
                    recherche: mot
                }, function(data, status){
                    $(".autocomplete-items").remove();
                    $('.autocomplete').append(data);
                });
            });

            $(document).on('click', '.autocomplete-items', function(){
                selectSuggestion($(this).text());
            });
            
            $(document).on('click', '#boutonRechercheRecette', function(){
                $('.containerRecettes').show();
                $('.contenuRecette').hide();
                $('#champRecherche').val("");
                $(".autocomplete-items").remove();
                effectuerRecherche(ingredients, histo);
            });

            $(document).on('click', '#ajouterIngredient', function(){
                let ing = $('#champRecherche').val();
                if(!ingredients.includes(ing) && !ingredients.includes("Sans " + ing)){
                    ingredients.push(ing);
                    mettreAJourIngredients(ingredients);
                }
                $('#champRecherche').val("");
                $(".autocomplete-items").remove();
            });

            $(document).on('click', '#ajouterPasIngredient', function(){
                let ing = $('#champRecherche').val();
                if(!ingredients.includes(ing) && !ingredients.includes("Sans " + ing)){
                    ingredients.push("Sans " + ing);
                    mettreAJourIngredients(ingredients);
                }
                $('#champRecherche').val("");
                $(".autocomplete-items").remove();
            });

            $(document).on('click', '.retirerIngredient', function(){
                let ing = $(this).siblings('span').text();
                if(ingredients.includes(ing)){
                    let index = ingredients.indexOf(ing);
                    ingredients.splice(index, 1);
                    mettreAJourIngredients(ingredients);
                }
                $('#champRecherche').val("");
                $(".autocomplete-items").remove();
            });
            
            mettreAJourCategories('Aliment', histo);
            mettreAJourHistorique('Aliment', histo);
            mettreAJourRecettes('Aliment');
            mettreAJourIngredients(ingredients);
        });

        
    </script>
</head>
<body>
    <div class="grid-container">

        <div class="header"> 
            <a href="./index.php?#" class="titre"> </a>
            <div class="topRight">
                <a href="panier.php"><img src="img/panier.png" alt="login" class="imageLogin"></a>
                <a href=<?php echo (isset($_SESSION['login']) ? "./compte/compte.php" : "./compte/login.php"); ?> ><img src="img/login.png" alt="login" class="imageLogin"></a>
                <?php
                    if(isset($_SESSION['login'])){
                        echo '<p>Connect?? en tant que <b>'.$_SESSION['login'].'</b></p>';
                    }
                ?> 
            </div>
            
        </div>


        <div class="menu">
            
            <div id="titreMenu" class="sousTitre">Ingr??dients</div>
            <div class="listeCategories">
                <div class="categorie">
                    <a class="boutonMenu" href="#">Aliment</a>
                </div>
            </div>
        </div>


        <div class="main">
            <ul class="navigation">

            </ul>
            <div class="containerRecettes"></div>
            <div class="contenuRecette"></div>
        </div>

        <div class="right">
            <div id="titreRight" class="sousTitre">Recherche</div>
            <form class="rechercheTexte" autocomplete="off">
                <div class="autocomplete">
                    <input type="text" id="champRecherche" placeholder="Ingr??dient">
                </div>
                <button id="ajouterIngredient" title="Avec">+</button>
                <button id="ajouterPasIngredient" title="Sans">x</button>
            </form>
            <div class="listeIngredients">
                <p>Aucun ingr??dient s??lectionn??</p>
            </div>
            <form class="rechercheRecettes">
                <button id="boutonRechercheRecette"> Rechercher des recettes </button>
            </form>
        </div>

        <div class="footer">
        </div>
        
    </div>
    </body>
</html>