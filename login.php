<!DOCTYPE html>
 <html>
 <head>
    <title>EasyDrinks - Compte</title>
    <meta charset="utf-8" />

    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    <style type="text/css">
    .ok {
    }
    .error
    { 
        background-color: red;
    }
    </style>
 </head>
 <body>
    <div class="header"> 
        <a href="./index.php?#" class="titre"> <h1> Easy Drinks </h1> </a>
        
    </div>


    <div class="menu">

    </div>


    <div class="main">
        <h1>S'identifier</h1>

        <form method="post" action="#" >
            <fieldset>
            <legend>Informations personnelles</legend>

            Login : 
            <input type="text" class="<?php echo $ClassLogin; ?>" name="login"
            value="<?php if(isset($_POST['login'])) echo $_POST['login']; ?>"
            required="required" />

            <br/>

            Mot de passe (8 caractères minimum) :
            <input type="password" id="pass" name="password"
            class="<?php echo $ClassMdp; ?>"
            value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>"
            required="required" />

        </fieldset>
        <br/>

        <input type="submit" name="submit" value="Valider" />
        <a href="register.php">S'enregistrer</a>
        </form>
    </div>

    <div class="right">

    </div>

    <div class="footer">
    </div>
</body>
</html>


<?php

require 'db.php';

/* Reprise de la correction, car mon ancien code était confu
   ce travail n'a PAS été réalisé par mes soins
*/

// Vérification du formulaire
 $ClassLogin='ok';
 $ClassMdp='ok';
 $ChampsIncorrects='';

 if(isset($_POST['submit'])) // le formulaire vient d'être soumis
 {
    $ClassLogin='ok';
    $ClassMdp='ok';
    $ChampsIncorrects='';


    // Vérification du login
    if((isset($_POST['login']))) 
    { 
        $login = strtolower(trim($_POST['login']));

        if ((strlen($login)<2)  // le login est trop court
        || !preg_match("/^[^\W]+\.?(?:[- ][^\W]+)*$/i", $login)) // lettres, chiffres, underscores, accents, points, espaces
        {
            $ChampsIncorrects=$ChampsIncorrects.'<li>login</li>';
            $ClassLogin='error';
        }
    }

    // Vérification du password
    if((isset($_POST['password'])))
    { 
        $password = strtolower(trim($_POST['password']));

        if (!preg_match("/^([^\W]|[!#$\*%{}\^&?\.\s-]){8}([^\W]|[!#$\*%{}\^&?\.\s-])*$/i", $password)) // lettres, chiffres, underscores, accents, points et caractères dans l'ensemble {!#$*%^&?.-} (8 caractères mini)
        {
            $ChampsIncorrects=$ChampsIncorrects.'<li>mdp (8 caractères minimum composé de lettres, chiffres, underscores, accents, points et caractères dans l\'ensemble {!#$*%^&?.-})</li>';
            $ClassLogin='error';
        }
    }

    // Login dans la bdd
    if($ChampsIncorrects=='')
    { 
        if(tentativeConnexion($login, $password)){

            echo 'Connexion réussie';

        }else{
            echo '
                <br />
                L\'utilisateur ou le mot de passe est incorrect';
        }   
        exit;
    }
}
 ?>


 <?php
 if(isset($_POST['submit'])) // le formulaire a été soumis (et est incorrect)
 { 
    echo '
    <br />
    L\'utilisateur ou le mot de passe est incorrect';
 }
 ?>