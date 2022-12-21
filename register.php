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
        <a href="./" class="titre"> <h1> Easy Drinks </h1> </a>
        
    </div>


    <div class="menu">

    </div>


    <div class="main">
        <h1>S'enregistrer</h1>

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
            minlength="8" 
            required="required" />

            <br/>

            Sexe :
            <span class="<?php echo $ClassSexe; ?>">
                <input type="radio" name="sexe" value="f"
                <?php if((isset($_POST['sexe']))&&($_POST['sexe'])=='f') echo 'checked="checked"'; ?>
                /> femme
                <input type="radio" name="sexe" value="h"
                <?php if((isset($_POST['sexe']))&&($_POST['sexe'])=='h') echo 'checked="checked"'; ?>
                /> homme
            </span>

            <br/>

            Nom :
            <input type="text" class="<?php echo $ClassNom; ?>" name="nom"
            value="<?php if(isset($_POST['nom'])) echo $_POST['nom']; ?>"
            placeholder="DUPONT">

            <br/>

            Prénom :
            <input type="text" class="<?php echo $ClassPrenom; ?>" name="prenom"
            value="<?php if(isset($_POST['prenom'])) echo $_POST['prenom']; ?>"
            placeholder="Jean"/>

            <br/>
            
            Adresse Electronique :
            <input type="email" class="<?php echo $ClassEmail; ?>" name="email"
            value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"
            placeholder="jean.dupont@email.com"
            />
            
            <br/>

            Date de naissance :
            <input type="date" class="<?php echo $ClassNaissance; ?>" name="naissance"
            value="<?php if(isset($_POST['naissance'])) echo $_POST['naissance']; ?>"/>

            <br/>

            Adresse Postale (numéro + rue) :
            <input type="text" name="postal"
            value="<?php if(isset($_POST['postal'])) echo $_POST['postal']; ?>"
            class="<?php echo $ClassPostal; ?>"
            placeholder="10 rue jean moulin"/>
            
            <br/>

            Code postal :
            <input id="zip" name="zip" type="text" inputmode="numeric" 
            class="<?php echo $ClassZip; ?>"
            value="<?php if(isset($_POST['zip'])) echo $_POST['zip']; ?>"
            placeholder="54500"/>
            
            <br/>

            Ville :
            <input type="text"name="ville"
            value="<?php if(isset($_POST['ville'])) echo $_POST['ville']; ?>"
            class="<?php echo $ClassVille; ?>"
            placeholder="Vandoeuvre-Lès-Nancy"/>
            
            <br/>

            Téléphone :
            <input id="telephone" name="telephone" type="tel"
            class="<?php echo $ClassTel; ?>"
            value="<?php if(isset($_POST['telephone'])) echo $_POST['telephone']; ?>"
            placeholder="+33000000000"/>

        
        </fieldset>
        <br/>
        <input type="submit" name="submit" value="Valider" />
        </form>
    </div>

    <div class="right">

    </div>

    <div class="footer">
    </div>
</body>
</html>


<?php

/* Reprise de la correction, car mon ancien code était confu
   ce travail n'a PAS été réalisé par mes soins
*/

// Vérification du formulaire
 $ClassLogin='ok';
 $ClassMdp='ok';
 $ClassSexe='ok';
 $ClassNom='ok';
 $ClassPrenom='ok';
 $ClassNaissance='ok';
 $ClassPostal='ok';
 $ClassZip='ok';
 $ClassVille='ok';
 $ClassTel='ok';
 $ChampsIncorrects='';

 if(isset($_POST['submit'])) // le formulaire vient d'être soumis
 {
    $ClassLogin='ok';
    $ClassMdp='ok';
    $ClassSexe='ok';
    $ClassNom='ok';
    $ClassPrenom='ok';
    $ClassNaissance='ok';
    $ClassPostal='ok';
    $ClassZip='ok';
    $ClassVille='ok';
    $ClassTel='ok';
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


    // Vérification du nom
    if((isset($_POST['nom'])) && $_POST['nom'] != '')
    { 
        $nom = strtolower(trim($_POST['nom']));

        if ((strlen($nom)<2)  // le nom est trop court
        || !preg_match("/^[^\W\d_]+\.?(?:[- ][^\W\d_]+\.?)*$/i", $nom)) // lettres, tirets, accents, espaces
        {
            $ChampsIncorrects=$ChampsIncorrects.'<li>nom</li>';
            $ClassNom='error';
        }
    }

    // Vérification du prenom 
    if(isset($_POST['prenom']) && $_POST['prenom'] != '')
    { 
        $Prenom=strtolower(trim($_POST['prenom'])); // suppression des espaces devant et derrière
        if(!preg_match("/^[^\W\d_]+?(?:[- ][^\W\d_]+\.?)*$/i", $Prenom)) // lettres, tirets, accents, espaces
        {   
            $ChampsIncorrects=$ChampsIncorrects.'<li>prénom</li>';
            $ClassPrenom='error';
        }
    }


    // Vérification de la date de naissance
    if(isset($_POST['naissance']) && (trim($_POST['naissance']) !='')) // naissance vide
    {
        list($Annee,$Mois,$Jour)=explode('-',$_POST['naissance']);
        if(!checkdate($Mois,$Jour,$Annee))
        { 
            $ChampsIncorrects=$ChampsIncorrects.'<li>date de naissance</li>';
            $ClassNaissance='error';
        }
    }

     // Vérification de l'adresse postale
     if(isset($_POST['postal']) && $_POST['postal'] != '')
     { 
         $postal = strtolower(trim($_POST['postal']));
         if(!preg_match("/^\d+([^\W\d_]|[\s])+\.?(?:[- ]([^\W\d_]|[\s])+\.?)*$/i", $postal)) // nombre suivis d'espaces, lettres, tirets, points, accents
         {
             $ChampsIncorrects=$ChampsIncorrects.'<li>adresse postale</li>';
             $ClassPostal='error';
         }
     }

    // Vérification du code postal
    if(isset($_POST['zip']) && $_POST['zip'] != '')
    { 
        $zip = trim($_POST['zip']);
        if(!preg_match("/[0-9]+/i", $zip)) // que des chiffres (au moins 1)
        {
            $ChampsIncorrects=$ChampsIncorrects.'<li>code postal</li>';
            $ClassPostal='error';
        }
    }

    // Vérification de la ville
    if(isset($_POST['ville']) && $_POST['ville'] != '')
    { 
        $ville = strtolower(trim($_POST['ville']));
        if(!preg_match("/^[^\W\d_]+\.?(?:[-\s][^\W\d_]+\.?)*$/i", $ville)) // nombre suivis d'espaces, lettres, tirets, points, accents
        {
            $ChampsIncorrects=$ChampsIncorrects.'<li>ville</li>';
            $ClassVille='error';
        }
    }


    // Vérification téléphone
    if(isset($_POST['telephone']) && $_POST['telephone'] != '')
    { 
        $tel = strtolower(trim($_POST['telephone']));

        if(!preg_match("/^[\+|0][0-9]+$/", $tel)) // Commence par + ou 0 et suivi de chiffres
        {
            $ChampsIncorrects=$ChampsIncorrects.'<li>téléphone</li>';
            $ClassTel = 'error';
         }
    
    }

    // Sauvegarde des données
    if($ChampsIncorrects=='')
    { 
        echo 'Formulaire bien rempli';
        exit;
    }
}
 ?>


 <?php
 if(isset($_POST['submit'])) // le formulaire a été soumis (et est incomplet)
 { 
    echo '
    <br />
    Merci de remplir correctement les champs ci-dessous :
    <ul>
    '.$ChampsIncorrects.'
    </ul>';
 }
 ?>