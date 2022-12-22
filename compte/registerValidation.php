<?php

session_start();

require '../db.php';

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
    $login = trim($_POST['login']);

    if (strlen($login) > 100 || strlen($login) < 2 ||  !preg_match("/^[a-zA-Z0-9àâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý \-\_]+$/i", $login)) // lettres, chiffres, tirets, accents, espaces
    {
        $ChampsIncorrects=$ChampsIncorrects.'<li>login</li>';
        $ClassLogin='error';
    }
}

// Vérification du password
if((isset($_POST['password'])))
{ 
    $password = trim($_POST['password']);

    if (strlen($password) > 100 || strlen($password) < 8 || !preg_match("/^[a-zA-Z0-9àâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý \-\_!#$\*%{}\^&?\. ]+$/i", $password)) // lettres, chiffres, tirets, accents, points et caractères dans l'ensemble {!#$*%^&?.} (8 caractères mini)
    {
        $ChampsIncorrects=$ChampsIncorrects.'<li>mdp (8 caractères minimum composé de lettres, chiffres, tirets, accents, points et caractères dans l\'ensemble {!#$*%^&?.})</li>';
        $ClassLogin='error';
    }
}


// Vérification du nom
if((isset($_POST['nom'])) && $_POST['nom'] != '')
{ 
    $nom = trim($_POST['nom']);

    if (strlen($nom) > 100 || strlen($nom) < 2 || !preg_match("/^[a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý -]+$/i", $nom)) // lettres, accents, espaces, tiret du 6
    {
        $ChampsIncorrects=$ChampsIncorrects.'<li>nom</li>';
        $ClassNom='error';
    }
}

// Vérification du prenom 
if(isset($_POST['prenom']) && $_POST['prenom'] != '')
{ 
    $Prenom=trim($_POST['prenom']); // suppression des espaces devant et derrière
    if (strlen($Prenom) > 100 || strlen($Prenom) < 2 || !preg_match("/^[a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý -]+$/i", $Prenom)) // lettres, accents, espaces, tiret du 6
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
        if(strlen($postal) > 100 || strlen($postal) < 3 || !preg_match("/^\d+\s[a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñý]+\.?(?:[- ][a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý]+\.?)*$/i", $postal)) // nombre suivis d'un espace, lettres, tirets (seulement entre deux mots), points (après un mot espace et un autre mot), accents
        {
            $ChampsIncorrects=$ChampsIncorrects.'<li>adresse postale</li>';
            $ClassPostal='error';
        }
    }

// Vérification du code postal
if(isset($_POST['zip']) && $_POST['zip'] != '')
{ 
    $zip = trim($_POST['zip']);
    if(strlen($zip) > 100 || strlen($zip) < 2 || !preg_match("/[0-9]+/i", $zip)) // que des chiffres (au moins 1)
    {
        $ChampsIncorrects=$ChampsIncorrects.'<li>code postal</li>';
        $ClassPostal='error';
    }
}

// Vérification de la ville
if(isset($_POST['ville']) && $_POST['ville'] != '')
{ 
    $ville = strtolower(trim($_POST['ville']));
    if(strlen($ville) > 100 || strlen($ville) < 2 || !preg_match("/^[a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý]+\.?(?:[- ][a-zA-ZàâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý]+\.?)*$/i", $ville)) // nombre suivis d'un espace, lettres, tirets (seulement entre deux mots), points (après un mot espace et un autre mot), accents
    {
        $ChampsIncorrects=$ChampsIncorrects.'<li>ville</li>';
        $ClassVille='error';
    }
}


// Vérification téléphone
if(isset($_POST['telephone']) && $_POST['telephone'] != '')
{ 
    $tel = strtolower(trim($_POST['telephone']));

    if(strlen($tel) > 100 || strlen($tel) < 3 || !preg_match("/^[\+|0][0-9]+$/", $tel)) // Commence par + ou 0 et suivi de chiffres
    {
        $ChampsIncorrects=$ChampsIncorrects.'<li>téléphone</li>';
        $ClassTel = 'error';
        }

}

// Sauvegarde des données
if($ChampsIncorrects=='')
{ 
    $password = password_hash($password, PASSWORD_BCRYPT);
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