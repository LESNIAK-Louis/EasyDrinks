<?php session_start(); ?>
<!DOCTYPE html>
 <html>
 <head>
    <title>EasyDrinks - Compte</title>
    <meta charset="utf-8" />

    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
    <script type="text/javascript">

        
    </script>

 </head>
 <body>
    <div class="header"> 
        <a href="./index.php?#" class="titre"> <h1> Easy Drinks </h1> </a>
        <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
            }
            ?> 
        
    </div>


    <div class="menu">

    </div>


    <div class="main">
        <h1>Informations du compte</h1>

        <?php

            require 'db.php';

            if(isset($_SESSION['login'])){

                $login = $_SESSION['login'];

                $utilisateur = getUtilisateur($login);

                $nom = 'Non renseigné';
                $prenom = 'Non renseigné';
                $sexe = 'Non renseigné';
                $ddn = 'Non renseigné';
                $email = 'Non renseigné';
                $adresse = 'Non renseigné';
                $cp = 'Non renseigné';
                $ville = 'Non renseigné';
                $noTel = 'Non renseigné';
                
                if(isset($utilisateur['nom'])){
                    $nom = $utilisateur['nom'];
                }
                if(isset($utilisateur['prenom'])){
                    $prenom = $utilisateur['prenom'];
                }

                if($utilisateur['sexe'] == 'h'){
                    $sexe = 'Homme';
                }else if($utilisateur['sexe'] == 'f'){
                    $sexe = 'Femme';
                }

                if(isset($utilisateur['ddn'])){
                    list($Annee,$Mois,$Jour) = explode('-',$utilisateur['ddn']);
                    $ddn = $Jour.'/'.$Mois.'/'.$Annee;
                }

                if(isset($utilisateur['ddn'])){
                    $ddn = $utilisateur['ddn'];
                }

                if(isset($utilisateur['email'])){
                    $email = $utilisateur['email'];
                }

                if(isset($utilisateur['adresse'])){
                    $adresse = $utilisateur['adresse'];
                }

                if(isset($utilisateur['cp'])){
                    $cp = $utilisateur['cp'];
                }

                if(isset($utilisateur['ville'])){
                    $ville = $utilisateur['ville'];
                }

                if(isset($utilisateur['noTel'])){
                    $noTel = $utilisateur['noTel'];
                }

                echo '
                    <p>Login : '.$login.'</p>
                    <p>Nom : '.$nom.'</p>
                    <p>Prénom : '.$prenom.'</p>
                    <p>Sexe : '.$sexe.'</p>
                    <p>Date de naissance : '.$ddn.'</p>
                    <p>Email : '.$email.'</p>
                    <p>Adresse : '.$adresse.'</p>
                    <p>Code postal : '.$cp.'</p>
                    <p>Ville : '.$ville.'</p>
                    <p>Téléphone : '.$noTel.'</p>
                ';
            }
        ?>
    </div>

    <div class="right">

    </div>

    <div class="footer">
    </div>
</body>
</html>