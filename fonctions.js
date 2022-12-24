function mettreAJourAffichage(categorie, histo){
    $('.listeCategories').empty();
    $('.navigation').empty();
    jQuery.each(categorie, function(index, value){
        $('.listeCategories').append("<div class='categorie'>" + value + "</div>");
        
    });
    histo.forEach(function(item, index, histo){
        $('.navigation').append("<li><a class='histo' href='#'>" + item + "</a></li>")
    });
}

function mettreAJourCategories(categorieActuelle, histo){
    $.post("navigation/nav.php", 
    {
        current: categorieActuelle
    }, function(data, status){
        
        let res = JSON.parse(data);
        if(!res.error){
            
            if(!histo.includes(categorieActuelle)){
                histo.push(categorieActuelle);
            }
            mettreAJourAffichage(res, histo);
        }
    });
}

function mettreAJourHistorique(categorieActuelle, histo){
    let removeIndex = histo.indexOf(categorieActuelle) + 1;
    histo.splice(removeIndex, histo.length - removeIndex);
    $.post("navigation/nav.php", 
    {
        current: categorieActuelle
    }, function(data, status){
        mettreAJourAffichage(JSON.parse(data), histo);
    });
}

function mettreAJourIngredients(ingredients){
    $('.listeIngredients').empty()
    ingredients.forEach(function(item, index, ingredients){
        $('.listeIngredients').append("<div class='ingredientItem'><button class='retirerIngredient'>X</button><span class='texteIngredient'>" + item + "</span></div>");
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
        current: recetteActuelle,
    }, function(data, status){
        const res = JSON.parse(data);
        if(!res.error){
            $('.containerRecettes').hide();
            $('.contenuRecette').show();
            $('.contenuRecette').empty();

            var contenu = '<div class="detailsRecette1">' +
                            '<h1 class="titreDetailsRecette">' + res.titre + '</h1>' + '<br>' +
                            res.image +
                            '</div>' +
                            '<div class="detailsRecette2">' +
                            '<h2>' + 'Liste des ingrédients' + '</h2>' + '<br>' +
                            '<ul class =\'ulIngredients\' ></ul>';

            var ingredients = res.ingredients.split('|');
            for (let i = 0; i < ingredients.length; ++i) {
                contenu += '<li>' + ingredients[i] + '</li>';
            }

            contenu += '</div>' +
                        '<div class="detailsRecette3">' +
                        '<h2>' + 'Préparation' + '</h2>' + '<br>' +
                        '<ol class=\'olPreparation\'></ol>';
            
            var preparation = res.preparation.split(/[.!]/);
            for (let i = 0; i < preparation.length; ++i) {
                if(preparation[i] != '')
                    contenu += '<li>' + preparation[i] + '</li>';
            }

            contenu += '</div>';

            $('.contenuRecette').append(contenu);
        } 
    });
}

function selectSuggestion(val) {
    $("#champRecherche").val(val);
    $(".autocomplete-items").remove();
}

function effectuerRecherche(liste, histo){
    $.post("recherche.php", 
        {
            recherche: liste
        }, function(data, status){

            $('.containerRecettes').empty();
            $('.containerRecettes').append(data);
            mettreAJourHistorique('Aliment', histo);
            
        });
}

function ucfirst(str){
    const strUcFirst = str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    return strUcFirst;
}

function mettreAJourFavori(imageFavRecette){
    boiteRecette = imageFavRecette.parent().get(0);
    titreRecette = $(".titreRecette", boiteRecette).text();

    $.post("favori.php", 
    {
        current: titreRecette
    }, function(data, status){
        $(".imageFavRecette", boiteRecette).attr("src", data)
    });
}