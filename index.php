<!DOCTYPE html>
<html>
<head>
    <title>EasyDrinks</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('click', '.boutonMenu', function(){
                $.post("nav.php", 
                {
                    current: $(this).text()
                }, function(data, status){
                    
                    res = JSON.parse(data);
                    $('.listeCategories').empty();
                    jQuery.each(res, function(index, value){
                        $('.listeCategories').append("<div class='categorie'> <a class='boutonMenu' href='#'>" + value + "</a></div>");
                    });
                })


                $.post("recettes.php", 
                {
                    current: $(this).text()
                }, function(data, status){
                    alert(data);
                    $('.containerRecettes').empty();
                    $('.containerRecettes').append(data);
                })
            });
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
                <li><a href="#">Catégorie 1</a></li>
                <li><a href="#">Catégorie 2</a></li>
                <li>Catégorie 3</li>
            </ul>
            <div class="containerRecettes">
                
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