<?php session_start(); ?>

<!DOCTYPE html>
 <html>
 <head>
    <title>EasyDrinks - Compte</title>
    <meta charset="utf-8" />

    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    <script type="text/javascript" src="fonctions.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
    <script type="text/javascript">

        function mettreAJourRecettes(){
            $.post("recettesSession.php", {}, function(data, status){
                $('.containerRecettes').empty();
                $('.containerRecettes').append(data);
            });
        }

        $(document).on('click', '.boiteRecette', function(){
                afficherRecette($(".titreRecette", this).text());
            });

        $(document).on('click', '.imageFavRecette', function(){
            mettreAJourFavori($(this));
            stopPropagation();
            mettreAJourRecettes();
        });

        mettreAJourRecettes();
    </script>
 </head>
 <body>
    <div class="grid-container">
        <div class="header"> 
                <a href="./index.php?#" class="titre"> <h1> Easy Drinks </h1> </a>
                <?php
                if(isset($_SESSION['login'])){
                    echo 'Connecté en tant que '.$_SESSION['login'];
                }
                ?> 
                <div class="topRight">
                    <a href="panier.php"><img src="img/panier.png" alt="login" class="imageLogin"></a>
                    <a href=<?php echo (isset($_SESSION['login']) ? "./compte/compte.php" : "./compte/login.php"); ?> ><img src="img/login.png" alt="login" class="imageLogin"></a>
                </div>
                
            </div>


        <div class="menu">

        </div>


        <div class="main">
                <div class="containerRecettes">
                    
                </div>
                <div class="contenuRecette"></div>
        </div>

        <div class="right">

        </div>

        <div class="footer">
        </div>
    </div>
</body>
</html>