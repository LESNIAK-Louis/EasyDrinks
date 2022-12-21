<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>EasyDrinks</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
    <script type="text/javascript">

        let histo = new Array(' ');
        let ingredients = new Array();

        function mettreAJourAffichage(categorie){
            $('.listeCategories').empty();
            $('.navigation').empty();
            jQuery.each(categorie, function(index, value){
                $('.listeCategories').append("<div class='categorie'> <a class='boutonMenu' href='#'>" + value + "</a> </div>");
                
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
                    
                    if(!histo.includes(categorieActuelle)){
                        histo.push(categorieActuelle);
                    }
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

        function mettreAJourIngredients(nouvelIngredient){
            $('.listeIngredients').empty()
            ingredients.forEach(function(item, index, ingredients){
                $('.listeIngredients').append("<div class='ingredientItem'><button class='retirerIngredient'>X</button><p>" + item + "</p></div>");
            });
            if(ingredients.length == 0){
                $('.listeIngredients').append("<p>Aucun ingrédient sélectionné</p>");
                $('#boutonRechercheRecette').hide();
            }else{
                $('#boutonRechercheRecette').show();
            }
        }

        function mettreAJourRecettes(categorieActuelle){
            $.post("recettes.php", 
            {
                current: categorieActuelle
            }, function(data, status){
                $('.containerRecettes').empty();
                $('.containerRecettes').append(data);
            });
        }

        function afficherRecette(recetteActuelle){
            $.post("detailRecette.php", 
            {
                current: recetteActuelle
            }, function(data, status){
                const res = JSON.parse(data);
                if(!res.error){
                    $('.containerRecettes').hide();
                    $('.contenuRecette').show();
                    $('.contenuRecette').empty();

                    $('.contenuRecette').append( '<h1>' + res.titre + '</h1>' + '<br>'); // Titre

                    $('.contenuRecette').append(res.image); // Image

                    // Ingrédients
                    $('.contenuRecette').append('<h2>' + 'Liste des ingrédients' + '</h2>' + '<br>' +
                    '<ul class =\'ulIngredients\' ></ul>'
                    );
                    var ingredients = res.ingredients.split('|');
                    for (let i = 0; i < ingredients.length; ++i) {
                        $('.ulIngredients').append('<li>' + ingredients[i] + '</li>');
                    }

                    // Préparation
                    $('.contenuRecette').append(
                        '<h2>' + 'Préparation' + '</h2>' + '<br>' +
                        '<ol class=\'olPreparation\'></ol>'
                    );
                    var preparation = res.preparation.split(/[.!]/);
                    for (let i = 0; i < preparation.length; ++i) {
                        if(preparation[i] != '')
                            $('.olPreparation').append('<li>' + preparation[i] + '</li>');
                    }
                   
                } 
            });
        }

        function selectSuggestion(val) {
            $("#champRecherche").val(val);
            $(".autocomplete-items").remove();
        }

        function effectuerRecherche(liste){
            $.post("recherche.php", 
                {
                    recherche: liste
                }, function(data, status){

                    $('.containerRecettes').empty();
                    $('.containerRecettes').append(data);
                    mettreAJourHistorique('Aliment');
                    
                });
        }

        function ucfirst(str){
            const strUcFirst = str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
            return strUcFirst;
        }

        function mettreAJourFavori(imageFavRecette){
            $boiteRecette = imageFavRecette.parent().get(0);
            $titreRecette = $(".titreRecette", $boiteRecette).text();
        }


        $(document).ready(function(){

            $(document).on('click', '.boutonMenu', function(){
                $('.containerRecettes').show();
                $('.contenuRecette').hide();
                mettreAJourCategories($(this).text());
                mettreAJourRecettes($(this).text());
            });

            $(document).on('click', '.histo', function(){
                $('.containerRecettes').show();
                $('.contenuRecette').hide();
                mettreAJourHistorique($(this).text());
                mettreAJourRecettes($(this).text());
            });

            $(document).on('click', '.boiteRecette', function(){
                afficherRecette($(".titreRecette", this).text());
            });

            $(document).on('click', '.imageFavRecette', function(){
                mettreAJourFavori($(this));
                stopPropagation();
            });

            $('#champRecherche').keyup( function(){
                let mot = $(this).val();
                $.post("suggestions.php",
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
                effectuerRecherche(ingredients);
            });

            $(document).on('click', '#ajouterIngredient', function(){
                let ing = ucfirst($('#champRecherche').val());
                if(!ingredients.includes(ing) && !ingredients.includes("Sans " + ing)){
                    ingredients.push(ing);
                    mettreAJourIngredients();
                }
                $('#champRecherche').val("");
                $(".autocomplete-items").remove();
            });

            $(document).on('click', '#ajouterPasIngredient', function(){
                let ing = ucfirst($('#champRecherche').val());
                if(!ingredients.includes(ing) && !ingredients.includes("Sans " + ing)){
                    ingredients.push("Sans " + ing);
                    mettreAJourIngredients();
                }
                $('#champRecherche').val("");
                $(".autocomplete-items").remove();
            });

            $(document).on('click', '.retirerIngredient', function(){
                let ing = $(this).siblings('p').text();
                if(ingredients.includes(ing)){
                    let index = ingredients.indexOf(ing);
                    ingredients.splice(index, 1);
                    mettreAJourIngredients();
                }
                $('#champRecherche').val("");
                $(".autocomplete-items").remove();
            });
            
            mettreAJourCategories('Aliment');
            mettreAJourHistorique('Aliment');
            mettreAJourRecettes('Aliment');
            mettreAJourIngredients();
        });

        
    </script>
</head>
<body>
    <div class="grid-container">

        <div class="header"> 
            <a href="./index.php?#" class="titre"> <h1> Easy Drinks </h1> </a>
            <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
            }
            ?> 
            <div class="topRight">
                <a href="./panier.php"><img src="img/panier.png" alt="login" class="imageLogin"></a>
                <a href="./login.php"><img src="img/login.png" alt="login" class="imageLogin"></a>
            </div>
            
        </div>


        <div class="menu">
            

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
            <form class="rechercheTexte" autocomplete="off">
                <div class="autocomplete">
                    <input type="text" id="champRecherche">
                </div>
                <button id="ajouterIngredient">+</button>
                <button id="ajouterPasIngredient">-</button>
            </form>
            <div class="listeIngredients">
                <p>Aucun ingrédient sélectionné</p>
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