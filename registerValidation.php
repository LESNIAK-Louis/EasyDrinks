<?php

session_start();

require 'db.php';

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

// Vérification du sexe
if(isset($_POST['sexe']) && $_POST['sexe'] != '')
{ 
    $sexe=strtolower(trim($_POST['sexe'])); // suppression des espaces devant et derrière
}

// Vérification du mail
if(isset($_POST['email']) && $_POST['email'] != '')
{ 
    $email=strtolower(trim($_POST['email'])); // suppression des espaces devant et derrière
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
    $utilisateur = array(   'login' => $login,
                            'mdp' => $password, 
                            'prenom' => (isset($Prenom) ? $Prenom : null),
                            'nom' => (isset($nom) ? $nom : null),
                            'sexe' => (isset($sexe) ? $sexe : null),
                            'email' => (isset($email) ? $email : null),
                            'ddn' => (isset($Annee) && isset($Mois) && isset($Jour) ? $Annee.'-'.$Mois.'-'.$Jour : null),
                            'adresse' => (isset($postal) ? $postal : null),
                            'cp' => (isset($zip) ? $zip : null),
                            'ville' => (isset($ville) ? $ville : null),
                            'noTel' => (isset($tel) ? $tel : null));

    try{
        ajouterUtilisateur($utilisateur);
        $_SESSION['login'] = $login;

        echo 'OK';
    }catch(Exception $e){
        if($e->getMessage() == '1062'){
            echo '<div class="retourFormulaire">
            <br />
            Ce login existe déjà</div>';
        }
    }
}else{
    echo '
    <div class="retourFormulaire">
    <br />
    Merci de remplir correctement les champs ci-dessous :
    <ul>
    '.$ChampsIncorrects.'
    </ul> </div>';
}


?>